# 📚 Dynamic Multiple Cases - User Guide

## 🎯 Fitur Utama

### ✨ Sekarang Anda Bisa:
1. **Membuat suspect tanpa case sama sekali**
2. **Membuat suspect dengan 1 case**
3. **Membuat suspect dengan multiple cases (2, 3, 5, 10, dst...)**
4. **Edit suspect dan tambah/hapus/ubah cases sesuka hati**

---

## 📖 Panduan Penggunaan

### 1️⃣ **Create Suspect - Tanpa Case**

```
Langkah:
1. Klik button "Add Suspect"
2. Isi form suspect:
   - NIK (required)
   - Name (required)
   - Gender (required)
   - Fields lainnya (optional)
3. Jangan klik button "Add Case"
4. Klik "Add Suspect"

Hasil:
✅ Suspect tersimpan TANPA case
```

---

### 2️⃣ **Create Suspect - Dengan 1 Case**

```
Langkah:
1. Klik button "Add Suspect"
2. Isi form suspect (NIK, Name, Gender, dll)
3. Klik button "Add Case"
   → Muncul form "Case #1"
4. Isi data case:
   - Case Number
   - Case Name
   - Chapter/Pasal
   - Place
   - Date & Time
   - Division
   - Decision
   - Description
5. Klik "Add Suspect"

Hasil:
✅ Suspect tersimpan dengan 1 case
```

---

### 3️⃣ **Create Suspect - Dengan Multiple Cases**

```
Langkah:
1. Klik button "Add Suspect"
2. Isi form suspect (NIK, Name, Gender, dll)

3. Tambah Case #1:
   - Klik "Add Case"
   - Isi data case pertama

4. Tambah Case #2:
   - Klik "Add Case" lagi
   - Isi data case kedua

5. Tambah Case #3:
   - Klik "Add Case" lagi
   - Isi data case ketiga

6. Dst... (bisa tambah sebanyak yang diinginkan)

7. Klik "Add Suspect"

Hasil:
✅ Suspect tersimpan dengan 3 cases (atau lebih)
```

---

### 4️⃣ **Create Suspect - Batalkan Case yang Sudah Ditambahkan**

```
Langkah:
1. Klik button "Add Suspect"
2. Isi form suspect
3. Klik "Add Case" → Isi Case #1
4. Klik "Add Case" → Isi Case #2
5. Klik "Add Case" → Isi Case #3

6. Ups! Case #2 salah, hapus:
   → Klik button "Remove" di Case #2
   → Case #2 hilang

7. Sekarang tinggal Case #1 dan Case #3
8. Klik "Add Suspect"

Hasil:
✅ Suspect tersimpan dengan 2 cases (Case #1 dan Case #3)
```

---

### 5️⃣ **Edit Suspect - Tanpa Mengubah Cases**

```
Langkah:
1. Klik button "Edit" pada suspect
2. Modal terbuka dengan:
   - Data suspect
   - Semua cases yang sudah ada (misal: 3 cases)
3. Ubah data suspect (misal: ganti Name atau Address)
4. Jangan ubah apapun di cases
5. Klik "Update Suspect"

Hasil:
✅ Data suspect terupdate
✅ Cases tetap sama (tidak berubah)
```

---

### 6️⃣ **Edit Suspect - Update Existing Case**

```
Langkah:
1. Klik button "Edit" pada suspect
2. Modal terbuka dengan cases yang sudah ada
3. Ubah data suspect (optional)
4. Ubah data di Case #1:
   - Ganti "Case Number" dari "CASE-001" ke "CASE-001-REV"
   - Ganti "Decision" dari "Pending" ke "Guilty"
5. Klik "Update Suspect"

Hasil:
✅ Data suspect terupdate
✅ Case #1 terupdate
✅ Cases lainnya tetap sama
```

---

### 7️⃣ **Edit Suspect - Tambah Case Baru**

```
Langkah:
1. Klik button "Edit" pada suspect
2. Modal terbuka dengan 2 cases yang sudah ada:
   - Case #1
   - Case #2

3. Tambah case baru:
   - Klik button "Add Case"
   - Muncul form "Case #3"
   - Isi data case baru

4. Tambah lagi (optional):
   - Klik "Add Case" lagi
   - Muncul form "Case #4"
   - Isi data

5. Klik "Update Suspect"

Hasil:
✅ Data suspect terupdate
✅ Case #1 dan #2 tetap ada
✅ Case #3 dan #4 ditambahkan
Total: 4 cases
```

---

### 8️⃣ **Edit Suspect - Hapus Case**

```
Langkah:
1. Klik button "Edit" pada suspect
2. Modal terbuka dengan 3 cases:
   - Case #1
   - Case #2
   - Case #3

3. Hapus Case #2:
   - Klik button "Remove" di Case #2
   - Case #2 hilang dari form

4. Klik "Update Suspect"

Hasil:
✅ Data suspect terupdate
✅ Case #1 dan #3 tetap ada
✅ Case #2 DIHAPUS dari database
Total: 2 cases
```

---

### 9️⃣ **Edit Suspect - Kombinasi (Update + Add + Remove)**

```
Scenario: Suspect punya 4 cases, mau:
- Update Case #1
- Hapus Case #2
- Tetap Case #3
- Hapus Case #4
- Tambah 2 case baru

Langkah:
1. Klik button "Edit" pada suspect
2. Modal terbuka dengan 4 cases

3. Update Case #1:
   - Ubah "Decision" menjadi "Guilty"

4. Hapus Case #2:
   - Klik "Remove" di Case #2

5. Biarkan Case #3:
   - Tidak diubah apapun

6. Hapus Case #4:
   - Klik "Remove" di Case #4

7. Tambah Case baru #5:
   - Klik "Add Case"
   - Isi data

8. Tambah Case baru #6:
   - Klik "Add Case"
   - Isi data

9. Klik "Update Suspect"

Hasil:
✅ Data suspect terupdate
✅ Case #1 terupdate (Decision changed)
✅ Case #2 DIHAPUS
✅ Case #3 tetap sama
✅ Case #4 DIHAPUS
✅ Case #5 DITAMBAHKAN (new)
✅ Case #6 DITAMBAHKAN (new)
Total: 4 cases (Case #1, #3, #5, #6)
```

---

## 🎨 Visual Guide

### **Create Modal - Form Kosong:**
```
┌─────────────────────────────────────────────────┐
│ Add Suspect                                  [×] │
├─────────────────────────────────────────────────┤
│ Suspect Information                             │
│ ┌────────────────┬──────────────────┐           │
│ │ NIK *          │ Name *           │           │
│ ├────────────────┼──────────────────┤           │
│ │ Alias          │ Gender *         │           │
│ └────────────────┴──────────────────┘           │
│ ... (other fields)                              │
│                                                  │
│ ─────────────────────────────────────────────   │
│                                                  │
│ Case Information (Optional)    [+ Add Case]     │
│                                                  │
│ (Empty - No cases yet)                          │
│                                                  │
├─────────────────────────────────────────────────┤
│                        [Cancel] [Add Suspect]   │
└─────────────────────────────────────────────────┘
```

### **Create Modal - Setelah Klik "Add Case" 2x:**
```
┌─────────────────────────────────────────────────┐
│ Add Suspect                                  [×] │
├─────────────────────────────────────────────────┤
│ Suspect Information                             │
│ ... (suspect fields)                            │
│                                                  │
│ ─────────────────────────────────────────────   │
│                                                  │
│ Case Information (Optional)    [+ Add Case]     │
│                                                  │
│ ┌──────────────────────────────────────────┐    │
│ │ Case #1                      [× Remove]  │    │
│ ├──────────────────────────────────────────┤    │
│ │ Case Number: [           ]               │    │
│ │ Case Name:   [           ]               │    │
│ │ Chapter:     [           ]               │    │
│ │ ... (other case fields)                  │    │
│ └──────────────────────────────────────────┘    │
│                                                  │
│ ┌──────────────────────────────────────────┐    │
│ │ Case #2                      [× Remove]  │    │
│ ├──────────────────────────────────────────┤    │
│ │ Case Number: [           ]               │    │
│ │ Case Name:   [           ]               │    │
│ │ Chapter:     [           ]               │    │
│ │ ... (other case fields)                  │    │
│ └──────────────────────────────────────────┘    │
│                                                  │
├─────────────────────────────────────────────────┤
│                        [Cancel] [Add Suspect]   │
└─────────────────────────────────────────────────┘
```

### **Edit Modal - Dengan Existing Cases:**
```
┌─────────────────────────────────────────────────┐
│ Edit Suspect                                 [×] │
├─────────────────────────────────────────────────┤
│ Suspect Information                             │
│ ... (suspect fields - filled with data)         │
│                                                  │
│ ─────────────────────────────────────────────   │
│                                                  │
│ Case Information (Optional)    [+ Add Case]     │
│                                                  │
│ ┌──────────────────────────────────────────┐    │
│ │ Case #1                      [× Remove]  │    │
│ ├──────────────────────────────────────────┤    │
│ │ Case Number: [CASE-001     ]  (Existing) │    │
│ │ Case Name:   [Theft        ]             │    │
│ │ Chapter:     [Pasal 362    ]             │    │
│ │ ... (other case fields - filled)         │    │
│ └──────────────────────────────────────────┘    │
│                                                  │
│ ┌──────────────────────────────────────────┐    │
│ │ Case #2                      [× Remove]  │    │
│ ├──────────────────────────────────────────┤    │
│ │ Case Number: [CASE-002     ]  (Existing) │    │
│ │ Case Name:   [Fraud        ]             │    │
│ │ Chapter:     [Pasal 378    ]             │    │
│ │ ... (other case fields - filled)         │    │
│ └──────────────────────────────────────────┘    │
│                                                  │
│ (Klik "Add Case" untuk tambah case baru)        │
│                                                  │
├─────────────────────────────────────────────────┤
│                      [Cancel] [Update Suspect]  │
└─────────────────────────────────────────────────┘
```

---

## 💡 Tips & Best Practices

### ✅ **DO:**
- Isi minimal NIK, Name, dan Gender untuk suspect (required)
- Tambahkan case sesuai kebutuhan (0 atau lebih)
- Gunakan button "Remove" untuk hapus case yang tidak diinginkan
- Setiap case minimal isi "Case Number" atau "Case Name"

### ❌ **DON'T:**
- Jangan submit form dengan case yang kosong semua field
  (akan di-skip otomatis oleh sistem)
- Jangan refresh page saat sedang mengisi form
  (data akan hilang)

---

## 🔧 Technical Notes

### **Form Input Names:**
```html
<!-- Suspect fields -->
<input name="nik">
<input name="name">
<input name="gender">
...

<!-- Cases array -->
<input name="cases[0][number]">
<input name="cases[0][name]">
<input name="cases[0][chapter]">
...

<input name="cases[1][number]">
<input name="cases[1][name]">
...

<!-- Edit: existing cases include ID -->
<input name="cases[0][id]" value="123">
<input name="cases[0][number]">
...
```

### **Backend Processing:**
```php
// Controller receives
$request->input('cases');
// Returns:
[
    0 => ['number' => '...', 'name' => '...', ...],
    1 => ['number' => '...', 'name' => '...', ...],
    2 => ['id' => 123, 'number' => '...', ...],  // Existing case
]

// Service processes
- Cases dengan 'id' → UPDATE
- Cases tanpa 'id' → CREATE
- Cases tidak di-submit → DELETE
```

---

## 🎉 Summary

Sekarang menu Suspect memiliki:

✅ **Table yang rapi dan sederhana** (NIK, Name, Gender, TTL, Action)
✅ **Dynamic form untuk multiple cases**
✅ **Flexibility penuh** (0 case, 1 case, atau banyak cases)
✅ **Easy add/remove** dengan UI yang intuitif
✅ **Smart update logic** (update/create/delete cases)
✅ **Transaction safety** (all-or-nothing)

**Happy managing suspects and cases!** 🚀

