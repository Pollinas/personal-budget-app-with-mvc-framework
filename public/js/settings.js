var button = document.getElementById('hamburger-menu'),
    section = button.getElementsByTagName('section')[0];

button.onclick = function () {
    section.classList.toggle('hamburger-menu-button-close');
};

$('#hamburger-menu').on('click', toggleOnClass);

function toggleOnClass(event) {
    var toggleElementId = '#' + $(this).data('toggle'),
        element = $(toggleElementId);

    element.toggleClass('on');

}

// close hamburger menu after click a
$('.menu li a').on("click", function () {
    $('#hamburger-menu').click();
});



/**
 * toggle different settings
 */

var incomesContainer = document.querySelector('#incomesContainer');
var expensesContainer = document.querySelector('#expensesContainer');
var methodsContainer = document.querySelector('#methodsContainer');
var profileContainer = document.querySelector('#profileContainer');
var passwordContainer = document.querySelector('#passwordContainer');
var guideContainer = document.querySelector('#guideContainer');

function choiceReset() {

    if (incomesContainer.style.display === 'flex') { incomesContainer.style.display = 'none'; }
    if (expensesContainer.style.display === 'flex') { expensesContainer.style.display = 'none'; }
    if (methodsContainer.style.display === 'flex') { methodsContainer.style.display = 'none'; }
    if (profileContainer.style.display === 'flex') { profileContainer.style.display = 'none'; }
    if (passwordContainer.style.display === 'flex') { passwordContainer.style.display = 'none'; }
    guideContainer.style.display = 'none';
}

// toggle income settings 

function toggleIncomes() {

    choiceReset();
    incomesContainer.style.display = 'flex';
}

//toggle expense settings 

function toggleExpenses() {

    choiceReset();
    expensesContainer.style.display = 'flex';

}

//toggle methods settings 

function toggleMethods() {

    choiceReset();
    methodsContainer.style.display = 'flex';

}

//toggle profile settings 

function toggleProfile() {

    choiceReset();
    profileContainer.style.display = 'flex';

}

//toggle password settings 

function togglePasswordContainer() {

    choiceReset();
    passwordContainer.style.display = 'flex';

}


/**
 * incomes and expenses
 */
$(document).ready(function () {
    $('.editIncomeBtn').on('click', function () {
        $('#editIncomeModal').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#incomeCategoryModal').val(data[0]);
        $('#incomeCategoryIdModal').val(data[2]);


    });

    $('.editExpenseBtn').on('click', function () {
        $('#editExpenseModal').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#expenseCategoryModal').val(data[0]);
        $('#expenseCategoryIdModal').val(data[2]);

    });

    $('.editPaymentBtn').on('click', function () {
        $('#editPaymentModal').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#paymentModal').val(data[0]);
        $('#paymentIdModal').val(data[2]);

    });
});

