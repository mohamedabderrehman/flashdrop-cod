# Current release verification

Recorded on 2026-10-06 using disposable local data. Historical deployment is a separate owner-provided fact.

## Passed locally

PHP syntax and synthetic HTTP checks passed: valid receipt, repeated idempotency key returns the same receipt, changed-payload conflict, phone/quantity/options validation and foreign-origin rejection. Browser assets contain no Telegram bot token. Live Telegram delivery is not asserted.

## Checks and commands

```sh
php -S 127.0.0.1:8084
# Separate terminal:
python tools/check-syntax.py
python tools/check-demo.py
```

## CI status

The configured GitHub Actions workflows are registered, but the initial runs ended with startup_failure before any jobs or check annotations were created. Local results above are independent of CI. No passing CI badge is shown; the service supplied no further diagnostic message through the available API.

## Remaining platform and coverage limits

Municipality input is length-validated rather than checked against a comprehensive administrative dataset. Uncertain live sends require operator reconciliation; do not retry with a new key blindly. Offers, stock and reviews in the demonstration are presentation content.

PHP checks used PHP 8.4.26; Node builds used Node 24.19; Python checks used Python 3.12.10 where applicable. This record does not claim production hardening, paid provider verification or tests on every platform.
