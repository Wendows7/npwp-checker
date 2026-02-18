# 🚀 INSTALLATION & SETUP GUIDE

**Version:** 1.0.0
**Date:** February 17, 2026
**Status:** Production Ready

---

## 📋 PRE-REQUISITES

Before starting, ensure you have:

- ✅ PHP 8.2+
- ✅ Composer installed
- ✅ Laravel 12+ app running
- ✅ MySQL/Database ready
- ✅ Git or file access
- ✅ Terminal/Command line access

---

## 🔧 STEP-BY-STEP INSTALLATION

### STEP 1: Install Dependencies

Open terminal in project root directory:

```bash
cd /Users/arswendosryhd/Documents/personal/projects/npwp-checker
```

Install Composer dependencies:

```bash
composer install
```

**Expected Output:**
```
Loading composer repositories with package information
Installing dependencies from lock file
...
composer-plugin-api: ^2.0
laravel/framework: ^12.0
maatwebsite/excel: ^3.1
...
✓ Success
```

**Troubleshoot:**
- If error: `composer dump-autoload`
- If permission denied: Check file permissions

---

### STEP 2: Setup Storage Symlink

Create symlink untuk akses public storage:

```bash
php artisan storage:link
```

**Expected Output:**
```
The [public/storage] link has been successfully created.
```

**Verify:**
```bash
ls -la public/storage
# Should output a link to storage/app/public
```

**Troubleshoot:**
- Already exists: Delete & recreate
  ```bash
  rm public/storage
  php artisan storage:link
  ```
- Permission denied: Set permissions
  ```bash
  chmod -R 755 storage/app/public
  chmod -R 755 storage/logs
  ```

---

### STEP 3: Clear Application Cache

Clear all Laravel caches:

```bash
# Clear application cache
php artisan cache:clear

# Clear route cache
php artisan route:clear

# Clear config cache
php artisan config:clear

# Clear view cache (optional)
php artisan view:clear
```

**All together:**
```bash
php artisan cache:clear && \
php artisan route:clear && \
php artisan config:clear && \
php artisan view:clear
```

---

### STEP 4: Verify Database Table Exists

Check if `suspects` table exists:

```bash
php artisan tinker
```

Inside tinker:
```php
>>> Schema::hasTable('suspects')
=> true

>>> Schema::getColumns('suspects')
=> [ list of columns ]
```

Exit tinker:
```php
>>> exit
```

**If table not exists, create it:**

```bash
php artisan migrate
```

---

### STEP 5: Verify Routes

Check if all new routes registered:

```bash
php artisan route:list | grep suspect
```

**Expected Output:**
```
POST      /suspect/import
POST      /suspect/store
PUT       /suspect/update/{suspect}
DELETE    /suspect/delete/{suspect}
GET       /suspect
GET       /suspect/search
```

---

### STEP 6: Test File Structure

Verify all files exist:

```bash
# Check controller
ls -la app/Http/Controllers/SuspectController.php

# Check import class
ls -la app/Imports/SuspectImport.php

# Check views
ls -la resources/views/suspect/

# Check documentation
ls -la CHANGELOG_SUSPECT.md
```

---

### STEP 7: File Permissions

Set proper permissions:

```bash
# Storage directory
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Public directory
chmod -R 755 public/
```

---

### STEP 8: Environment Configuration

Check `.env` file:

```env
# Ensure these are set:
APP_NAME="NPWP Checker"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain.local

# Database connection
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=npwp_checker
DB_USERNAME=root
DB_PASSWORD=

# File storage
FILESYSTEM_DISK=public
FILESYSTEM_VISIBILITY=public
```

---

## ✅ POST-INSTALLATION VERIFICATION

### Check 1: Login to Application

1. Open browser: `http://your-app.local`
2. Login dengan credentials Anda
3. Navigate to `/suspect`

**Expected Result:** Table dengan data suspect muncul

---

### Check 2: Test Add Suspect

1. Click "Add Suspect" button
2. Fill form:
   - NIK: 9999999999999999
   - Name: Test User
   - Gender: Male
3. Click "Add Suspect"
4. Verify data muncul di table

**Expected Result:** Data saved & notification appears

---

### Check 3: Test Edit Suspect

1. Click "Edit" button pada data
2. Update Name: "Test User Updated"
3. Click "Update Suspect"
4. Verify data updated

**Expected Result:** Data updated & notification appears

---

### Check 4: Test Delete Suspect

1. Click "Delete" button
2. Confirm deletion
3. Verify data deleted

**Expected Result:** Data deleted & notification appears

---

### Check 5: Test Import Excel

1. Click "Import Excel" button
2. Prepare Excel file with format:
   ```
   nik,name,gender
   1234567890123451,Test 1,Male
   1234567890123452,Test 2,Female
   ```
3. Upload file
4. Click "Import"
5. Verify data imported

**Expected Result:** Data imported & notification appears

---

### Check 6: Storage Verification

Verify photos stored correctly:

```bash
ls -la storage/app/public/suspects/
```

Should show uploaded photo files.

---

### Check 7: Database Verification

Check database data:

```bash
php artisan tinker

>>> Suspect::count()
=> 5 (or your data count)

>>> Suspect::first()
=> Suspect object with data

>>> Suspect::find(1)->photo
=> "suspects/filename.jpg"
```

---

## 🧪 TESTING CHECKLIST

Run through all these tests:

### UI Tests
- [ ] Can view suspect list
- [ ] Can open add modal
- [ ] Can open import modal
- [ ] Can see edit button
- [ ] Can see delete button
- [ ] Pagination works
- [ ] Photos display

### Form Tests
- [ ] Add form validation works
- [ ] Edit form pre-fills data
- [ ] Photo upload works
- [ ] Required fields enforced
- [ ] Error messages display

### Data Tests
- [ ] Add suspect saves data
- [ ] Edit suspect updates data
- [ ] Delete suspect removes data
- [ ] Import adds multiple records
- [ ] Duplicate NIK rejected
- [ ] Search by NIK works

### Storage Tests
- [ ] Photos save to storage
- [ ] Photos display in table
- [ ] Old photos deleted on update
- [ ] Photos deleted on delete

### Database Tests
- [ ] NIK is unique
- [ ] All fields save correctly
- [ ] Timestamps work
- [ ] Soft delete (if enabled)

---

## 🐛 TROUBLESHOOTING

### Problem: Routes Not Found (404)

**Solution:**
```bash
php artisan route:cache
php artisan route:clear
```

---

### Problem: Class SuspectImport Not Found

**Solution:**
```bash
composer dump-autoload
php artisan cache:clear
```

---

### Problem: Photos Not Uploading

**Solution:**
```bash
php artisan storage:link
chmod -R 755 storage/app/public
# Also check max_upload_size in php.ini
```

---

### Problem: Modal Not Opening

**Solution:**
- Check browser console for JS errors
- Verify Bootstrap JS is loaded
- Check modal ID matches button data-target
- Verify jQuery is loaded (for Bootstrap 4/5)

---

### Problem: Form Validation Not Working

**Solution:**
```blade
<!-- Verify @csrf token exists -->
<form method="POST" action="{{ route('suspect.store') }}">
    @csrf
    <!-- form fields -->
</form>
```

---

### Problem: Database Connection Error

**Solution:**
```bash
# Check .env file
cat .env | grep DB_

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo()
```

---

### Problem: Permission Denied Errors

**Solution:**
```bash
# Reset permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/
chmod -R 755 public/

# If still issues:
sudo chown -R www-data:www-data storage/
sudo chown -R www-data:www-data bootstrap/
```

---

## 📊 HEALTH CHECK SCRIPT

Run this to verify everything:

```bash
#!/bin/bash
echo "🔍 NPWP Checker - Health Check"
echo "==============================="

# Check composer
echo "1. Checking Composer..."
composer check || echo "❌ Composer check failed"

# Check routes
echo "2. Checking Routes..."
php artisan route:list | grep suspect || echo "❌ Routes not found"

# Check database
echo "3. Checking Database..."
php artisan tinker --execute="echo 'DB OK'; exit;" || echo "❌ Database error"

# Check storage link
echo "4. Checking Storage Link..."
test -L public/storage && echo "✅ Storage link OK" || echo "❌ Storage link missing"

# Check file permissions
echo "5. Checking Permissions..."
test -w storage/ && echo "✅ Storage writable" || echo "❌ Storage not writable"

echo "==============================="
echo "✅ Health check complete"
```

Save as `health-check.sh` and run:
```bash
chmod +x health-check.sh
./health-check.sh
```

---

## 🚀 PRODUCTION DEPLOYMENT

### Pre-Deployment Checklist

- [ ] All code files copied
- [ ] Dependencies installed
- [ ] Database migrated
- [ ] Storage link created
- [ ] Permissions set
- [ ] .env configured
- [ ] Cache cleared
- [ ] Test page loads
- [ ] Test add/edit/delete
- [ ] Backups created

### Deploy Commands

```bash
# Pull/copy latest code
git pull origin main
# or
cp -r /source/npwp-checker/* /destination/

# Install/update dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Clear caches
php artisan cache:clear
php artisan route:clear
php artisan config:clear

# Optimize for production
php artisan optimize

# Restart services
sudo systemctl restart php-fpm
sudo systemctl restart nginx
# or Apache
sudo systemctl restart apache2
```

---

## 📈 PERFORMANCE OPTIMIZATION

### Enable Query Logging (Development)

```php
// In .env
APP_DEBUG=true

// In controller
Log::info(DB::getQueryLog());
```

### Optimize Database

```sql
-- Add index on NIK
ALTER TABLE suspects ADD UNIQUE INDEX idx_nik (nik);

-- Add index on created_at for pagination
ALTER TABLE suspects ADD INDEX idx_created_at (created_at);
```

### Enable Caching

```bash
# Use Redis (if available)
# In .env
CACHE_DRIVER=redis
SESSION_DRIVER=redis

# Pre-cache routes
php artisan route:cache

# Pre-cache config
php artisan config:cache
```

---

## 📝 DOCUMENTATION REFERENCE

After installation, read these files:

1. **CHANGELOG_SUSPECT.md** - What was added
2. **QUICK_REFERENCE.md** - Code examples
3. **VERIFICATION_CHECKLIST.md** - Testing guide
4. **API_DOCUMENTATION.md** - API reference
5. **EXCEL_IMPORT_TEMPLATE.md** - Excel format

---

## 🆘 SUPPORT & HELP

### Common Issues

See **CHANGELOG_SUSPECT.md** section "Troubleshooting"

### File Locations

See **FILE_MANIFEST.md** for complete list

### Code Examples

See **QUICK_REFERENCE.md** for code snippets

### API Details

See **API_DOCUMENTATION.md** for endpoints

---

## ✅ INSTALLATION COMPLETE

If you've completed all steps:

```
✅ Dependencies installed
✅ Storage link created
✅ Cache cleared
✅ Routes verified
✅ Database checked
✅ Permissions set
✅ Tests passed

🎉 Ready for production!
```

---

## 📞 NEXT STEPS

1. Read **QUICK_REFERENCE.md**
2. Review **VERIFICATION_CHECKLIST.md**
3. Test all features
4. Configure production environment
5. Deploy to server
6. Monitor logs

---

**Last Updated:** February 17, 2026
**Version:** 1.0.0
**Status:** Production Ready ✅

**Happy coding!** 🚀

