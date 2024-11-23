<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
@if($errors->any())
    <script>
        let values = '<span>';
        @foreach ($errors->all() as $error)
            values += "<p>{{$error}}</p>";
        @endforeach

        Swal.fire({
            icon: 'error',
            title: 'Ada kesalahan',
            text: 'Validation Error',
            html: values+'</span>'
        });
    </script>
@endif
@if (session()->has('swal_msg'))
    <script>
    let notification = @json(session()->pull("swal_msg"));
    Swal.fire(notification.title, notification.message, notification.type);
    <!--To prevent showing the notification when on browser back-->
    @php
        session()->forget('swal_msg');
    @endphp
    </script>
@endif

@if(session()->has('swal_lokasi_penugasan'))
    <script>
        let notification = @json(session()->pull("swal_lokasi_penugasan"));
        Swal.fire({
            title: notification.title,
            text: notification.message,
            icon: notification.type,
        }).then((result) => {
            location.href = notification.alert === 'notfound' ?  route('lokasi-penugasan.create', {text: 'name'}) : '/profile';
        });
    </script>
@endif

@if(session()->has('swal_alert_harian_laporan_bhabin'))
    <script>
        let notification = @json(session()->pull("swal_alert_harian_laporan_bhabin"));
        Swal.fire({
            title: notification.title,
            html: notification.message,
            icon: notification.type,
        });
    </script>
@endif
