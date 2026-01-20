#!/usr/bin/env bash
set -euo pipefail

# ------------- EDIT THESE BEFORE RUNNING -------------
DOMAIN="bharatstockmarketresearch.com"
EMAIL="you@example.com"           # used for Let's Encrypt - change to your email
WEBROOT="/var/www/${DOMAIN}"
DB_NAME="bharat_db"               # change as needed
DB_USER="bharat_user"
DB_PASS="CHANGEME_db_password"
# ----------------------------------------------------

BACKUP_DIR="/var/backups/${DOMAIN}_backup_$(date +%F_%H%M%S)"

echo "Backing up ${WEBROOT} to ${BACKUP_DIR}..."
sudo mkdir -p "${BACKUP_DIR}"
sudo cp -a "${WEBROOT}/." "${BACKUP_DIR}/" || true

# Ensure site directory exists
if [ ! -d "${WEBROOT}" ]; then
  echo "${WEBROOT} not found. Aborting."
  exit 1
fi

cd "${WEBROOT}"

# Ensure public/index.php is present
if [ ! -f "${WEBROOT}/public/index.php" ]; then
  echo "public/index.php missing — please ensure your project is in place"
  ls -la "${WEBROOT}"
  exit 1
fi

# Detect php-fpm socket
PHP_SOCK=$(ls /run/php/php*-fpm.sock 2>/dev/null | head -n1 || true)
if [ -z "$PHP_SOCK" ]; then
  echo "No php-fpm socket found in /run/php. Will attempt fastcgi on 127.0.0.1:9000"
  FPM_PASS="127.0.0.1:9000"
else
  echo "Detected php-fpm socket: $PHP_SOCK"
  FPM_PASS="unix:${PHP_SOCK}"
fi

# Create nginx site config
NGINX_SITE="/etc/nginx/sites-available/${DOMAIN}"
sudo tee "${NGINX_SITE}" > /dev/null <<NGINXCONF
server {
    listen 80;
    server_name ${DOMAIN} www.${DOMAIN};

    root ${WEBROOT}/public;
    index index.php index.html;

    access_log /var/log/nginx/${DOMAIN}_access.log;
    error_log  /var/log/nginx/${DOMAIN}_error.log;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass ${FPM_PASS};
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT \$realpath_root;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
NGINXCONF

echo "Enabling nginx site..."
sudo ln -sf "${NGINX_SITE}" /etc/nginx/sites-enabled/${DOMAIN}
sudo rm -f /etc/nginx/sites-enabled/default || true

# Test nginx config
sudo nginx -t
sudo systemctl reload nginx

# Install composer deps (run as www-data)
if command -v composer >/dev/null 2>&1; then
  echo "Installing Composer dependencies..."
  sudo -u www-data composer install --prefer-dist --no-dev --optimize-autoloader || true
else
  echo "Composer not found; please install composer to continue."
fi

# Setup .env if missing
if [ ! -f .env ]; then
  echo ".env not found; copying from .env.example"
  sudo -u www-data cp .env.example .env || true
fi

# Update APP_URL and DB values in .env (simple sed, may overwrite existing)
sudo sed -i "s|APP_URL=.*|APP_URL=https://${DOMAIN}|g" .env || true
sudo sed -i "s|DB_DATABASE=.*|DB_DATABASE=${DB_NAME}|g" .env || true
sudo sed -i "s|DB_USERNAME=.*|DB_USERNAME=${DB_USER}|g" .env || true
sudo sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=${DB_PASS}|g" .env || true

# Generate APP_KEY
sudo -u www-data php artisan key:generate --force || true

# Create storage link and caches
sudo -u www-data php artisan storage:link || true
sudo -u www-data php artisan config:clear || true
sudo -u www-data php artisan config:cache || true
sudo -u www-data php artisan route:cache || true
sudo -u www-data php artisan view:cache || true

# Fix permissions
sudo chown -R www-data:www-data "${WEBROOT}"
sudo find "${WEBROOT}" -type f -exec chmod 644 {} \;
sudo find "${WEBROOT}" -type d -exec chmod 755 {} \;
sudo chmod -R 775 "${WEBROOT}/storage" "${WEBROOT}/bootstrap/cache" || true

# Create MySQL database & user (will prompt for mysql root password)
echo "Creating MySQL database and user. You will be prompted for MySQL root password"
MYSQL_CMD="CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASS}';
GRANT ALL ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';
FLUSH PRIVILEGES;"
sudo mysql -u root -p -e "${MYSQL_CMD}" || echo "MySQL step failed — run the CREATE DATABASE commands manually."

# Run migrations (interactive; will run as www-data)
echo "Running migrations (may require DB credentials to be correct in .env)..."
sudo -u www-data php artisan migrate --force || echo "Migrations failed. Check DB credentials and run 'php artisan migrate' manually."

# Install certbot & issue Let's Encrypt cert for domain
if ! command -v certbot >/dev/null 2>&1; then
  echo "Installing certbot..."
  sudo apt update
  sudo apt install -y certbot python3-certbot-nginx
fi

echo "Requesting Let's Encrypt certificate (certbot will fail if DNS not pointed to this server) ..."
sudo certbot --nginx -d "${DOMAIN}" -d "www.${DOMAIN}" --non-interactive --agree-tos -m "${EMAIL}" --redirect || echo "Certbot failed. Check DNS or certbot logs."

# Restart services
sudo systemctl restart nginx
# Try restarting appropriate php-fpm service
for s in php8.4-fpm php8.3-fpm php8.2-fpm php8.1-fpm php8.0-fpm php7.4-fpm; do
  if systemctl list-units --full -all | grep -q "^${s}.service"; then
    sudo systemctl restart "${s}" || true
  fi
done

echo "Done. Quick tests:"
echo " - curl -I http://${DOMAIN}"
echo " - curl -I https://${DOMAIN}"
