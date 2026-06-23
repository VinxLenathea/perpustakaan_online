<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->title }} - Viewer Aman</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            background: #f4f6f8;
            overflow-x: hidden;
            user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }

        .header {
            background: #001f3f;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            position: relative;
            z-index: 999;
        }

        .viewer-wrapper {
            position: relative;
            width: 100%;
            height: 92vh;
            overflow: hidden;
            background: #000;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* overlay blok kanan */
        .overlay-blocker {
            position: absolute;
            top: 0;
            left: 0;
            width: 92%;
            height: 100%;
            z-index: 5;
            background: transparent;
        }

        /* watermark */
        .watermark {
            position: absolute;
            top: 30%;
            left: 15%;
            font-size: 42px;
            color: rgba(255, 0, 0, 0.12);
            transform: rotate(-28deg);
            z-index: 8;
            pointer-events: none;
            font-weight: bold;
            white-space: nowrap;
        }

        .watermark2 {
            position: absolute;
            top: 60%;
            left: 25%;
            font-size: 35px;
            color: rgba(0, 0, 255, 0.10);
            transform: rotate(-28deg);
            z-index: 8;
            pointer-events: none;
            white-space: nowrap;
        }

        .btn-back {
            background: #001f3f;
            color: white;
            border: none;
        }

        .btn-back:hover {
            background: #003366;
            color: white;
        }

        #notice {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(0,0,0,.8);
            color: white;
            padding: 10px 14px;
            border-radius: 8px;
            display: none;
            z-index: 99999;
        }

        .blur-screen {
            filter: blur(18px);
        }

        @media print {
            body {
                display: none !important;
            }
        }
    </style>
</head>

<body>

<div class="header">
    {{ $document->title }}
</div>

<div id="viewerArea" class="viewer-wrapper">

    {{-- watermark --}}
    <div class="watermark">
        {{ auth()->user()->name ?? 'Guest' }} | {{ now()->format('d-m-Y H:i') }}
    </div>

    <div class="watermark2">
        PERPUSTAKAAN ONLINE RSUD MOHAMMAD NOER PAMEKASAN
    </div>

    {{-- pdf --}}
    <iframe
        src="{{ asset('storage/' . $document->file_url) }}#toolbar=0&navpanes=0&scrollbar=1"
        id="docFrame"
        allowfullscreen>
    </iframe>

    {{-- blocker --}}
    <div class="overlay-blocker"
         oncontextmenu="return false;"
         ondragstart="return false;"
         onselectstart="return false;">
    </div>

</div>

<div class="text-center my-3">
    <button onclick="history.back()" class="btn btn-back px-4 btn-lg">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </button>
</div>

<div id="notice"></div>

<script>
(function () {
    "use strict";

    const notice = document.getElementById("notice");
    const viewer = document.getElementById("viewerArea");

    function showNotice(text) {
        notice.innerText = text;
        notice.style.display = "block";
        setTimeout(() => {
            notice.style.display = "none";
        }, 2000);
    }

    // klik kanan
    document.addEventListener("contextmenu", e => e.preventDefault());

    // blok drag
    document.addEventListener("dragstart", e => e.preventDefault());

    // blok select
    document.addEventListener("selectstart", e => e.preventDefault());

    // blok shortcut
    document.addEventListener("keydown", function (e) {
        let key = e.key.toLowerCase();

        if (
            e.key === "F12" ||
            (e.ctrlKey && ["s", "u", "p"].includes(key)) ||
            (e.ctrlKey && e.shiftKey && ["i", "j", "c"].includes(key))
        ) {
            e.preventDefault();
            showNotice("Shortcut dinonaktifkan");
        }
    });

    // printscreen
    document.addEventListener("keyup", function(e){
        if(e.key === "PrintScreen"){
            navigator.clipboard.writeText('');
            showNotice("Screenshot terdeteksi");
        }
    });

    // blur saat pindah tab
    document.addEventListener("visibilitychange", function () {
        if (document.hidden) {
            viewer.classList.add("blur-screen");
        } else {
            viewer.classList.remove("blur-screen");
        }
    });

    // deteksi devtools
    let devtoolsOpen = false;

    setInterval(() => {
        const widthGap = window.outerWidth - window.innerWidth;
        const heightGap = window.outerHeight - window.innerHeight;

        if (widthGap > 180 || heightGap > 180) {
            if (!devtoolsOpen) {
                devtoolsOpen = true;
                document.body.innerHTML = `
                    <div style="
                        height:100vh;
                        display:flex;
                        justify-content:center;
                        align-items:center;
                        font-size:40px;
                        color:red;
                        font-weight:bold;">
                        ⚠️ Akses Diblokir
                    </div>
                `;
            }
        }
    }, 1500);

})();
</script>

</body>
</html>