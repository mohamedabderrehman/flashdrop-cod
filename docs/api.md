# API and execution paths

This index is extracted from the current source. Router-local paths require their mount prefix from the server entry point. PHP endpoint paths map directly to files unless Apache rewrites them. Controllers and auth middleware are authoritative for request bodies and permissions.

See the source entry points below; this project does not declare Express/Flask router paths.

## Source entry points

- [index.html](../index.html)
- [api/order.php](../api/order.php)
- [api/options.json](../api/options.json)

## الاستخدام

المسارات المذكورة محلية للموجه وتحتاج بادئة الربط في الخادم. ملفات PHP هي مرجع المسارات ما لم تُعَد كتابتها. استخدم بيانات اصطناعية وفحوص الصلاحيات الموجودة في الشيفرة.


## Representative usage

The JSON fields are fullname, wilaya, baladia, phone, color, size, delivery, quantity and address. Allowed choices are read from api/options.json. Send Idempotency-Key for reliable retries: the same key/payload returns the same receipt; changing its payload returns 409. In demo mode no Telegram channel is contacted.

```sh
python tools/check-demo.py
# See the generated synthetic order in tools/check-demo.py for exact option labels.
# POST /api/order.php, Content-Type: application/json,
# Idempotency-Key: a new UUID for a distinct order.
# 200: confirmed demo/provider receipt; 422: invalid fields; 409: conflict.
```
