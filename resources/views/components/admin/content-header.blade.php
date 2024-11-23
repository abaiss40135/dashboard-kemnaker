<section class="content-header">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <h1 class="mb-0 p-2 h3">{{ $title }}</h1>
        <ol class="breadcrumb float-sm-right d-none d-md-flex align-items-center mb-0 p-2"
            style="background: none">
            <li class="breadcrumb-item-none">
                <i class="fas fa-home mr-2"></i>
            </li>
            @php $link = '' @endphp
            @for($i = 1; $i <= count(Request::segments()); $i++)
                @if(!is_numeric(Request::segment($i)))
                    <li class="breadcrumb-item {{ ($i < count(Request::segments())) ? 'active' : '' }}">
                        @if($i == 1)
                            @php $link .= "/" . Request::segment($i) @endphp
                            <a href="{{ route(auth()->user()->role()) }}">
                                {{ auth()->user()->roleName() }}
                            </a>
                        @elseif(($i < count(Request::segments())))
                            <a href="{{ $link .= "/" . Request::segment($i) }}">
                                {{ ucwords(str_replace('-',' ', Request::segment($i))) }}
                            </a>
                        @else
                            {{ ucwords(str_replace('-',' ', Request::segment($i))) }}
                        @endif
                    </li>
                @endif
            @endfor
        </ol>
    </div>
</section>
