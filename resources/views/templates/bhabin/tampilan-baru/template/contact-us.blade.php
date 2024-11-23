@php
    $isSatpam = role("satpam");
    $isBhabin = role("bhabinkamtibmas");
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

<div style="margin-top: 100px;" id="contact-us" class="d-flex justify-content-center align-items-center mb-3">
    <div class="d-flex justify-content-center align-items-center w-25 {{ $isBhabin ? 'bg-primary' : 'bg-black' }} py-3 rounded-3">
        <span class="text-center text-light" style="font-size: 1.2em;">Hubungi Kami!</span>
    </div>
</div>

<div class="new-container mb-5">
    <div class="row justify-content-between align-items-center">
        <div style="width: 30%;" class="card border border-primary col-sm-12 col-md-3">
            <div class="card-body">
                <div style="cursor: pointer"
                     onclick="document.location.href='tel:110'">
                    <img src="{{$phoneIcon}}" class="d-block mx-auto" width="40px"
                         alt="phone-icon" loading="lazy">
                    <div class="text-left text-md-center" style="line-height: normal !important">
                        <p class="mt-3 mb-0"><b>110</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div style="width: 30%;" class="card border border-primary col-sm-12 col-md-3">
            <div class="card-body">
                <div style="cursor: pointer"
                     onclick="document.location.href='mailto:bos-binmasonline@polri.go.id'">
                    <img src="{{ $mailIcon }}" class="d-block mx-auto" width="40px"
                         alt="mail-icon" loading="lazy">
                    <div class="text-left text-md-center" style="line-height: normal !important">
                        <p class="mt-3 mb-0"><b>Email</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div style="width: 30%;" class="card border border-primary col-sm-12 col-md-3">
            <div class="card-body">
                <div style="cursor: pointer"
                     onclick="document.location.href='http:/\/api.whatsapp.com/send?phone={{$phoneNumber}}'">
                    <img src="{{$messageIcon}}" class="d-block mx-auto" width="40px"
                         alt="whatsapp-icon" loading="lazy">
                    <div class="text-left text-md-center" style="line-height: normal !important">
                        <p class="mt-3 mb-0"><b>{{ $hotline }}@if(empty($phoneNumber)) Tidak Aktif @endif</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
