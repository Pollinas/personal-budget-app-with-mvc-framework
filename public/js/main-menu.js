$(window).load(function () { // makes sure the whole site is loaded
    $("#status").delay(500).fadeOut("slow"); // will first fade out the loading animation
    $("#preloader").delay(1000).fadeOut("slow"); // will fade out the white DIV that covers the website.
})

let description = document.querySelector('#description');

// opis inspiracja
const inspiration = document.querySelector('.inspiration');
inspiration.onmouseover = inspirationMouseOver;
inspiration.onmouseout = inspirationMouseOut;


function inspirationMouseOver() {
    description.style.display = 'block';
    description.innerHTML = "Zainspiruj się!";
}

function inspirationMouseOut() {
    description.style.display = 'none';
}

//opis wyświetl bilans

const balance = document.querySelector('.balance');
balance.onmouseover = balanceMouseOver;
balance.onmouseout = balanceMouseOut;


function balanceMouseOver() {
    description.style.display = 'block';
    description.innerHTML = "Wyświetl bilans";
}

function balanceMouseOut() {
    description.style.display = 'none';
}

//opis dodaj wydatek

const expense = document.querySelector('.expense');
expense.onmouseover = expenseMouseOver;
expense.onmouseout = expenseMouseOut;


function expenseMouseOver() {
    description.style.display = 'block';
    description.innerHTML = "Dodaj wydatek";
}

function expenseMouseOut() {
    description.style.display = 'none';
}

//opis dodaj przychód

const income = document.querySelector('.income');
income.onmouseover = incomeMouseOver;
income.onmouseout = incomeMouseOut;


function incomeMouseOver() {
    description.style.display = 'block';
    description.innerHTML = "Dodaj przychód";
}

function incomeMouseOut() {
    description.style.display = 'none';
}


//opis ustawienia

const settings = document.querySelector('.settings');
settings.onmouseover = settingsMouseOver;
settings.onmouseout = settingsMouseOut;


function settingsMouseOver() {
    description.style.display = 'block';
    description.innerHTML = "Ustawienia";
}

function settingsMouseOut() {
    description.style.display = 'none';
}

//opis wyloguj się
const logOut = document.querySelector('.logOut');
logOut.onmouseover = logOutMouseOver;
logOut.onmouseout = logOutMouseOut;

function logOutMouseOver() {
    description.style.display = 'block';
    description.innerHTML = "Wyloguj się";
}

function logOutMouseOut() {
    description.style.display = 'none';
}