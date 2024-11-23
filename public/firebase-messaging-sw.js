// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");
const env = require('./js/dotenv-setup.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    databaseURL: "db-url",
    apiKey: "AIzaSyAi5qVXA856ZveHiBwjHWfLuq8R_AGQJx0",
    authDomain: "bos-v2-4412a.firebaseapp.com",
    projectId: "bos-v2-4412a",
    storageBucket: "bos-v2-4412a.appspot.com",
    messagingSenderId: "382318820998",
    appId: "1:382318820998:web:82ade43e1c0e57ab795b07",
    measurementId: "G-CZ2QBSS89X",
});

// Retrieve an instance of Firebase Messaging so that it can handle background messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    // const title = "Hello world is awesome";
    // const options = {
    //     body: "Your notificaiton message .",
    //     icon: "/firebase-logo.png",
    // };
    // return self.registration.showNotification(
    //     title,
    //     options,
    // );
});

self.addEventListener("push", function (event) {
    var data = event.data.json().data;

    const title = data.title;
    const options = {
        body: data.body,
        icon: data.icon,
        image: data.image,
        data: data.action,
        requireInteraction: true,
    };
    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener("notificationclick", function (event) {
    event.notification.close();
    event.waitUntil(clients.openWindow(event.notification.data));
});

self.addEventListener("notificationclose", function (event) {
    // action ketika notifikasi di close
});
