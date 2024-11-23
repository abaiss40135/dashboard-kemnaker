@php
    $isBhabin = role('bhabinkamtibmas');
    $twitterIcon = $isBhabin
        ? asset('img/bhabin/icon/twitter.svg')
        : asset('img/bhabin/icon/twitter-dark.svg');
    $ytIcon = $isBhabin
        ? asset('img/bhabin/icon/youtube.svg')
        : asset('img/bhabin/icon/youtube-dark.svg');
    $fbIcon = $isBhabin
        ? asset('img/bhabin/icon/facebook.svg')
        : asset('img/bhabin/icon/facebook-dark.svg');
    $tiktokIcon = $isBhabin
        ? asset('img/bhabin/icon/tiktok.svg')
        : asset('img/bhabin/icon/tiktok-dark.svg');
    $igIcon = $isBhabin
        ? asset('img/bhabin/icon/instagram.svg')
        : asset('img/bhabin/icon/instagram-dark.svg');
@endphp

<div class="row my-1 box-information mx-1 mx-sm-0 mt-2 mt-md-3">
    <div style="cursor: pointer" class="col-xs-12 col-sm-6"
         onclick="window.open('https:/\/www.facebook.com/korbinmasbaharkampolri', '_blank')">
        <img src="{{ $fbIcon }}" class="d-block mx-auto" width="40px"
             alt="facebook-icon" loading="lazy">
        <div class="text-left text-md-center" style="line-height: normal !important">
            <p class="mt-2 mb-0"><b>Facebook</b></p>
            <small>Korbinmas Baharkam Polri</small>
        </div>
    </div>

    <div style="cursor: pointer" class="col-xs-12 col-sm-6"
         onclick="window.open('https:/\/www.youtube.com/channel/UCO_iydvrzXy-oH5iKiNsTiA', '_blank')">
        <img src="{{ $ytIcon }}" class="d-block mx-auto" width="40px"
             alt="youtube-icon" loading="lazy">
        <div class="text-left text-md-center" style="line-height: normal !important">
            <p class="mt-2 mb-0"><b>Youtube</b></p>
            <small>Korbinmas Baharkam Polri</small>
        </div>
    </div>

    <div style="cursor: pointer" class="col-xs-12 col-sm-4"
         onclick="window.open('https:/\/twitter.com/KorbinmasPolri', '_blank')">
        <img src="{{ $twitterIcon }}" class="d-block mx-auto" width="40px"
             alt="twitter-icon" loading="lazy">
        <div class="text-left text-md-center" style="line-height: normal !important">
            <p class="mt-2 mb-0"><b>Twitter</b></p>
            <small>@KorbinmasPolri</small>
        </div>
    </div>

    <div style="cursor: pointer" class="col-xs-12 col-sm-4"
         onclick="window.open('https://www.tiktok.com/@korbinmas_baharkam_polri?_t=8esIbrOFvQg&_r=1', '_blank')">
        <img src="{{ $tiktokIcon }}" class="d-block mx-auto" width="40px"
             alt="tiktok-icon" loading="lazy">
        <div class="text-left text-md-center" style="line-height: normal !important">
            <p class="mt-2 mb-0"><b>TikTok</b></p>
            <small>@KorbinmasPolri</small>
        </div>
    </div>

    <div style="cursor: pointer" class="col-xs-12 col-sm-4"
         onclick="window.open('https:/\/www.instagram.com/korbinmas_baharkam_polri/', '_blank')">
        <img src="{{ $igIcon }}" class="d-block mx-auto" width="40px"
                alt="instagram-icon" loading="lazy">
        <div class="text-left text-md-center" style="line-height: normal !important">
            <p class="mt-2 mb-0"><b>Instagram</b></p>
            <small>@korbinmas_baharkam_polri</small>
        </div>
    </div>
</div>
