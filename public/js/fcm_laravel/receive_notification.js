messaging.onMessage(function (payload) {
    const title = payload.notification.title;
    const options = {
        body: payload.notification.body,
        icon: payload.data.icon,
        image: payload.notification.image,
    };
    new Notification(title, options);
});
