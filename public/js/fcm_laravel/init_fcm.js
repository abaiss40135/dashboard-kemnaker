navigator.serviceWorker
    .register("/firebase-messaging-sw.js")
    .then((registration) => {
        console.log('service worker registered')
        // Service Worker berhasil didaftarkan
    })
    .catch((error) => {
        // Gagal mendaftarkan Service Worker
        console.error("firebase service worker - gagal didaftarkan", error);
        // alert("firebase service worker - gagal didaftarkan");
    });

const firebaseConfig = {
    apiKey: "AIzaSyAi5qVXA856ZveHiBwjHWfLuq8R_AGQJx0",
    authDomain: "bos-v2-4412a.firebaseapp.com",
    projectId: "bos-v2-4412a",
    storageBucket: "bos-v2-4412a.appspot.com",
    messagingSenderId: "382318820998",
    appId: "1:382318820998:web:82ade43e1c0e57ab795b07",
    measurementId: "G-CZ2QBSS89X",
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
