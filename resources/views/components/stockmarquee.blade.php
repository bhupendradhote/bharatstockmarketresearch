{{-- resources/views/components/stockmarquee.blade.php --}}

<style>
    .stock-marquee-breakout {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        max-width: 100vw;
        overflow: hidden; 
        z-index: 0; 
    }

    .ticker-wrap {
        width: 100%;
        background: linear-gradient(90deg, #0f172a, #1e293b);
        color: #fff;
        height: 36px; 
        display: flex;
        align-items: center;
    }

    .ticker-content {
        display: flex;
        width: max-content;
        animation: ticker-scroll 60s linear infinite;
    }

    .ticker-wrap:hover .ticker-content {
        animation-play-state: paused;
    }

    @keyframes ticker-scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    .ticker-item {
        display: inline-flex;
        align-items: center;
        padding: 0 30px; 
        height: 36px;
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 12px;
        font-weight: 500;
        white-space: nowrap;
    }

    .ticker-symbol {
        color: #fbbf24;
        font-weight: 700;
        margin-right: 8px;
    }

    .trend-up { color: #4ade80; }
    .trend-down { color: #f87171; }
    .trend-neutral { color: #94a3b8; }
</style>

<div class="stock-marquee-breakout">
    <div class="ticker-wrap">
        <div id="tickerContent" class="ticker-content">
            <div class="ticker-item text-gray-400">Loading Market Data...</div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('tickerContent');
    const API_URL = '/api/angel/nifty50-marquee';

    async function fetchMarketData() {
        try {
            const response = await fetch(API_URL, { cache: 'no-store' });
            if (!response.ok) throw new Error('API Error');
            const json = await response.json();

            if (json.status && Array.isArray(json.data)) {
                renderTicker(json.data);
            }
        } catch (error) {
            console.error('Ticker Error:', error);
        }
    }

    function renderTicker(data) {
        if (!data.length) return;

        const itemsHtml = data.map(item => {
            const symbol = item.symbol;
            const ltp = parseFloat(item.ltp || 0).toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            const change = parseFloat(item.change || 0).toFixed(2);
            
            let colorClass = 'trend-neutral';
            let arrow = '';
            let sign = '';

            if (item.change > 0) {
                colorClass = 'trend-up';
                arrow = '▲';
                sign = '+';
            } else if (item.change < 0) {
                colorClass = 'trend-down';
                arrow = '▼';
                sign = ''; 
            }

            return `
                <div class="ticker-item">
                    <span class="ticker-symbol">${symbol}</span>
                    <span class="mr-2 text-white">${ltp}</span>
                    <span class="${colorClass} text-xs font-bold flex items-center gap-1">
                        ${sign}${change}% ${arrow}
                    </span>
                </div>
            `;
        }).join('');

        container.innerHTML = itemsHtml + itemsHtml;
    }

    fetchMarketData();
    setInterval(fetchMarketData, 60000); 
});
</script>