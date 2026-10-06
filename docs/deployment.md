# Deployment and troubleshooting

## Historical status

Focused Algerian COD landing page with an order workflow; stock, reviews and offers in the portfolio demo are presentation content.

صفحة بيع جزائرية مركزة مع إجراءات طلب. المخزون والتقييمات والعروض في العرض بيانات تقديمية.

## Local release environment

Use fresh configuration, a disposable database/corpus and independently installed dependencies. This release never needs retired production services. Keep credentials, uploaded files, sessions, caches and signing material outside the public source. Credential removal does not revoke a provider key.

## Troubleshooting

### Static server cannot submit

Use PHP, not a plain static server, for api/order.php.

### 409 on retry

The key is bound to one payload or a provider send needs reconciliation. Do not blindly resend.

### 502 provider failure

Check provider configuration privately; success requires a Telegram confirmation.

### No message during demo

DEMO_MODE defaults to 1 and intentionally does not contact Telegram.

## Current limits

Municipality names are validated for length, not against a complete administrative dataset. No payment processing. Live Telegram delivery requires a separate provider check; uncertain sends require operator reconciliation.

تُفحص أسماء البلديات من حيث الطول وليس من قائمة إدارية شاملة. لا توجد معالجة دفع. تحتاج نتائج إرسال Telegram غير المؤكدة إلى مراجعة المشغل.
