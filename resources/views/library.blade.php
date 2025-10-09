<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin perpustakaan</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('view component.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('view component.header')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Perpustakaan RSUD Mohammad Noer</h1>
                    </div>

                    <!-- Search Bar -->
                    <div class="card shadow mb-4">
                        <div class="card-body bg-light">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <!-- Form Pencarian -->
                                <form action="{{ route('library') }}" method="GET" class="form-inline mb-2">
                                    <input type="text" name="keyword" class="form-control mr-2"
                                        placeholder="Kata Kunci" value="{{ request('keyword') }}"
                                        style="min-width:200px;">

                                    <select name="filter" class="form-control mr-2">
                                        <option value="judul" {{ request('filter') == 'judul' ? 'selected' : '' }}>
                                            Judul</option>
                                        <option value="penulis" {{ request('filter') == 'penulis' ? 'selected' : '' }}>
                                            Penulis</option>
                                        <option value="tahun" {{ request('filter') == 'tahun' ? 'selected' : '' }}>
                                            Tahun</option>
                                    </select>

                                    <select name="category_id" class="form-control mr-2">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->category_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit" class="btn btn-success">Cari</button>
                                </form>


                                <!-- Tombol Tambah Document -->
                                <button class="btn btn-sm btn-success shadow-sm mb-2" data-toggle="modal"
                                    data-target="#tambahDocumentModal">
                                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Document
                                </button>
                            </div>

                            <!-- Table -->
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cover</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Tahun</th>
                                        <th>Pembuat</th>
                                        <th>Abstrak</th>
                                        <th>File</th>
                                        <th>Dilihat</th>
                                        <th>Kampus</th>
                                        <th>Prodi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documents as $doc)
                                        <tr id="row-{{ $doc->id }}">
                                            <td>{{ $doc->id }}</td>
                                            <td>
                                                @if($doc->category->category_name == 'Poster')
                                                    @if($doc->file_url && in_array(pathinfo($doc->file_url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif']))
                                                        <img src="{{ asset('storage/' . $doc->file_url) }}" alt="Cover {{ $doc->title }}" style="width: 50px; height: 70px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('assets/img/undraw_posting_photo.svg') }}" alt="Cover {{ $doc->title }}" style="width: 50px; height: 70px; object-fit: cover;">
                                                    @endif
                                                @else
                                                    @if($doc->cover_image)
                                                        <img src="{{ asset('storage/' . $doc->cover_image) }}" alt="Cover {{ $doc->title }}" style="width: 50px; height: 70px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('assets/img/undraw_posting_photo.svg') }}" alt="Cover {{ $doc->title }}" style="width: 50px; height: 70px; object-fit: cover;">
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="title">{{ $doc->title }}</td>
                                            <td class="category">{{ $doc->category->category_name }}</td>
                                            <td class="year">{{ $doc->year_published }}</td>
                                            <td class="author">{{ $doc->author }}</td>
                                            <td class="abstract">
                                                @if($doc->abstract)
                                                    {{ Str::limit($doc->abstract, 50) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="file">
                                                <a href="{{ asset('storage/' . $doc->file_url) }}"
                                                    target="_blank">Lihat File</a>
                                            </td>
                                            <td class="views">{{ $doc->views }}X dilihat</td>
                                            <td class="kampus">{{ $doc->kampus }}</td>
                                            <td class="prodi">{{ $doc->prodi }}</td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    <button class="btn btn-success btn-sm" data-toggle="modal"
                                                        data-target="#editDocumentModal{{ $doc->id }}"><i class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        data-toggle="modal" style="margin-top: 5px" data-target="#confirmModal"
                                                        data-url="{{ route('library.destroy', $doc) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- ✅ Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $documents->onEachSide(1)->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>

                    <!-- Modal Tambah Document -->
                    <div class="modal fade" id="tambahDocumentModal" tabindex="-1" role="dialog"
                        aria-labelledby="tambahDocumentLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('library.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahDocumentLabel">Tambah Document</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form Input -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="title">Judul</label>
                                                    <input type="text" class="form-control" name="title" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="author">Penulis</label>
                                                    <input type="text" class="form-control" name="author" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="year_published">Tahun Terbit</label>
                                                    <input type="number" class="form-control" name="year_published"
                                                        min="1900" max="2099" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="category_id">Kategori</label>
                                                    <select class="form-control" name="category_id" required>
                                                        <option value="">-- Pilih Kategori --</option>
                                                        @foreach ($categories as $cat)
                                                            <option value="{{ $cat->id }}">{{ $cat->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="file">Upload File (PDF,PNG)</label>
                                                    <input type="file" class="form-control" name="file"
                                                        accept=".pdf,.png,.jpg,.jpeg" required>
                                                    <small class="text-muted">Opsional. Format: JPG, PNG, GIF. Max 2MB.</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cover_image">Upload Cover Image</label>
                                                    <input type="file" class="form-control" name="cover_image"
                                                        accept="image/*">
                                                    <small class="text-muted">Opsional. Format: JPG, PNG, GIF. Max 2MB.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="abstract">Abstrak</label>
                                            <textarea class="form-control" name="abstract" rows="2"
                                                placeholder="Masukkan abstrak dokumen..."></textarea>
                                        </div>
                                        <div class="row kampus-prodi-row" style="display: none;">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="kampus">Kampus</label>
                                                    <input type="text" class="form-control" name="kampus">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="prodi">Prodi</label>
                                                    <input type="text" class="form-control" name="prodi">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Edit Document (Per Document) -->
                    @foreach ($documents as $doc)
                        <div class="modal fade" id="editDocumentModal{{ $doc->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="editDocumentLabel{{ $doc->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form class="updateForm" data-id="{{ $doc->id }}"
                                    action="{{ route('library.update', $doc) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editDocumentLabel{{ $doc->id }}">Edit
                                                Document</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="title">Judul</label>
                                                        <input type="text" class="form-control" name="title"
                                                            value="{{ $doc->title }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="author">Penulis</label>
                                                        <input type="text" class="form-control" name="author"
                                                            value="{{ $doc->author }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="year_published">Tahun Terbit</label>
                                                        <input type="number" class="form-control" name="year_published"
                                                            value="{{ $doc->year_published }}" min="1900" max="2099"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="category_id">Kategori</label>
                                                        <select class="form-control" name="category_id" required>
                                                            @foreach ($categories as $cat)
                                                                <option value="{{ $cat->id }}"
                                                                    {{ $doc->category_id == $cat->id ? 'selected' : '' }}>
                                                                    {{ $cat->category_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="file">Ganti File (Opsional)</label>
                                                        <input type="file" class="form-control" name="file"
                                                            accept=".pdf,.doc,.docx">
                                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti
                                                            file.</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="cover_image">Ganti Cover Image (Opsional)</label>
                                                        <input type="file" class="form-control" name="cover_image"
                                                            accept="image/*">
                                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti cover. Format: JPG, PNG, GIF. Max 2MB.</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="abstract">Abstrak</label>
                                                <textarea class="form-control" name="abstract" rows="2"
                                                    placeholder="Masukkan abstrak dokumen...">{{ $doc->abstract }}</textarea>
                                            </div>
                                            <div class="row kampus-prodi-row" style="display: none;">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="kampus">Kampus</label>
                                                        <input type="text" class="form-control" name="kampus" value="{{ $doc->kampus }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="prodi">Prodi</label>
                                                        <input type="text" class="form-control" name="prodi" value="{{ $doc->prodi }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach


                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('view component.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi (reusable) -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <!-- Konten akan diisi secara dinamis melalui JavaScript -->
                    <div id="deleteContent">
                        <!-- Default content -->
                        <p class="mb-3">Apakah Anda yakin ingin menghapus item ini?</p>
                        <div id="itemDetails" class="text-left mb-3">
                            <!-- Item details akan diisi di sini -->
                        </div>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-secondary btn-lg" type="button" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>

                    <!-- Form dinamis -->
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg">
                            <i class="fas fa-trash mr-2"></i>Ya, Hapus!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content text-center shadow-lg border-0 rounded animate__animated animate__zoomIn">
                    <div class="modal-body p-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5 class="text-success">{{ session('success') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!-- jQuery -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin tambahan -->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
    <script src="assets/vendor/chart.js/Chart.min.js"></script>
    <script src="assets/js/demo/chart-area-demo.js"></script>
    <script src="assets/js/demo/chart-pie-demo.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Modal konfirmasi hapus menggunakan JavaScript yang sama dengan users.blade.php -->

    <script>
        // Modal konfirmasi hapus dengan AJAX (Generic untuk semua jenis data)
        $('#confirmModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang diklik
            var url = button.data('url'); // Ambil data-url dari tombol
            var row = button.closest('tr'); // Ambil row tabel

            // Deteksi jenis data berdasarkan struktur tabel
            if (row.find('td:nth-child(3)').length > 0) {
                // User table (kolom: ID, Name, Email, Aksi)
                var itemName = row.find('.title').text(); // Nama user
                var itemDetail = row.find('.category').text(); // Email user
                var itemType = 'user';

                var detailsHtml = `
                    <div class="alert alert-light">
                        <strong>Nama File:</strong> ${itemName}<br>
                        <strong>Kategori:</strong> ${itemDetail}
                    </div>
                `;

                var warningText = 'Data ini akan dihapus secara permanen.';
            } else {
                // Document table (kolom: ID, Judul, Kategori, Tahun, Pembuat, File, Aksi)
                var itemName = row.find('.title').text(); // Judul document
                var itemDetail = row.find('.category').text(); // Penulis document
                var itemType = 'document';

                var detailsHtml = `
                    <div class="alert alert-light">
                        <strong>Judul:</strong> ${itemName}<br>
                        <strong>Penulis:</strong> ${itemDetail}
                    </div>
                `;

                var warningText = 'File ini akan dihapus secara permanen.';
            }

            // Update modal content
            $(this).find('#itemDetails').html(detailsHtml);
            $(this).find('.modal-body p').first().html(`Apakah Anda yakin ingin menghapus file ini?`);
            $(this).find('.text-muted').html(warningText);

            // Set action form untuk AJAX
            var form = $(this).find('#deleteForm');
            form.attr('action', url);
        });

        // Handle delete form submission dengan AJAX (Generic)
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var modal = form.closest('.modal');
            var itemName = modal.find('#itemDetails strong').first().text().replace(/^(Nama|Judul):\s*/, '');

            // Deteksi jenis item berdasarkan konten modal
            var isUser = modal.find('#itemDetails').text().includes('Email:');
            var itemType = isUser ? 'user' : 'document';
            var successMessage = isUser ? 'File berhasil dihapus!' : 'File berhasil dihapus!';

            // Lanjutkan dengan AJAX request langsung
            $.ajax({
                url: url,
                type: "POST", // spoofing pakai _method=DELETE
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Tutup modal konfirmasi
                    $('#confirmModal').modal('hide');

                    // Hapus row dari tabel
                    var button = $(`button[data-url="${url}"]`);
                    button.closest('tr').fadeOut(500, function() {
                        $(this).remove();
                    });

                    // Tampilkan notifikasi sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: successMessage,
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    // Tutup modal konfirmasi
                    $('#confirmModal').modal('hide');

                    let message = xhr.responseJSON?.message ??
                        `Terjadi kesalahan saat menghapus ${itemType}`;

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: message
                    });
                }
            });
        });
    </script>

    <script>
        // Modal sukses otomatis muncul
        @if (session('success'))
            $(document).ready(function() {
                let modal = $('#successModal');
                modal.modal('show');

                setTimeout(function() {
                    modal.modal('hide');
                }, 2500);
            });
        @endif
    </script>

    <script>
        // Update data dengan AJAX dan konfirmasi
        $(document).ready(function() {
            $('.updateForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let id = form.data('id');
                let formData = new FormData(this);

                // Ambil data form untuk konfirmasi
                let title = form.find('input[name="title"]').val();
                let author = form.find('input[name="author"]').val();
                let year = form.find('input[name="year_published"]').val();
                let category = form.find('select[name="category_id"] option:selected').text();
                let fileInput = form.find('input[name="file"]');
                let hasNewFile = fileInput.length > 0 && fileInput[0].files.length > 0;

                // Buat pesan konfirmasi
                let confirmMessage = `Apakah Anda yakin ingin mengupdate document ini?\n\n`;
                confirmMessage += `Judul: ${title}\n`;
                confirmMessage += `Penulis: ${author}\n`;
                confirmMessage += `Tahun: ${year}\n`;
                confirmMessage += `Kategori: ${category}\n`;
                if (hasNewFile) {
                    confirmMessage += `File: [File baru akan diupload]\n`;
                }

                // Tampilkan konfirmasi dengan SweetAlert2
                Swal.fire({
                    title: 'Konfirmasi Update',
                    text: confirmMessage,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Update!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Lanjutkan dengan AJAX request
                        $.ajax({
                            url: form.attr('action'), // gunakan action dari form
                            type: "POST", // spoofing pakai _method=PUT
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $('#editDocumentModal' + id).modal('hide');

                                // update data di tabel langsung
                                $('#row-' + id + ' .title').text(response.document.title);
                                $('#row-' + id + ' .author').text(response.document.author);
                                $('#row-' + id + ' .year').text(response.document.year_published);
                                $('#row-' + id + ' .category').text(response.document.category.category_name);

                                // Update abstract
                                let abstractText = response.document.abstract ? response.document.abstract.substring(0, 50) + (response.document.abstract.length > 50 ? '...' : '') : '-';
                                $('#row-' + id + ' .abstract').text(abstractText);

                                // Update cover image
                                let coverCell = $('#row-' + id + ' td').eq(1); // Cover is second column (index 1)
                                if (response.document.category.category_name == 'Poster') {
                                    coverCell.html(response.document.file_url ?
                                        `<img src="/storage/${response.document.file_url}" alt="Cover ${response.document.title}" style="width: 50px; height: 70px; object-fit: cover;">` :
                                        `<img src="/assets/img/undraw_posting_photo.svg" alt="Cover ${response.document.title}" style="width: 50px; height: 70px; object-fit: cover;">`);
                                } else {
                                    coverCell.html(response.document.cover_image ?
                                        `<img src="/storage/${response.document.cover_image}" alt="Cover ${response.document.title}" style="width: 50px; height: 70px; object-fit: cover;">` :
                                        `<img src="/assets/img/undraw_posting_photo.svg" alt="Cover ${response.document.title}" style="width: 50px; height: 70px; object-fit: cover;">`);
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr) {
                                let errors = xhr.responseJSON?.errors;
                                let message = xhr.responseJSON?.message ??
                                    'Terjadi kesalahan';

                                if (errors) {
                                    // Tampilkan error validasi
                                    let errorMessages = Object.values(errors).flat()
                                        .join('\n');
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validasi Gagal!',
                                        text: errorMessages
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: message
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        // Handle add document form submission dengan AJAX
        $(document).ready(function() {
            $('#tambahDocumentModal form').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);

                // Lanjutkan dengan AJAX request langsung
                $.ajax({
                    url: form.attr('action'),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Tutup modal
                        $('#tambahDocumentModal').modal('hide');

                        // Reset form
                        form[0].reset();

                        // Tambahkan row baru ke tabel
                        let coverHtml;
                        if (response.document.category.category_name == 'Poster') {
                            coverHtml = response.document.file_url ?
                                `<img src="/storage/${response.document.file_url}" alt="Cover ${response.document.title}" style="width: 50px; height: 70px; object-fit: cover;">` :
                                `<img src="/assets/img/undraw_posting_photo.svg" alt="Cover ${response.document.title}" style="width: 50px; height: 70px; object-fit: cover;">`;
                        } else {
                            coverHtml = response.document.cover_image ?
                                `<img src="/storage/${response.document.cover_image}" alt="Cover ${response.document.title}" style="width: 50px; height: 70px; object-fit: cover;">` :
                                `<img src="/assets/img/undraw_posting_photo.svg" alt="Cover ${response.document.title}" style="width: 50px; height: 70px; object-fit: cover;">`;
                        }

                        let abstractText = response.document.abstract ? response.document.abstract.substring(0, 50) + (response.document.abstract.length > 50 ? '...' : '') : '-';

                        let newRow = `
                            <tr id="row-${response.document.id}">
                                <td>${response.document.id}</td>
                                <td>${coverHtml}</td>
                                <td class="title">${response.document.title}</td>
                                <td class="category">${response.document.category.category_name}</td>
                                <td class="year">${response.document.year_published}</td>
                                <td class="author">${response.document.author}</td>
                                <td class="abstract">${abstractText}</td>
                                <td class="file">
                                    <a href="/storage/${response.document.file_url}" target="_blank">Lihat File</a>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editDocumentModal${response.document.id}"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm deleteBtn" data-toggle="modal" data-target="#confirmModal" data-url="/library/${response.document.id}"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        `;

                        // Tambahkan row ke tabel
                        $('#dataTable tbody').prepend(newRow);

                        // Tampilkan popup sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        let message = xhr.responseJSON?.message ?? 'Terjadi kesalahan';

                        if (errors) {
                            // Tampilkan error validasi
                            let errorMessages = Object.values(errors).flat().join('\n');
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal!',
                                text: errorMessages
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: message
                            });
                        }
                    }
                });
            });
        });
    </script>

    <script>
        // Show/hide abstract, cover image, kampus, and prodi fields based on category selection
        $(document).ready(function() {
            function toggleFields(form) {
                var categorySelect = form.find('select[name="category_id"]');
                var selectedCategoryText = categorySelect.find('option:selected').text().trim();

                // Show fields for all categories except Poster
                if (selectedCategoryText !== 'Poster') {
                    form.find('input[name="cover_image"]').closest('.form-group').show();
                    form.find('textarea[name="abstract"]').closest('.form-group').show();
                } else {
                    form.find('input[name="cover_image"]').closest('.form-group').hide();
                    form.find('textarea[name="abstract"]').closest('.form-group').hide();
                }

                // Show kampus and prodi only for 'penelitian eksternal'
                if (selectedCategoryText === 'Penelitian Eksternal') {
                    form.find('.kampus-prodi-row').show();
                } else {
                    form.find('.kampus-prodi-row').hide();
                }
            }

            // Handle add document modal
            $('#tambahDocumentModal').on('shown.bs.modal', function() {
                toggleFields($(this).find('form'));
            });

            $('#tambahDocumentModal select[name="category_id"]').on('change', function() {
                toggleFields($(this).closest('form'));
            });

            // Handle edit document modals
            $('[id^="editDocumentModal"]').on('shown.bs.modal', function() {
                toggleFields($(this).find('form'));
            });

            $('[id^="editDocumentModal"] select[name="category_id"]').on('change', function() {
                toggleFields($(this).closest('form'));
            });
        });
    </script>

</body>

</html>
