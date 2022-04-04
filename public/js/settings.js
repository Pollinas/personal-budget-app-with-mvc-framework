let button = document.getElementById('hamburger-menu'),
    section = button.getElementsByTagName('section')[0];

button.onclick = function () {
    section.classList.toggle('hamburger-menu-button-close');
};

$('#hamburger-menu').on('click', toggleOnClass);

function toggleOnClass(event) {
    let toggleElementId = '#' + $(this).data('toggle'),
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

let incomesContainer = document.querySelector('#incomesContainer');
let expensesContainer = document.querySelector('#expensesContainer');
let methodsContainer = document.querySelector('#methodsContainer');
let profileContainer = document.querySelector('#profileContainer');
let passwordContainer = document.querySelector('#passwordContainer');
let guideContainer = document.querySelector('#guideContainer');

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
 * incomes, expenses an payment methods
 */
$(document).ready(function () {

    //incomes
    $('.editIncomeBtn').on('click', function () {
        $('#editIncomeModal').modal('show');

        $tr = $(this).closest('tr');
        let data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#incomeCategoryModal').val(data[0]);
        $('#incomeCategoryIdModal').val(data[2]);


    });

    $('.deleteIncomeCategoryBtn').on('click', function () {
        $('#deleteIncomeCategoryModal').modal('show');

        $tr = $(this).closest('tr');
        let data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#incomeCategoryNameDeleteModal').val(data[0]);
        $('#incomeCategoryIdDeleteModal').val(data[2]);


    });

    //expenses

    $('.editExpenseBtn').on('click', function () {
        $('#editExpenseModal').modal('show');

        $tr = $(this).closest('tr');
        let data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#expenseCategoryModal').val(data[0]);
        $('#expenseCategoryIdEditModal').val(data[2]);

    });


    $('.deleteExpenseCatgedoryBtn').on('click', function () {
        $('#deleteExpenseCategoryModal').modal('show');

        $tr = $(this).closest('tr');
        let data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#expenseCategoryNameModal').val(data[0]);
        $('#expenseCategoryIdModal').val(data[2]);

    });

    //methods 

    $('.editMethodBtn').on('click', function () {
        $('#editPaymentModal').modal('show');

        $tr = $(this).closest('tr');
        let data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#paymentModal').val(data[0]);
        $('#paymentIdModal').val(data[2]);

    });

    $('.deleteMethodBtn').on('click', function () {
        $('#deleteMethodModal').modal('show');

        $tr = $(this).closest('tr');
        let data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        $('#methodName').val(data[0]);
        $('#methodIdModal').val(data[2]);

    });

    /**
     * forms validation
     */


    $.validator.addMethod('regex', function (value) {
        return /^[A-Z, a-z, ą,Ą,ć,Ć,ę,Ę,ł,Ł, ń,Ń,ó,Ó,ś,Ś,ż,Ż,ź,Ź]+$/.test(value);
    }, 'Nazwa może zawierać tylko litery polskiego alfabetu.');


    // kategorie wydatków i przychodów
    function formCategoryValidation(formID, remoteAction) {
        $(formID).validate({
            rules: {
                new_category_name:
                {
                    required: true,
                    remote: remoteAction,
                    minlength: 4,
                    maxlength: 20,
                    regex: true
                }

            },
            messages: {
                new_category_name: {
                    remote: 'Kategoria o takiej nazwie już istnieje.',
                    maxlength: 'Kategoria może zawierać 4-20 liter polskiego alfabetu.',
                    minlength: 'Kategoria może zawierać 4-20 liter polskiego alfabetu.'
                }
            },
            errorElement: "span",
            errorClass: "help-inline"
        });
    }

    formCategoryValidation('#addExpenseCategoryForm', '/account/validate-expense-category-name'); // dodawanie nowej kategorii wydatku

    formCategoryValidation('#addIncomeCategoryForm', '/account/validate-income-category-name'); // dodawanie nowej kategorii przychodu


    //edytowanie istniejącej kategorii wydatków
    $('#editExpenseForm').validate({
        rules: {
            new_category_name:
            {
                required: true,
                remote: {
                    url: '/account/validate-expense-category-name',
                    data: {
                        ignore_id: function () {
                            return $('#expenseCategoryIdEditModal').val();
                        }
                    }
                },
                minlength: 4,
                maxlength: 20,
                regex: true
            }

        },
        messages: {
            new_category_name: {
                remote: 'Kategoria wydatków o takiej nazwie już istnieje.',
                maxlength: 'Kategoria wydatków może zawierać 4-20 liter polskiego alfabetu.',
                minlength: 'Kategoria wydatków może zawierać 4-20 liter polskiego alfabetu.'
            }
        },
        errorElement: "span",
        errorClass: "help-inline"
    });


    //edytowanie istniejącej kategorii przychodu
    $('#editIncomeForm').validate({
        rules: {
            new_category_name:
            {
                required: true,
                remote: {
                    url: '/account/validate-income-category-name',
                    data: {
                        ignore_id: function () {
                            return $('#incomeCategoryIdModal').val();
                        }
                    }
                },
                minlength: 4,
                maxlength: 20,
                regex: true
            }

        },
        messages: {
            new_category_name: {
                remote: 'Kategoria przychodu o takiej nazwie już istnieje.',
                maxlength: 'Kategoria przychodu może zawierać 4-20 liter polskiego alfabetu.',
                minlength: 'Kategoria przychodu może zawierać 4-20 liter polskiego alfabetu.'
            }
        },
        errorElement: "span",
        errorClass: "help-inline"
    });




    //payment method
    $('#addPaymentMethodForm').validate({
        rules: {
            new_method_name:
            {
                required: true,
                remote: '/account/validate-method-name',
                minlength: 4,
                maxlength: 20,
                regex: true
            }

        },
        messages: {
            new_method_name: {
                remote: 'Metoda płatności o takiej nazwie już istnieje.',
                maxlength: 'Metoda płatności może zawierać 4-20 liter polskiego alfabetu.',
                minlength: 'Metoda płatności może zawierać 4-20 liter polskiego alfabetu.'
            }
        },
        errorElement: "span",
        errorClass: "help-inline"
    });

    //payment method
    $('#editPaymentMethodForm').validate({
        rules: {
            new_method_name:
            {
                required: true,
                remote: {
                    url: '/account/validate-method-name',
                    data: {
                        ignore_id: function () {
                            return $('#paymentIdModal').val();
                        }
                    }
                },
                minlength: 4,
                maxlength: 20,
                regex: true
            }

        },
        messages: {
            new_method_name: {
                remote: 'Metoda płatności o takiej nazwie już istnieje.',
                maxlength: 'Metoda płatności może zawierać 4-20 liter polskiego alfabetu.',
                minlength: 'Metoda płatności może zawierać 4-20 liter polskiego alfabetu.'
            }
        },
        errorElement: "span",
        errorClass: "help-inline"
    });


});

