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
    'The password must contain at least 1 letter and 1 number.'
);


$(document).ready(function () {

    /**
     * Validate the form
     */
    $('#formPassword').validate({

        password: {
            required: true,
            minlength: 6,
            validPassword: true
        }
    });
});

