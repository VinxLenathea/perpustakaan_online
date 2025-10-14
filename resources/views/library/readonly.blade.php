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
      user-select: none; /* ❌ Tidak bisa seleksi teks */
      -webkit-user-select: none;
      -ms-user-select: none;
      margin: 0;
      overflow: hidden;
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
      pointer-events: auto; /* biar tetap bisa scroll */
      overflow: auto;
    }

    /* Overlay transparan hanya blokir klik kanan, bukan scroll */
    /* .overlay-blocker {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: transparent;
      cursor: default;
      z-index: 10;
    } */

    /* Sembunyikan halaman saat print */
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
  </style>
</head>

<body>
  <div class="header">
    <p class="mb-0 fw-bold">{{ $document->title }}</p>
  </div>

  <div class="iframe-wrapper">
    <!-- Dokumen -->
    <iframe
      id="docFrame"
      src="{{ asset('storage/' . $document->file_url) }}#toolbar=0&navpanes=0&scrollbar=1"
      allow="autoplay"
      allowfullscreen>
    </iframe>

    <!-- Overlay transparan untuk blok klik kanan tanpa ganggu scroll -->
    <div class="overlay-blocker"
         oncontextmenu="return false;"
         onmousedown="if(event.button===2) return false;"
         onmouseup="if(event.button===2) return false;"
         ondragstart="return false;"
         onselectstart="return false;"
         ontouchstart="return true;"
         ontouchmove="return true;">
    </div>
  </div>

  @if(!isset($showBackButton) || $showBackButton)
  <div class="text-center my-3">
    <button onclick="window.history.back()" class="btn btn-beranda btn-lg px-4">
      <i class="fas fa-arrow-left me-2"></i> Kembali ke Halaman Sebelumnya
    </button>
  </div>
  @endif

  <script>
    (function(){
      'use strict';

      // 🔒 Blok klik kanan di seluruh dokumen utama
      document.addEventListener('contextmenu', e => e.preventDefault());
      document.addEventListener('mousedown', e => { if (e.button === 2) e.preventDefault(); });
      document.addEventListener('mouseup', e => { if (e.button === 2) e.preventDefault(); });

      // 🔒 Blok shortcut developer
      document.addEventListener('keydown', e => {
        const k = e.key.toLowerCase();
        if (
          e.key === 'F12' ||
          (e.ctrlKey && ['s','u','p'].includes(k)) ||
          (e.ctrlKey && e.shiftKey && ['i','j','c'].includes(k))
        ) {
          e.preventDefault();
          alert('Tombol pintasan ini dinonaktifkan!');
        }
      });

      // 🔒 Blok PrintScreen
      document.addEventListener('keyup', e => {
        if (e.key === 'PrintScreen') {
          navigator.clipboard.writeText('');
          alert('Tangkapan layar dinonaktifkan!');
        }
      });

      // 🔒 Deteksi Developer Tools
      let devTools = false;
      setInterval(() => {
        const t = 160;
        if (
          window.outerWidth - window.innerWidth > t ||
          window.outerHeight - window.innerHeight > t
        ) {
          if (!devTools) {
            devTools = true;
            document.body.innerHTML =
              "<h1 style='color:red;text-align:center;margin-top:20%;'>⚠️ Akses Diblokir</h1>";
          }
        }
      }, 1000);
    })();
  </script>
</body>
</html>
