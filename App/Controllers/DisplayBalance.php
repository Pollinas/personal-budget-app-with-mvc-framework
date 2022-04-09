<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Balance;
use \App\Models\Income;
use \App\Models\Expense;
use \App\Flash;

/**
 * DisplayBalance controller
 *
 * PHP version 7.4
 */
class Displaybalance extends Authenticated
{

    /**
     * Show the display balance  page; load default data : this month
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('displaybalance/index.html', [
            'incomes' => Balance::getCurrentMonthIncomes(),
            'expenses' => Balance::getCurrentMonthExpenses(),
            'balanceCalc' => Balance::getCurrentMonthBalance(),
            'current_month' => 'true',
            'incomes_sums' => Balance::getCurrentMonthIncomesSumsDivedIntoCategories(),
            'expenses_sums' => Balance::getCurrentMonthExpensesSumsDivedIntoCategories(),
            'expense_categories' => Expense::getExpenseCategories(),
            'payment_methods' => Expense::getPaymentMethods(),
            'income_categories' => Income::getIncomeCategories()
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
            $this->indexAction();

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
        View::renderTemplate('displayBalance/index.html', [
            'incomes' => Balance::getPreviousMonthIncomes(),
            'expenses' => Balance::getPreviousMonthExpenses(),
            'balanceCalc' => Balance::getPreviousMonthBalance(),
            'previous_month' => 'true',
            'incomes_sums' => Balance::getPreviousMonthIncomesSumsDivedIntoCategories(),
            'expenses_sums' => Balance::getPreviousMonthExpensesSumsDivedIntoCategories(),
            'expense_categories' => Expense::getExpenseCategories(),
            'payment_methods' => Expense::getPaymentMethods(),
            'income_categories' => Income::getIncomeCategories()
             ]);
    }

    
    /**
     * show the display balance page with data form the current year 
     * 
     * @return void
     */

    protected function showCurrentYearDataAction()
    {
        View::renderTemplate('displayBalance/index.html', [
            'incomes' => Balance::getCurrentYearIncomes(),
            'expenses' => Balance::getCurrentYearExpenses(),
            'balanceCalc' => Balance::getCurrentYearBalance(),
            'current_year' => true,
            'incomes_sums' => Balance::getCurrentYearIncomesSumsDivedIntoCategories(),
            'expenses_sums' => Balance::getCurrentYearExpensesSumsDivedIntoCategories(),
            'expense_categories' => Expense::getExpenseCategories(),
            'payment_methods' => Expense::getPaymentMethods(),
            'income_categories' => Income::getIncomeCategories()
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
      
        View::renderTemplate('displayBalance/index.html', [
            'balance' => $balance, 
            'incomes' => Balance::getCustomIncomes($begin, $end),
            'expenses' =>   Balance::getCustomExpenses($begin, $end),
            'balanceCalc' => Balance::getCustomBalance($begin, $end),
            'custom' => true,
            'incomes_sums' => Balance::getCustomIncomesSumsDivedIntoCategories($begin, $end),
            'expenses_sums' => Balance::getCustomExpensesSumsDivedIntoCategories($begin, $end),
            'expense_categories' => Expense::getExpenseCategories(),
            'payment_methods' => Expense::getPaymentMethods(),
            'income_categories' => Income::getIncomeCategories()
            ]);

    }

    

    /**
     * delete single income
     * 
     * @return void
     */
    public function deleteSingleIncomeAction()
    {
        $id = $_POST['income_id'];

        if(Income::deleteSingleIncome($id))
        {
            Flash::addMessage('Usunięto wybrany przychód.');    
            $this->indexAction();
        }
        else
        {
            Flash::addMessage('Ups! Coś poszło nie tak.' , $type='info');  
        }
      
    }

    /**
     * delete single expense
     * 
     * @return void
     */
    public function deleteSingleExpenseAction()
    {
        $id = $_POST['expense_id'];

        if(Expense::deleteSingleExpense($id))
        {
            Flash::addMessage('Usunięto wybrany wydatek.');    
            $this->indexAction();
        }
        else
        {
            Flash::addMessage('Ups! Coś poszło nie tak. Spróbuj ponownie później.' , $type='info');  
        }
      
    }
   /**
     * edit single income 
     * 
     * @return void
     */
    public function editSingleIncomeAction()
    {
        $id= $_POST['income_id'] ;  $date = $_POST['date'] ; $amount = $_POST['amount'] ; $category= $_POST['category']; $comment = $_POST['comment'];
        
        if(Income::editSingleIncome($id, $date, $amount, $category, $comment))
        {
            
            Flash::addMessage('Edytowano wybrany przychód.');    
            $this->indexAction();
        }
        else
        {
            Flash::addMessage('Ups! Coś poszło nie tak. Wpisz poprawne dane w formularzu lub spróbuj ponownie później.' , $type='warning');  
            $this->indexAction();
        }
    }


    /**
     * edit single expense
     * 
     * @return void
     */
    public function editSingleExpenseAction()
    {
        $id= $_POST['expense_id'] ;  $date = $_POST['date'] ; $amount = $_POST['amount'] ; $category= $_POST['category']; $comment = $_POST['comment']; $method = $_POST['method'];
        
        if(Expense::editSingleExpense($id, $date, $amount, $category, $comment, $method))
        {
            
            Flash::addMessage('Edytowano wybrany wydatek.');    
            $this->indexAction();
        }
        else
        {
            Flash::addMessage('Ups! Coś poszło nie tak. Wpisz poprawne dane w formularzu lub spróbuj ponownie później.' , $type='warning');  
            $this->indexAction();
        }
    }


}
