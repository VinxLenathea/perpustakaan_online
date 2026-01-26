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
                        <h1 class="h3 mb-0 text-gray-800">Category Management</h1>
                    </div>

                    <!-- Data User -->
                    <div class="card shadow mb-4">
                        <div class="card-body bg-light">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <!-- Tombol Tambah User -->
                                <button class="btn btn-sm btn-success shadow-sm mb-2" data-toggle="modal"
                                    data-target="#tambahUserModal">
                                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Kategori
                                </button>
                            </div>

                            <!-- Table -->
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr id="userRow{{ $category->id }}">
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->category_name }}</td>
                                            <td>
                                                <!-- Tombol Edit -->

                                                <button class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-target="#editUserModal{{ $category->id }}">Edit</button>


                                                <!-- Tombol Hapus -->

                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#confirmModal"
                                                    data-url="{{ route('categories.destroy', $category->id) }}">
                                                    Hapus
                                                </button>


                                            </td>
                                        </tr>

                                        <!-- Modal Edit User -->
                                        <div class="modal fade" id="editUserModal{{ $category->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editUserLabel{{ $category->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form id="editUserForm{{ $category->id }}" class="editUserForm"
                                                    data-id="{{ $category->id }}"
                                                    action="{{ route('categories.update', $category) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editUserLabel{{ $category->id }}">Edit Kategori
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form Edit -->
                                                            <div class="form-group">
                                                                <label for="name">Nama Kategori</label>
                                                                <input type="text" class="form-control"
                                                                    name="name"
                                                                    value="{{ $category->category_name }}" required>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Update</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal Tambah User -->
                    <div class="modal fade" id="tambahUserModal" tabindex="-1" role="dialog"
                        aria-labelledby="tambahUserLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('categories.store') }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahUserLabel">Tambah Kategori</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form Input -->
                                        <div class="form-group">
                                            <label for="name">Nama Kategori</label>
                                            <input type="text" class="form-control" name="name" required>
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
                        <p class="mb-3">Apakah Anda yakin ingin menghapus kategori ini?</p>
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



    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>

    <script>
        // Modal konfirmasi hapus dengan AJAX (Generic untuk semua jenis data)
        $('#confirmModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang diklik
            var url = button.data('url'); // Ambil data-url dari tombol
            var row = button.closest('tr'); // Ambil row tabel

            // Deteksi jenis data berdasarkan struktur tabel
            if (row.find('td:nth-child(3)').length > 0) {
                // User table (kolom: ID, Name, Email, Aksi)
                var itemName = row.find('td:nth-child(2)').text(); // Nama user
                var itemDetail = row.find('td:nth-child(3)').text(); // Email user
                var itemType = 'user';

                var detailsHtml = `
                    <div class="alert alert-light">
                        <strong>Nama Kategori:</strong> ${itemName}<br>

                    </div>
                `;

                var warningText = 'User ini akan dihapus secara permanen.';
            } else {
                // Document table (kolom: ID, Judul, Kategori, Tahun, Pembuat, File, Aksi)
                var itemName = row.find('.title').text(); // Judul document
                var itemDetail = row.find('.author').text(); // Penulis document
                var itemType = 'document';

                var detailsHtml = `
                    <div class="alert alert-light">
                        <strong>Judul:</strong> ${itemName}<br>
                        <strong>Penulis:</strong> ${itemDetail}
                    </div>
                `;

                var warningText = 'Document ini akan dihapus secara permanen beserta file yang terkait.';
            }

            // Update modal content
            $(this).find('#itemDetails').html(detailsHtml);
            $(this).find('.modal-body p').first().html(`Apakah Anda yakin ingin menghapus ${itemType} ini?`);
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
            var successMessage = isUser ? 'User berhasil dihapus!' : 'Document berhasil dihapus!';

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
        @if (session('success'))
            $(document).ready(function() {
                let modal = $('#successModal');
                modal.modal('show');

                // Tutup otomatis setelah 2.5 detik
                setTimeout(function() {
                    modal.modal('hide');
                }, 2500);
            });
        @endif
    </script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // tangkap submit form update user
            $(document).on("submit", ".editUserForm", function(e) {
                e.preventDefault();

                let form = $(this);
                let id = form.data("id");
                let formData = new FormData(this);

                // Ambil data form untuk konfirmasi
                let name = form.find('input[name="name"]').val();

                // Buat pesan konfirmasi
                let confirmMessage = `Apakah Anda yakin ingin mengupdate kategori ini?\n\n`;
                confirmMessage += `Nama Kategori: ${name}\n`;

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
                            type: "POST", // tetap POST (Laravel pakai _method=PUT)
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // tutup modal
                                $("#editUserModal" + id).modal("hide");

                                // update tabel
                                $("#userRow" + id + " td:nth-child(2)").text(response
                                    .user.name);
                                $("#userRow" + id + " td:nth-child(3)").text(response
                                    .user.email);

                                // popup sukses
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil!",
                                    text: "Kategori berhasil diperbarui!",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            },
                            error: function(xhr) {
                                let errors = xhr.responseJSON?.errors;
                                let message = xhr.responseJSON?.message ??
                                    "Terjadi kesalahan";

                                if (errors) {
                                    // Tampilkan error validasi
                                    let errorMessages = Object.values(errors).flat()
                                        .join('\n');
                                    Swal.fire({
                                        icon: "error",
                                        title: "Validasi Gagal!",
                                        text: errorMessages
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Gagal!",
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
        // Handle add user form submission dengan AJAX
        $(document).ready(function() {
            $('#tambahUserModal form').on('submit', function(e) {
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
                        $('#tambahUserModal').modal('hide');

                        // Reset form
                        form[0].reset();

                        // Tambahkan row baru ke tabel
                        let newRow = `
                            <tr id="userRow${response.category.id}">
                                <td>${response.category.id}</td>
                                <td>${response.category.category_name}</td>
                                <td>
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editUserModal${response.category.id}">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmModal" data-url="/categories/${response.category.id}">Hapus</button>
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

</body>

</html>
