<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Expense;
use \App\Flash;

/**
 * Add Expense controller
 *
 * PHP version 7.4
 */
class AddExpense extends Authenticated
{

    /**
     * Show the add expense page
     *
     * @return void
     */
    public function newAction()
    {

        View::renderTemplate('AddExpense/new.html',[
            'categories' => Expense::getExpenseCategories(),
            'methods' => Expense::getPaymentMethods()
        ]);
    }

    /**
     * Add a new expense
     *
     * @return void
     */
    public function createAction()
    {
        $expense = new Expense($_POST);

          if($expense->save())
        {
            Flash::addMessage('Dodawanie wydatku zakończone sukcesem.');
            $this->newAction();

        } else {

            View::renderTemplate('AddExpense/new.html', [
            'categories' => Expense::getExpenseCategories(),
             'methods' => Expense::getPaymentMethods(),
            'expense' => $expense
            ]);

        }
    }
}
