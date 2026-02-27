<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Upload - Admin perpustakaan</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Verifikasi Upload</h1>
                    </div>

                    <!-- Filter Section -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('verification.index') }}" class="row g-3">
                                <div class="col-md-4">
                                    <label for="date_from" class="form-label">Tanggal Dari</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from"
                                        value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="date_to" class="form-label">Tanggal Sampai</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to"
                                        value="{{ request('date_to') }}">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('verification.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Pending Uploads Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Upload Menunggu Verifikasi
                                ({{ $pendingUploads->total() }})</h6>
                        </div>
                        <div class="card-body">
                            @if ($pendingUploads->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Judul Dokumen</th>
                                                <th>Pembuat</th>
                                                <th>Kategori</th>
                                                <th>Tahun</th>
                                                <th>Client</th>
                                                <th>Tanggal Upload</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pendingUploads as $log)
                                                <tr>
                                                    <td>{{ $log->id }}</td>
                                                    <td>{{ $log->document->title ?? 'N/A' }}</td>
                                                    <td>{{ $log->document->author ?? 'N/A' }}</td>
                                                    <td>{{ $log->document->category->category_name ?? 'N/A' }}</td>
                                                    <td>{{ $log->document->year_published ?? 'N/A' }}</td>
                                                    <td>{{ $log->client->name ?? 'N/A' }}</td>
                                                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                                    <td>
                                                        <div class="d-flex flex-column gap-1">
                                                            <a href="{{ route('verification.viewFile', $log->id) }}"
                                                                target="_blank" class="btn btn-info btn-sm">
                                                                <i class="fas fa-eye"></i> Lihat File
                                                            </a>
                                                            @if ($log->status == 'pending')
                                                                <button class="btn btn-success btn-sm"
                                                                    onclick="approveUpload({{ $log->id }})">
                                                                    <i class="fas fa-check"></i> Setujui
                                                                </button>
                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="rejectUpload({{ $log->id }})">
                                                                    <i class="fas fa-times"></i> Tolak
                                                                </button>
                                                            @else
                                                                <div class="text-center">
                                                                    <small class="text-muted">
                                                                        @if ($log->verifier)
                                                                            Oleh: {{ $log->verifier->name }}<br>
                                                                            {{ $log->verified_at ? $log->verified_at->format('d/m/Y H:i') : '-' }}
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $pendingUploads->links() }}
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <h5>Tidak ada upload yang menunggu verifikasi</h5>
                                    <p class="text-muted">Semua upload telah diverifikasi.</p>
                                </div>
                            @endif
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

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="rejectModalLabel">
                        <i class="fas fa-times-circle mr-2"></i> Tolak Upload
                    </h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="rejectForm">
                        @csrf
                        <div class="form-group">
                            <label for="rejectReason">Alasan Penolakan</label>
                            <textarea class="form-control" id="rejectReason" name="reason" rows="3"
                                placeholder="Masukkan alasan penolakan..." required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-secondary btn-lg" type="button" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-danger btn-lg" id="confirmRejectBtn">
                        <i class="fas fa-times-circle mr-2"></i>Ya, Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Plugin tambahan -->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let currentRejectId = null;

        function approveUpload(id) {
            Swal.fire({
                title: 'Konfirmasi Persetujuan',
                text: 'Apakah Anda yakin ingin menyetujui upload ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/verification/approve/${id}`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
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
                            let message = xhr.responseJSON?.message ?? 'Terjadi kesalahan';
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: message
                            });
                        }
                    });
                }
            });
        }

        function rejectUpload(id) {
            currentRejectId = id;
            $('#rejectReason').val('');
            $('#rejectModal').modal('show');
        }

        $('#confirmRejectBtn').on('click', function() {
            const reason = $('#rejectReason').val().trim();

            if (!reason) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Alasan penolakan harus diisi'
                });
                return;
            }

            $.ajax({
                url: `/verification/reject/${currentRejectId}`,
                type: 'POST',
                data: {
                    reason: reason,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#rejectModal').modal('hide');
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
                    let message = xhr.responseJSON?.message ?? 'Terjadi kesalahan';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: message
                    });
                }
            });
        });
    </script>
</body>

</html>
