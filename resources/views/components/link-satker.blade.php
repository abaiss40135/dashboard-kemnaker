<div class="row">
    @foreach ($link as $item)
        <div class="d-flex justify-content-stretch p-2 col-lg-3 col-md-4
                    {{ (($loop->iteration + 2) % 3 === 0) ? 'col-sm-12' : 'col-sm-6' }}">
            <a href="{{$item->link_satker}}" class="header-title btn w-100 btn-primary p-3"
            @if ($item->nama_satker === 'Pencarian Anti Hoax') style="background-color: #bf3f3f !important" @endif>
                <span class="d-flex align-items-center justify-content-center h-100">{{$item->nama_satker}}</span>
            </a>
        </div>
    @endforeach
</div>
