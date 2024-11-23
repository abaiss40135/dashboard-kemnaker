<form id="form-search" action="{{ $route }}" method="POST" onkeydown="return event.key !== 'Enter';">
    @csrf
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <div class="justify-content-start">
            @if(! request()->is('*/si-polsus/*'))
                @can('sislap_approval_create')
                <button type="button" class="btn btn-primary" id="btn-ajukan-approval"
                >@if(role('operator_bagopsnalev_mabes')) Approve Laporan @else Ajukan Approval @endif @if (role('operator_bagopsnalev_polres')) ke Polda @endif
                                 @if (role('operator_bagopsnalev_polda')) ke Mabes Polri @endif</button>
                @endcan
                @can('sislap_approval_edit')
                    <button type="button" class="btn btn-success" id="btn-approve-approval">Approve</button>
                @endcan
            @endif
        </div>
        <div class="justify-content-end{{ isset($className) ? ' '.$className : ''}}">
            <div class="input-group">
                <input type="search" name="search" placeholder="cari" class="form-control" aria-label="search_field">
                <div class="input-group-append">
                    <button id="btn-search" type="button" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-file"></i> Export</button>
                </div>
            </div>
        </div>
    </div>
</form>
