<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Models\Income;
use \App\Models\Expense;

/**
 * Edit controller
 *
 * PHP version 7.4
 */
class Edit extends Authenticated
{

    /**
     * Show the add income  page
     *
     * @return void
     */
    public function showAction()
    {
        View::renderTemplate('Edit/show.html');
    }

    /**
     * Delete all incomes
     * 
     * @return void
     */
    public function deleteAllIncomes()
    {
        if(Income::deleteAllIncomes())
        {
            Flash::addMessage('Przychody zostały usunięte.');
            $this->redirect('/');
        }
        else{
            Flash::addMessage('Ups! Coś poszło nie tak.');  
            $this->redirect('/');  
        }
    }

    /**
     * Delete all expenses
     * 
     * @return void
     */
    public function deleteAllExpenses()
    {
        if(Expense::deleteAllExpenses())
        {
            Flash::addMessage('Wydatki zostały usunięte.');
            $this->redirect('/');
           
        }else{
            Flash::addMessage('Ups! Coś poszło nie tak.');
            $this->redirect('/');
        }
    }

    
}
