# Setup and configuration

Use PHP 8.1+ with cURL for live delivery. Demo mode is the default: run `php -S 127.0.0.1:8084`. PHP reads exported environment variables, not `.env` automatically. For live operation set `DEMO_MODE=0`, `TELEGRAM_BOT_TOKEN`, `TELEGRAM_CHAT_ID` and an `ORDER_STATE_DIR` outside the web root. Preserve TLS validation and store secrets through the hosting environment.

## Environment variables read by source

| Variable | Source consumer | Configuration rule |
|---|---|---|
| `DEMO_MODE` | `api/order.php` | Use the local example/source default; adapt to your disposable environment. |
| `ORDER_STATE_DIR` | `api/order.php` | Use the local example/source default; adapt to your disposable environment. |
| `TELEGRAM_BOT_TOKEN` | `api/order.php` | Supply privately when enabling its integration; no secret default. |
| `TELEGRAM_CHAT_ID` | `api/order.php` | Use the local example/source default; adapt to your disposable environment. |

Environment examples do not load themselves. Node dotenv modules read local `.env` where configured; PHP uses its process/hosting environment. Keep provider integrations disconnected for demos. Generate a new secret with `node -e "console.log(require('crypto').randomBytes(32).toString('hex'))"` or equivalent, then store it privately.

## Declared component commands



## Source boundaries

| Component | Responsibility |
|---|---|
| `index.html` | Landing page and order interface |
| `api/order.php` | Validation, idempotency and provider boundary |
| `api/options.json` | Allowed existing order options |
| `1.jpg … 5.jpg` | Existing product imagery |
