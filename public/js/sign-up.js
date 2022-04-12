
$(document).ready(function () {

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


    let v = $("#msform").validate({
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
            name: 'Podaj imię.',
            email: {
                required: 'Podaj adres e-mail.',
                email: 'Podaj poprawny adres e-mail',
                remote: 'Podany adres e-mail istnieje już w bazie danych.'
            },
            password: {
                required: 'Podaj hasło.',
                minlegth: 'Podane hasło jest za krótkie.'
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



    $(".open1").click(function () {
        if (v.form()) {

            $("#sf2").show("slow");
        }

    });

    // Binding next button on second step
    $(".open2").click(function () {
        if (v.form()) {
            $("#sf3").show("slow");
        }
    });


    // Binding back button on second step
    $(".back2").click(function () {
        $("#sf1").show("slow");
    });

    // Binding back button on third step
    $(".back3").click(function () {
        $("#sf2").show("slow");
    });


});



