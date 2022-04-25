<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;
use \App\Flash;

/**
 * Add income controller
 *
 * PHP version 7.4
 */
class Addincome extends Authenticated
{

    /**
     * Show the add income  page
     *
     * @return void
     */
    public function newAction()
    {
        $id= $_SESSION['user_id'];

        View::renderTemplate('Addincome/new.html',[
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
            Flash::addMessage('Income added successfully.');
            http_response_code(201);
            $this->redirect('/');

        } else {

            View::renderTemplate('Addincome/new.html', [
            'categories' => Income::getIncomeCategories(),
            'income' => $income
            ]);

        }
    }
}
