<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\User;
use \App\Models\Income;
use \App\Models\Expense;


/**
 * Settings controller
 *
 * PHP version 7.4
 */
class Settings extends Authenticated
{

       /**
     * Before filter - called before each action method
     *
     * @return void
     */
    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }

    /**
     * Show the settings page
     *
     * @return void
     */
    public function indexAction()
    {

        View::renderTemplate('Settings/index.html',[
            'user' => $this->user,
            'incomeCategories' => Income::getIncomeCategories(),
            'expenseCategories' => Expense::getExpenseCategories(),
            'methods' => Expense::getPaymentMethods()
        ]);
    }

    /**
     * Delete all incomes
     * 
     * @return void
     */
    public function deleteAllIncomesAction()
    {
        if(Income::deleteAllIncomes())
        {
            Flash::addMessage('Przychody zostały usunięte.');
            $this->indexAction();
        }
        else{
            Flash::addMessage('Ups! Coś poszło nie tak.');  
            $this->indexAction();
        }
    }

    /**
     * Delete all expenses
     * 
     * @return void
     */
    public function deleteAllExpensesAction()
    {
        if(Expense::deleteAllExpenses())
        {
            Flash::addMessage('Wydatki zostały usunięte.');
            $this->indexAction();
           
        }else{
            Flash::addMessage('Ups! Coś poszło nie tak.');
            $this->indexAction();
        }
    }

     /**
     * update the profile data 
     * 
     * @return void
     */

  public function updateProfileAction()
  {
      if($this->user->updateProfile($_POST)){
          Flash::addMessage('Nowe dane zostały zapisane.');
         $this->indexAction();
      }
      else{
         Flash::addMessage('Dane profilowe nie zostały zmienione.', $type='warning');
         $this->indexAction();
      }
      
  }
 
      /**
      * update password 
      * 
      * @return void
      */
 
     public function updatePasswordAction()
     {
         if($this->user->updatePassword($_POST['password']))
         {
             Flash::addMessage('Hasło zostało zmienione.');
             $this->indexAction();
         }
         else{
             Flash::addMessage('Hasło nie zostało zmienione.');
            $this->indexAction();
         }
         
     }
 
     /**
      * delete account
      * 
      * @return void 
      * automatically log the user out
      */
     public function deleteAction()
     {
         if($this->user->deleteAccount())
         {
             Flash::addMessage('Konto i wszystkie dane z nim powiązane zostały usunięte.');
             $this->redirect('/');
         }
         else{
             Flash::addMessage('Ups! Coś poszło nie tak.');
            $this->redirect('/');
         }
     }
    
}