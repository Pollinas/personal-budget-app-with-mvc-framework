Date.prototype.toDateInputValue = (function () {
    let local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0, 10);
});

document.getElementById('date').value = new Date().toDateInputValue();

function myFunction(e) {
    let date = document.querySelector("#date").value;
    let letDate = new Date(date);
    let today = new Date();


    if (letDate > today) {
        alert("Data przychodu nie może być późniejsza od dzisiejszej daty!");
        document.getElementById("date").valueAsDate = null;
    }

}



$(document).ready(function () {

    let v = $("#msform").validate({

        rules: {
            date: 'required',
            category: 'required',
            amount: 'required'
        },
        messages: {
            amount: 'Podaj kwotę przychodu w poprawnej formie.',
            date: ' Podaj datę przychodu.',
            category: 'Wybierz kategorię.'
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







