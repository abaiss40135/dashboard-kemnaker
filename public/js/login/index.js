const password = document.querySelector("#password");
const eyeOpen = document.querySelector(".fa-eye");
const eyeClose = document.querySelector(".fa-eye-slash");

const show_password = () => {
    password.type = "text";
    eyeOpen.style.display = "none";
    eyeClose.style.display = "block";
};
const hide_password = () => {
    password.type = "password";
    eyeOpen.style.display = "block";
    eyeClose.style.display = "none";
};
