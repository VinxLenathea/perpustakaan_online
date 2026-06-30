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
                                        <th>Tipe Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                    <tr id="userRow{{ $category->id }}">
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->category_name }}</td>
                                        <td> {{-- ← kolom tipe --}}
                                            <span class="badge {{ $category->category_type == 'internal' ? 'badge-primary' : 'badge-success' }}">
                                                {{ ucfirst($category->category_type) }}
                                            </span>
                                        </td>
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
                                                                name="category_name"
                                                                value="{{ $category->category_name }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="category_type">Tipe Kategori</label>
                                                            <select class="form-control" name="category_type" required>
                                                                <option value="">Pilih Tipe</option>
                                                                <option value="internal" {{ $category->category_type == 'internal' ? 'selected' : '' }}>Internal</option>
                                                                <option value="external" {{ $category->category_type == 'external' ? 'selected' : '' }}>External</option>
                                                            </select>
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
                                            <input type="text" class="form-control" name="category_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="category_type">Tipe Kategori</label>
                                            <select class="form-control" name="category_type" required>
                                                <option value="">Pilih Tipe</option>
                                                <option value="internal">Internal</option>
                                                <option value="external">External</option>
                                            </select>
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
    <!-- jQuery -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Plugin tambahan -->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
    <!-- SweetAlert2 — harus SEBELUM script lain yang pakai Swal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var baseUrl = "{{ url('/') }}";
        var sessionSuccess = "{{ session('success') ?? '' }}";
    </script>

    <script>
        $(document).ready(function() {
            if (sessionSuccess) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: sessionSuccess,
                    timer: 2500,
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            }
        });
    </script>

    <script>
        // Modal konfirmasi hapus
        $('#confirmModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var url = button.data('url');
            var row = button.closest('tr');
            var itemName = row.find('td:nth-child(2)').text();

            var detailsHtml = `
            <div class="alert alert-light">
                <strong>Nama Kategori:</strong> ${itemName}
            </div>
        `;

            $(this).find('#itemDetails').html(detailsHtml);
            $(this).find('.modal-body p').first().html('Apakah Anda yakin ingin menghapus kategori ini?');
            $(this).find('.text-muted').html('Kategori ini akan dihapus secara permanen.');
            $(this).find('#deleteForm').attr('action', url);
        });

        // Handle delete AJAX
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                url: url,
                type: "POST",
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#confirmModal').modal('hide');
                    $(`button[data-url="${url}"]`).closest('tr').fadeOut(500, function() {
                        $(this).remove();
                    });
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Kategori berhasil dihapus!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    $('#confirmModal').modal('hide');
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON?.message ?? 'Terjadi kesalahan'
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Edit kategori
            $(document).on("submit", ".editUserForm", function(e) {
                e.preventDefault();

                let form = $(this);
                let id = form.data("id");
                let formData = new FormData(this);
                let name = form.find('input[name="category_name"]').val();

                Swal.fire({
                    title: 'Konfirmasi Update',
                    text: `Apakah Anda yakin ingin mengupdate kategori ini?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Update!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            success: function(response) {
                                $("#editUserModal" + id).modal("hide");

                                // ← Fix: pakai response.category bukan response.user
                                $("#userRow" + id + " td:nth-child(2)").text(response.category.category_name);
                                $("#userRow" + id + " td:nth-child(3)").html(
                                    `<span class="badge ${response.category.category_type == 'internal' ? 'badge-primary' : 'badge-success'}">
                                        ${response.category.category_type.charAt(0).toUpperCase() + response.category.category_type.slice(1)}
                                    </span>`
                                );

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
                                let message = xhr.responseJSON?.message ?? "Terjadi kesalahan";

                                if (errors) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Validasi Gagal!",
                                        text: Object.values(errors).flat().join('\n')
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

            // Tambah kategori
            $('#tambahUserModal form').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);

                $.ajax({
                    url: form.attr('action'),
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        $('#tambahUserModal').modal('hide');
                        form[0].reset();

                        let newRow = `
                        <tr id="userRow${response.category.id}">
                            <td>${response.category.id}</td>
                            <td>${response.category.category_name}</td>
                            <td>
                                <span class="badge ${response.category.category_type == 'internal' ? 'badge-primary' : 'badge-success'}">
                                    ${response.category.category_type.charAt(0).toUpperCase() + response.category.category_type.slice(1)}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm" data-toggle="modal" 
                                        data-target="#editUserModal${response.category.id}">Edit</button>
                                <button type="button" class="btn btn-danger btn-sm" 
                                        data-toggle="modal" data-target="#confirmModal" 
                                        data-url="${baseUrl}/categories/${response.category.id}">Hapus</button>
                            </td>
                        </tr>
                    `;

                        $('#dataTable tbody').prepend(newRow);

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
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal!',
                                text: Object.values(errors).flat().join('\n')
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