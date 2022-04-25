$(document).ready(function () {

    let v = $("#msform").validate({
        rules: {
            amount: 'required',
            date: 'required',
            method: 'required',
            category: 'required'
        },
        messages: {
            amount: 'Enter the amount of the expense in the correct form.',
            date: 'Set the date of the expense.',
            method: 'Choose one of the payment methods.',
            category: 'Select a category.'
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


