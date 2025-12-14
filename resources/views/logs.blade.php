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
                        <h1 class="h3 mb-0 text-gray-800">Upload Logs</h1>
                    </div>

                    <!-- Search Bar -->
                    <div class="card shadow mb-4">
                        <div class="card-body bg-light">
                            <div class="container-fluid">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <!-- Form Filter -->
                                    <form action="{{ route('logs.index') }}" method="GET"
                                        class="form-inline mb-2 d-flex align-items-center flex-wrap">
                                        <label for="status" class="mr-1">Status:</label>
                                        <select name="status" id="status" class="form-control form-control-sm mr-2"
                                            style="width: auto;">
                                            <option value="">Semua Status</option>
                                            <option value="pending"
                                                {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved"
                                                {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                                            </option>
                                            <option value="rejected"
                                                {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                            </option>
                                        </select>

                                        <label for="date_from" class="mr-1 ml-2">Dari:</label>
                                        <input type="date" name="date_from" id="date_from"
                                            class="form-control form-control-sm mr-2" value="{{ request('date_from') }}"
                                            style="width: auto;">

                                        <label for="date_to" class="mr-1 ml-2">Sampai:</label>
                                        <input type="date" name="date_to" id="date_to"
                                            class="form-control form-control-sm mr-2" value="{{ request('date_to') }}"
                                            style="width: auto;">

                                        <button type="submit" class="btn btn-success btn-sm ml-2">Filter</button>
                                        <a href="{{ route('logs.index') }}"
                                            class="btn btn-secondary btn-sm ml-2">Reset</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Container -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Document</th>
                                                <th>Uploader</th>
                                                <th>Client</th>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Tanggal Upload</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($logs as $log)
                                                <tr id="logRow{{ $log->id }}">
                                                    <td>{{ $log->id }}</td>
                                                    <td>
                                                        @if ($log->document)
                                                            <strong>{{ $log->document->title }}</strong><br>
                                                            <small
                                                                class="text-muted">{{ $log->document->author }}</small>
                                                        @else
                                                            <em class="text-muted">Document tidak ditemukan</em>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($log->user)
                                                            {{ $log->user->name }}<br>
                                                            <small class="text-muted">{{ $log->user->email }}</small>
                                                        @else
                                                            <em class="text-muted">-</em>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($log->client)
                                                            {{ $log->client->name }}<br>
                                                            <small
                                                                class="text-muted">{{ $log->client->api_token ? substr($log->client->api_token, 0, 10) . '...' : '-' }}</small>
                                                        @else
                                                            <em class="text-muted">-</em>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $log->action)) }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge
                                                            @if ($log->status == 'approved') badge-success
                                                            @elseif($log->status == 'rejected') badge-danger
                                                            @else badge-warning @endif">
                                                            {{ ucfirst($log->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>
                                                        @if ($log->status == 'pending')
                                                            <div class="d-flex flex-column align-items-center gap-1">
                                                                <button class="btn btn-success btn-sm approveBtn"
                                                                    data-id="{{ $log->id }}"
                                                                    data-title="{{ $log->document ? $log->document->title : 'Unknown' }}">
                                                                    <i class="fas fa-check"></i> Approve
                                                                </button>
                                                                <button class="btn btn-danger btn-sm rejectBtn" style="margin-top: 5px; width: 90px;"
                                                                    data-id="{{ $log->id }}"
                                                                    data-title="{{ $log->document ? $log->document->title : 'Unknown' }}">
                                                                    <i class="fas fa-times"></i> Reject
                                                                </button>
                                                            </div>
                                                        @else
                                                            <em class="text-muted">Sudah diproses</em>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $logs->onEachSide(1)->links('pagination::bootstrap-4') }}
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

    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Handle approve button
            $('.approveBtn').on('click', function() {
                var logId = $(this).data('id');
                var title = $(this).data('title');

                Swal.fire({
                    title: 'Approve Upload?',
                    text: `Apakah Anda yakin ingin menyetujui upload "${title}"?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Approve!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/logs/${logId}/approve`,
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $('#logRow' + logId + ' .badge').removeClass(
                                    'badge-warning').addClass('badge-success').text(
                                    'Approved');
                                $('#logRow' + logId + ' td:last-child').html(
                                    '<em class="text-muted">Sudah diproses</em>');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan'
                                });
                            }
                        });
                    }
                });
            });

            // Handle reject button
            $('.rejectBtn').on('click', function() {
                var logId = $(this).data('id');
                var title = $(this).data('title');

                Swal.fire({
                    title: 'Reject Upload?',
                    text: `Apakah Anda yakin ingin menolak upload "${title}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Reject!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/logs/${logId}/reject`,
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                $('#logRow' + logId + ' .badge').removeClass(
                                    'badge-warning').addClass('badge-danger').text(
                                    'Rejected');
                                $('#logRow' + logId + ' td:last-child').html(
                                    '<em class="text-muted">Sudah diproses</em>');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
