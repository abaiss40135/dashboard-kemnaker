const messaging = firebase.messaging();

if (
    Notification.permission === "denied" ||
    Notification.permission === "default"
) {
    // alert('Anda belum memberi izin notifikasi', 'Aktifkan notifikasi untuk mendapatkan informasi terbaru dari kami.')

    Notification.requestPermission().then(function (permission) {
        // Callback dipanggil ketika pengguna memberikan izin atau menolak izin
        if (permission === "denied") {
            // Izin notifikasi ditolak
            // alert('Anda tidak dapat mendapatkan informasi terbaru secara up to date dari kami!', 'Anda menolak memberikan izin Notifikasi!',)
        } else if (permission === "default") {
            // Izin notifikasi belum ditentukan (default)
            // Swal.fire(
            //     'Anda belum memberikan izin Notifikasi!',
            //     'Anda tidak dapat mendapatkan informasi terbaru secara up to date dari kami!',
            //     'info'
            // )
        }
    });
} else {
    messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken();
        })
        .then(function (token) {
            const openAppByBrowser =
                !/Android|webOS|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                    navigator.userAgent
                );

            // if (openAppByBrowser) return;

            fetch("/update-fcm-token", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({
                    fcm_token: token,
                }),
            }).then(function (response) {
                // console.log('send fcm key to server')
            }).catch(function (error) {
                console.log(error);
            });
        });
}

messaging.onTokenRefresh(() => {
    messaging
        .getToken()
        .then((refreshedToken) => {
            const openAppByBrowser =
                !/Android|webOS|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                    navigator.userAgent
                );

            // if (openAppByBrowser) return;

            fetch("/update-fcm-token", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({
                    fcm_token: refreshedToken,
                }),
            }).then(function (response) {
                console.log(response);
                // console.log('send fcm key to server')
            });
        })
        .catch((error) => {
            console.log("Error refreshing token:", error);
        });
});
