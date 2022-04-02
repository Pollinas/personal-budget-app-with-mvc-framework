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
     * auxliary method for the categories and methods proper convention
     * 
     * @return string ; original string input after convertion
     */
    protected static function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = false) {
        $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
        $str_end = "";
        if ($lower_str_end) {
            $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
        } else {
            $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
        }
        $str = $first_letter . $str_end;
        return $str;
    }

    //methods for managing incomes 

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
     * Delete chosen income category 
     * 
     * @return void
     */
    public function deleteIncomeCategoryAction()
    {
        $income_category_id = $_POST['incomeCategoryId'];
        
        if ($_POST['incomeCategoryName'] != "Inne")
         {
           
          if( Income::deleteSingleIncomeCategory($income_category_id) )
             {
                 Flash::addMessage('Wybrana kategoria przychodu została usunięta.');
                 $this->indexAction();
 
             } else {
 
                 Flash::addMessage('Ups! Coś poszło nie tak. spróbuj ponownie później.' , $type='info');
                 $this->indexAction();
             }       
        
         }else{
             Flash::addMessage('Tej kategorii przychodu nie można usuwać ani edytować.' , $type='warning');
             $this->indexAction();
        }
    }

    // methods for managing expenses

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
     * Delete chosen expense category 
     * 
     * @return void
     */
    public function deleteExpenseCategoryAction()
    {
        $expense_category_id = $_POST['expenseCategoryId'];
        
        if ($_POST['expenseCategoryName'] != "Inne")
         {
           
          if( Expense::deleteSingleExpenseCategory($expense_category_id) )
             {
                 Flash::addMessage('Wybrana kategoria wydatku została usunięta.');
                 $this->indexAction();
 
             } else {
 
                 Flash::addMessage('Ups! Coś poszło nie tak. spróbuj ponownie później.' , $type='info');
                 $this->indexAction();
             }       
        
         }else{
             Flash::addMessage('Tej kategorii wydatku nie można usuwać ani edytować.' , $type='warning');
             $this->indexAction();
        }
    }

    //methods for managing payment methods

    /**
     * Delete chosen payment method
     * 
     * @return void
     */
    public function deletePaymentMethodAction()
    {
        $payment_method_id = $_POST['methodId'];
        
       if ($_POST['methodName'] != "Inne")
        {
         if(Expense::deleteSinglePaymentMethod( $payment_method_id))
            {
                Flash::addMessage('Wybrana metoda płatności została usunięta.');
                $this->indexAction();

            } else {

                Flash::addMessage('Ups! Coś poszło nie tak. spróbuj ponownie później.' , $type='info');
                $this->indexAction();
            }
        }else{
            Flash::addMessage('Tej metody płatności nie można usuwać ani edytować.' , $type='warning');
            $this->indexAction();
       }
    }



    /**
     * Add a new payment method 
     * 
     * @return void
     */
    public function addNewPaymentMethodAction()
    {
        $new_method_name = $_POST['new_method_name'];

        $new_method_name = Settings::mb_ucfirst($new_method_name, 'UTF-8', true);
    
        if(!Expense::MethodExists($new_method_name))
        {
            if(Expense::addNewPaymentMethod($new_method_name))
            {
               Flash::addMessage('Dodano nową metodę płatności.');
                $this->indexAction(); 

            } else {
                Flash::addMessage('Ups! Coś poszło nie tak. Wpisz poprawną nazwę nowej metody płatności lub spróbuj ponownie później.' , $type='info');
                $this->indexAction();
            }
           
        } else {

            Flash::addMessage('Metoda płatności o takiej nazwie już istnieje.' , $type='warning');
            $this->indexAction();
        } 
    }

    /**
     * Update a name of existing payment method
     * 
     * @return void 
     */
    public function updatePaymentMethodAction()
    {
      
    }



    //methods for managing profile data 

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
