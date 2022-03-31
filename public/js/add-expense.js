
Date.prototype.toDateInputValue = (function () {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0, 10);
});

document.getElementById('date').value = new Date().toDateInputValue();


function myFunction(e) {
    var date = document.querySelector("#date").value;
    var varDate = new Date(date);
    var today = new Date();


    if (varDate > today) {
        alert("Data wydatku nie może być późniejsza od dzisiejszej daty!");
        document.getElementById("date").valueAsDate = null;
    }

}


$(document).ready(function () {

    var v = $("#msform").validate({
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


