<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Balance;

/**
 * DisplayBalance controller
 *
 * PHP version 7.4
 */
class DisplayBalance extends Authenticated
{

    /**
     * Show the display balance  page
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
             View::renderTemplate('displayBalance/new.html', [
            'incomes' => Balance::getPreviousMonthIncomes(),
            'expenses' => Balance::getPreviousMonthExpenses(),
            'balanceCalc' => Balance::getPreviousMonthBalance(),
            'previous_month' => 'true',
            'incomes_sums' => Balance::getPreviousMonthIncomesSumsDivedIntoCategories(),
            'expenses_sums' => Balance::getPreviousMonthExpensesSumsDivedIntoCategories()
             ]);
        }

        else if ($balance->time ===  "current_year")
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
        
        unset($balance);
    }

    /**
     * 
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

        unset($balance);
    }

}
