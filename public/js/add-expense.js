$(document).ready(function () {

    let v = $("#msform").validate({
        ignore: '#amount',
        rules: {
            date: 'required',
            method: 'required',
            category: 'required'
        },
        messages: {
            date: ' Podaj datę wydatku.',
            method: 'Wybierz jedną z metod płatności.',
            category: 'Wybierz kategorię.'
        },
        errorElement: "span",
        errorClass: "help-inline",
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


