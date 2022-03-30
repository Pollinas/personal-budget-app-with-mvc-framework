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


// toggle income settings 

function toggleIncomes() {

    var incomesContainer = document.querySelector('#incomesContainer');

    incomesContainer.style.display = 'block';

}

//toggle expense settings 

function toggleExpenses() {

    var expensesContainer = document.querySelector('#expensesContainer');

    expensesContainer.style.display = 'block';

}

//toggle methods settings 

function toggleMethods() {

    var methodsContainer = document.querySelector('#methodsContainer');

    methodsContainer.style.display = 'block';

}

//toggle profile settings 

function toggleProfile() {

    var profileContainer = document.querySelector('#profileContainer');

    profileContainer.style.display = 'block';

}

//toggle password settings 

function togglePassword() {

    var passwordContainer = document.querySelector('#passwordContainer');

    passwordContainer.style.display = 'block';

}


