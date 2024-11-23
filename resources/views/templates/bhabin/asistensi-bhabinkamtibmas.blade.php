@php
    $isSatpam = role("satpam");
    $isBhabin = role("bhabinkamtibmas");
    $phoneNumber = $isBhabin
        ? "+628118228886"
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

<div class="row my-2 box-information mx-1 mx-sm-0 mt-2 mt-md-3">
    <div style="cursor: pointer" class="col-xs-12 col-sm-4"
         onclick="document.location.href='tel:110'">
        <img src="{{$phoneIcon}}" class="d-block mx-auto" width="40px"
             alt="phone-icon" loading="lazy">
        <div class="text-left text-md-center" style="line-height: normal !important">
            <p class="mt-3 mb-0"><b>Call Center</b></p>
            <small>110</small>
        </div>
    </div>

    <div style="cursor: pointer" class="col-xs-12 col-sm-4"
         onclick="document.location.href='http:/\/api.whatsapp.com/send?phone={{$phoneNumber}}'">
        <img src="{{$messageIcon}}" class="d-block mx-auto" width="40px"
             alt="whatsapp-icon" loading="lazy">
        <div class="text-left text-md-center" style="line-height: normal !important">
            <p class="mt-3 mb-0"><b>{{ $hotline }}@if(empty($phoneNumber)) Tidak Aktif @endif</b></p>
            <small>{{ $phoneNumber }}</small>
        </div>
    </div>

    <div style="cursor: pointer" class="col-xs-12 col-sm-4"
         onclick="document.location.href='mailto:bos-binmasonline@polri.go.id'">
        <img src="{{ $mailIcon }}" class="d-block mx-auto" width="40px"
             alt="mail-icon" loading="lazy">
        <div class="text-left text-md-center" style="line-height: normal !important">
            <p class="mt-3 mb-0"><b>Email</b></p>
            <small>bos-binmasonline@polri.go.id</small>
        </div>
    </div>
</div>
