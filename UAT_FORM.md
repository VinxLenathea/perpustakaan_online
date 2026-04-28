# Form User Acceptance Testing (UAT) - Sistem Perpustakaan Online

**Project:** Perpustakaan Online (Laravel)  
**Test Type:** User Acceptance Testing (UAT)  
**Tester:** ___________________  
**Date:** ___________________  
**Environment:** ___________________  
**Version:** ___________________  

---

## Instruksi Penggunaan

1. Jalankan setiap **Test Scenario** sesuai dengan peran pengguna (Role)
2. Tandai **Status** sebagai:
   - ✅ **PASS** - Fitur berfungsi sesuai harapan pengguna
   - ❌ **FAIL** - Fitur tidak berfungsi sesuai harapan
   - ⏸️ **N/A** - Fitur tidak dapat diuji
3. Isi **Actual Result** dengan hasil pengujian yang diamati
4. Tambahkan catatan di kolom **Remarks** jika diperlukan

---

## Legend

| Symbol | Meaning |
|--------|---------|
| ✅ | Pass |
| ❌ | Fail |
| ⏸️ | Not Applicable |
| 🔴 | Critical (Must Work) |
| 🟡 | Medium (Should Work) |
| 🟢 | Low (Nice to Have) |

---

# Modul 1: Autentikasi & Otorisasi

## Test Scenario: TS-UAT-AUTH-01 - Login sebagai Berbagai Role

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-AUTH-001 | Login sebagai master_admin | master_admin | Akun master_admin tersedia | 1. Buka halaman login<br>2. Masukkan email & password master_admin<br>3. Klik Login | Berhasil login dan diarahkan ke Dashboard | | | 🔴 | |
| UAT-AUTH-002 | Login sebagai admin biasa | admin | Akun admin tersedia | 1. Buka halaman login<br>2. Masukkan email & password admin<br>3. Klik Login | Berhasil login dan diarahkan ke Dashboard | | | 🔴 | |
| UAT-AUTH-003 | Login dengan kredensial salah | Semua | - | 1. Buka halaman login<br>2. Masukkan email/password salah<br>3. Klik Login | Muncul pesan error "Email atau password salah" | | | 🔴 | |
| UAT-AUTH-004 | Login dengan field kosong | Semua | - | 1. Buka halaman login<br>2. Biarkan field kosong<br>3. Klik Login | Muncul pesan validasi field wajib diisi | | | 🔴 | |
| UAT-AUTH-005 | Logout dari sistem | Semua | User sudah login | 1. Klik tombol Logout<br>2. Konfirmasi logout | Berhasil logout, kembali ke halaman login/welcome | | | 🔴 | |
| UAT-AUTH-006 | Akses halaman setelah logout | Semua | User sudah logout | 1. Logout<br>2. Tekan tombol Back browser<br>3. Coba akses /dashboard | Sistem redirect ke halaman login | | | 🔴 | |

---

## Test Scenario: TS-UAT-AUTH-02 - Role-Based Access Control (RBAC)

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-RBAC-001 | Akses Dashboard sebagai master_admin | master_admin | Sudah login | 1. Login sebagai master_admin<br>2. Klik menu Dashboard | Halaman Dashboard tampil dengan statistik | | | 🔴 | |
| UAT-RBAC-002 | Akses Dashboard sebagai admin | admin | Sudah login | 1. Login sebagai admin<br>2. Klik menu Dashboard | Halaman Dashboard tampil dengan statistik | | | 🔴 | |
| UAT-RBAC-003 | Akses Library sebagai master_admin | master_admin | Sudah login | 1. Login sebagai master_admin<br>2. Klik menu Library | Halaman Library tampil dengan daftar dokumen | | | 🔴 | |
| UAT-RBAC-004 | Akses Library sebagai admin | admin | Sudah login | 1. Login sebagai admin<br>2. Klik menu Library | Halaman Library tampil dengan daftar dokumen | | | 🔴 | |
| UAT-RBAC-005 | Akses Verifikasi Upload sebagai master_admin | master_admin | Sudah login | 1. Login sebagai master_admin<br>2. Klik menu Verifikasi Upload | Halaman Verifikasi Upload tampil | | | 🔴 | |
| UAT-RBAC-006 | Akses Verifikasi Upload sebagai admin | admin | Sudah login | 1. Login sebagai admin<br>2. Klik menu Verifikasi Upload | Halaman Verifikasi Upload tampil | | | 🔴 | |
| UAT-RBAC-007 | Akses User Management sebagai master_admin | master_admin | Sudah login | 1. Login sebagai master_admin<br>2. Klik menu Users | Halaman Users tampil dengan daftar user | | | 🔴 | |
| UAT-RBAC-008 | Akses User Management sebagai admin | admin | Sudah login | 1. Login sebagai admin<br>2. Coba akses menu Users / URL /users | Menu Users tidak tampil di sidebar, akses URL menampilkan 403 Forbidden | | | 🔴 | |
| UAT-RBAC-009 | Akses Category Management sebagai master_admin | master_admin | Sudah login | 1. Login sebagai master_admin<br>2. Klik menu Category | Halaman Category tampil | | | 🔴 | |
| UAT-RBAC-010 | Akses Category Management sebagai admin | admin | Sudah login | 1. Login sebagai admin<br>2. Coba akses menu Category / URL /categories | Menu Category tidak tampil di sidebar, akses URL menampilkan 403 Forbidden | | | 🔴 | |
| UAT-RBAC-011 | Akses Logs sebagai master_admin | master_admin | Sudah login | 1. Login sebagai master_admin<br>2. Klik menu Logs | Halaman Logs tampil | | | 🔴 | |
| UAT-RBAC-012 | Akses Logs sebagai admin | admin | Sudah login | 1. Login sebagai admin<br>2. Coba akses menu Logs / URL /logs | Menu Logs tidak tampil di sidebar, akses URL menampilkan 403 Forbidden | | | 🔴 | |
| UAT-RBAC-013 | Akses Export sebagai master_admin | master_admin | Sudah login | 1. Login sebagai master_admin<br>2. Akses fitur Export | Export berhasil dijalankan | | | 🟡 | |
| UAT-RBAC-014 | Akses Export sebagai admin | admin | Sudah login | 1. Login sebagai admin<br>2. Coba akses URL /export/buku/1/2024 | Akses ditolak dengan 403 Forbidden | | | 🟡 | |
| UAT-RBAC-015 | Akses Profile sebagai master_admin | master_admin | Sudah login | 1. Login sebagai master_admin<br>2. Klik menu Profile | Halaman Profile tampil | | | 🔴 | |
| UAT-RBAC-016 | Akses Profile sebagai admin | admin | Sudah login | 1. Login sebagai admin<br>2. Klik menu Profile | Halaman Profile tampil | | | 🔴 | |
| UAT-RBAC-017 | Sidebar menu untuk master_admin | master_admin | Sudah login | 1. Login sebagai master_admin<br>2. Periksa sidebar | Sidebar menampilkan: Dashboard, Users, Library, Category, Logs, Verifikasi Upload | | | 🔴 | |
| UAT-RBAC-018 | Sidebar menu untuk admin | admin | Sudah login | 1. Login sebagai admin<br>2. Periksa sidebar | Sidebar hanya menampilkan: Dashboard, Library, Verifikasi Upload | | | 🔴 | |

---

# Modul 2: Dashboard

## Test Scenario: TS-UAT-DASH-01 - Dashboard View

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-DASH-001 | Lihat statistik total dokumen | Semua | Sudah login, ada data dokumen | 1. Akses Dashboard<br>2. Perhatikan card "Total Dokumen" | Jumlah total dokumen sesuai dengan data di database | | | 🔴 | |
| UAT-DASH-002 | Lihat statistik per kategori | Semua | Sudah login, ada kategori dengan dokumen | 1. Akses Dashboard<br>2. Perhatikan card per kategori | Jumlah dokumen per kategori sesuai dengan data | | | 🟡 | |
| UAT-DASH-003 | Dashboard dengan data kosong | Semua | Sudah login, tabel dokumen kosong | 1. Akses Dashboard | Total dokumen menampilkan 0 tanpa error | | | 🟢 | |
| UAT-DASH-004 | Navigasi dari Dashboard ke Library | Semua | Sudah login | 1. Di Dashboard, klik menu Library | Berpindah ke halaman Library | | | 🔴 | |

---

# Modul 3: Manajemen Library (Dokumen)

## Test Scenario: TS-UAT-LIB-01 - Melihat Daftar Dokumen

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-LIB-001 | Lihat daftar dokumen | Semua | Sudah login, ada data dokumen | 1. Klik menu Library | Daftar dokumen ditampilkan dengan judul, penulis, tahun, kategori | | | 🔴 | |
| UAT-LIB-002 | Pagination daftar dokumen | Semua | Sudah login, ada >10 dokumen | 1. Di Library, klik tombol halaman berikutnya | Daftar dokumen halaman berikutnya ditampilkan | | | 🟡 | |
| UAT-LIB-003 | Sortir dokumen | Semua | Sudah login, ada beberapa dokumen | 1. Pilih opsi sortir (terbaru/judul/views/tahun)<br>2. Klik terapkan | Dokumen diurutkan sesuai pilihan | | | 🟡 | |

## Test Scenario: TS-UAT-LIB-02 - Pencarian Dokumen

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-LIB-004 | Cari dokumen berdasarkan judul | Semua | Sudah login | 1. Masukkan keyword judul<br>2. Pilih filter "Judul"<br>3. Klik Cari | Dokumen dengan judul mengandung keyword ditampilkan | | | 🔴 | |
| UAT-LIB-005 | Cari dokumen berdasarkan penulis | Semua | Sudah login | 1. Masukkan nama penulis<br>2. Pilih filter "Penulis"<br>3. Klik Cari | Dokumen dengan penulis mengandung keyword ditampilkan | | | 🔴 | |
| UAT-LIB-006 | Cari dokumen berdasarkan tahun | Semua | Sudah login | 1. Masukkan tahun<br>2. Pilih filter "Tahun"<br>3. Klik Cari | Dokumen dengan tahun sesuai ditampilkan | | | 🔴 | |
| UAT-LIB-007 | Filter berdasarkan kategori | Semua | Sudah login | 1. Pilih kategori dari dropdown<br>2. Klik Filter | Hanya dokumen dari kategori terpilih yang ditampilkan | | | 🔴 | |
| UAT-LIB-008 | Pencarian tanpa hasil | Semua | Sudah login | 1. Masukkan keyword yang tidak ada<br>2. Klik Cari | Tampil pesan "Tidak ada data" atau daftar kosong | | | 🟡 | |

## Test Scenario: TS-UAT-LIB-03 - Tambah Dokumen Baru

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-LIB-009 | Tambah dokumen dengan data lengkap | Semua | Sudah login | 1. Klik "Tambah Dokumen"<br>2. Isi judul, penulis, tahun, kategori<br>3. Upload file PDF<br>4. Upload cover image<br>5. Klik Simpan | Dokumen berhasil ditambahkan, muncul pesan sukses | | | 🔴 | |
| UAT-LIB-010 | Tambah dokumen tanpa judul | Semua | Sudah login | 1. Klik "Tambah Dokumen"<br>2. Kosongkan judul<br>3. Klik Simpan | Muncul pesan error "Judul wajib diisi" | | | 🔴 | |
| UAT-LIB-011 | Tambah dokumen dengan file >10MB | Semua | Sudah login | 1. Pilih file PDF >10MB<br>2. Klik Simpan | Muncul pesan error "File maksimal 10MB" | | | 🔴 | |
| UAT-LIB-012 | Tambah dokumen dengan format file tidak didukung | Semua | Sudah login | 1. Pilih file .exe atau .txt<br>2. Klik Simpan | Muncul pesan error "Format file tidak didukung" | | | 🔴 | |
| UAT-LIB-013 | Tambah dokumen tanpa kategori | Semua | Sudah login | 1. Kosongkan pilihan kategori<br>2. Klik Simpan | Muncul pesan error "Kategori wajib dipilih" | | | 🔴 | |

## Test Scenario: TS-UAT-LIB-04 - Edit Dokumen

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-LIB-014 | Edit data dokumen | Semua | Sudah login, ada dokumen | 1. Klik tombol Edit pada dokumen<br>2. Ubah judul/penulis/tahun<br>3. Klik Update | Data dokumen berhasil diperbarui | | | 🔴 | |
| UAT-LIB-015 | Ganti file dokumen | Semua | Sudah login, ada dokumen dengan file | 1. Klik Edit<br>2. Upload file baru<br>3. Klik Update | File lama terganti dengan file baru | | | 🟡 | |
| UAT-LIB-016 | Ganti cover dokumen | Semua | Sudah login, ada dokumen dengan cover | 1. Klik Edit<br>2. Upload cover baru<br>3. Klik Update | Cover lama terganti dengan cover baru | | | 🟡 | |

## Test Scenario: TS-UAT-LIB-05 - Hapus Dokumen

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-LIB-017 | Hapus dokumen | Semua | Sudah login, ada dokumen | 1. Klik tombol Hapus<br>2. Konfirmasi penghapusan | Dokumen terhapus dari daftar | | | 🔴 | |
| UAT-LIB-018 | Batal hapus dokumen | Semua | Sudah login | 1. Klik tombol Hapus<br>2. Klik Batal pada konfirmasi | Dokumen tidak terhapus | | | 🟡 | |

## Test Scenario: TS-UAT-LIB-06 - Lihat File & Detail Dokumen

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-LIB-019 | Lihat file PDF dokumen | Semua | Sudah login, ada dokumen PDF | 1. Klik "View File" pada dokumen PDF | File PDF ditampilkan di browser | | | 🔴 | |
| UAT-LIB-020 | Lihat detail dokumen | Semua | Sudah login, ada dokumen | 1. Klik "Detail" pada dokumen | Informasi lengkap dokumen ditampilkan | | | 🔴 | |
| UAT-LIB-021 | Lihat dokumen readonly (public) | Guest | - | 1. Akses URL /document/readonly/{id} | Dokumen ditampilkan dalam mode readonly | | | 🟡 | |

---

# Modul 4: Manajemen Kategori

## Test Scenario: TS-UAT-CAT-01 - CRUD Kategori (master_admin only)

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-CAT-001 | Lihat daftar kategori | master_admin | Sudah login | 1. Klik menu Category | Daftar kategori ditampilkan | | | 🔴 | |
| UAT-CAT-002 | Tambah kategori baru | master_admin | Sudah login | 1. Klik "Tambah Kategori"<br>2. Isi nama kategori<br>3. Klik Simpan | Kategori baru berhasil ditambahkan | | | 🔴 | |
| UAT-CAT-003 | Tambah kategori dengan nama kosong | master_admin | Sudah login | 1. Klik "Tambah Kategori"<br>2. Kosongkan nama<br>3. Klik Simpan | Muncul error "Nama kategori wajib diisi" | | | 🔴 | |
| UAT-CAT-004 | Tambah kategori dengan nama duplikat | master_admin | Sudah login, ada kategori "Teknologi" | 1. Isi nama "Teknologi"<br>2. Klik Simpan | Muncul error "Nama kategori sudah ada" | | | 🔴 | |
| UAT-CAT-005 | Edit nama kategori | master_admin | Sudah login, ada kategori | 1. Klik Edit pada kategori<br>2. Ubah nama<br>3. Klik Update | Nama kategori berhasil diubah | | | 🔴 | |
| UAT-CAT-006 | Hapus kategori | master_admin | Sudah login, ada kategori | 1. Klik Hapus pada kategori<br>2. Konfirmasi | Kategori terhapus | | | 🔴 | |
| UAT-CAT-007 | Akses Category sebagai admin | admin | Sudah login | 1. Coba akses menu Category | Menu tidak tersedia, akses ditolak | | | 🔴 | |

---

# Modul 5: Manajemen User

## Test Scenario: TS-UAT-USER-01 - CRUD User (master_admin only)

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-USER-001 | Lihat daftar user | master_admin | Sudah login | 1. Klik menu Users | Daftar user ditampilkan dengan nama, email, role | | | 🔴 | |
| UAT-USER-002 | Tambah user baru | master_admin | Sudah login | 1. Klik "Tambah User"<br>2. Isi nama, email, password, pilih role<br>3. Klik Simpan | User baru berhasil ditambahkan | | | 🔴 | |
| UAT-USER-003 | Tambah user dengan email duplikat | master_admin | Sudah login, ada user dengan email tersebut | 1. Isi email yang sudah terdaftar<br>2. Klik Simpan | Muncul error "Email sudah terdaftar" | | | 🔴 | |
| UAT-USER-004 | Tambah user dengan role master_admin | master_admin | Sudah login | 1. Tambah user baru<br>2. Pilih role "master_admin"<br>3. Klik Simpan | User dengan role master_admin berhasil dibuat | | | 🔴 | |
| UAT-USER-005 | Tambah user dengan role admin | master_admin | Sudah login | 1. Tambah user baru<br>2. Pilih role "admin"<br>3. Klik Simpan | User dengan role admin berhasil dibuat | | | 🔴 | |
| UAT-USER-006 | Edit data user | master_admin | Sudah login, ada user | 1. Klik Edit pada user<br>2. Ubah nama/email/role<br>3. Klik Update | Data user berhasil diperbarui | | | 🔴 | |
| UAT-USER-007 | Hapus user | master_admin | Sudah login, ada user | 1. Klik Hapus pada user<br>2. Konfirmasi | User terhapus dari sistem | | | 🔴 | |
| UAT-USER-008 | Akses Users sebagai admin | admin | Sudah login | 1. Coba akses menu Users | Menu tidak tersedia, akses ditolak | | | 🔴 | |

---

# Modul 6: Verifikasi Upload

## Test Scenario: TS-UAT-VER-01 - Verifikasi Dokumen Upload

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-VER-001 | Lihat daftar upload pending | Semua | Sudah login, ada upload pending | 1. Klik menu Verifikasi Upload | Daftar upload dengan status "pending" ditampilkan | | | 🔴 | |
| UAT-VER-002 | Approve upload dokumen | Semua | Sudah login, ada upload pending | 1. Klik tombol Approve pada upload<br>2. Konfirmasi | Status upload berubah menjadi "approved", dokumen masuk ke library | | | 🔴 | |
| UAT-VER-003 | Reject upload dokumen | Semua | Sudah login, ada upload pending | 1. Klik tombol Reject<br>2. Isi alasan penolakan<br>3. Klik Konfirmasi | Status upload berubah menjadi "rejected", muncul catatan alasan | | | 🔴 | |
| UAT-VER-004 | Lihat file upload pending | Semua | Sudah login, ada upload pending | 1. Klik "View File" pada upload pending | File ditampilkan untuk preview | | | 🟡 | |
| UAT-VER-005 | Filter berdasarkan tanggal | Semua | Sudah login | 1. Pilih rentang tanggal<br>2. Klik Filter | Upload sesuai rentang tanggal ditampilkan | | | 🟢 | |
| UAT-VER-006 | Verifikasi upload yang sudah diverifikasi | Semua | Sudah login | 1. Coba approve/reject upload yang sudah approved/rejected | Muncul pesan "Upload sudah diverifikasi" | | | 🟡 | |

---

# Modul 7: Logs

## Test Scenario: TS-UAT-LOG-01 - Lihat Logs (master_admin only)

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-LOG-001 | Lihat daftar logs | master_admin | Sudah login, ada data log | 1. Klik menu Logs | Daftar log aktivitas ditampilkan dengan status, user, waktu | | | 🔴 | |
| UAT-LOG-002 | Filter logs berdasarkan status | master_admin | Sudah login | 1. Pilih filter status (approved/rejected/pending)<br>2. Klik Filter | Log dengan status terpilih ditampilkan | | | 🟡 | |
| UAT-LOG-003 | Filter logs berdasarkan tanggal | master_admin | Sudah login | 1. Pilih rentang tanggal<br>2. Klik Filter | Log sesuai rentang tanggal ditampilkan | | | 🟡 | |
| UAT-LOG-004 | Akses Logs sebagai admin | admin | Sudah login | 1. Coba akses menu Logs | Menu tidak tersedia, akses ditolak | | | 🔴 | |

---

# Modul 8: Export

## Test Scenario: TS-UAT-EXP-01 - Export Data (master_admin only)

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-EXP-001 | Export data buku per bulan | master_admin | Sudah login, ada data dokumen | 1. Pilih bulan dan tahun<br>2. Klik Export | File Excel/CSV berhasil diunduh | | | 🟡 | |
| UAT-EXP-002 | Export dengan bulan tanpa data | master_admin | Sudah login | 1. Pilih bulan/tahun tanpa data<br>2. Klik Export | File kosong atau pesan "Tidak ada data" | | | 🟢 | |
| UAT-EXP-003 | Akses Export sebagai admin | admin | Sudah login | 1. Coba akses URL export | Akses ditolak dengan 403 Forbidden | | | 🟡 | |

---

# Modul 9: Profile

## Test Scenario: TS-UAT-PROF-01 - Manajemen Profile

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-PROF-001 | Lihat halaman profile | Semua | Sudah login | 1. Klik menu Profile | Halaman profile dengan data user ditampilkan | | | 🔴 | |
| UAT-PROF-002 | Update nama profile | Semua | Sudah login | 1. Ubah nama<br>2. Klik Simpan | Nama berhasil diperbarui | | | 🔴 | |
| UAT-PROF-003 | Update email profile | Semua | Sudah login | 1. Ubah email<br>2. Klik Simpan | Email berhasil diperbarui | | | 🔴 | |
| UAT-PROF-004 | Update password | Semua | Sudah login | 1. Isi password lama<br>2. Isi password baru<br>3. Konfirmasi password baru<br>4. Klik Simpan | Password berhasil diubah | | | 🔴 | |
| UAT-PROF-005 | Hapus akun | Semua | Sudah login | 1. Klik hapus akun<br>2. Konfirmasi | Akun terhapus, logout otomatis | | | 🔴 | |

---

# Modul 10: Halaman Public (Welcome)

## Test Scenario: TS-UAT-PUB-01 - Akses Halaman Public

| Test ID | Test Case | Role | Pre-condition | Langkah Uji | Expected Result | Actual Result | Status | Priority | Remarks |
|---------|-----------|------|---------------|-------------|-----------------|---------------|--------|----------|---------|
| UAT-PUB-001 | Lihat halaman welcome | Guest | - | 1. Buka URL / | Halaman welcome dengan dokumen populer ditampilkan | | | 🔴 | |
| UAT-PUB-002 | Cari dokumen dari halaman welcome | Guest | - | 1. Masukkan keyword<br>2. Pilih filter<br>3. Klik Cari | Hasil pencarian ditampilkan | | | 🔴 | |
| UAT-PUB-003 | Lihat koleksi kategori | Guest | - | 1. Klik salah satu kategori | Halaman koleksi kategori ditampilkan | | | 🟡 | |
| UAT-PUB-004 | Lihat detail dokumen public | Guest | - | 1. Klik dokumen dari halaman welcome | Detail dokumen ditampilkan | | | 🟡 | |

---

# Ringkasan Hasil UAT

| Modul | Total Test Case | Pass | Fail | N/A | Pass Rate |
|-------|-----------------|------|------|-----|-----------|
| Autentikasi & Otorisasi | 18 | | | | |
| Dashboard | 4 | | | | |
| Library | 21 | | | | |
| Kategori | 7 | | | | |
| User Management | 8 | | | | |
| Verifikasi Upload | 6 | | | | |
| Logs | 4 | | | | |
| Export | 3 | | | | |
| Profile | 5 | | | | |
| Halaman Public | 4 | | | | |
| **TOTAL** | **80** | | | | |

---

# Kesimpulan & Rekomendasi

**Kesimpulan:** _________________________________

**Rekomendasi:** _________________________________

**Disetujui oleh:** ___________________ **Tanggal:** ___________________

**Diverifikasi oleh:** ___________________ **Tanggal:** ___________________

