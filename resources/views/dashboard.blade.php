<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

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
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

                    {{-- Kartu statistik utama --}}
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <div class="rounded p-3 mr-3" style="background:#E6F1FB">
                                        <i class="fas fa-folder fa-lg" style="color:#185FA5"></i>
                                    </div>
                                    <div>
                                        <p class="text-uppercase text-muted small mb-1">Total Dokumen</p>
                                        <h4 class="mb-0 font-weight-bold">{{ $totalDocuments }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <div class="rounded p-3 mr-3" style="background:#EAF3DE">
                                        <i class="fas fa-check fa-lg" style="color:#3B6D11"></i>
                                    </div>
                                    <div>
                                        <p class="text-uppercase text-muted small mb-1">Disetujui</p>
                                        <h4 class="mb-0 font-weight-bold text-success">{{ $approvedDocuments }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <div class="rounded p-3 mr-3" style="background:#FAEEDA">
                                        <i class="fas fa-clock fa-lg" style="color:#854F0B"></i>
                                    </div>
                                    <div>
                                        <p class="text-uppercase text-muted small mb-1">Menunggu</p>
                                        <h4 class="mb-0 font-weight-bold text-warning">{{ $pendingDocuments }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <div class="rounded p-3 mr-3" style="background:#FCEBEB">
                                        <i class="fas fa-times fa-lg" style="color:#A32D2D"></i>
                                    </div>
                                    <div>
                                        <p class="text-uppercase text-muted small mb-1">Ditolak</p>
                                        <h4 class="mb-0 font-weight-bold text-danger">{{ $rejectedDocuments }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kartu per kategori --}}
                    <div class="row mb-4">
                        @foreach ($categories as $category)
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body d-flex align-items-center">
                                    <div class="rounded p-3 mr-3" style="background:#EEEDFE">
                                        <i class="fas fa-file-alt fa-lg" style="color:#534AB7"></i>
                                    </div>
                                    <div>
                                        <p class="text-uppercase text-muted small mb-1">{{ $category->category_name }}</p>
                                        <h4 class="mb-0 font-weight-bold">{{ $category->documents_count }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Tabel upload terbaru --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 font-weight-bold text-gray-800">
                                <i class="fas fa-clock mr-2 text-warning"></i> Upload Terbaru Menunggu Verifikasi
                            </h6>
                            <a href="{{ route('verification.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Judul</th>
                                        <th>Pembuat</th>
                                        <th>Tanggal Upload</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPending as $doc)
                                    <tr>
                                        <td>{{ Str::limit($doc->title, 40) }}</td>
                                        <td>{{ $doc->author }}</td>
                                        <td>{{ $doc->created_at->format('d M Y') }}</td>
                                        <td><span class="badge badge-warning">Menunggu</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="fas fa-check-circle mr-2 text-success"></i>
                                            Tidak ada dokumen yang menunggu verifikasi
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('view component.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->


    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="assets/js/demo/chart-area-demo.js"></script>
    <script src="assets/js/demo/chart-pie-demo.js"></script>

</body>

</html>