# 📊 EXCEL IMPORT TEMPLATE GUIDE

## Format File Excel untuk Import Data Suspect

File Excel HARUS memiliki header row dengan kolom-kolom berikut (dalam urutan ini):

### Header Row (Baris Pertama)

```
nik | name | alias | gender | place_of_birth | date_of_birth | age | religion | education | occupation | address | finger_code | photo
```

---

## Penjelasan Setiap Kolom

| No | Kolom | Tipe | Required | Contoh | Catatan |
|----|-------|------|----------|--------|---------|
| 1 | nik | String | ✅ Ya | 1234567890123456 | Max 20 char, Unique |
| 2 | name | String | ✅ Ya | John Doe | Nama lengkap |
| 3 | alias | String | ❌ Opsional | Johnny | Bisa dikosongkan |
| 4 | gender | String | ✅ Ya | Male | Male atau Female |
| 5 | place_of_birth | String | ❌ Opsional | Jakarta | Kota kelahiran |
| 6 | date_of_birth | Date | ❌ Opsional | 1990-01-15 | Format: YYYY-MM-DD |
| 7 | age | Integer | ❌ Opsional | 33 | Angka saja |
| 8 | religion | String | ❌ Opsional | Islam | Agama |
| 9 | education | String | ❌ Opsional | SMA | Pendidikan terakhir |
| 10 | occupation | String | ❌ Opsional | Engineer | Pekerjaan |
| 11 | address | String | ❌ Opsional | Jl Merdeka No 123 | Alamat lengkap |
| 12 | finger_code | String | ❌ Opsional | FP001 | Kode fingerprint |
| 13 | photo | String | ❌ Opsional | /path/to/photo.jpg | Path atau URL foto |

---

## Contoh Data Lengkap

### Row 1 (Complete Data)
```
nik                | name      | alias  | gender | place_of_birth | date_of_birth | age | religion | education | occupation | address          | finger_code | photo
1234567890123456   | John Doe  | Johnny | Male   | Jakarta        | 1990-01-15    | 33  | Islam    | SMA       | Engineer   | Jl Merdeka No 1  | FP001       |
```

### Row 2 (Minimal Data)
```
nik                | name       | alias | gender | place_of_birth | date_of_birth | age | religion | education | occupation | address | finger_code | photo
1234567890123457   | Jane Smith |       | Female |                |               |     |          |           |            |         |             |
```

### Row 3 (Mixed Data)
```
nik                | name          | alias    | gender | place_of_birth | date_of_birth | age | religion | education | occupation | address          | finger_code | photo
1234567890123458   | Ahmad Hassan  | Ahmadh   | Male   | Bandung        | 1992-05-20    | 31  | Islam    | S1        | Analyst    | Jl Sudirman 456  | FP003       |
```

---

## Template Excel Kosong

Salin dan gunakan template berikut di Excel file Anda:

```
nik | name | alias | gender | place_of_birth | date_of_birth | age | religion | education | occupation | address | finger_code | photo
    |      |       |        |                |               |     |          |           |            |         |             |
    |      |       |        |                |               |     |          |           |            |         |             |
    |      |       |        |                |               |     |          |           |            |         |             |
    |      |       |        |                |               |     |          |           |            |         |             |
    |      |       |        |                |               |     |          |           |            |         |             |
```

---

## Format Khusus Setiap Kolom

### NIK
- **Format:** Angka saja, max 20 karakter
- **Unik:** Tidak boleh ada duplikasi
- **Validasi:** Required
- **Contoh:** `1234567890123456`, `1001012345678901`

### Name
- **Format:** Text/String
- **Validasi:** Required, tidak boleh kosong
- **Contoh:** `John Doe`, `Ahmad Hassan`

### Gender
- **Format:** Text (exactly "Male" atau "Female")
- **Validasi:** Required, case-sensitive
- **Contoh:** `Male`, `Female`
- ❌ SALAH: `male`, `M`, `1`

### Date of Birth
- **Format:** Date dengan format YYYY-MM-DD
- **Validasi:** Optional
- **Contoh:** `1990-01-15`, `1992-12-31`
- ❌ SALAH: `01/15/1990`, `15-01-1990`

### Age
- **Format:** Number/Integer
- **Validasi:** Optional, harus angka
- **Contoh:** `33`, `28`, `45`
- ❌ SALAH: `33 tahun`, `thirty`

---

## Aturan Penting

✅ **DO:**
- Gunakan format Excel standar (.xlsx atau .xls)
- Pastikan header row di baris pertama
- Pisahkan data dengan tab atau comma (CSV)
- Gunakan format date YYYY-MM-DD
- Gunakan "Male" atau "Female" (exact case)
- Kosongkan kolom optional jika tidak ada data
- Escape special characters di text field

❌ **DON'T:**
- Jangan gunakan format XLS lama jika bisa XLSX
- Jangan merge cells di header
- Jangan tambah warna atau formatting fancy
- Jangan gunakan gender "m" atau "f"
- Jangan format date berbeda (DD/MM/YYYY)
- Jangan spasi di akhir data
- Jangan ada data duplikasi di NIK

---

## Common Errors & Solutions

### Error: "NIK sudah terdaftar"
**Penyebab:** NIK sudah ada di database
**Solusi:** Check database atau gunakan NIK yang unik

### Error: "Nama tidak boleh kosong"
**Penyebab:** Column "name" kosong
**Solusi:** Isi semua baris di kolom "name"

### Error: "Gender tidak boleh kosong"
**Penyebab:** Column "gender" kosong atau format salah
**Solusi:** Gunakan "Male" atau "Female" (exact)

### Error: "File format tidak didukung"
**Penyebab:** Format file bukan .xlsx, .xls, atau .csv
**Solusi:** Save Excel file sebagai .xlsx

### Error: "Tanggal format salah"
**Penyebab:** Format date bukan YYYY-MM-DD
**Solusi:** Gunakan format `1990-01-15` (ISO format)

---

## Step-by-Step Guide

### Menggunakan Microsoft Excel

1. Buka Excel
2. Di baris pertama, ketik header:
   ```
   nik | name | alias | gender | place_of_birth | date_of_birth | age | religion | education | occupation | address | finger_code | photo
   ```
3. Di baris 2 ke bawah, isi data suspect
4. Save as → Format: Excel Workbook (.xlsx)
5. Upload via aplikasi

### Menggunakan Google Sheets

1. Buka Google Sheets
2. Buat header di baris pertama (seperti di atas)
3. Isi data mulai baris 2
4. Download → Format: Excel (.xlsx)
5. Upload via aplikasi

### Menggunakan CSV (Text Editor)

1. Buat file baru di text editor (Notepad, VS Code, dll)
2. Ketik data dengan format:
   ```
   nik,name,alias,gender,place_of_birth,date_of_birth,age,religion,education,occupation,address,finger_code,photo
   1234567890123456,John Doe,Johnny,Male,Jakarta,1990-01-15,33,Islam,SMA,Engineer,Jl Merdeka,FP001,
   1234567890123457,Jane Smith,,Female,Bandung,1992-05-20,31,Catholic,S1,Analyst,Jl Sudirman,FP002,
   ```
3. Save as `.csv` file
4. Upload via aplikasi

---

## Validasi Data Sebelum Upload

### Checklist

- [ ] Header row ada di baris pertama
- [ ] Semua baris punya nilai NIK (tidak kosong)
- [ ] Semua baris punya nilai Name (tidak kosong)
- [ ] Semua baris punya nilai Gender ("Male" atau "Female")
- [ ] Tidak ada duplikasi NIK
- [ ] Format date adalah YYYY-MM-DD (jika ada)
- [ ] Age adalah angka saja (jika ada)
- [ ] Tidak ada space di awal/akhir data
- [ ] Tidak ada karakter special di NIK
- [ ] File format adalah .xlsx, .xls, atau .csv

---

## Sample Files

### Minimal Import (Required Fields Only)

```
nik,name,gender
1234567890123456,John Doe,Male
1234567890123457,Jane Smith,Female
1234567890123458,Ahmad Hassan,Male
```

### Complete Import (All Fields)

```
nik,name,alias,gender,place_of_birth,date_of_birth,age,religion,education,occupation,address,finger_code,photo
1234567890123456,John Doe,Johnny,Male,Jakarta,1990-01-15,33,Islam,SMA,Engineer,Jl Merdeka No 1,FP001,
1234567890123457,Jane Smith,Jane,Female,Bandung,1992-05-20,31,Catholic,S1,Analyst,Jl Sudirman No 456,FP002,
1234567890123458,Ahmad Hassan,Ahmad,Male,Surabaya,1988-03-10,35,Islam,S1,Manager,Jl Ahmad Yani,FP003,
1234567890123459,Siti Nurhaliza,Siti,Female,Medan,1995-07-25,28,Islam,SMA,Designer,Jl Gatot Subroto,FP004,
1234567890123460,Budi Santoso,Budi,Male,Yogyakarta,1991-11-30,32,Catholic,S1,Developer,Jl Malioboro,FP005,
```

---

## Batch Upload Best Practices

### Untuk Upload Besar (100+ Records)

1. Pisahkan data jadi multiple files (max 50 records per file)
2. Upload satu per satu
3. Check setiap upload di halaman list
4. Jika ada error, fix dan retry

### Untuk Data Existing (Update)

1. Jangan import data yang sudah ada (akan error duplicate NIK)
2. Untuk update, gunakan feature Edit di UI
3. Jangan mix insert dan update dalam satu file

---

## Excel File Naming Convention

Gunakan naming yang jelas:

```
✅ GOOD:
- suspect_import_batch1.xlsx
- suspect_2024_02.xlsx
- import_suspects_jan.xlsx

❌ BAD:
- file.xlsx
- data.xlsx
- import.xlsx
```

---

## Data Privacy & Security

⚠️ **Penting:**
- Jangan share file Excel yang berisi data real
- Jangan store file di public folder
- Hapus file setelah import selesai
- Backup database sebelum bulk import
- Log semua import activities

---

## Support & Testing

### Test dengan Sample Data

Download atau buat file Excel dengan sample data:

```
nik,name,alias,gender,place_of_birth,date_of_birth,age,religion,education,occupation,address,finger_code,photo
9999999999999999,Test User 1,Test1,Male,Test City,2000-01-01,24,Islam,SMA,Test Job,Test Address,TEST001,
9999999999999998,Test User 2,Test2,Female,Test City,2000-01-02,24,Catholic,S1,Test Job,Test Address,TEST002,
```

Kemudian test upload via aplikasi.

---

**Version:** 1.0
**Last Updated:** February 17, 2026
**Status:** Ready to Use ✅

