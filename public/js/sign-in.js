
const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");

togglePassword.addEventListener("click", function () {
    // toggle the type attribute
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    // toggle the icon
    this.classList.toggle("bi-eye");
});

$(window).load(function () { // makes sure the whole site is loaded
    $("#status").delay(500).fadeOut("slow"); // will first fade out the loading animation
    $("#preloader").delay(1000).fadeOut("slow"); // will fade out the white DIV that covers the website.
})
