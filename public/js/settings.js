function checkLimit(e) {
    if ($('#set_limit').is(':checked')) {
        $('#limitEdit').show();
    }
    else {
        $('#limitEdit').hide();
    }
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
        $('#expenseCategoryIdEditModal').val(data[1]);
        $('#limitEdit').val(data[2]);

        if (data[2] != '') {
            $('#set_limit').prop('checked', true);
            $('#limitEdit').show();
        }
        else {
            $('#set_limit').prop('checked', false);
            $('#limitEdit').hide();
        }


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
                    remote: 'Category with that name already exists.',
                    maxlength: 'A category can contain 4-20 letters. ',
                    minlength: 'A category can contain 4-20 letters.'
                }
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
    }

    formCategoryValidation('#addExpenseCategoryForm', '/account/validate-expense-category-name'); // dodawanie nowej kategorii wydatku

    formCategoryValidation('#addIncomeCategoryForm', '/account/validate-income-category-name'); // dodawanie nowej kategorii przychodu


    //edytowanie istniejącej kategorii wydatków
    $('#editExpenseForm').validate({
        ignore: '#limitEdit',
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
                remote: 'Expense category with that name already exists.',
                maxlength: 'An expense category can contain 4-20 letters.',
                minlength: 'An expense category can contain 4-20 letters.'
            }
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
                remote: 'Income category with that name already exists.',
                maxlength: 'An income category can contain 4-20 letters.',
                minlength: 'An income category can contain 4-20 letters.'
            }
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




    //add payment method
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
                required: 'This field is required.',
                remote: 'Payment method with that name already exists.',
                maxlength: 'An payment method can contain 4-20 letters.',
                minlength: 'An payment method can contain 4-20 letters.'
            }
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

    //edit payment method
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
                required: 'This field is required.',
                remote: 'Payment method with that name already exists.',
                maxlength: 'An payment method can contain 4-20 letters.',
                minlength: 'An payment method can contain 4-20 letters.'
            }
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

