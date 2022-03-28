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