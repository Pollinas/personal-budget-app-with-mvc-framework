$(document).ready(function () {

    let userId = document.querySelector('#userId').innerHTML;

    /**
     * Validate the form
     */
    $('.formProfile').validate({
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
            name: 'Podaj imię.',
            email: {
                email: 'Podaj poprawny adres e-mail',
                remote: 'Podany adres e-mail istnieje już w bazie danych.'
            }
        },
        errorElement: "span",
        errorClass: "help-block",
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
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

    //let userId = document.querySelector('#userId').innerHTML;

    /**
     * Validate the form
     */
    $('.formPasswordReset').validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                validPassword: true
            }
        },
        messages: {
            password: {
                required: 'To pole nie może być puste.',
                minlength: 'Hasło jest zbyt krótkie.'
            }
        },
        errorElement: "span",
        errorClass: "help-block",
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }

    });
});

