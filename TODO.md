# TODO

## Fix: Render 500 on register
- [x] Identify root causes from error log
- [x] Make RegisterController resilient when `users.user_id_number` column is not present
- [ ] Ensure logging doesn’t crash when `storage/logs/laravel.log` isn’t writable (set LOG_CHANNEL=stderr or adjust config)
- [ ] Deploy and run: migrate to add missing id columns (or verify migrations ran on Render)
- [ ] Re-test registration

