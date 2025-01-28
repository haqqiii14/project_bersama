@extends('layouts.user')

@section('title', 'Baca Berita')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">{{ $koran->title }}</h2>
    <p class="text-center text-muted">Edition: {{ $koran->edisi }}</p>
    <p class="text-center text-muted">File: {{ $koran->file }}</p>

    <!-- Popup untuk langganan habis -->
    @if (!$isSubscribed)
        <div id="subscription-popup" class="position-fixed top-0 left-0 w-100 h-100 bg-dark bg-opacity-75 d-flex align-items-center justify-content-center"
            style="z-index: 9999; display: none;">
            <div class="bg-white p-4 rounded shadow text-center">
                <h3 class="text-danger">Langganan Anda Telah Habis</h3>
                <p>Anda akan diarahkan kembali dalam <span id="countdown">5</span> detik...</p>
                <a href="{{ route('detailKoran', ['productId' => $product->id, 'koranId' => $koran->id]) }}" class="btn btn-primary mt-3">Kembali Sekarang</a>
            </div>
        </div>
    @endif

    <div id="pdf-container" class="mt-4">
        <canvas id="pdf-render" style="border: 1px solid #ccc; display: block; margin: 0 auto;"></canvas>
    </div>

    <div class="text-center mt-4">
        <button id="prev" class="btn btn-secondary">Previous</button>
        <select id="page-select"></select>
        <button id="next" class="btn btn-secondary">Next</button>
        <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
    const url = '{{ asset('storage/' . $koran->file) }}';

    let pdfDoc = null,
        pageNum = 1,
        pageIsRendering = false,
        pageNumIsPending = null;

    const scale = 1.5, // Zoom level
        canvas = document.querySelector('#pdf-render'),
        ctx = canvas.getContext('2d');

    // Render halaman PDF
    const renderPage = (num) => {
        pageIsRendering = true;

        // Dapatkan halaman
        pdfDoc.getPage(num).then((page) => {
            const viewport = page.getViewport({ scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderCtx = {
                canvasContext: ctx,
                viewport,
            };

            page.render(renderCtx).promise.then(() => {
                pageIsRendering = false;

                if (pageNumIsPending !== null) {
                    renderPage(pageNumIsPending);
                    pageNumIsPending = null;
                }
            });

            // Update page count
            document.querySelector('#page-num').textContent = num;
        });
    };

    // Cek halaman berikutnya
    const queueRenderPage = (num) => {
        if (pageIsRendering) {
            pageNumIsPending = num;
        } else {
            renderPage(num);
        }
    };

    // Tampilkan halaman sebelumnya
    const showPrevPage = () => {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
    };

    // Tampilkan halaman berikutnya
    const showNextPage = () => {
        if (pageNum >= pdfDoc.numPages) {
            return;
        }
        pageNum++;
        queueRenderPage(pageNum);
    };

    // Dapatkan dokumen PDF
    pdfjsLib.getDocument(url).promise.then((pdfDoc_) => {
        pdfDoc = pdfDoc_;

        document.querySelector('#page-count').textContent = pdfDoc.numPages;

        renderPage(pageNum);
    });

    // Tombol navigasi
    document.querySelector('#prev').addEventListener('click', showPrevPage);
    document.querySelector('#next').addEventListener('click', showNextPage);

    @if (!$isSubscribed)
        // Tampilkan popup jika langganan habis
        const popup = document.getElementById('subscription-popup');
        const countdownElement = document.getElementById('countdown');
        let countdown = 5;

        popup.style.display = 'flex'; // Tampilkan popup

        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = "{{ route('detailKoran', ['productId' => $product->id, 'koranId' => $koran->id]) }}";
            }
        }, 1000);
    @endif
</script>
@endsection
