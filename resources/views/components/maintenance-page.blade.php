@push('styles')
    <style>
        .maintenance-page { text-align: center; padding: 15%; }
        .maintenance-page h1 { font-size: 50px; }
        .maintenance-page { font: 20px Helvetica, sans-serif; color: #333; }
        .maintenance-page article { display: block; text-align: left; width: 70%; margin: 10vh auto 0; }
        .maintenance-page a { color: #dc8100; text-decoration: none; }
        .maintenance-page a:hover { color: #333; text-decoration: none; }
        .maintenance-page ~ * { display: none !important; }
        @media screen and (max-width: 600px) {
            .maintenance-page { padding: 1em; }
            .maintenance-page > article { width: 100%; }
        }
    </style>
@endpush
<div class="maintenance-page">
    <article>
        <h1>Fitur dalam tahap pengembangan</h1>
        <div>
            <p>Mohon maaf atas ketidaknyamanan ini, fitur ini masih belum sepenuhnya jadi atau sedang dalam tahap pengembangan. </p>
            <p>&mdash; Tim {{ config('app.long_name') }}</p>
        </div>
        <div class="d-flex justify-content-center mt-5">
            <button class="btn btn-danger" onclick="window.history.go(-1)">
                <i class="fa fa-arrow-left"></i> Kembali</button>
        </div>
    </article>
</div>
