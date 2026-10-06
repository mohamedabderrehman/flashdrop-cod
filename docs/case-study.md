# An Algerian cash-on-delivery landing page

## From the problem to the implementation

Turn a mobile product visit into a validated local delivery request without exposing provider credentials.

Choose variant and delivery → validate customer fields → submit to PHP with an idempotency key → server validates again → demo accepts or Telegram confirms → interface displays the server order number.

## Decisions and tradeoffs

Moving the bot token out of browser code changes the trust boundary: the browser sends an order, while the server owns provider credentials.

Server allowlists are derived from the actual variant and delivery controls. Browser validation alone is bypassable.

A locked hashed submission record avoids resending a successful request. An uncertain provider outcome is held for reconciliation rather than silently retried.

Successful local backups contain only receipt IDs and timestamps. Draft form recovery remains local and should be cleared on shared devices.

## What the publication preparation established

PHP syntax and synthetic HTTP checks passed: valid receipt, repeated idempotency key returns the same receipt, changed-payload conflict, phone/quantity/options validation and foreign-origin rejection. Browser assets contain no Telegram bot token. Live Telegram delivery is not asserted.

## Deployment experience and evidence limits

Focused Algerian COD landing page with an order workflow; stock, reviews and offers in the portfolio demo are presentation content.

Municipality input is length-validated rather than checked against a comprehensive administrative dataset. Uncertain live sends require operator reconciliation; do not retry with a new key blindly. Offers, stock and reviews in the demonstration are presentation content.

## Next steps

Complete the uncovered checks above, record the results, and update the demonstration. Retain the existing architecture and add reproducible synthetic cases before claiming performance improvements or another provider integration.
