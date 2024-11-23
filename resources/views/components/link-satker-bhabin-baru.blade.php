@php
    $pencariaunAntiHoax = $link->filter(function ($value, $key) {
        return $value->nama_satker == 'Pencarian Anti Hoax';
    })->first();
@endphp

<div class="d-flex justify-content-center mt-3 mb-3">
    <a href="{{$pencariaunAntiHoax->link_satker}}">
        <div style="width: 40vw;" class="rounded bg-danger py-2">
            <h6 style="font-size: 1.2em;" class="text-center text-white mb-0">
                {{$pencariaunAntiHoax->nama_satker}}
            </h6>
        </div>
    </a>
</div>

<div class="row container" style="background-color: @if(role('satpam')) #8A8A8A @else #BADAFF @endif;">
    @foreach ($link as $item)
        @if ($item->nama_satker !== 'Pencarian Anti Hoax')
            <div class="d-flex justify-content-stretch p-2 col-lg-3 col-md-4 my-3
                        {{ (($loop->iteration + 2) % 3 === 0) ? 'col-sm-12' : 'col-sm-6' }}">
                <a href="{{$item->link_satker}}" class="header-title btn w-100 p-3 @if(role('satpam')) btn-secondary @else btn-primary @endif">
                    <span class="d-flex align-items-center justify-content-center h-100">{{$item->nama_satker}}</span>
                </a>
            </div>
        @endif
    @endforeach
</div>
