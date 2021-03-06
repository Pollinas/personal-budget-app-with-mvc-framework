Date.prototype.toDateInputValue = (function () {
    let local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0, 10);
});

document.getElementById('date').value = new Date().toDateInputValue();

// Zmiana kategorii 
function checkCategory(e) {
    checkLimit();
};


//Zmiana daty 
function checkDate(e) {

    let date = document.querySelector("#date").value;
    let letDate = new Date(date);
    let today = new Date();

    if (letDate > today) {
        alert("The date of the expense must not be later than today's date!");
        document.getElementById("date").valueAsDate = null;
    }

    checkLimit();
}

// zmiana kwoty
function checkAmount(e) {
    let expenses = $('#monthlyExpenses').html()
    let amount = $('#amount').val()
    let sum = calculateSum(expenses, amount)
    let sumOk = (Math.round(sum * 100) / 100).toFixed(2);
    $('#calculated').html(sumOk);
    changeColor();
}

async function checkLimit() {
    let category = $('#category').val()

    if (category !== '') {
        let limit = await getLimitForCategory(category);

        if (limit !== null) {

            let date = $('#date').val()

            if (date !== null) {
                let expenses = await getSumOfExpensesForSelectedMonth(category, date);
                let difference = calculateDifference(limit, expenses)

                if ($('#amount').val() !== '') {
                    let amount = $('#amount').val()
                    let sum = calculateSum(expenses, amount);
                    renderOnDOM(limit, expenses, difference, sum);
                } else {
                    renderOnDOM(limit, expenses, difference, expenses);
                }

            } else {

                $('#limitContainer').hide();
            }
        }
        else {

            $('#limitContainer').hide();
        }
    }
    else {

        $('#limitContainer').hide();
    }

}


/**
 * 
 *check how much has been spent for the given category in the given month 
* @return value 
 */
async function getSumOfExpensesForSelectedMonth(category, date) {
    try {
        const response = await fetch(`/api/expenses/${category}/${date}`);
        const expenses = await response.json();
        return expenses;
    } catch (error) {
        console.error(error);
    }
};

/**
 * 
 * check if there is a limit for a category
 * 
 * @return value if there is, null if there isn't
 */
async function getLimitForCategory(category) {

    try {
        const response = await fetch(`/api/limit/${category}`);
        const limit = await response.json();
        return limit;
    } catch (error) {
        console.error(error);
    }
};

const calculateDifference = (limit, expenses) => {
    return (limit - expenses);
};

const calculateSum = (expenses, amount) => {
    sum = (parseFloat(expenses) + parseFloat(amount));
    return sum;
}


const renderOnDOM = (limit, expenses, difference, sum) => {

    let sumOk = (Math.round(sum * 100) / 100).toFixed(2);
    $('#monthlyLimit').html(limit);
    $('#monthlyExpenses').html(expenses);
    $('#difference').html(difference);

    $('#calculated').html(sumOk);


    changeColor();
    $('#limitContainer').show();
};


changeColor = () => {

    let limit = parseFloat($('#monthlyLimit').html());

    if ((parseFloat($('#monthlyExpenses').html()) > limit) || (parseFloat($('#calculated').html()) > limit)) {

        if ($('#limitContainer').hasClass("alert-success")) {
            $('#limitContainer').removeClass("alert-success")
        }
        if (!$('#limitContainer').hasClass("alert-danger")) {
            $('#limitContainer').addClass('alert-danger')
        }
    }

    else {

        if ($('#limitContainer').hasClass("alert-danger")) {
            $('#limitContainer').removeClass("alert-danger")
        }
        if (!$('#limitContainer').hasClass("alert-success")) {
            $('#limitContainer').addClass('alert-success')
        }
    }
}






