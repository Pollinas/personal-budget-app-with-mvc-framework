<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;
use \App\Flash;

/**
 * Add Income controller
 *
 * PHP version 7.4
 */
class AddIncome extends Authenticated
{

    /**
     * Show the add income  page
     *
     * @return void
     */
    public function newAction()
    {
        $id= $_SESSION['user_id'];

        View::renderTemplate('AddIncome/new.html',[
            'categories' => Income::getIncomeCategories()
        ]);
    }

     /**
     * Add a new income
     *
     * @return void
     */
    public function createAction()
    {
        $income = new Income($_POST);

          if($income->save())
        {
            Flash::addMessage('Dodawanie przychodu zakończone sukcesem.');
            $this->redirect('/MainMenu/new');

        } else {

            View::renderTemplate('AddIncome/new.html', [
            'categories' => Income::getIncomeCategories(),
            'income' => $income
            ]);

        }
    }
}
