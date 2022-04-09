<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Expense;
use \App\Flash;

/**
 * Add expense controller
 *
 * PHP version 7.4
 */
class Addexpense extends Authenticated
{

    /**
     * Show the add expense page
     *
     * @return void
     */
    public function newAction()
    {

        View::renderTemplate('Addexpense/new.html',[
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
            $this->redirect('/');

        } else {

            View::renderTemplate('Addexpense/new.html', [
            'categories' => Expense::getExpenseCategories(),
             'methods' => Expense::getPaymentMethods(),
            'expense' => $expense
            ]);

        }
    }

    public function expensesAction()
    {
        $date = $this->route_params['date'];
        $name = $this->route_params['category'];
        echo json_encode(Expense::getMonthlyExpensesSumInGivenCategory($name, $date), JSON_UNESCAPED_UNICODE);
    }

    public function limitAction()
    {
        $name = $this->route_params['category'];
        echo json_encode(Expense::getCategoryLimit($name), JSON_UNESCAPED_UNICODE);
    }
}
