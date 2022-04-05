
function myFunction(e) {
    let option_value = document.getElementById("time").value;
    let none = document.querySelector(".none")
    if (option_value == "custom") {
        let myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {});
        myModal.show();
    }
}

//universal function for checking the date in forms
function checkDate(date, id) {
    let today = new Date();

    if (date > today) {
        alert("Data nie może być późniejsza od dzisiejszej daty!");
        document.getElementById(id).valueAsDate = null;
    }
}

function checkEndDate(e) {
    let end = document.querySelector("#end").value;
    let begin = document.querySelector("#begin").value;

    let endDate = new Date(end);
    let beginDate = new Date(begin);

    checkDate(endDate, "end");

    if (beginDate > endDate) {
        alert("Data końcowa bilansu nie może być wcześniejsza od jego daty początkowej!");
        document.getElementById("end").valueAsDate = null;
    }
}




function checkBeginDate(e) {

    let begin = document.querySelector("#begin").value;
    let beginDate = new Date(begin);
    checkDate(beginDate, "begin");

}


function checkIncomeDate(e) {

    let incomeDate = document.querySelector("#incomeDateEditModal").value;
    let date = new Date(incomeDate);
    checkDate(date, "incomeDateEditModal");

}

function checkExpenseDate(e) {

    let expenseDate = document.querySelector("#expenseDateEditModal").value;
    let date = new Date(expenseDate);
    checkDate(date, "expenseDateEditModal");

}
// piechart 


function drawChart(labels, data, id) {
    const colors = ['#D295BF', '#A9CEF4', '#001D4A', '#23CE6B', '#F34213', '#7E52A0', '#F8F1FF', '#716A5C', '#5DB7DE', '#A0CA92', '#9B2226', '#542344', '#FF6B6B', '#CA6702', '#0A9396', '#005F73', '#F6F930', '#E9D8A6', '#F72585', '#F4C3C2', '#94D2BD', '#EE9B00', '#36453B', '#A37C40', '#6A3937'];

    const Data = {
        labels: labels,
        datasets: [{
            label: 'chart',
            data: data.split(","),
            backgroundColor: colors,
            hoverOffset: 4
        }]
    };

    const Config = {
        type: 'pie',
        data: Data
    };


    new Chart(
        document.getElementById(id),
        Config
    );
}

if (document.getElementById('currentMonthIncomesChart')) {
    let currentMonthIncomesAmounts = document.getElementById('currentMonthIncomesAmounts').innerText;
    let currentMonthIncomesSumsNames = document.getElementById('currentMonthIncomesSumsNames').innerText;
    let currentMonthIncomesSumsNamesReady = currentMonthIncomesSumsNames.split(",");
    currentMonthIncomesSumsNamesReady.pop();

    drawChart(currentMonthIncomesSumsNamesReady, currentMonthIncomesAmounts, 'currentMonthIncomesChart');
}

// current month expenses chart
if (document.getElementById('currentMonthExpensesChart')) {
    let currentMonthExpensesAmounts = document.getElementById('currentMonthExpensesAmounts').innerText;
    let currentMonthExpensesSumsNames = document.getElementById('currentMonthExpensesSumsNames').innerText;
    let currentMonthExpensesSumsNamesReady = currentMonthExpensesSumsNames.split(",");
    currentMonthExpensesSumsNamesReady.pop();

    drawChart(currentMonthExpensesSumsNamesReady, currentMonthExpensesAmounts, 'currentMonthExpensesChart');
}

//previous month incomes pie chart
if (document.getElementById('previousMonthIncomesChart')) {
    let previousMonthIncomesAmounts = document.getElementById('previousMonthIncomesAmounts').innerText;
    let previousMonthIncomesSumsNames = document.getElementById('previousMonthIncomesSumsNames').innerText;
    let previousMonthIncomesSumsNamesReady = previousMonthIncomesSumsNames.split(",");
    previousMonthIncomesSumsNamesReady.pop();

    drawChart(previousMonthIncomesSumsNamesReady, previousMonthIncomesAmounts, 'previousMonthIncomesChart');
}

// previous month expenses chart
if (document.getElementById('previousMonthExpensesChart')) {
    let previousMonthExpensesAmounts = document.getElementById('previousMonthExpensesAmounts').innerText;
    let previousMonthExpensesSumsNames = document.getElementById('previousMonthExpensesSumsNames').innerText;
    let previousMonthExpensesSumsNamesReady = previousMonthExpensesSumsNames.split(",");
    previousMonthExpensesSumsNamesReady.pop();

    drawChart(previousMonthExpensesSumsNamesReady, previousMonthExpensesAmounts, 'previousMonthExpensesChart');
}


//current year incomes pie chart
if (document.getElementById('currentYearIncomesChart')) {
    let currentYearIncomesAmounts = document.getElementById('currentYearIncomesAmounts').innerText;
    let currentYearIncomesSumsNames = document.getElementById('currentYearIncomesSumsNames').innerText;
    let currentYearIncomesSumsNamesReady = currentYearIncomesSumsNames.split(",");
    currentYearIncomesSumsNamesReady.pop();

    drawChart(currentYearIncomesSumsNamesReady, currentYearIncomesAmounts, 'currentYearIncomesChart');
}

//current year expenses chart
if (document.getElementById('currentYearExpensesChart')) {
    let currentYearExpensesAmounts = document.getElementById('currentYearExpensesAmounts').innerText;
    let currentYearExpensesSumsNames = document.getElementById('currentYearExpensesSumsNames').innerText;
    let currentYearExpensesSumsNamesReady = currentYearExpensesSumsNames.split(",");
    currentYearExpensesSumsNamesReady.pop();

    drawChart(currentYearExpensesSumsNamesReady, currentYearExpensesAmounts, 'currentYearExpensesChart');
}


//custom incomes pie chart
if (document.getElementById('customIncomesChart')) {
    let customIncomesAmounts = document.getElementById('customIncomesAmounts').innerText;
    let customIncomesSumsNames = document.getElementById('customIncomesSumsNames').innerText;
    let customIncomesSumsNamesReady = customIncomesSumsNames.split(",");
    customIncomesSumsNamesReady.pop();

    drawChart(customIncomesSumsNamesReady, customIncomesAmounts, 'customIncomesChart');
}

//custom expenses chart

if (document.getElementById('customExpensesChart')) {
    let customExpensesAmounts = document.getElementById('customExpensesAmounts').innerText;
    let customExpensesSumsNames = document.getElementById('customExpensesSumsNames').innerText;
    let customExpensesSumsNamesReady = customExpensesSumsNames.split(",");
    customExpensesSumsNamesReady.pop();

    drawChart(customExpensesSumsNamesReady, customExpensesAmounts, 'customExpensesChart');
}


/**
 * editing and deleting single incomes and expenses 
 */
$(document).ready(function () {

    $('.deleteSingleIncomeBtn').on('click', function () {
        $('#deleteSingleIncomeModal').modal('show');

        $tr = $(this).closest('tr');
        let data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#incomeIdDeleteModal').val(data[0]);


    });

    $('.editSingleIncomeBtn').on('click', function () {
        $('#editSingleIncomeModal').modal('show');

        $tr = $(this).closest('tr');
        let data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#incomeIdEditModal').val(data[0]);
        $('#incomeDateEditModal').val(data[1]);
        $('#incomeAmountEditModal').val(data[2]);
        $('#incomeCategoryEditModal').val(data[3]);
        $('#incomeCommentEditModal').val(data[4]);

    });



    $('.deleteSingleExpenseBtn').on('click', function () {
        $('#deleteSingleExpenseModal').modal('show');

        $tr = $(this).closest('tr');
        let data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#expenseIdDeleteModal').val(data[0]);

    });

    $('.editSingleExpenseBtn').on('click', function () {
        $('#editSingleExpenseModal').modal('show');

        $tr = $(this).closest('tr');
        let data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#expenseIdEditModal').val(data[0]);
        $('#expenseDateEditModal').val(data[1]);
        $('#editExpenseAmount').val(data[2]);
        $('#expenseCategoryEditModal').val(data[3]);
        $('#expenseMethodEditModal').val(data[4]);
        $('#expenseCommentEditModal').val(data[5]);

    });


    $("#editSingleIncomeForm").validate({
        ignore: '#incomeAmountEditModal',
        rules: {
            date: 'required',
            category: 'required'
        },
        messages: {
            date: ' Podaj datę przychodu.',
            category: 'Wybierz kategorię.'
        },
        errorElement: "span",
        errorClass: "help-inline",
    });

    $("#editSingleExpenseForm").validate({
        ignore: '#editExpenseAmount',
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


});