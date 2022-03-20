const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");


togglePassword.addEventListener("click", function () {

    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);

    this.classList.toggle("bi-eye");
});


$.validator.addMethod('validPassword',
    function (value, element, param) {
        if (value != '') {
            if (value.match(/.*[a-z]+.*/i) == null) {
                return false;
            }
            if (value.match(/.*\d+.*/) == null) {
                return false;
            }
        }

        return true;
    },
    'Hasło musi zawierać przynajmniej 1 literę i 1 cyfrę.'
);


$(document).ready(function () {

    /**
     * Validate the form
     */
    $('#formSignup').validate({
        rules: {
            name: 'required',
            email: {
                required: true,
                email: true,
                remote: '/account/validate-email'
            },
            password: {
                required: true,
                minlength: 6,
                validPassword: true
            }
        },
        messages: {
            email: {
                email: 'Podaj poprawny adres e-mail',
                remote: 'Podany adres e-mail istnieje już w bazie danych.'
            }
        }
    });
});

