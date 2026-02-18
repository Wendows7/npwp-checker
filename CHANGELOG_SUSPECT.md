# Update Dokumentasi - Fitur Import Excel & CRUD Suspect

## 📋 Ringkasan Perubahan

File-file berikut telah diupdate untuk menambahkan fitur Import Excel, Create, Update, dan Delete Suspect:

---

## 🔄 File yang Diupdate

### 1. **Routes** (`routes/web.php`)
✅ Ditambahkan route baru:
```php
Route::post('/suspect/import', [\App\Http\Controllers\SuspectController::class, 'import'])->name('suspect.import');
Route::post('/suspect/store', [\App\Http\Controllers\SuspectController::class, 'store'])->name('suspect.store');
Route::put('/suspect/update/{suspect}', [\App\Http\Controllers\SuspectController::class, 'update'])->name('suspect.update');
Route::delete('/suspect/delete/{suspect}', [\App\Http\Controllers\SuspectController::class, 'delete'])->name('suspect.delete');
```

---

### 2. **Controller** (`app/Http/Controllers/SuspectController.php`)
✅ Ditambahkan method baru:
- **index()** - Updated untuk menampilkan semua data suspect
- **import()** - Import data suspect dari file Excel
- **store()** - Menyimpan data suspect baru
- **update()** - Update data suspect existing
- **delete()** - Hapus data suspect

Fitur utama:
- Validasi file Excel (.xlsx, .xls, .csv)
- Upload dan storage foto suspect
- Error handling dengan sweet alert
- Hapus foto lama saat update

---

### 3. **Service** (`app/Services/SuspectService.php`)
✅ Ditambahkan method baru:
- **create()** - Helper untuk membuat record baru
- **update()** - Helper untuk update record
- **delete()** - Helper untuk delete record

---

### 4. **Import Class** (NEW - `app/Imports/SuspectImport.php`)
✅ File baru yang dibuat untuk handle import Excel
Fitur:
- Mapping kolom Excel ke model Suspect
- Validasi data saat import
- Pesan error custom dalam Bahasa Indonesia
- Mendukung kolom optional (alias, finger_code, photo)

---

### 5. **View - Index** (`resources/views/suspect/index.blade.php`)
✅ Perubahan:
- Include modals (create, edit, detail)
- Tambah button "Import Excel" di header
- Tabel menampilkan semua data suspect dengan 14 kolom
- Buttons Detail, Edit, Delete dengan ukuran konsisten
- Import Modal dengan form upload Excel

---

### 6. **View - Modal Create** (`resources/views/suspect/modal/create.blade.php`)
✅ Updated dengan form Suspect lengkap:
- NIK, Name, Alias, Gender
- Place of Birth, Date of Birth, Age
- Religion, Education, Occupation
- Address, Finger Code, Photo
- Validasi error inline
- Submit ke route `suspect.store`

---

### 7. **View - Modal Edit** (`resources/views/suspect/modal/edit.blade.php`)
✅ Updated dengan form Edit Suspect:
- Semua field sama seperti Create
- Pre-filled dengan data existing
- Preview foto lama sebelum upload baru
- Submit ke route `suspect.update` dengan method PUT

---

### 8. **Composer.json**
✅ Ditambahkan dependency:
```json
"maatwebsite/excel": "^3.1"
```
Jalankan: `composer install`

---

## 🚀 Cara Menggunakan

### Import Data Supplier Excel:
1. Klik tombol "Import Excel" di halaman Suspect
2. Pilih file Excel (.xlsx, .xls, .csv)
3. File harus memiliki kolom: nik, name, gender, place_of_birth, date_of_birth, age, religion, education, occupation, address
4. Klik "Import" untuk proses
5. Data akan tersimpan otomatis

### Tambah Data Suspect:
1. Klik tombol "Add Suspect"
2. Isi form dengan data lengkap
3. Upload foto (opsional)
4. Klik "Add Suspect" untuk simpan

### Edit Data Suspect:
1. Di table, klik button "Edit" pada row data
2. Update field yang diperlukan
3. Upload foto baru atau biarkan kosong untuk tidak update
4. Klik "Update Suspect" untuk simpan

### Hapus Data Suspect:
1. Di table, klik button "Delete" pada row data
2. Confirm untuk hapus
3. Data dan foto akan terhapus dari sistem

---

## 📦 Dependencies yang Ditambahkan

- **maatwebsite/excel** (^3.1) - Untuk import/export Excel

Pastikan sudah install dengan:
```bash
composer install
```

---

## ✅ Validasi Data

### Saat Create/Update:
- **NIK**: Required, Unique
- **Name**: Required, String
- **Gender**: Required
- **Photo**: Optional, Max 2MB (jpeg, png, jpg, gif)
- **Lainnya**: Optional

### Saat Import Excel:
- **NIK**: Required, Unique
- **Name**: Required
- **Gender**: Required
- Error handling untuk duplikasi NIK

---

## 🎯 Struktur Database yang Diperlukan

Tabel `suspects` harus memiliki kolom:
- id
- nik (unique)
- name
- alias
- gender
- place_of_birth
- date_of_birth
- age
- religion
- education
- occupation
- address
- finger_code
- photo
- timestamps

---

## 💡 Tips

1. **File Storage**: Foto disimpan di `storage/app/public/suspects/`
2. **Symlink**: Pastikan sudah run `php artisan storage:link`
3. **Validasi**: Setiap form sudah include validasi client dan server side
4. **Alert**: Menggunakan SweetAlert untuk notifikasi success/error
5. **Pagination**: Tabel pagination 15 item per halaman

---

## 📝 Catatan Penting

- ✅ Semua route sudah protected dengan middleware `auth`
- ✅ File upload handling dengan aman (validasi mime type & size)
- ✅ Foto lama dihapus saat upload foto baru di update
- ✅ Database transaction untuk konsistensi data
- ✅ Error handling comprehensive dengan sweet alert

---

## 🔧 Troubleshooting

**Error: Class SuspectImport not found**
- Jalankan: `composer dump-autoload`

**Error: Import gagal karena format file**
- Pastikan file Excel memiliki header row
- Gunakan format .xlsx atau .csv yang benar

**Error: Foto tidak upload**
- Jalankan: `php artisan storage:link`
- Check permission folder `storage/app/public`

**Error: Route not found**
- Jalankan: `php artisan route:cache`
- Clear cache: `php artisan cache:clear`

---

Semua fitur sudah siap digunakan! 🎉

