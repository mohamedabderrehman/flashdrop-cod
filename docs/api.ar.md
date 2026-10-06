# الواجهات ومسارات التنفيذ

اختيار النوع والتوصيل ← فحص الحقول ← إرسال PHP مع مفتاح منع التكرار ← تحقق الخادم ← قبول العرض أو تأكيد Telegram ← عرض رقم الطلب من الخادم.

تحتاج المسارات المحلية للموجه إلى بادئة الخادم. تستخدم مسارات PHP الملفات الفعلية ما لم توجد إعادة كتابة. المتحكمات والوسطاء في الشيفرة مرجع الحقول والصلاحيات. فحوص tools/check-demo تمثل طلبات حقيقية ببيانات اصطناعية وليست مزوداً وهمياً.

## مراجع التنفيذ

- [index.html](../index.html)
- [api/order.php](../api/order.php)
- [api/options.json](../api/options.json)

## حدود التكامل

يُفحص طول البلدية دون قائمة إدارية شاملة. يحتاج الإرسال الحي غير المؤكد مراجعة المشغل ولا يُعاد بمفتاح جديد عشوائياً. العروض والمخزون والمراجعات محتوى تقديمي.


## جرد المسارات



## مثال الاستخدام

حقول JSON هي fullname وwilaya وbaladia وphone وcolor وsize وdelivery وquantity وaddress. تأتي الخيارات من api/options.json. أرسل Idempotency-Key لإعادة آمنة؛ يعيد المفتاح والحمولة نفسيهما الإيصال نفسه، وتغيير الحمولة يعيد 409. لا يتصل العرض بقناة Telegram.

```sh
python tools/check-demo.py
# See the generated synthetic order in tools/check-demo.py for exact option labels.
# POST /api/order.php, Content-Type: application/json,
# Idempotency-Key: a new UUID for a distinct order.
# 200: confirmed demo/provider receipt; 422: invalid fields; 409: conflict.
```
