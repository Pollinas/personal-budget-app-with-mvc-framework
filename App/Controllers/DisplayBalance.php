<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Balance;
use \App\Flash;

/**
 * DisplayBalance controller
 *
 * PHP version 7.4
 */
class DisplayBalance extends Authenticated
{

    /**
     * Show the display balance  page; load default data : this month
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('displayBalance/new.html', [
            'incomes' => Balance::getCurrentMonthIncomes(),
            'expenses' => Balance::getCurrentMonthExpenses(),
            'balanceCalc' => Balance::getCurrentMonthBalance(),
            'current_month' => 'true',
            'incomes_sums' => Balance::getCurrentMonthIncomesSumsDivedIntoCategories(),
            'expenses_sums' => Balance::getCurrentMonthExpensesSumsDivedIntoCategories()
            ]);
    }

    /**
     * 
     */
    public function CreateAction()
    {
        $balance = new Balance($_POST);

        if ($balance->time ===  "current_month")
        {
            $this->newAction();

        }

        else if ($balance->time ===  "previous_month")
        {
            $this->showPreviousMonthDataAction();
        }

        else if ($balance->time ===  "current_year")
        {
            $this->showCurrentYearDataAction();
        }    
        
    }

    /**
     * show the display balance page with data form the previous month
     * 
     * @return void
     */

    protected function showPreviousMonthDataAction()
    {
        View::renderTemplate('displayBalance/new.html', [
            'incomes' => Balance::getPreviousMonthIncomes(),
            'expenses' => Balance::getPreviousMonthExpenses(),
            'balanceCalc' => Balance::getPreviousMonthBalance(),
            'previous_month' => 'true',
            'incomes_sums' => Balance::getPreviousMonthIncomesSumsDivedIntoCategories(),
            'expenses_sums' => Balance::getPreviousMonthExpensesSumsDivedIntoCategories()
             ]);
    }

    
    /**
     * show the display balance page with data form the current year 
     * 
     * @return void
     */

    protected function showCurrentYearDataAction()
    {
        View::renderTemplate('displayBalance/new.html', [
            'incomes' => Balance::getCurrentYearIncomes(),
            'expenses' => Balance::getCurrentYearExpenses(),
            'balanceCalc' => Balance::getCurrentYearBalance(),
            'current_year' => true,
            'incomes_sums' => Balance::getCurrentYearIncomesSumsDivedIntoCategories(),
            'expenses_sums' => Balance::getCurrentYearExpensesSumsDivedIntoCategories()
            ]);
    }



    /**
     * show the display balance page with data form the chosen dates 
     * 
     * @return void
     */
    public function createCustomAction()
    {
        $balance = new Balance($_POST);
        $begin = $balance->begin;
        $end = $balance->end;
      
        View::renderTemplate('displayBalance/new.html', [
            'balance' => $balance, 
            'incomes' => Balance::getCustomIncomes($begin, $end),
            'expenses' =>   Balance::getCustomExpenses($begin, $end),
            'balanceCalc' => Balance::getCustomBalance($begin, $end),
            'custom' => true,
            'incomes_sums' => Balance::getCustomIncomesSumsDivedIntoCategories($begin, $end),
            'expenses_sums' => Balance::getCustomExpensesSumsDivedIntoCategories($begin, $end)
            ]);

    }

    

    /**
     * delete single income; then render the same view as before 
     * 
     * @return void
     */
    public function deleteSingleIncomeAction()
    {
        $id = $_POST['income_id'];


        if(Balance::deleteSingleIncome($id))
        {
            Flash::addMessage('Usunięto wybrany przychód.');    
            $this->newAction();
        }
        else
        {
            Flash::addMessage('Ups! Coś poszło nie tak.' , $type='info');  
        }
      
    }

    /**
     * delete single expense; then render the same view as before 
     * 
     * @return void
     */
    public function deleteSingleExpenseAction()
    {
        $id = $_POST['expense_id'];

        if(Balance::deleteSingleExpense($id))
        {
            Flash::addMessage('Usunięto wybrany wydatek.');    
            $this->newAction();
        }
        else
        {
            Flash::addMessage('Ups! Coś poszło nie tak.' , $type='info');  
        }
      
    }

}
