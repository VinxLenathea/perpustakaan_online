# Form Blackbox Testing - Sistem Perpustakaan Online

**Project:** Perpustakaan Online (Laravel)  
**Test Type:** Blackbox Testing (Functional)  
**Tester:** ___________________  
**Date:** ___________________  
**Environment:** ___________________  

---

## How to Use This Form

1. Jalankan setiap **Test Case** sesuai dengan langkah-langkah yang tercantum
2. Catat **Actual Result** berdasarkan perilaku aplikasi yang diamati
3. Tandai **Status** sebagai:
   - ✅ **PASS** - Jika actual result sesuai dengan expected result
   - ❌ **FAIL** - Jika actual result tidak sesuai dengan expected result
   - ⏸️ **N/A** - Jika test case tidak dapat dijalankan
4. Tambahkan catatan di kolom **Remarks** jika diperlukan

---

## Legend

| Symbol | Meaning |
|--------|---------|
| ✅ | Pass |
| ❌ | Fail |
| ⏸️ | Not Applicable |
| 🔴 | Critical Priority |
| 🟡 | Medium Priority |
| 🟢 | Low Priority |

---

# Module 1: Authentication

## Test Scenario: TS-AUTH-01 - User Login

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| AUTH-001 | Valid login with correct credentials | User terdaftar di database | 1. Buka halaman login<br>2. Masukkan email dan password valid<br>3. Klik tombol "Login" | Email: admin@example.com<br>Password: password | User berhasil login dan diarahkan ke halaman dashboard | | | 🔴 | |
| AUTH-002 | Login with empty email | - | 1. Buka halaman login<br>2. Kosongkan field email<br>3. Isi password<br>4. Klik "Login" | Email: (kosong)<br>Password: password | Muncul pesan error validasi "Email wajib diisi" | | | 🔴 | |
| AUTH-003 | Login with empty password | - | 1. Buka halaman login<br>2. Isi email valid<br>3. Kosongkan password<br>4. Klik "Login" | Email: admin@example.com<br>Password: (kosong) | Muncul pesan error validasi "Password wajib diisi" | | | 🔴 | |
| AUTH-004 | Login with empty email and password | - | 1. Buka halaman login<br>2. Kosongkan semua field<br>3. Klik "Login" | Email: (kosong)<br>Password: (kosong) | Muncul pesan error validasi untuk kedua field | | | 🔴 | |
| AUTH-005 | Login with unregistered email | - | 1. Buka halaman login<br>2. Masukkan email yang tidak terdaftar<br>3. Klik "Login" | Email: tidakada@email.com<br>Password: password123 | Muncul pesan error "Email atau password salah" | | | 🔴 | |
| AUTH-006 | Login with wrong password | User terdaftar | 1. Buka halaman login<br>2. Masukkan email valid<br>3. Masukkan password salah<br>4. Klik "Login" | Email: admin@example.com<br>Password: wrongpassword | Muncul pesan error "Email atau password salah" | | | 🔴 | |
| AUTH-007 | Login with invalid email format | - | 1. Buka halaman login<br>2. Masukkan email tanpa format @<br>3. Klik "Login" | Email: invalidemail<br>Password: password123 | Muncul pesan error "Format email tidak valid" | | | 🟡 | |
| AUTH-008 | Login with SQL injection attempt | - | 1. Buka halaman login<br>2. Masukkan input SQL injection<br>3. Klik "Login" | Email: ' OR '1'='1<br>Password: ' OR '1'='1 | Sistem menolak input dan tidak terjadi unauthorized access | | | 🔴 | |
| AUTH-009 | Login with XSS attempt | - | 1. Buka halaman login<br>2. Masukkan script XSS<br>3. Klik "Login" | Email: <script>alert('xss')</script><br>Password: password | Script tidak dieksekusi, input di-sanitasi | | | 🔴 | |
| AUTH-010 | Login with extremely long password (>255 chars) | - | 1. Buka halaman login<br>2. Masukkan password dengan 500 karakter<br>3. Klik "Login" | Password: [500 karakter] | Sistem menangani dengan baik, tidak crash | | | 🟡 | |

## Test Scenario: TS-AUTH-02 - User Logout

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| AUTH-011 | Logout from authenticated session | User sudah login | 1. Klik tombol "Logout"<br>2. Konfirmasi logout (jika ada) | - | User berhasil logout dan diarahkan ke halaman login/welcome | | | 🔴 | |
| AUTH-012 | Access protected page after logout | User sudah logout | 1. Logout dari sistem<br>2. Coba akses /dashboard melalui URL | URL: /dashboard | Sistem redirect ke halaman login | | | 🔴 | |
| AUTH-013 | Use browser back button after logout | User sudah logout | 1. Logout<br>2. Tekan tombol back browser | - | Tidak bisa mengakses halaman protected, redirect ke login | | | 🔴 | |

---

# Module 2: Dashboard

## Test Scenario: TS-DASH-01 - Dashboard View

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| DASH-001 | View dashboard as authenticated user | User sudah login | 1. Login dengan akun valid<br>2. Akses halaman /dashboard | - | Dashboard ditampilkan dengan statistik total dokumen dan kategori | | | 🔴 | |
| DASH-002 | View dashboard as guest | User belum login | 1. Buka URL /dashboard tanpa login | URL: /dashboard | Redirect ke halaman login | | | 🔴 | |
| DASH-003 | Verify total document count accuracy | Ada data dokumen di database | 1. Login<br>2. Periksa jumlah total dokumen di dashboard<br>3. Bandingkan dengan data di database | - | Angka total dokumen sesuai dengan jumlah record di tabel documents | | | 🟡 | |
| DASH-004 | Verify category document count | Ada kategori dengan dokumen | 1. Login<br>2. Periksa jumlah dokumen per kategori<br>3. Bandingkan dengan database | - | Jumlah dokumen per kategori sesuai dengan relasi di database | | | 🟡 | |
| DASH-005 | Dashboard with zero documents | Database dokumen kosong | 1. Pastikan tabel documents kosong<br>2. Login dan akses dashboard | - | Dashboard menampilkan "0" untuk total dokumen tanpa error | | | 🟢 | |

---

# Module 3: Library Management (Document CRUD)

## Test Scenario: TS-LIB-01 - View Document List

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| LIB-001 | View library page as authenticated user | User sudah login | 1. Login<br>2. Klik menu "Library" atau akses /library | - | Halaman library ditampilkan dengan daftar dokumen | | | 🔴 | |
| LIB-002 | View library page as guest | User belum login | 1. Akses /library tanpa login | URL: /library | Redirect ke halaman login | | | 🔴 | |
| LIB-003 | Pagination functionality | Ada >10 dokumen | 1. Login<br>2. Akses library<br>3. Klik tombol halaman berikutnya | - | Daftar dokumen halaman berikutnya ditampilkan | | | 🟡 | |
| LIB-004 | Default sort by newest | Ada beberapa dokumen | 1. Login<br>2. Akses library tanpa parameter sort | - | Dokumen diurutkan dari yang terbaru (created_at desc) | | | 🟡 | |
| LIB-005 | Sort by views | Ada dokumen dengan views berbeda | 1. Login<br>2. Pilih sort "views"<br>3. Klik terapkan | Sort: views | Dokumen diurutkan berdasarkan views descending | | | 🟡 | |
| LIB-006 | Sort by title ascending | Ada beberapa dokumen | 1. Login<br>2. Pilih sort "judul_asc"<br>3. Klik terapkan | Sort: judul_asc | Dokumen diurutkan A-Z berdasarkan judul | | | 🟡 | |
| LIB-007 | Sort by year descending | Ada dokumen dengan tahun berbeda | 1. Login<br>2. Pilih sort "tahun_desc"<br>3. Klik terapkan | Sort: tahun_desc | Dokumen diurutkan dari tahun terbaru ke terlama | | | 🟡 | |
| LIB-008 | Search by title keyword | Ada dokumen dengan judul "Machine Learning" | 1. Login<br>2. Masukkan keyword "Machine"<br>3. Pilih filter "judul"<br>4. Klik search | Keyword: Machine<br>Filter: judul | Dokumen dengan judul mengandung "Machine" ditampilkan | | | 🔴 | |
| LIB-009 | Search by author | Ada dokumen dengan author "John Doe" | 1. Login<br>2. Masukkan keyword "John"<br>3. Pilih filter "pembuat"<br>4. Klik search | Keyword: John<br>Filter: pembuat | Dokumen dengan author mengandung "John" ditampilkan | | | 🔴 | |
| LIB-010 | Search by year | Ada dokumen tahun 2023 | 1. Login<br>2. Masukkan "2023"<br>3. Pilih filter "tahun"<br>4. Klik search | Keyword: 2023<br>Filter: tahun | Dokumen tahun 2023 ditampilkan | | | 🔴 | |
| LIB-011 | Search with no results | - | 1. Login<br>2. Masukkan keyword yang tidak ada<br>3. Klik search | Keyword: xyznotfound123 | Tampil pesan "Tidak ada data" atau daftar kosong | | | 🟡 | |
| LIB-012 | Filter by category | Ada kategori "Teknologi" | 1. Login<br>2. Pilih kategori "Teknologi"<br>3. Klik filter | Category: Teknologi | Hanya dokumen dengan kategori Teknologi yang ditampilkan | | | 🔴 | |
| LIB-013 | Combine search and category filter | - | 1. Login<br>2. Masukkan keyword<br>3. Pilih filter<br>4. Pilih kategori<br>5. Klik search | Keyword: AI<br>Filter: judul<br>Category: Teknologi | Hasil pencarian sesuai kombinasi keyword + kategori | | | 🟡 | |
| LIB-014 | Search with empty keyword | - | 1. Login<br>2. Kosongkan keyword<br>3. Klik search | Keyword: (kosong) | Semua dokumen ditampilkan atau validasi muncul | | | 🟢 | |
| LIB-015 | Search with SQL injection | - | 1. Login<br>2. Masukkan SQL injection di keyword<br>3. Klik search | Keyword: ' OR 1=1 -- | Sistem menolak/menangani tanpa error atau data bocor | | | 🔴 | |

## Test Scenario: TS-LIB-02 - Create Document

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| LIB-016 | Add document with all valid data | User sudah login | 1. Login<br>2. Klik "Tambah Dokumen"<br>3. Isi semua field valid<br>4. Upload file PDF valid<br>5. Upload cover image valid<br>6. Klik "Simpan" | Title: "Test Document"<br>Author: "John Doe"<br>Year: 2024<br>Category: 1<br>File: test.pdf<br>Cover: cover.jpg | Dokumen berhasil ditambahkan, muncul pesan sukses, redirect ke library | | | 🔴 | |
| LIB-017 | Add document without title | User sudah login | 1. Login<br>2. Klik "Tambah Dokumen"<br>3. Kosongkan judul<br>4. Isi field lain<br>5. Klik "Simpan" | Title: (kosong) | Muncul error validasi "Title wajib diisi" | | | 🔴 | |
| LIB-018 | Add document with title >255 chars | User sudah login | 1. Login<br>2. Isi judul dengan 300 karakter<br>3. Isi field lain valid<br>4. Klik "Simpan" | Title: [300 karakter] | Muncul error "Title maksimal 255 karakter" | | | 🟡 | |
| LIB-019 | Add document without author | User sudah login | 1. Login<br>2. Kosongkan author<br>3. Isi field lain valid<br>4. Klik "Simpan" | Author: (kosong) | Muncul error validasi "Author wajib diisi" | | | 🔴 | |
| LIB-020 | Add document with invalid year (text) | User sudah login | 1. Login<br>2. Isi year dengan teks "abc"<br>3. Klik "Simpan" | Year: abc | Muncul error validasi "Year harus angka" | | | 🔴 | |
| LIB-021 | Add document with year <1900 | User sudah login | 1. Login<br>2. Isi year dengan 1800<br>3. Klik "Simpan" | Year: 1800 | Muncul error "Year minimal 1900" | | | 🟡 | |
| LIB-022 | Add document with year >2099 | User sudah login | 1. Login<br>2. Isi year dengan 2100<br>3. Klik "Simpan" | Year: 2100 | Muncul error "Year maksimal 2099" | | | 🟡 | |
| LIB-023 | Add document with valid year boundary (1900) | User sudah login | 1. Login<br>2. Isi year dengan 1900<br>3. Isi field lain valid<br>4. Klik "Simpan" | Year: 1900 | Dokumen berhasil disimpan | | | 🟢 | |
| LIB-024 | Add document with valid year boundary (2099) | User sudah login | 1. Login<br>2. Isi year dengan 2099<br>3. Isi field lain valid<br>4. Klik "Simpan" | Year: 2099 | Dokumen berhasil disimpan | | | 🟢 | |
| LIB-025 | Add document without selecting category | User sudah login | 1. Login<br>2. Kosongkan kategori<br>3. Isi field lain<br>4. Klik "Simpan" | Category: (kosong) | Muncul error "Category wajib dipilih" | | | 🔴 | |
| LIB-026 | Add document with non-existent category_id | User sudah login | 1. Login<br>2. Kirim request dengan category_id 99999 | Category: 99999 | Muncul error "Kategori tidak ditemukan" | | | 🟡 | |
| LIB-027 | Add document with valid PDF file | User sudah login | 1. Login<br>2. Pilih file PDF < 10MB<br>3. Isi field lain<br>4. Klik "Simpan" | File: document.pdf (5MB) | File berhasil diupload, dokumen tersimpan | | | 🔴 | |
| LIB-028 | Add document with file >10MB | User sudah login | 1. Login<br>2. Pilih file PDF 15MB<br>3. Klik "Simpan" | File: large.pdf (15MB) | Muncul error "File maksimal 10MB" | | | 🔴 | |
| LIB-029 | Add document with invalid file type (.exe) | User sudah login | 1. Login<br>2. Pilih file .exe<br>3. Klik "Simpan" | File: virus.exe | Muncul error "Format file tidak didukung" | | | 🔴 | |
| LIB-030 | Add document with valid image cover | User sudah login | 1. Login<br>2. Upload cover JPG/PNG<br>3. Isi field lain<br>4. Klik "Simpan" | Cover: cover.jpg (1MB) | Cover berhasil diupload | | | 🟡 | |
| LIB-031 | Add document with cover >2MB | User sudah login | 1. Login<br>2. Upload cover 5MB<br>3. Klik "Simpan" | Cover: large.jpg (5MB) | Muncul error "Cover maksimal 2MB" | | | 🟡 | |
| LIB-032 | Add document with invalid cover type | User sudah login | 1. Login<br>2. Upload cover .txt<br>3. Klik "Simpan" | Cover: readme.txt | Muncul error "Format cover tidak didukung" | | | 🟡 | |
| LIB-033 | Add document without file (optional) | User sudah login | 1. Login<br>2. Kosongkan file<br>3. Isi field wajib<br>4. Klik "Simpan" | File: (kosong) | Dokumen tersimpan tanpa file | | | 🟡 | |
| LIB-034 | Add document for non-poster category with abstract | User sudah login, kategori selain "poster" | 1. Login<br>2. Pilih kategori "Karya Tulis Ilmiah"<br>3. Isi abstract<br>4. Klik "Simpan" | Category: KTI<br>Abstract: "Abstract test" | Dokumen tersimpan dengan abstract | | | 🟡 | |
| LIB-035 | Add document with XSS in title | User sudah login | 1. Login<br>2. Isi judul dengan script<br>3. Klik "Simpan" | Title: <script>alert('xss')</script> | Script tidak dieksekusi, input di-escape | | | 🔴 | |
| LIB-036 | Add document with special characters in title | User sudah login | 1. Login<br>2. Isi judul dengan karakter spesial<br>3. Klik "Simpan" | Title: "Dokumen @#$$%^&*()" | Dokumen tersimpan dengan judul sesuai input | | | 🟡 | |
| LIB-037 | Add document via AJAX | User sudah login | 1. Login<br>2. Isi form<br>3. Submit via AJAX | - | Response JSON success:true dan dokumen tersimpan | | | 🟡 | |
| LIB-038 | Add document as guest (unauthorized) | User belum login | 1. Logout<br>2. Kirim POST ke /library/store | - | Redirect ke login atau 401 Unauthorized | | | 🔴 | |

## Test Scenario: TS-LIB-03 - Edit Document

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| LIB-039 | Edit document with valid data | User login, ada dokumen | 1. Login<br>2. Klik edit dokumen<br>3. Ubah judul<br>4. Klik "Update" | Title: "Updated Title" | Dokumen berhasil diupdate, pesan sukses | | | 🔴 | |
| LIB-040 | Edit document with empty title | User login, ada dokumen | 1. Login<br>2. Edit dokumen<br>3. Kosongkan judul<br>4. Klik "Update" | Title: (kosong) | Error validasi "Title wajib diisi" | | | 🔴 | |
| LIB-041 | Edit document and replace file | User login, ada dokumen dengan file | 1. Login<br>2. Edit dokumen<br>3. Upload file baru<br>4. Klik "Update" | File: newfile.pdf | File lama terhapus, file baru tersimpan | | | 🟡 | |
| LIB-042 | Edit document and replace cover | User login, ada dokumen dengan cover | 1. Login<br>2. Edit dokumen<br>3. Upload cover baru<br>4. Klik "Update" | Cover: newcover.jpg | Cover lama terhapus, cover baru tersimpan | | | 🟡 | |
| LIB-043 | Edit non-existent document | User login | 1. Login<br>2. Akses /library/99999/edit | ID: 99999 | Error 404 Not Found | | | 🟡 | |
| LIB-044 | Edit document via AJAX | User login, ada dokumen | 1. Login<br>2. Edit via modal/AJAX<br>3. Klik update | - | Response JSON success:true | | | 🟡 | |
| LIB-045 | Edit document as guest | User logout | 1. Logout<br>2. Akses halaman edit | - | Redirect ke login | | | 🔴 | |

## Test Scenario: TS-LIB-04 - Delete Document

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| LIB-046 | Delete existing document | User login, ada dokumen | 1. Login<br>2. Klik hapus dokumen<br>3. Konfirmasi | - | Dokumen terhapus, file dan cover ikut terhapus dari storage | | | 🔴 | |
| LIB-047 | Delete document without confirmation | User login | 1. Login<br>2. Klik hapus tanpa konfirmasi | - | Tidak terjadi penghapusan (jika ada konfirmasi) | | | 🟡 | |
| LIB-048 | Delete non-existent document | User login | 1. Login<br>2. Kirim DELETE ke /library/99999 | ID: 99999 | Error 404 Not Found | | | 🟡 | |
| LIB-049 | Delete document and verify file removal | User login, ada dokumen dengan file | 1. Login<br>2. Hapus dokumen<br>3. Cek folder storage | - | File fisik terhapus dari storage/app/public | | | 🟡 | |
| LIB-050 | Delete document as guest | User logout | 1. Logout<br>2. Kirim DELETE request | - | Redirect ke login atau 401 | | | 🔴 | |

## Test Scenario: TS-LIB-05 - View Document File

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| LIB-051 | View PDF file | User login, ada dokumen PDF | 1. Login<br>2. Klik "View File" pada dokumen PDF | - | PDF ditampilkan di browser | | | 🔴 | |
| LIB-052 | View image file | User login, ada dokumen gambar | 1. Login<br>2. Klik "View File" pada dokumen gambar | - | Gambar ditampilkan di browser | | | 🟡 | |
| LIB-053 | View file of deleted document | User login | 1. Login<br>2. Akses /library/view-file/99999 | ID: 99999 | Error 404 "File tidak ditemukan" | | | 🟡 | |
| LIB-054 | View readonly file | User login | 1. Login<br>2. Akses /document/readonly/{id} | - | File ditampilkan dalam mode readonly, views bertambah | | | 🟡 | |
| LIB-055 | View file as guest (readonly) | User logout | 1. Logout<br>2. Akses /document/readonly/{id} | - | File ditampilkan (jika public) atau redirect login | | | 🔴 | |

## Test Scenario: TS-LIB-06 - Document Detail

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| LIB-056 | View document detail | User login, ada dokumen | 1. Login<br>2. Klik "Detail" pada dokumen | - | Halaman detail menampilkan semua informasi dokumen | | | 🔴 | |
| LIB-057 | View detail of non-existent document | User login | 1. Login<br>2. Akses /library/detail/99999 | ID: 99999 | Error 404 Not Found | | | 🟡 | |

---

# Module 4: Category Management

## Test Scenario: TS-CAT-01 - View Categories

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| CAT-001 | View category list as authenticated user | User sudah login | 1. Login<br>2. Akses /categories | - | Daftar kategori ditampilkan | | | 🔴 | |
| CAT-002 | View category list as guest | User belum login | 1. Akses /categories tanpa login | - | Redirect ke login | | | 🔴 | |

## Test Scenario: TS-CAT-02 - Create Category

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| CAT-003 | Add category with valid name | User login | 1. Login<br>2. Klik "Tambah Kategori"<br>3. Isi nama valid<br>4. Klik "Simpan" | Name: "Teknologi Baru" | Kategori berhasil ditambahkan | | | 🔴 | |
| CAT-004 | Add category with empty name | User login | 1. Login<br>2. Kosongkan nama<br>3. Klik "Simpan" | Name: (kosong) | Error "Name wajib diisi" | | | 🔴 | |
| CAT-005 | Add category with duplicate name | User login, ada kategori "Teknologi" | 1. Login<br>2. Isi nama "Teknologi"<br>3. Klik "Simpan" | Name: "Teknologi" | Error "Nama kategori sudah ada" | | | 🔴 | |
| CAT-006 | Add category with name >255 chars | User login | 1. Login<br>2. Isi nama 300 karakter<br>3. Klik "Simpan" | Name: [300 karakter] | Error "Name maksimal 255 karakter" | | | 🟡 | |
| CAT-007 | Add category via AJAX | User login | 1. Login<br>2. Submit form via AJAX | Name: "Ajax Category" | Response JSON success:true | | | 🟡 | |
| CAT-008 | Add category as guest | User logout | 1. Logout<br>2. Kirim POST /categories | - | Redirect ke login | | | 🔴 | |

## Test Scenario: TS-CAT-03 - Edit Category

| Test ID | Test Case | Pre-condition | Test Steps | Test Data (Input) | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|---------------|------------|-------------------|-----------------|---------------|--------|----------|---------|
| CAT-009 | Edit category with valid name | User login, ada kategori | 1. Login<br>2. Klik edit<br>3. Ubah nama<br>4. Klik "Update" | Name: "Updated Name" | Kategori berhasil diupdate | | | 🔴 | |
| CAT-010 | Edit category to duplicate name | User login, ada 2 kategori | 1. Login<br>2. Edit kategori A<br>3. Isi nama sama dengan kategori B | Name: (existing) | Error "Nama kategori sudah ada
