@push('styles')
@include('assets.css.select2')
@endpush
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav">

    </ul>
    <ul class="navbar-nav">

    </ul>

    <ul class="navbar-nav ml-auto">
        <span>
            <div>
                <button class="btn" onclick="backToLogin()">Logout</button>
            </div>
        </span>
    </ul>
</nav>
@push('scripts')
@include('assets.js.select2')
<script>
function backToLogin()
{
    window.location.href = '/login';
}

buildSelect2Search({
    placeholder: '-- Pilih Pengguna (NRP/Email) --',
    url: route('user.select2'),
    minimumInputLength: 3,
    selector: [{ id: $('#select-pengguna') }],
    query: function (params) {
        return {
            identity: params.term
        }
    }
});

$('#select-pengguna').on('select2:select', function (e) {
    let id = e.params.data.id;
    let url = "{{ route('impersonate', ':id') }}";
    let hrefElement = document.querySelector("#div-impersonate a");
    hrefElement.href = url.replace(':id', id);
    hrefElement.querySelector('button.btn-success').disabled = false;
});
</script>
@endpush
