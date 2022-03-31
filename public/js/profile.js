
document.getElementById('toggleProfileInput').addEventListener('click', function () {
    [].map.call(document.querySelectorAll('.profile'), function (el) {
        el.classList.toggle('profile--open');
    });
});

document.getElementById('togglePasswordInput').addEventListener('click', function () {
    [].map.call(document.querySelectorAll('.passwordInput'), function (el) {
        el.classList.toggle('passwordInput--open');
    });
});



$(document).ready(function () {

    var userId = document.querySelector('#userId').innerHTML;

    /**
     * Validate the form
     */
    $('#formProfile').validate({
        rules: {
            name: 'required',
            email: {
                required: true,
                email: true,
                remote: {
                    url: '/account/validate-email',
                    data: {
                        ignore_id: function () {
                            return userId;
                        }
                    }
                }
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

    //var userId = document.querySelector('#userId').innerHTML;

    /**
     * Validate the form
     */
    $('#formPasswordReset').validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                validPassword: true
            }
        }

    });
});

