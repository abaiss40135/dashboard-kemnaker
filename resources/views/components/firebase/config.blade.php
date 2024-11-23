<script>
    navigator.serviceWorker
        .register("/firebase-messaging-sw.js")
        .then((registration) => {
            // Service Worker berhasil didaftarkan
        })
        .catch((error) => {
            // Gagal mendaftarkan Service Worker
            console.error("firebase service worker - gagal didaftarkan", error);
            // alert("firebase service worker - gagal didaftarkan");
        });

    const firebaseConfig = {{ Illuminate\Support\Js::from($firebaseConfig) }};
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
</script>
