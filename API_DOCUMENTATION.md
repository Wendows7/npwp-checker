# 📚 API DOCUMENTATION - Suspect Module

## Base URL
```
http://your-app-url.local
```

---

## Authentication
Semua endpoint require authentication (`auth` middleware)

**Method:** Session-based (Login required)

---

## Endpoints Reference

## 1️⃣ LIST ALL SUSPECTS

### Endpoint
```
GET /suspect
```

### Description
Menampilkan semua data suspect dengan pagination (15 item per halaman)

### Query Parameters
| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| page | integer | No | 1 | Halaman data |

### Response
```json
{
    "data": [
        {
            "id": 1,
            "nik": "1234567890123456",
            "name": "John Doe",
            "alias": "Johnny",
            "gender": "Male",
            "place_of_birth": "Jakarta",
            "date_of_birth": "1990-01-15",
            "age": 33,
            "religion": "Islam",
            "education": "SMA",
            "occupation": "Engineer",
            "address": "Jl Merdeka No 1",
            "finger_code": "FP001",
            "photo": "suspects/photo.jpg",
            "created_at": "2026-02-17 10:30:00",
            "updated_at": "2026-02-17 10:30:00"
        }
    ],
    "pagination": {
        "total": 50,
        "per_page": 15,
        "current_page": 1,
        "last_page": 4
    }
}
```

### HTTP Status
- `200 OK` - Success
- `401 Unauthorized` - Not authenticated

### Example
```bash
curl -X GET "http://app.local/suspect?page=1"
```

---

## 2️⃣ SEARCH SUSPECT BY NIK

### Endpoint
```
GET /suspect/search
```

### Description
Mencari suspect berdasarkan NIK dengan case-sensitive exact match

### Query Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| slug | string | ✅ Yes | NIK suspect yang dicari |

### Response (Success)
```json
{
    "data": [
        {
            "id": 1,
            "nik": "1234567890123456",
            "name": "John Doe",
            ...
            "cases": [
                {
                    "id": 1,
                    "number": "CASE-001",
                    "name": "Case Name",
                    ...
                }
            ]
        }
    ]
}
```

### Response (Not Found)
```
Redirect ke /suspect dengan error message
```

### HTTP Status
- `200 OK` - Found
- `302 Redirect` - Not found
- `401 Unauthorized` - Not authenticated

### Example
```bash
curl -X GET "http://app.local/suspect/search?slug=1234567890123456"
```

---

## 3️⃣ CREATE SUSPECT

### Endpoint
```
POST /suspect/store
```

### Description
Membuat data suspect baru

### Request Headers
```
Content-Type: multipart/form-data
X-Requested-With: XMLHttpRequest (optional, for AJAX)
```

### Form Parameters
| Field | Type | Required | Max Length | Description |
|-------|------|----------|-----------|-------------|
| nik | string | ✅ Yes | 20 | Nomor Induk Kependudukan (Unique) |
| name | string | ✅ Yes | 255 | Nama lengkap suspect |
| gender | string | ✅ Yes | 10 | "Male" atau "Female" |
| alias | string | No | 255 | Alias/nickname |
| place_of_birth | string | No | 255 | Tempat lahir |
| date_of_birth | date | No | - | Tanggal lahir (YYYY-MM-DD) |
| age | integer | No | - | Umur |
| religion | string | No | 50 | Agama |
| education | string | No | 100 | Pendidikan terakhir |
| occupation | string | No | 100 | Pekerjaan |
| address | string | No | - | Alamat lengkap |
| finger_code | string | No | 100 | Kode fingerprint |
| photo | file | No | 2MB | Foto (jpeg, png, jpg, gif) |

### Response (Success)
```json
{
    "status": "success",
    "message": "Data tersangka berhasil ditambahkan",
    "data": {
        "id": 1,
        "nik": "1234567890123456",
        "name": "John Doe",
        ...
    }
}
```

### Response (Validation Error)
```json
{
    "status": "error",
    "message": "Validation failed",
    "errors": {
        "nik": ["NIK sudah terdaftar dalam sistem"],
        "name": ["Nama tidak boleh kosong"]
    }
}
```

### HTTP Status
- `201 Created` / `200 OK` - Success + Redirect
- `422 Unprocessable Entity` - Validation error
- `401 Unauthorized` - Not authenticated

### Example (cURL)
```bash
curl -X POST "http://app.local/suspect/store" \
  -F "nik=1234567890123456" \
  -F "name=John Doe" \
  -F "gender=Male" \
  -F "photo=@/path/to/photo.jpg"
```

### Example (JavaScript/Fetch)
```javascript
const formData = new FormData();
formData.append('nik', '1234567890123456');
formData.append('name', 'John Doe');
formData.append('gender', 'Male');
formData.append('photo', fileInput.files[0]);

fetch('/suspect/store', {
    method: 'POST',
    body: formData,
    headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    }
})
.then(response => response.json())
.then(data => console.log(data));
```

---

## 4️⃣ UPDATE SUSPECT

### Endpoint
```
PUT /suspect/update/{suspect_id}
```

### Description
Update data suspect existing

### URL Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| suspect_id | integer | ✅ Yes | ID suspect yang akan diupdate |

### Request Headers
```
Content-Type: multipart/form-data
X-Requested-With: XMLHttpRequest (optional)
```

### Form Parameters
Same as CREATE (semua field optional, minimum 1 field harus diisi)

Plus special handling:
- `_method` = "PUT" (untuk form HTML)

### Response (Success)
```json
{
    "status": "success",
    "message": "Data tersangka berhasil diubah",
    "data": {
        "id": 1,
        "nik": "1234567890123456",
        ...
    }
}
```

### HTTP Status
- `200 OK` - Success + Redirect
- `404 Not Found` - Suspect tidak ditemukan
- `422 Unprocessable Entity` - Validation error
- `401 Unauthorized` - Not authenticated

### Example (cURL with PUT)
```bash
curl -X POST "http://app.local/suspect/update/1" \
  -F "_method=PUT" \
  -F "name=John Doe Updated" \
  -F "age=34" \
  -F "photo=@/path/to/new-photo.jpg"
```

### Example (JavaScript/Fetch)
```javascript
const formData = new FormData();
formData.append('_method', 'PUT');
formData.append('name', 'John Doe Updated');
formData.append('age', 34);
formData.append('photo', fileInput.files[0]);

fetch('/suspect/update/1', {
    method: 'POST',
    body: formData,
    headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    }
})
.then(response => response.json())
.then(data => console.log(data));
```

---

## 5️⃣ DELETE SUSPECT

### Endpoint
```
DELETE /suspect/delete/{suspect_id}
```

### Description
Menghapus data suspect dan foto (jika ada)

### URL Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| suspect_id | integer | ✅ Yes | ID suspect yang akan dihapus |

### Request Headers
```
Content-Type: application/x-www-form-urlencoded
X-Requested-With: XMLHttpRequest (optional)
```

### Form Parameters
```
_method=DELETE
_token={csrf_token}
```

### Response (Success)
```json
{
    "status": "success",
    "message": "Data tersangka berhasil dihapus"
}
```

### HTTP Status
- `200 OK` - Success + Redirect
- `404 Not Found` - Suspect tidak ditemukan
- `401 Unauthorized` - Not authenticated

### Example (cURL)
```bash
curl -X POST "http://app.local/suspect/delete/1" \
  -d "_method=DELETE" \
  -d "_token={csrf_token}"
```

### Example (JavaScript/Fetch)
```javascript
const token = document.querySelector('input[name="_token"]').value;

fetch('/suspect/delete/1', {
    method: 'POST',
    body: new URLSearchParams({
        '_method': 'DELETE',
        '_token': token
    }),
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-CSRF-TOKEN': token
    }
})
.then(response => response.json())
.then(data => console.log(data));
```

---

## 6️⃣ IMPORT SUSPECTS FROM EXCEL

### Endpoint
```
POST /suspect/import
```

### Description
Bulk import suspect data dari file Excel

### Request Headers
```
Content-Type: multipart/form-data
```

### Form Parameters
| Field | Type | Required | Max Size | Description |
|-------|------|----------|----------|-------------|
| excel_file | file | ✅ Yes | No limit | File Excel (.xlsx, .xls, .csv) |

### Excel File Format
Harus memiliki header row dengan kolom:
```
nik | name | alias | gender | place_of_birth | date_of_birth | age | religion | education | occupation | address | finger_code | photo
```

### Response (Success)
```json
{
    "status": "success",
    "message": "Data berhasil diimport",
    "imported_count": 25
}
```

### Response (File Error)
```json
{
    "status": "error",
    "message": "File validation failed",
    "errors": {
        "excel_file": ["Format file harus .xlsx, .xls, atau .csv"]
    }
}
```

### Response (Import Error)
```json
{
    "status": "error",
    "message": "Gagal mengimport data: Duplicate entry for nik '1234567890123456'"
}
```

### HTTP Status
- `200 OK` - Success + Redirect
- `422 Unprocessable Entity` - File validation error
- `500 Internal Server Error` - Import error
- `401 Unauthorized` - Not authenticated

### Example (cURL)
```bash
curl -X POST "http://app.local/suspect/import" \
  -F "excel_file=@/path/to/suspects.xlsx"
```

### Example (JavaScript/Fetch with FormData)
```javascript
const formData = new FormData();
formData.append('excel_file', fileInput.files[0]);

fetch('/suspect/import', {
    method: 'POST',
    body: formData,
    headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    }
})
.then(response => response.json())
.then(data => {
    if (data.status === 'success') {
        alert(`Successfully imported ${data.imported_count} records`);
    } else {
        alert(`Error: ${data.message}`);
    }
});
```

---

## Error Codes & Messages

| Code | Message | Meaning |
|------|---------|---------|
| 200 | Success | Request berhasil |
| 201 | Created | Resource berhasil dibuat |
| 302 | Redirect | Redirect ke halaman lain |
| 401 | Unauthorized | Belum login / session expired |
| 404 | Not Found | Resource tidak ditemukan |
| 422 | Validation Error | Data validation gagal |
| 500 | Server Error | Internal server error |

---

## Validation Rules

### NIK
- Required
- Unique di database
- String max 20 chars
- Only alphanumeric

### Name
- Required
- String
- Max 255 chars

### Gender
- Required
- Must be "Male" or "Female"
- Case-sensitive

### Photo
- Optional
- Mimes: jpeg, png, jpg, gif
- Max size: 2MB

### Email (if applicable)
- Unique (per suspect)
- Valid email format

---

## Rate Limiting
Tidak ada rate limiting set. Sesuaikan sesuai kebutuhan di `.env`:
```
RATE_LIMIT=60,1
```

---

## CORS Headers
Jika API akan diakses dari domain berbeda, pastikan CORS middleware terkonfigurasi.

---

## Authentication Token
Gunakan session cookie dari login:
```
Cookie: XSRF-TOKEN=...; laravel_session=...
```

---

## Pagination

### Format
```json
{
    "data": [...],
    "pagination": {
        "total": 100,
        "per_page": 15,
        "current_page": 1,
        "last_page": 7,
        "from": 1,
        "to": 15
    }
}
```

### Query Parameters
```
?page=2&per_page=20
```

---

## Filtering & Sorting

### Search by NIK
```
GET /suspect/search?slug={nik}
```

### Sort (Coming Soon)
Implementation untuk sort by column belum tersedia.

---

## Data Types

| Type | Format | Example |
|------|--------|---------|
| string | Text | "John Doe" |
| integer | Number | 33 |
| date | YYYY-MM-DD | "1990-01-15" |
| email | Email format | "john@email.com" |
| file | Binary | multipart file |
| boolean | true/false | true |

---

## API Testing Tools

### Postman
1. Import endpoints ke Postman
2. Set base URL: `http://app.local`
3. Add Cookie header untuk auth
4. Test setiap endpoint

### Thunder Client
VS Code extension untuk API testing

### cURL
Command line tool (examples di atas)

---

## Example Workflow

```
1. GET /suspect
   → Lihat list semua suspect

2. POST /suspect/store
   → Add suspect baru

3. PUT /suspect/update/{id}
   → Update suspect

4. GET /suspect/search?slug={nik}
   → Search specific suspect

5. DELETE /suspect/delete/{id}
   → Delete suspect

6. POST /suspect/import
   → Import bulk data dari Excel
```

---

## Support

Untuk pertanyaan atau issue, lihat file:
- CHANGELOG_SUSPECT.md
- VERIFICATION_CHECKLIST.md
- QUICK_REFERENCE.md

---

**API Version:** 1.0.0
**Last Updated:** February 17, 2026
**Status:** Production Ready ✅

