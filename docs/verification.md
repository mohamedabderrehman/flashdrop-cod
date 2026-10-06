# Current release verification

Historical status: Focused Algerian COD landing page with an order workflow; stock, reviews and offers in the portfolio demo are presentation content.

Current acceptance checks are in progress. No CI badge or passing integration claim is made yet.

## Checks required

- [ ] No Telegram token in browser assets
- [ ] PHP validation and demo success
- [ ] Invalid phone/options/quantity rejection
- [ ] Idempotency repeat and conflict; provider failure must not show success

## External dependencies and limits

Municipality names are validated for length, not against a complete administrative dataset. No payment processing. Live Telegram delivery requires a separate provider check; uncertain sends require operator reconciliation.
