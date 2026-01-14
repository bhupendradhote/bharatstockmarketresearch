<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | BHARAT STOCK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Compact Color Palette --- */
        :root {
            --bg-dark-blue: #0f172a;
            --bg-dark-section: #1e293b;
            --bg-white: #ffffff;
            --bg-light-card: #f8faff;
            --accent-yellow: #ffc107;
            --accent-blue: #38bdf8;
            --accent-green: #10b981;
            --accent-red: #ef4444;
            --text-dark: #121212;
            --text-light: #f0f8ff;
            --text-secondary: #94a3b8;
            --text-dark-secondary: #64748b;
            --border-color: #334155;
            --border-light: #e2e8f0;
        }

        body {
            background-color: var(--bg-dark-blue);
            color: var(--text-light);
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            /* Small base font */
            line-height: 1.4;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        h1 {
            font-size: 1.5rem;
        }

        h2 {
            font-size: 1.3rem;
        }

        h3 {
            font-size: 1.1rem;
        }

        h4 {
            font-size: 1rem;
        }

        h5 {
            font-size: 0.9rem;
        }

        h6 {
            font-size: 0.85rem;
        }

        /* --- Compact Navbar --- */
        .navbar {
            background-color: var(--bg-dark-blue) !important;
            border-bottom: 1px solid var(--border-color);
            padding: 0.5rem 0;
            font-size: 0.85rem;
        }

        .navbar-brand {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .navbar-brand .text-accent-fix {
            color: var(--accent-yellow) !important;
        }

        /* --- Dashboard Layout --- */
        .dashboard-container {
            display: flex;
            min-height: calc(100vh - 56px);
        }

        /* --- Sidebar (Compact) --- */
        .sidebar {
            width: 200px;
            background-color: var(--bg-dark-section);
            border-right: 1px solid var(--border-color);
            padding: 1rem 0;
            flex-shrink: 0;
        }

        .sidebar-header {
            padding: 0 1rem 1rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-green));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.8rem;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .user-id {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav li {
            margin-bottom: 0.25rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1rem;
            color: var(--text-light);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
            font-size: 0.85rem;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: rgba(56, 189, 248, 0.1);
            color: var(--accent-blue);
            border-left: 3px solid var(--accent-blue);
        }

        .sidebar-nav i {
            font-size: 0.9rem;
            width: 16px;
            text-align: center;
        }

        .nav-badge {
            margin-left: auto;
            background-color: var(--accent-red);
            color: white;
            font-size: 0.7rem;
            padding: 0.1rem 0.4rem;
            border-radius: 10px;
        }

        /* --- Main Content Area --- */
        .main-content {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
            background-color: var(--bg-dark-blue);
        }

        /* --- Compact Cards --- */
        .compact-card {
            background-color: var(--bg-dark-section);
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 1rem;
            transition: all 0.2s ease;
            margin-bottom: 1rem;
        }

        .compact-card:hover {
            border-color: var(--accent-blue);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .compact-card-light {
            background-color: var(--bg-white);
            color: var(--text-dark);
            border-color: var(--border-light);
        }

        .compact-card-light .text-secondary {
            color: var(--text-dark-secondary) !important;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .compact-card-light .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .card-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-light);
            margin: 0;
        }

        .compact-card-light .card-title {
            color: var(--text-dark);
        }

        .card-actions {
            display: flex;
            gap: 0.5rem;
        }

        .card-action-btn {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 0.9rem;
            padding: 0.2rem;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .card-action-btn:hover {
            color: var(--accent-blue);
        }

        /* --- Portfolio Summary --- */
        .portfolio-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 0.25rem;
        }

        .portfolio-change {
            font-size: 0.85rem;
            font-weight: 600;
        }

        .change-positive {
            color: var(--accent-green);
        }

        .change-negative {
            color: var(--accent-red);
        }

        .portfolio-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-light);
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        /* --- Market Watch Table --- */
        .market-table {
            width: 100%;
            font-size: 0.85rem;
        }

        .market-table th {
            color: var(--text-secondary);
            font-weight: 600;
            padding: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            text-align: left;
            font-size: 0.8rem;
        }

        .compact-card-light .market-table th {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            color: var(--text-dark-secondary);
        }

        .market-table td {
            padding: 0.6rem 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        }

        .compact-card-light .market-table td {
            border-bottom: 1px solid rgba(0, 0, 0, 0.02);
        }

        .market-table tr:hover td {
            background-color: rgba(56, 189, 248, 0.05);
        }

        .stock-symbol {
            font-weight: 600;
            color: var(--text-light);
        }

        .compact-card-light .stock-symbol {
            color: var(--text-dark);
        }

        .stock-name {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* --- Quick Actions --- */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 0.5rem;
            background-color: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.2);
            border-radius: 6px;
            color: var(--accent-blue);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.8rem;
            text-align: center;
        }

        .action-btn:hover {
            background-color: rgba(56, 189, 248, 0.2);
            transform: translateY(-2px);
        }

        .action-icon {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        /* --- Chart Container --- */
        .chart-container {
            height: 200px;
            margin-top: 0.75rem;
        }

        .chart-placeholder {
            height: 100%;
            background: linear-gradient(45deg, rgba(56, 189, 248, 0.05), rgba(56, 189, 248, 0.1));
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        /* --- Order Form --- */
        .order-form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-top: 0.75rem;
        }

        .form-group {
            margin-bottom: 0.5rem;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.25rem;
            display: block;
        }

        .form-control-sm {
            padding: 0.4rem 0.5rem;
            font-size: 0.85rem;
            height: calc(1.5em + 0.5rem);
            border-radius: 4px;
            border: 1px solid var(--border-color);
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--text-light);
        }

        .compact-card-light .form-control-sm {
            background-color: white;
            color: var(--text-dark);
            border-color: var(--border-light);
        }

        .btn-sm {
            padding: 0.4rem 0.75rem;
            font-size: 0.85rem;
            border-radius: 4px;
            font-weight: 600;
        }

        .btn-buy {
            background-color: var(--accent-green);
            border-color: var(--accent-green);
            color: white;
        }

        .btn-sell {
            background-color: var(--accent-red);
            border-color: var(--accent-red);
            color: white;
        }

        /* --- Recent Activity --- */
        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 0.6rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .compact-card-light .activity-item {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-size: 0.75rem;
        }

        .icon-buy {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--accent-green);
        }

        .icon-sell {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--accent-red);
        }

        .icon-deposit {
            background-color: rgba(56, 189, 248, 0.1);
            color: var(--accent-blue);
        }

        .activity-details {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .compact-card-light .activity-title {
            color: var(--text-dark);
        }

        .activity-meta {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .activity-amount {
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* --- Responsive Adjustments --- */
        @media (max-width: 992px) {
            .sidebar {
                width: 60px;
            }

            .sidebar .nav-text,
            .user-details {
                display: none;
            }

            .sidebar-header {
                padding: 0 0.5rem 1rem;
                text-align: center;
            }

            .user-info {
                justify-content: center;
            }

            .sidebar-nav a {
                justify-content: center;
                padding: 0.6rem;
            }

            .nav-badge {
                position: absolute;
                top: 5px;
                right: 5px;
            }

            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .portfolio-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .order-form {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.75rem;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .portfolio-stats {
                grid-template-columns: 1fr;
            }
        }

        /* --- Utility Classes --- */
        .text-small {
            font-size: 0.85rem;
        }

        .text-xsmall {
            font-size: 0.75rem;
        }

        .mb-1 {
            margin-bottom: 0.5rem !important;
        }

        .mb-2 {
            margin-bottom: 1rem !important;
        }

        .mt-1 {
            margin-top: 0.5rem !important;
        }

        .mt-2 {
            margin-top: 1rem !important;
        }

        .p-1 {
            padding: 0.5rem !important;
        }

        .p-2 {
            padding: 1rem !important;
        }

        /* --- Toggle for Light/Dark Mode --- */
        .theme-toggle {
            position: fixed;
            bottom: 1rem;
            right: 1rem;
            z-index: 1000;
        }

        .theme-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--bg-dark-section);
            border: 1px solid var(--border-color);
            color: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .theme-btn:hover {
            background-color: var(--accent-blue);
            color: white;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <span class="text-accent-fix me-1">B</span> BHARAT STOCK
            </a>

            <div class="d-flex align-items-center gap-2">
                <div class="d-none d-md-block">
                    <span class="text-secondary me-3">Live: NIFTY 22,415.65 <span
                            class="change-positive">+1.25%</span></span>
                </div>
                <button class="btn btn-sm btn-outline-light">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-danger" style="font-size: 0.6rem; padding: 0.1rem 0.3rem;">3</span>
                </button>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i>
                                Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="user-info">
                    <div class="user-avatar">RK</div>
                    <div class="user-details">
                        <div class="user-name">Rajesh Kumar</div>
                        <div class="user-id">ID: UNI789456</div>
                    </div>
                </div>
            </div>

            <ul class="sidebar-nav">
                <li><a href="#" class="active"><i class="bi bi-speedometer2"></i> <span
                            class="nav-text">Dashboard</span></a></li>
                <li><a href="#"><i class="bi bi-graph-up"></i> <span class="nav-text">Portfolio</span></a></li>
                <li><a href="#"><i class="bi bi-bar-chart"></i> <span class="nav-text">Market</span></a></li>
                <li><a href="#"><i class="bi bi-cart"></i> <span class="nav-text">Orders</span> <span
                            class="nav-badge">2</span></a></li>
                <li><a href="#"><i class="bi bi-wallet2"></i> <span class="nav-text">Holdings</span></a></li>
                <li><a href="#"><i class="bi bi-arrow-left-right"></i> <span
                            class="nav-text">Transactions</span></a></li>
                <li><a href="#"><i class="bi bi-cash-coin"></i> <span class="nav-text">Funds</span></a></li>
                <li><a href="#"><i class="bi bi-file-text"></i> <span class="nav-text">Reports</span></a></li>
                <li><a href="#"><i class="bi bi-gear"></i> <span class="nav-text">Settings</span></a></li>
            </ul>

            <div class="mt-3 p-2 text-xsmall text-secondary">
                <div>Account Status: <span class="text-success">Active</span></div>
                <div>Last Login: 10:45 AM</div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header Row -->
            <div class="row mb-2">
                <div class="col">
                    <h1>Dashboard</h1>
                    <p class="text-secondary mb-0">Welcome back, Rajesh. Here's your trading overview.</p>
                </div>
                <div class="col-auto">
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-light">Refresh</button>
                        <button class="btn btn-sm btn-primary">New Order</button>
                    </div>
                </div>
            </div>

            <!-- Portfolio Summary -->
            <div class="row mb-2">
                <div class="col-lg-8">
                    <div class="compact-card">
                        <div class="card-header">
                            <h5 class="card-title">Portfolio Summary</h5>
                            <div class="card-actions">
                                <button class="card-action-btn"><i class="bi bi-arrow-clockwise"></i></button>
                                <button class="card-action-btn"><i class="bi bi-three-dots"></i></button>
                            </div>
                        </div>

                        <div class="portfolio-value">₹ 12,85,430.25</div>
                        <div class="portfolio-change change-positive">+ ₹ 24,560.75 (1.95%) Today</div>

                        <div class="portfolio-stats">
                            <div class="stat-item">
                                <div class="stat-value">₹ 8,42,150</div>
                                <div class="stat-label">Invested</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">₹ 4,43,280</div>
                                <div class="stat-label">Returns</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">52.6%</div>
                                <div class="stat-label">Growth</div>
                            </div>
                        </div>

                        <div class="chart-container mt-2">
                            <div class="chart-placeholder">
                                <i class="bi bi-bar-chart me-2"></i> Portfolio Performance Chart
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="compact-card compact-card-light">
                        <div class="card-header">
                            <h5 class="card-title">Quick Actions</h5>
                        </div>

                        <div class="quick-actions">
                            <a href="#" class="action-btn">
                                <i class="bi bi-cart-plus action-icon"></i>
                                Buy
                            </a>
                            <a href="#" class="action-btn">
                                <i class="bi bi-cart-dash action-icon"></i>
                                Sell
                            </a>
                            <a href="#" class="action-btn">
                                <i class="bi bi-cash-coin action-icon"></i>
                                Add Funds
                            </a>
                            <a href="#" class="action-btn">
                                <i class="bi bi-download action-icon"></i>
                                Withdraw
                            </a>
                        </div>

                        <div class="mt-2">
                            <h6 class="mb-1">Funds Available</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-value">₹ 1,25,000</div>
                                    <div class="stat-label">Margin: ₹ 2,85,000</div>
                                </div>
                                <button class="btn btn-sm btn-primary">Add More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Market Watch & Orders -->
            <div class="row mb-2">
                <div class="col-lg-8">
                    <div class="compact-card">
                        <div class="card-header">
                            <h5 class="card-title">Market Watch</h5>
                            <div class="card-actions">
                                <button class="card-action-btn">NSE</button>
                                <button class="card-action-btn">BSE</button>
                                <button class="card-action-btn"><i class="bi bi-funnel"></i></button>
                            </div>
                        </div>

                        <table class="market-table">
                            <thead>
                                <tr>
                                    <th>Symbol</th>
                                    <th>LTP</th>
                                    <th>Change</th>
                                    <th>Volume</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="stock-symbol">RELIANCE</div>
                                        <div class="stock-name">Reliance Industries</div>
                                    </td>
                                    <td>₹ 2,845.60</td>
                                    <td class="change-positive">+1.25%</td>
                                    <td>12.5M</td>
                                    <td>
                                        <button class="btn btn-sm btn-buy"
                                            style="padding: 0.2rem 0.5rem;">Buy</button>
                                        <button class="btn btn-sm btn-sell"
                                            style="padding: 0.2rem 0.5rem;">Sell</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="stock-symbol">TCS</div>
                                        <div class="stock-name">Tata Consultancy</div>
                                    </td>
                                    <td>₹ 3,985.75</td>
                                    <td class="change-negative">-0.45%</td>
                                    <td>8.2M</td>
                                    <td>
                                        <button class="btn btn-sm btn-buy"
                                            style="padding: 0.2rem 0.5rem;">Buy</button>
                                        <button class="btn btn-sm btn-sell"
                                            style="padding: 0.2rem 0.5rem;">Sell</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="stock-symbol">HDFCBANK</div>
                                        <div class="stock-name">HDFC Bank</div>
                                    </td>
                                    <td>₹ 1,658.40</td>
                                    <td class="change-positive">+0.85%</td>
                                    <td>15.3M</td>
                                    <td>
                                        <button class="btn btn-sm btn-buy"
                                            style="padding: 0.2rem 0.5rem;">Buy</button>
                                        <button class="btn btn-sm btn-sell"
                                            style="padding: 0.2rem 0.5rem;">Sell</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="stock-symbol">INFY</div>
                                        <div class="stock-name">Infosys</div>
                                    </td>
                                    <td>₹ 1,542.30</td>
                                    <td class="change-positive">+1.15%</td>
                                    <td>9.8M</td>
                                    <td>
                                        <button class="btn btn-sm btn-buy"
                                            style="padding: 0.2rem 0.5rem;">Buy</button>
                                        <button class="btn btn-sm btn-sell"
                                            style="padding: 0.2rem 0.5rem;">Sell</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="stock-symbol">ICICIBANK</div>
                                        <div class="stock-name">ICICI Bank</div>
                                    </td>
                                    <td>₹ 1,075.25</td>
                                    <td class="change-negative">-0.25%</td>
                                    <td>11.4M</td>
                                    <td>
                                        <button class="btn btn-sm btn-buy"
                                            style="padding: 0.2rem 0.5rem;">Buy</button>
                                        <button class="btn btn-sm btn-sell"
                                            style="padding: 0.2rem 0.5rem;">Sell</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="compact-card compact-card-light">
                        <div class="card-header">
                            <h5 class="card-title">Place Order</h5>
                        </div>

                        <form class="order-form">
                            <div class="form-group">
                                <label class="form-label">Symbol</label>
                                <input type="text" class="form-control-sm" value="RELIANCE"
                                    placeholder="Enter symbol">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control-sm" value="10" placeholder="Qty">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Order Type</label>
                                <select class="form-control-sm">
                                    <option>Market</option>
                                    <option>Limit</option>
                                    <option>SL</option>
                                    <option>SL-M</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control-sm" value="2,845.60" placeholder="Price">
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-buy w-100">Buy RELIANCE</button>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-sell w-100">Sell RELIANCE</button>
                            </div>
                        </form>

                        <div class="mt-2">
                            <h6 class="mb-1">Order Summary</h6>
                            <div class="text-xsmall">
                                <div class="d-flex justify-content-between">
                                    <span>Estimated Cost:</span>
                                    <span class="fw-bold">₹ 28,456</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Brokerage:</span>
                                    <span>₹ 20</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Taxes:</span>
                                    <span>₹ 42.68</span>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total:</span>
                                    <span>₹ 28,518.68</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Holdings -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="compact-card">
                        <div class="card-header">
                            <h5 class="card-title">Recent Activity</h5>
                            <a href="#" class="text-xsmall text-accent-blue">View All</a>
                        </div>

                        <ul class="activity-list">
                            <li class="activity-item">
                                <div class="activity-icon icon-buy">
                                    <i class="bi bi-cart-plus"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">Buy RELIANCE</div>
                                    <div class="activity-meta">10 shares at ₹ 2,840 • 10:30 AM</div>
                                </div>
                                <div class="activity-amount change-positive">+ ₹ 28,400</div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon icon-sell">
                                    <i class="bi bi-cart-dash"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">Sell TCS</div>
                                    <div class="activity-meta">5 shares at ₹ 3,990 • Yesterday</div>
                                </div>
                                <div class="activity-amount change-negative">- ₹ 19,950</div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon icon-deposit">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">Funds Added</div>
                                    <div class="activity-meta">Bank Transfer • 2 days ago</div>
                                </div>
                                <div class="activity-amount change-positive">+ ₹ 50,000</div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon icon-buy">
                                    <i class="bi bi-cart-plus"></i>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-title">Buy HDFCBANK</div>
                                    <div class="activity-meta">15 shares at ₹ 1,650 • 3 days ago</div>
                                </div>
                                <div class="activity-amount change-positive">+ ₹ 24,750</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="compact-card compact-card-light">
                        <div class="card-header">
                            <h5 class="card-title">Top Holdings</h5>
                            <a href="#" class="text-xsmall text-accent-blue">View All</a>
                        </div>

                        <table class="market-table">
                            <thead>
                                <tr>
                                    <th>Stock</th>
                                    <th>Qty</th>
                                    <th>Avg Price</th>
                                    <th>Current</th>
                                    <th>P&L</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="stock-symbol">RELIANCE</div>
                                        <div class="stock-name">25 shares</div>
                                    </td>
                                    <td>25</td>
                                    <td>₹ 2,780</td>
                                    <td>₹ 2,845.60</td>
                                    <td class="change-positive">+ ₹ 1,640</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="stock-symbol">TCS</div>
                                        <div class="stock-name">15 shares</div>
                                    </td>
                                    <td>15</td>
                                    <td>₹ 3,950</td>
                                    <td>₹ 3,985.75</td>
                                    <td class="change-positive">+ ₹ 536</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="stock-symbol">HDFCBANK</div>
                                        <div class="stock-name">30 shares</div>
                                    </td>
                                    <td>30</td>
                                    <td>₹ 1,620</td>
                                    <td>₹ 1,658.40</td>
                                    <td class="change-positive">+ ₹ 1,152</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="stock-symbol">INFY</div>
                                        <div class="stock-name">20 shares</div>
                                    </td>
                                    <td>20</td>
                                    <td>₹ 1,510</td>
                                    <td>₹ 1,542.30</td>
                                    <td class="change-positive">+ ₹ 646</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Toggle -->
    <div class="theme-toggle">
        <button class="theme-btn" id="themeToggle">
            <i class="bi bi-moon"></i>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme Toggle
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = themeToggle.querySelector('i');

            themeToggle.addEventListener('click', function() {
                document.body.classList.toggle('light-theme');

                if (document.body.classList.contains('light-theme')) {
                    // Switch to light theme
                    document.body.style.backgroundColor = '#f8fafc';
                    themeIcon.classList.remove('bi-moon');
                    themeIcon.classList.add('bi-sun');
                } else {
                    // Switch to dark theme
                    document.body.style.backgroundColor = 'var(--bg-dark-blue)';
                    themeIcon.classList.remove('bi-sun');
                    themeIcon.classList.add('bi-moon');
                }
            });

            // Update stock prices randomly (demo only)
            function updateStockPrices() {
                const stockPrices = document.querySelectorAll('.market-table tbody tr td:nth-child(2)');
                const changes = document.querySelectorAll('.market-table tbody tr td:nth-child(3)');

                stockPrices.forEach((priceCell, index) => {
                    if (Math.random() > 0.7) { // 30% chance to update
                        const currentPrice = parseFloat(priceCell.textContent.replace('₹ ', '').replace(',',
                            ''));
                        const change = (Math.random() * 2 - 1) *
                            0.5; // Random change between -0.5% to +0.5%
                        const newPrice = currentPrice * (1 + change / 100);

                        priceCell.textContent = '₹ ' + newPrice.toFixed(2);

                        // Update change cell
                        const changeCell = changes[index];
                        changeCell.textContent = (change > 0 ? '+' : '') + change.toFixed(2) + '%';
                        changeCell.className = change >= 0 ? 'change-positive' : 'change-negative';
                    }
                });

                // Update portfolio value
                const portfolioValue = document.querySelector('.portfolio-value');
                const currentValue = parseFloat(portfolioValue.textContent.replace('₹ ', '').replace(',', ''));
                const newValue = currentValue * (1 + (Math.random() * 0.4 - 0.2) / 100); // Small random change
                portfolioValue.textContent = '₹ ' + newValue.toLocaleString('en-IN', {
                    minimumFractionDigits: 2
                });
            }

            // Update every 10 seconds for demo
            setInterval(updateStockPrices, 10000);

            // Buy/Sell button functionality
            document.querySelectorAll('.btn-buy, .btn-sell').forEach(button => {
                button.addEventListener('click', function() {
                    const action = this.classList.contains('btn-buy') ? 'Buy' : 'Sell';
                    const stockRow = this.closest('tr');
                    const stockSymbol = stockRow.querySelector('.stock-symbol').textContent;
                    const stockPrice = stockRow.querySelector('td:nth-child(2)').textContent;

                    // Set values in order form
                    document.querySelector('.order-form input[type="text"]').value = stockSymbol;
                    document.querySelector('.order-form input[type="text"]:nth-child(2)').value =
                        stockPrice;

                    // Show notification
                    showNotification(`${action} order prepared for ${stockSymbol}`, 'info');
                });
            });

            // Form submission
            document.querySelector('.order-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const symbol = this.querySelector('input[type="text"]').value;
                showNotification(`Order placed for ${symbol}`, 'success');
                this.reset();
            });

            // Notification function
            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className =
                    `alert alert-${type === 'success' ? 'success' : 'info'} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 1050; max-width: 300px;';
                notification.innerHTML = `
                    <small>${message}</small>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                `;

                document.body.appendChild(notification);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }

            // Refresh button
            document.querySelector('.btn-outline-light').addEventListener('click', function() {
                showNotification('Data refreshed', 'info');
                updateStockPrices();
            });
        });
    </script>
</body>

</html>
