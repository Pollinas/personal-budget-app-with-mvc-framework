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

    if (incomesContainer.style.display === 'block') { incomesContainer.style.display = 'none'; }
    if (expensesContainer.style.display === 'block') { expensesContainer.style.display = 'none'; }
    if (methodsContainer.style.display === 'block') { methodsContainer.style.display = 'none'; }
    if (profileContainer.style.display === 'block') { profileContainer.style.display = 'none'; }
    if (passwordContainer.style.display === 'block') { passwordContainer.style.display = 'none'; }
    guideContainer.style.display = 'none';
}

// toggle income settings 

function toggleIncomes() {

    choiceReset();
    incomesContainer.style.display = 'block';
}

//toggle expense settings 

function toggleExpenses() {

    choiceReset();
    expensesContainer.style.display = 'block';

}

//toggle methods settings 

function toggleMethods() {

    choiceReset();
    methodsContainer.style.display = 'block';

}

//toggle profile settings 

function toggleProfile() {

    choiceReset();
    profileContainer.style.display = 'block';

}

//toggle password settings 

function togglePassword() {

    choiceReset();
    passwordContainer.style.display = 'block';

}


