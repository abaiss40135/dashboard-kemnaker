@php
    $configData = \App\Helpers\AppHelper::applClasses();

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

    $isSatpam = role("satpam");
    $isBhabin = roles(["bhabinkamtibmas", "polisi_rw"]);
    $phoneNumber = $isBhabin
        ? "628118228886"
        : "";
    $phoneIcon = $isBhabin
        ? asset("img/bhabin/icon/phone.svg")
        : asset("img/bhabin/icon/phone-dark.svg");
    $messageIcon = $isBhabin
        ? asset("img/bhabin/icon/sms.svg")
        : asset("img/bhabin/icon/sms-dark.svg");
    $hotline = ($isBhabin || $isSatpam) ? "Hotline (WA)" : "Keluhan/Harapan (WA)";
    $mailIcon =  $isBhabin
        ? asset("img/bhabin/icon/mail.svg")
        : asset("img/bhabin/icon/mail-dark.svg");
@endphp
@push('styles')
    <style>
        .logout p:last-child {
            display: none;
        }

        .active {
            background: #7898CF;
        }

        div > p > a {
            text-decoration: none
        }

        .active p a {
            color: #fff !important;
        }
    </style>
@endpush
<footer class="mt-5 text-light @if($isBhabin) {{ $configData['footerColor'] }}  @endif">
    <div style="background: @if($isBhabin) #091833 @else #191919 @endif; padding: 4px 0;"></div>
    <div style="background: @if($isBhabin) #1E4588 @else #565656 @endif; padding: 20px 0; white-space: normal;"
         class="text-white footer-alamat">
        <div class="new-container d-lg-flex justify-content-between align-items-center mx-auto w-md-80">
            <div class="w-lg-30 section1-footer">
                <h5 class="mb-2 mt-3 title-polri text-md-center">KORBINMAS BAHARKAM POLRI</h5>
                <div class="w-lg-75 text-md-center mt-4">
                    <p class="sub-title-polri">Jalan Trunojoyo No. 3, Kebayoran Baru, Jakarta Selatan, DKI Jakarta. 12110 (021) 7218141</p>
                </div>
            </div>
            <div class="w-lg-40 section2-footer mt-md-4 mt-lg-0">
                <div class="d-flex justify-content-center">
                    <div class="d-flex justify-content-between w-75">
                        <div class="sosmed-footer-icon"
                             onclick="window.open('https:/\/www.facebook.com/korbinmasbaharkampolri', '_blank')">
                            <img src="{{ $fbIcon }}" class="d-block mx-auto" width="40px"
                                 alt="facebook-icon" loading="lazy">
                        </div>
                        <div class="sosmed-footer-icon"
                             onclick="window.open('https:/\/www.youtube.com/channel/UCO_iydvrzXy-oH5iKiNsTiA', '_blank')">
                            <img src="{{ $ytIcon }}" class="d-block mx-auto" width="40px"
                                 alt="youtube-icon" loading="lazy">
                        </div>
                        <div class="sosmed-footer-icon"
                             onclick="window.open('https:/\/twitter.com/KorbinmasPolri', '_blank')">
                            <img src="{{ $twitterIcon }}" class="d-block mx-auto" width="40px"
                                 alt="twitter-icon" loading="lazy">
                        </div>
                        <div class="sosmed-footer-icon"
                             onclick="window.open('https://www.tiktok.com/@korbinmas_baharkam_polri?_t=8esIbrOFvQg&_r=1', '_blank')">
                            <img src="{{ $tiktokIcon }}" class="d-block mx-auto" width="40px"
                                 alt="tiktok-icon" loading="lazy">
                        </div>
                        <div class="sosmed-footer-icon"
                         onclick="window.open('https:/\/www.instagram.com/korbinmas_baharkam_polri/', '_blank')">
                        <img src="{{ $igIcon }}" class="d-block mx-auto" width="40px"
                             alt="instagram-icon" loading="lazy">
                    </div>
                </div>
                </div>
            </div>
            <div class="w-lg-30 section3-footer mt-md-4 d-md-none d-lg-block">
                <div class="d-lg-flex align-items-center gap-lg-4">
                    <p class="contact-us mr-lg-4">Hubungi Kami!</p>

                    <div style="width: 12em;">
                        <div onclick="document.location.href='tel:110'"
                             class="mb-2 border border-primary bg-light rounded-3 contact-us-icon-wrapping">
                            <div style="width: 85%;" class="h-100 d-flex align-items-center px-2">
                                <div class="my-auto ml-2 ">
                                    <img src="{{$phoneIcon}}" class="d-block contact-us-icon" width="30px"
                                         alt="phone-icon" loading="lazy">
                                </div>
                                <div class="contact-us-footer-text">
                                    <p class="text-dark"><b>110</b></p>
                                </div>
                            </div>
                        </div>
                        <div onclick="document.location.href='mailto:bos-binmasonline@polri.go.id'"
                             class="mb-2 border border-primary bg-light rounded-3 contact-us-icon-wrapping">
                            <div style="width: 85%;" class="h-100 d-flex align-items-center px-2">
                                <div class="my-auto ml-2">
                                    <img src="{{$mailIcon}}" class="d-block contact-us-icon" width="30px"
                                         alt="phone-icon" loading="lazy">
                                </div>
                                <div class="contact-us-footer-text">
                                    <p class="text-dark"><b>Email</b></p>
                                </div>
                            </div>
                        </div>
                        <div onclick="document.location.href='http:/\/api.whatsapp.com/send?phone={{$phoneNumber}}'"
                             class="mb-2 border border-primary bg-light rounded-3 contact-us-icon-wrapping">
                            <div style="width: 85%;" class="h-100 d-flex align-items-center px-2">
                                <div class="my-auto ml-2">
                                    <img src="{{$messageIcon}}" class="d-block contact-us-icon" width="30px"
                                         alt="phone-icon" loading="lazy">
                                </div>
                                <div class="contact-us-footer-text">
                                    <p class="text-dark"><b>{{$hotline}}@if(empty($phoneNumber)) Tidak Aktif @endif</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="signature mt-md-5 mt-lg-2">
            <p class="text-center" style="color: #A7BEE5; margin-bottom: 0; font-size: 10px;">
                Copyright © 2021 Kepolisian Negara Republik Indonesia
            </p>
        </div>
    </div>

    <div style="background: @if($isBhabin) #091833 @else #191919 @endif; padding: 4px 0;"></div>
</footer>
@push('scripts')
    <script>

    </script>
@endpush
