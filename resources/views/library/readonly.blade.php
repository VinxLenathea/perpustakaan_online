<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->title }} - Baca Saja</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: #f4f6f8;
            user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            margin: 0;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .header {
            background: #001f3f;
            color: white;
            padding: 15px;
            text-align: center;
            user-select: none;
        }

        .iframe-wrapper {
            position: relative;
            width: 100%;
            height: 95vh;
            overflow: hidden;

        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
            pointer-events: auto;
            overflow: auto;
        }

        /* ✅ Overlay transparan: blok klik kanan tapi tetap bisa scroll */
        .overlay-blocker {
            position: absolute;
            top: 0;
            left: 0;
            width: 90%;
            height: 100%;
            background: transparent;
            z-index: 10;
        }

        /* supaya scroll lewat overlay tetap berfungsi */
        .overlay-blocker::-webkit-scrollbar {
            display: none;
        }

        /* Sembunyikan saat print */
        @media print {
            body {
                display: none !important;
            }
        }

        .btn-beranda {
            background-color: #001f3f;
            color: #fff;
            border: none;
            transition: 0.3s;
        }

        .btn-beranda:hover {
            background-color: #003366;
            color: #fff;
        }

        /* Notifikasi kecil */
        #notice {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.75);
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            display: none;
            z-index: 9999;
            animation: fadein 0.5s;
        }

        @keyframes fadein {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <p class="mb-0 fw-bold">{{ $document->title }}</p>
    </div>

    <div class="iframe-wrapper">
        @php
            $fileExtension = pathinfo($document->file_url, PATHINFO_EXTENSION);
            $isImage = in_array(strtolower($fileExtension), ['png', 'jpg', 'jpeg', 'gif']);
        @endphp

        @if ($isImage)
            <!-- Tampilkan gambar di tengah -->
            <div class="d-flex justify-content-center align-items-center h-100">
                <img src="{{ asset('storage/' . $document->file_url) }}" alt="{{ $document->title }}" class="img-fluid"
                    style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
        @else
            <!-- Dokumen PDF -->
            <iframe id="docFrame" src="{{ asset('storage/' . $document->file_url) }}#toolbar=0&navpanes=0&scrollbar=1"
                allowfullscreen>
            </iframe>

            <!-- Overlay transparan -->
            <div class="overlay-blocker" oncontextmenu="return false;" onmousedown="if(event.button===2) return false;"
                onmouseup="if(event.button===2) return false;" ondragstart="return false;" onselectstart="return false;"
                ontouchstart="return true;" ontouchmove="return true;">
            </div>
        @endif
    </div>

    @if (!isset($showBackButton) || $showBackButton)
        <div class="text-center my-3">
            <button onclick="window.history.back()" class="btn btn-beranda btn-lg px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Halaman Sebelumnya
            </button>
        </div>
    @endif

    <!-- Notifikasi -->
    <div id="notice"></div>

    <script>
        (function() {
            'use strict';

            const showNotice = (msg) => {
                const notice = document.getElementById('notice');
                notice.textContent = msg;
                notice.style.display = 'block';
                setTimeout(() => {
                    notice.style.display = 'none';
                }, 2000);
            };

            // 🔒 Blok klik kanan di seluruh halaman
            document.addEventListener('contextmenu', e => e.preventDefault());
            document.addEventListener('mousedown', e => {
                if (e.button === 2) e.preventDefault();
            });
            document.addEventListener('mouseup', e => {
                if (e.button === 2) e.preventDefault();
            });

            // 🔒 Blok shortcut developer
            document.addEventListener('keydown', e => {
                const k = e.key.toLowerCase();
                if (
                    e.key === 'F12' ||
                    (e.ctrlKey && ['s', 'u', 'p'].includes(k)) ||
                    (e.ctrlKey && e.shiftKey && ['i', 'j', 'c'].includes(k))
                ) {
                    e.preventDefault();
                    console.clear();
                    showNotice('Tombol pintasan ini dinonaktifkan!');
                }
            });

            // 🔒 Peringatan PrintScreen
            document.addEventListener('keyup', e => {
                if (e.key === 'PrintScreen') {
                    showNotice('Tangkapan layar tidak diperbolehkan.');
                    navigator.clipboard.writeText('');
                }
            });

            // 🔒 Deteksi Developer Tools (lebih stabil)
            let open = false;
            const threshold = 200;
            setInterval(() => {
                if (
                    window.outerWidth - window.innerWidth > threshold ||
                    window.outerHeight - window.innerHeight > threshold
                ) {
                    if (!open) {
                        open = true;
                        document.body.innerHTML =
                            "<h1 style='color:red;text-align:center;margin-top:20%;'>⚠️ Akses Diblokir</h1>";
                    }
                }
            }, 1500);
        })();
    </script>
</body>

</html>
