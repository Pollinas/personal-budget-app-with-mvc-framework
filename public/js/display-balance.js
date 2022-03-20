
function myFunction(e) {
    var option_value = document.getElementById("time").value;
    let none = document.querySelector(".none")
    if (option_value == "custom") {
        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {});
        myModal.show();
    }
}



function checkEndDate(e) {
    var end = document.querySelector("#end").value;
    var begin = document.querySelector("#begin").value;

    var endDate = new Date(end);
    var beginDate = new Date(begin);
    var today = new Date();

    if (endDate > today) {
        alert("Data końcowa nie może być późniejsza od dzisiejszej daty!");
        document.getElementById("end").valueAsDate = null;
    }


    if (beginDate > endDate) {
        alert("Data końcowa bilansu nie może być wcześniejsza od jego daty początkowej!");
        document.getElementById("end").valueAsDate = null;
    }
}

function checkBeginDate(e) {

    var begin = document.querySelector("#begin").value;

    var beginDate = new Date(begin);
    var today = new Date();

    if (beginDate > today) {
        alert("Data początkowa nie może być późniejsza od dzisiejszej daty!");
        document.getElementById("begin").valueAsDate = null;
    }

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
        type: 'doughnut',
        data: Data
    };


    new Chart(
        document.getElementById(id),
        Config
    );
}

if (document.getElementById('currentMonthIncomesChart')) {
    var currentMonthIncomesAmounts = document.getElementById('currentMonthIncomesAmounts').innerText;
    var currentMonthIncomesSumsNames = document.getElementById('currentMonthIncomesSumsNames').innerText;
    var currentMonthIncomesSumsNamesReady = currentMonthIncomesSumsNames.split(",");
    currentMonthIncomesSumsNamesReady.pop();

    drawChart(currentMonthIncomesSumsNamesReady, currentMonthIncomesAmounts, 'currentMonthIncomesChart');
}

// current month expenses chart
if (document.getElementById('currentMonthExpensesChart')) {
    var currentMonthExpensesAmounts = document.getElementById('currentMonthExpensesAmounts').innerText;
    var currentMonthExpensesSumsNames = document.getElementById('currentMonthExpensesSumsNames').innerText;
    var currentMonthExpensesSumsNamesReady = currentMonthExpensesSumsNames.split(",");
    currentMonthExpensesSumsNamesReady.pop();

    drawChart(currentMonthExpensesSumsNamesReady, currentMonthExpensesAmounts, 'currentMonthExpensesChart');
}

//previous month incomes pie chart
if (document.getElementById('previousMonthIncomesChart')) {
    var previousMonthIncomesAmounts = document.getElementById('previousMonthIncomesAmounts').innerText;
    var previousMonthIncomesSumsNames = document.getElementById('previousMonthIncomesSumsNames').innerText;
    var previousMonthIncomesSumsNamesReady = previousMonthIncomesSumsNames.split(",");
    previousMonthIncomesSumsNamesReady.pop();

    drawChart(previousMonthIncomesSumsNamesReady, previousMonthIncomesAmounts, 'previousMonthIncomesChart');
}

// previous month expenses chart
if (document.getElementById('previousMonthExpensesChart')) {
    var previousMonthExpensesAmounts = document.getElementById('previousMonthExpensesAmounts').innerText;
    var previousMonthExpensesSumsNames = document.getElementById('previousMonthExpensesSumsNames').innerText;
    var previousMonthExpensesSumsNamesReady = previousMonthExpensesSumsNames.split(",");
    previousMonthExpensesSumsNamesReady.pop();

    drawChart(previousMonthExpensesSumsNamesReady, previousMonthExpensesAmounts, 'previousMonthExpensesChart');
}


//current year incomes pie chart
if (document.getElementById('currentYearIncomesChart')) {
    var currentYearIncomesAmounts = document.getElementById('currentYearIncomesAmounts').innerText;
    var currentYearIncomesSumsNames = document.getElementById('currentYearIncomesSumsNames').innerText;
    var currentYearIncomesSumsNamesReady = currentYearIncomesSumsNames.split(",");
    currentYearIncomesSumsNamesReady.pop();

    drawChart(currentYearIncomesSumsNamesReady, currentYearIncomesAmounts, 'currentYearIncomesChart');
}

//current year expenses chart
if (document.getElementById('currentYearExpensesChart')) {
    var currentYearExpensesAmounts = document.getElementById('currentYearExpensesAmounts').innerText;
    var currentYearExpensesSumsNames = document.getElementById('currentYearExpensesSumsNames').innerText;
    var currentYearExpensesSumsNamesReady = currentYearExpensesSumsNames.split(",");
    currentYearExpensesSumsNamesReady.pop();

    drawChart(currentYearExpensesSumsNamesReady, currentYearExpensesAmounts, 'currentYearExpensesChart');
}


//custom incomes pie chart
if (document.getElementById('customIncomesChart')) {
    var customIncomesAmounts = document.getElementById('customIncomesAmounts').innerText;
    var customIncomesSumsNames = document.getElementById('customIncomesSumsNames').innerText;
    var customIncomesSumsNamesReady = customIncomesSumsNames.split(",");
    customIncomesSumsNamesReady.pop();

    drawChart(customIncomesSumsNamesReady, customIncomesAmounts, 'customIncomesChart');
}

//custom expenses chart

if (document.getElementById('customExpensesChart')) {
    var customExpensesAmounts = document.getElementById('customExpensesAmounts').innerText;
    var customExpensesSumsNames = document.getElementById('customExpensesSumsNames').innerText;
    var customExpensesSumsNamesReady = customExpensesSumsNames.split(",");
    customExpensesSumsNamesReady.pop();

    drawChart(customExpensesSumsNamesReady, customExpensesAmounts, 'customExpensesChart');
}


