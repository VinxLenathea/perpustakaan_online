<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Document - Perpustakaan RSUD Mohammad Noer</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
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
                        <h1 class="h3 mb-0 text-gray-800">Detail Document</h1>
                        <a href="{{ route('library') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Library
                        </a>
                    </div>

                    <!-- Document Detail Card -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Informasi Document</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                @if ($document->category->category_name == 'Poster')
                                                    @if ($document->file_url && in_array(pathinfo($document->file_url, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg', 'gif']))
                                                        <img src="{{ asset('storage/' . $document->file_url) }}"
                                                            alt="Cover {{ $document->title }}"
                                                            class="img-fluid rounded shadow">
                                                    @else
                                                        <img src="{{ asset('assets/img/undraw_posting_photo.svg') }}"
                                                            alt="Cover {{ $document->title }}"
                                                            class="img-fluid rounded shadow">
                                                    @endif
                                                @else
                                                    @if ($document->cover_image)
                                                        <img src="{{ asset('storage/' . $document->cover_image) }}"
                                                            alt="Cover {{ $document->title }}"
                                                            class="img-fluid rounded shadow">
                                                    @else
                                                        <img src="{{ asset('assets/img/undraw_posting_photo.svg') }}"
                                                            alt="Cover {{ $document->title }}"
                                                            class="img-fluid rounded shadow">
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th width="150">ID</th>
                                                    <td>: {{ $document->id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Judul</th>
                                                    <td>: {{ $document->title }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Pembuat</th>
                                                    <td>: {{ $document->author }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kategori</th>
                                                    <td>: {{ $document->category->category_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tahun</th>
                                                    <td>: {{ $document->year_published }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kampus</th>
                                                    <td>: {{ $document->kampus ?: '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Prodi</th>
                                                    <td>: {{ $document->prodi ?: '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Dilihat</th>
                                                    <td>: {{ $document->views }} kali</td>
                                                </tr>
                                                <tr>
                                                    <th>File</th>
                                                    <td>:
                                                        @if ($document->file_url)
                                                            <a href="{{ route('library.viewFile', $document->id) }}"
                                                                target="_blank" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-eye"></i> Lihat File
                                                            </a>
                                                        @else
                                                            Tidak ada file
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Dibuat</th>
                                                    <td>: {{ $document->created_at->format('d M Y H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Diupdate</th>
                                                    <td>: {{ $document->updated_at->format('d M Y H:i') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Abstract Card -->
                            @if ($document->abstract)
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Abstrak</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-justify">{{ $document->abstract }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Actions Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-2">
                                        <button class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#editDocumentModal{{ $document->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button style="margin-top: 5px" type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#confirmModal"
                                            data-url="{{ route('library.destroy', $document) }}">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
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

    <!-- Modal Edit Document -->
    <div class="modal fade" id="editDocumentModal{{ $document->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editDocumentLabel{{ $document->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="updateForm" data-id="{{ $document->id }}"
                action="{{ route('library.update', $document) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDocumentLabel{{ $document->id }}">Edit Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Judul</label>
                                    <input type="text" class="form-control" name="title"
                                        value="{{ $document->title }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="author">Pembuat</label>
                                    <input type="text" class="form-control" name="author"
                                        value="{{ $document->author }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="year_published">Tahun Terbit</label>
                                    <input type="number" class="form-control" name="year_published"
                                        value="{{ $document->year_published }}" min="1900" max="2099"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Kategori</label>
                                    <select class="form-control" name="category_id" required>
                                        @foreach (\App\Models\CategoryModel::all() as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ $document->category_id == $cat->id ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $cat->category_name)) }}
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
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cover_image">Ganti Cover Image (Opsional)</label>
                                    <input type="file" class="form-control" name="cover_image" accept="image/*">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti cover. Format: JPG,
                                        PNG, GIF. Max 2MB.</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="abstract">Abstrak</label>
                            <textarea class="form-control" name="abstract" rows="2" placeholder="Masukkan abstrak dokumen...">{{ $document->abstract }}</textarea>
                        </div>
                        <div class="row kampus-prodi-row" style="display: none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kampus">Kampus</label>
                                    <input type="text" class="form-control" name="kampus"
                                        value="{{ $document->kampus }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prodi">Prodi</label>
                                    <input type="text" class="form-control" name="prodi"
                                        value="{{ $document->prodi }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Konfirmasi Hapus
                    </h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="deleteContent">
                        <p class="mb-3">Apakah Anda yakin ingin menghapus document ini?</p>
                        <div id="itemDetails" class="text-left mb-3">
                            <div class="alert alert-light">
                                <strong>Judul:</strong> {{ $document->title }}<br>
                                <strong>Pembuat:</strong> {{ $document->author }}
                            </div>
                        </div>
                        <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-secondary btn-lg" type="button" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
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

    <!-- jQuery -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Plugin tambahan -->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/js/demo/chart-pie-demo.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Modal konfirmasi hapus
        $('#confirmModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var url = button.data('url');
            var form = $(this).find('#deleteForm');
            form.attr('action', url);
        });

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
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Document berhasil dihapus!',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '{{ route('library') }}';
                    });
                },
                error: function(xhr) {
                    $('#confirmModal').modal('hide');
                    let message = xhr.responseJSON?.message ??
                        'Terjadi kesalahan saat menghapus document';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: message
                    });
                }
            });
        });

        // Update document
        $('.updateForm').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);
            let id = form.data('id');
            let formData = new FormData(this);

            Swal.fire({
                title: 'Konfirmasi Update',
                text: 'Apakah Anda yakin ingin mengupdate document ini?',
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
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#editDocumentModal' + id).modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            let errors = xhr.responseJSON?.errors;
                            let message = xhr.responseJSON?.message ?? 'Terjadi kesalahan';
                            if (errors) {
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
                }
            });
        });

        // Show/hide kampus and prodi fields
        $(document).ready(function() {
            function toggleFields(form) {
                var categorySelect = form.find('select[name="category_id"]');
                var selectedCategoryText = categorySelect.find('option:selected').text().trim();

                if (selectedCategoryText === 'Penelitian Eksternal') {
                    form.find('.kampus-prodi-row').show();
                } else {
                    form.find('.kampus-prodi-row').hide();
                }
            }

            $('#editDocumentModal{{ $document->id }}').on('shown.bs.modal', function() {
                toggleFields($(this).find('form'));
            });

            $('#editDocumentModal{{ $document->id }} select[name="category_id"]').on('change', function() {
                toggleFields($(this).closest('form'));
            });
        });
    </script>
</body>

</html>
