# الإعداد

استخدم PHP 8.1 أو أحدث مع cURL للإرسال الفعلي. وضع العرض افتراضي: `php -S 127.0.0.1:8084`. يقرأ PHP متغيرات البيئة المصدرة ولا يقرأ `.env` تلقائياً. للإرسال اضبط `DEMO_MODE=0` والتوكن ومعرف المحادثة ومجلد حالة خارج الجذر العام.

## التفاصيل والأوامر

Use PHP 8.1+ with cURL for live delivery. Demo mode is the default: run `php -S 127.0.0.1:8084`. PHP reads exported environment variables, not `.env` automatically. For live operation set `DEMO_MODE=0`, `TELEGRAM_BOT_TOKEN`, `TELEGRAM_CHAT_ID` and an `ORDER_STATE_DIR` outside the web root. Preserve TLS validation and store secrets through the hosting environment.

## متغيرات تقرأها الشيفرة

| Variable | Source consumer | Configuration rule |
|---|---|---|
| `DEMO_MODE` | `api/order.php` | Use the local example/source default; adapt to your disposable environment. |
| `ORDER_STATE_DIR` | `api/order.php` | Use the local example/source default; adapt to your disposable environment. |
| `TELEGRAM_BOT_TOKEN` | `api/order.php` | Supply privately when enabling its integration; no secret default. |
| `TELEGRAM_CHAT_ID` | `api/order.php` | Use the local example/source default; adapt to your disposable environment. |

لا تُحمَّل ملفات الأمثلة تلقائياً. تستخدم وحدات dotenv الملف حيث تكون مهيأة، ويستخدم PHP بيئة العملية أو الاستضافة. افصل المزودين عن العرض وأنشئ أسراراً جديدة واحفظها خارج المستودع.

## أوامر المكونات
