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
        alert("The income date cannot be later than today's date!");
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
            amount: 'Enter the income amount in the correct form.',
            date: 'Specify the date of the income.',
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

});







