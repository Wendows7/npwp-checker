# 🚀 Quick Reference - Fitur Import Excel & CRUD Suspect

## 📌 File Locations

```
📦 App Layer
├── Controllers/SuspectController.php (5 methods baru)
├── Imports/SuspectImport.php (NEW - Import handler)
└── Services/SuspectService.php (3 methods baru)

📦 Routes
└── routes/web.php (4 routes baru)

📦 Views
├── suspect/index.blade.php (main table view)
├── suspect/modal/create.blade.php (add form)
├── suspect/modal/edit.blade.php (edit form)
└── suspect/modal/detail.blade.php (detail view)

📦 Config
└── composer.json (maatwebsite/excel added)
```

---

## 🔄 API Routes Reference

### Import Excel
```
POST /suspect/import
Body: multipart/form-data
- excel_file: file (.xlsx, .xls, .csv)
```

### Create Suspect
```
POST /suspect/store
Body: form-data
- nik: string (required, unique)
- name: string (required)
- gender: string (required)
- alias, place_of_birth, date_of_birth, age, religion, education, occupation, address: optional
- photo: file (optional, max 2MB)
```

### Update Suspect
```
PUT /suspect/update/{suspect_id}
Body: form-data + _method=PUT
- nik, name, gender, alias, place_of_birth, date_of_birth, age, religion, education, occupation, address: optional
- photo: file (optional, replaces old photo)
```

### Delete Suspect
```
DELETE /suspect/delete/{suspect_id}
Method: POST dengan _method=DELETE
```

### View All Suspects
```
GET /suspect
- Menampilkan tabel dengan pagination (15 item/halaman)
```

### Search Suspect
```
GET /suspect/search?slug={nik}
- Search suspect berdasarkan NIK
```

---

## 🎯 Controller Methods Summary

### SuspectController

#### `index()`
- Display semua suspects dengan pagination
- View: `suspect.index`
- Params: none

#### `search(Request $request)`
- Search suspects by NIK
- View: `suspect.search`
- Params: `slug` (NIK)

#### `import(Request $request)` ⭐ NEW
- Import suspects dari Excel file
- Validasi: file required, mimes: xlsx,xls,csv
- Return: redirect ke suspect route
- Alert: success/error message

#### `store(Request $request)` ⭐ NEW
- Create suspect baru
- Validasi: nik (required, unique), name (required), gender (required)
- Photo: upload ke storage/suspects/
- Return: redirect + alert

#### `update(Request $request, Suspect $suspect)` ⭐ NEW
- Update suspect data
- Validasi: nik (required, unique except current)
- Photo: delete old, upload new (opsional)
- Return: redirect + alert

#### `delete(Suspect $suspect)` ⭐ NEW
- Delete suspect dan foto
- Storage: auto delete foto dari public disk
- Return: redirect + alert

---

## 🛠️ Service Methods Reference

### SuspectService

```php
// Get by NIK
$suspects = $service->getByNik('1234567890123456');

// Get all (with latest first)
$suspects = $service->getAll();

// Create
$suspect = $service->create($data);

// Update
$service->update($suspect, $data);

// Delete
$service->delete($suspect);
```

---

## 📝 Excel Import Format

File harus memiliki header row dengan kolom:

| No | Kolom | Required | Format |
|----|-------|----------|--------|
| 1 | nik | Ya | String (max 20) |
| 2 | name | Ya | String |
| 3 | alias | Tidak | String |
| 4 | gender | Ya | String (Male/Female) |
| 5 | place_of_birth | Tidak | String |
| 6 | date_of_birth | Tidak | Date (YYYY-MM-DD) |
| 7 | age | Tidak | Integer |
| 8 | religion | Tidak | String |
| 9 | education | Tidak | String |
| 10 | occupation | Tidak | String |
| 11 | address | Tidak | String |
| 12 | finger_code | Tidak | String |
| 13 | photo | Tidak | String (path/url) |

### Sample Excel Content

```
nik | name | alias | gender | place_of_birth | date_of_birth | age | religion | education | occupation | address | finger_code | photo
1234567890123456 | John Doe | Johnny | Male | Jakarta | 1990-01-15 | 33 | Islam | SMA | Engineer | Jl Merdeka | FP001 | 
1234567890123457 | Jane Smith | | Female | Bandung | 1992-05-20 | 31 | Catholic | S1 | Analyst | Jl Sudirman | FP002 |
```

---

## 💾 Storage Paths

### Photo Storage Location
```
storage/app/public/suspects/{suspect_id}-{original_filename}
```

### Access in View
```blade
{{ asset('storage/' . $suspect->photo) }}
```

### Delete Photo
```php
Storage::disk('public')->delete($suspect->photo);
```

---

## 🎨 Form Validation Messages

### Create/Update Form
```
NIK:
- required: "NIK tidak boleh kosong"
- unique: "NIK sudah terdaftar"

Name:
- required: "Nama tidak boleh kosong"
- string: "Nama harus berupa teks"

Gender:
- required: "Gender harus dipilih"

Photo:
- image: "File harus berupa gambar"
- mimes: "Format harus jpeg, png, jpg, atau gif"
- max: "Ukuran maksimal 2MB"
```

### Import Form
```
File:
- required: "File tidak boleh kosong"
- file: "Upload harus berupa file"
- mimes: "Format harus .xlsx, .xls, atau .csv"
```

---

## 🔒 Security Features

✅ CSRF Protection (@csrf di semua form)
✅ File validation (mime type, size)
✅ Unique constraint pada NIK
✅ Path traversal prevention (Storage facade)
✅ SQL Injection prevention (Eloquent ORM)
✅ Auth middleware protection
✅ Input sanitization

---

## 🐛 Debugging Tips

### Check Import Status
```php
// Di SuspectImport.php, add logging
use Illuminate\Support\Facades\Log;

public function model(array $row)
{
    Log::info('Importing row: ' . json_encode($row));
    // ... rest of code
}
```

### Check Storage Path
```bash
ls -la storage/app/public/suspects/
```

### Check Routes
```bash
php artisan route:list | grep suspect
```

### Check Database
```bash
php artisan tinker
>>> Suspect::all()
>>> Suspect::find(1)->photo
```

---

## ⚡ Performance Optimizations

1. **Pagination**: 15 items per halaman untuk optimize loading
2. **Lazy Load Photos**: Thumbnail preview 50x50px
3. **Eager Loading**: With relationships di query
4. **Database Indexing**: NIK field punya index
5. **Caching**: Route cache untuk production

---

## 📱 Responsive Design

### Breakpoints
- **xs** (< 576px): Single column
- **sm** (≥ 576px): 2 columns
- **md** (≥ 768px): Full layout
- **lg** (≥ 992px): Optimized layout
- **xl** (≥ 1200px): Full width

### Table Responsive
```blade
<div class="table-responsive">
    <table class="table">...</table>
</div>
```

---

## 🎯 Common Use Cases

### Add New Suspect
```
1. Click "Add Suspect" button
2. Fill form
3. Upload photo (optional)
4. Click "Add Suspect"
5. Redirect to list
```

### Edit Suspect
```
1. Click "Edit" button on row
2. Update fields
3. Click "Update Suspect"
4. Old photo deleted, new saved
```

### Import Bulk Data
```
1. Prepare Excel file with correct format
2. Click "Import Excel" button
3. Select file
4. Click "Import"
5. All data imported automatically
```

### Delete Suspect
```
1. Click "Delete" button on row
2. Confirm deletion
3. Data and photo deleted
4. Redirect to list
```

---

## 📞 Support & Troubleshooting

### Problem: Import fails dengan "Class not found"
```bash
composer dump-autoload
php artisan cache:clear
```

### Problem: Photos tidak tampil
```bash
php artisan storage:link
chmod -R 775 storage/app/public
```

### Problem: Modal tidak muncul
- Check browser console for JS errors
- Verify Bootstrap modal JS loaded
- Check modal ID matches button data-target

### Problem: Validation errors tidak tampil
- Check @error directive in form
- Verify form has @csrf token
- Check request return back() with errors

---

## 📊 Status Codes & Messages

| Action | Status | Message |
|--------|--------|---------|
| Create Success | 200 | Data tersangka berhasil ditambahkan |
| Update Success | 200 | Data tersangka berhasil diubah |
| Delete Success | 200 | Data tersangka berhasil dihapus |
| Import Success | 200 | Data berhasil diimport |
| Validation Error | 422 | [Field] tidak boleh kosong |
| Duplicate NIK | 422 | NIK sudah terdaftar |
| File Error | 422 | Format file tidak didukung |

---

## 🔗 Related Routes

```
GET  /              → Login page
POST /login         → Authenticate
POST /logout        → Logout
GET  /suspect       → List all suspects
GET  /suspect/search → Search by NIK
POST /suspect/import → Import Excel (NEW)
POST /suspect/store → Create suspect (NEW)
PUT  /suspect/update/{id} → Update suspect (NEW)
DELETE /suspect/delete/{id} → Delete suspect (NEW)
```

---

## 📚 Dependencies

```json
{
    "maatwebsite/excel": "^3.1"
}
```

Docs: https://docs.laravel-excel.com/

---

## ⚙️ Configuration

### Disk Configuration (config/filesystems.php)
```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'path' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

### App Configuration
```php
FILESYSTEM_DISK=public
FILESYSTEM_VISIBILITY=public
```

---

**Last Updated:** Feb 17, 2026
**Version:** 1.0.0
**Status:** Production Ready ✅

