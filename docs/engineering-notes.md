## A checkout shaped by Algerian cash-on-delivery ordering

Flashdrop is a focused product landing page with an order workflow. Phone validation, wilaya and municipality choices, home or office delivery, product variants and quantity totals turn a visual page into an operational intake form. Local form recovery supports a visitor returning after an interruption.

The release retains the design and moves Telegram submission to a small PHP endpoint. A bot token in browser JavaScript can be copied by anyone loading the page; server-side configuration keeps that credential outside the public assets. The server repeats validation because browser controls can be bypassed.

## Distinguishing a retry from another order

Duplicate submissions need more than a loading spinner. An idempotency key binds a submitted payload to a receipt. Repeating the same key returns that receipt, while changing its payload produces a conflict. Private receipt storage and locking support this boundary; provider uncertainty must not be silently shown as a successful delivery.

The public demonstration accepts synthetic orders without contacting a real Telegram channel. Stock, offers, countdowns and reviews are presentation content, not evidence of actual commercial activity. Live provider-failure and retry integration remain follow-up checks before using it for real customers.
