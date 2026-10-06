# Synthetic demonstration

Choose variant and delivery → validate customer fields → submit to PHP with an idempotency key → server validates again → demo accepts or Telegram confirms → interface displays the server order number.

## Walkthrough

1. Submit synthetic Algerian phone/name and a valid variant.
2. Change quantity and delivery option; inspect totals.
3. Submit invalid fields directly to PHP; expect rejection.
4. Repeat the same idempotency key; verify the same receipt. Use a changed payload with that key; expect conflict.

## Acceptance checklist

- [ ] No Telegram token in browser assets
- [ ] PHP validation and demo success
- [ ] Invalid phone/options/quantity rejection
- [ ] Idempotency repeat and conflict; provider failure must not show success

## Evidence discipline

Screenshots must come from the running application with synthetic records. Record the component, viewport and configuration. A storyboard is not a recorded walkthrough. Benchmark only generated data and include hardware, input size, configuration, elapsed time and cache conditions.

Municipality names are validated for length, not against a complete administrative dataset. No payment processing. Live Telegram delivery requires a separate provider check; uncertain sends require operator reconciliation.
