<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->title }} - Baca Saja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f8;
            user-select: text; /* tetap bisa Ctrl+F dan seleksi teks */
            -webkit-user-select: text;
        }

        /* wrapper scroll */
        .iframe-wrapper {
            width: 100%;
            height: 95vh;

        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
            pointer-events: auto; /* biar bisa scroll */
        }

        .header {
            background: #001f3f;
            color: white;
            padding: 15px;
            text-align: center;
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

        /* ❌ Sembunyikan halaman saat print */
        @media print {
            body {
                display: none !important;
            }
        }
    </style>

    <script>
        // 🔒 Blok klik kanan di seluruh halaman
        document.addEventListener("contextmenu", function(e) {
            e.preventDefault();
        });

        // 🔒 Blok drag teks atau gambar
        document.addEventListener("dragstart", e => e.preventDefault());
        document.addEventListener("selectstart", e => {
            if (window.getSelection().toString().length === 0) {
                e.preventDefault();
            }
        });

        // 🔒 Blok shortcut berbahaya
        document.addEventListener("keydown", function(e) {
            const forbiddenKeys = ['s','S','u','U','p','P'];
            if (
                (e.ctrlKey && forbiddenKeys.includes(e.key)) || // Ctrl+S/U/P
                e.key === 'PrintScreen' ||
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && ['I','i','J','j','C','c'].includes(e.key))
            ) {
                e.preventDefault();
            }
        });

        // 🔒 Blok print manual
        window.print = function() {
            e.preventDefault();
        };

        // 🔒 Blok print dari menu browser
        window.addEventListener("beforeprint", (e) => {
            e.preventDefault();
        });

        // 🔒 Deteksi PrintScreen
        document.addEventListener("keyup", function(e) {
            if (e.key === "PrintScreen") {
                navigator.clipboard.writeText("");
            }
        });

        // 🔒 Deteksi developer tools (F12 terbuka)
        setInterval(function() {
            const threshold = 160;
            if (
                window.outerWidth - window.innerWidth > threshold ||
                window.outerHeight - window.innerHeight > threshold
            ) {
                document.body.innerHTML = "<h1 style='color:red;text-align:center;margin-top:20%;'>s</h1>";
            }
        }, 1000);
    </script>
</head>

<body>
    <div class="header">
        <p class="mb-0 fw-bold">{{ $document->title }}</p>
    </div>

    <div class="iframe-wrapper">
        <iframe
            src="{{ asset('storage/' . $document->file_url) }}#toolbar=0"
            allow="autoplay"
            allowfullscreen>
        </iframe>
    </div>

    @if(!isset($showBackButton) || $showBackButton)
        <div class="text-center my-3">
            <button onclick="window.history.back()" class="btn btn-beranda btn-lg px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Halaman Sebelumnya
            </button>
        </div>
    @endif
</body>
</html>
