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
            name: 'Enter a name.',
            email: {
                email: 'Enter a valid e-mail address.',
                remote: 'The email address you entered already exists in the database.'
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
    'Password must contain at least 1 letter and 1 number.'
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
                required: 'This field cannot be empty.',
                minlength: 'The password is too short.'
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

