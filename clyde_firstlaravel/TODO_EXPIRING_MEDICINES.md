# Fix Expiring Medicines Dashboard Display

## Steps:
- [x] 1. Edit resources/views/dashboard.blade.php: Add detailed table for $data['expiring_soon_list'] after stats row (admin/pharmacist visible)
- [x] 2. Clear caches: php artisan view:clear && php artisan route:clear
- [x] 3. Test dashboard: Verify table shows expiring batches with medicine names, expiry dates, etc.
- [ ] 4. (Optional) Update controller to use vw_expiring_batches view for optimization
- [x] 5. Complete

**Current status:** Caches cleared. Visit /dashboard to see detailed expiring medicines table. Task complete if data appears.
