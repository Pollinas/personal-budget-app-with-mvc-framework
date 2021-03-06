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
            'user' => $this->user
        ]);
    }

    /**
     * show the profile settings page 
     * 
     * @return void
     */

    public function profileAction()
    {
        View::renderTemplate('Settings/profile.html',[
            'user' => $this->user
        ]);
    }

    /**
     * show the password settings page 
     * 
     * @return void
     */

    public function passwordAction()
    {
        View::renderTemplate('Settings/password.html',[
            'user' => $this->user
        ]);
    }

     /**
     * show the payment methods settings page 
     * 
     * @return void
     */

    public function methodsAction()
    {
        View::renderTemplate('Settings/methods.html',[
            'methods' => Expense::getPaymentMethods()
        ]);
    }

    
     /**
     * show expense categories settings page 
     * 
     * @return void
     */

    public function expensesAction()
    {
        View::renderTemplate('Settings/expenses.html',[
            'expenseCategories' => Expense::getExpenseCategories()
        ]);
    }
    
     /**
     * show the income categories settings page 
     * 
     * @return void
     */

    public function incomesAction()
    {
        View::renderTemplate('Settings/incomes.html',[
            'incomeCategories' => Income::getIncomeCategories()
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
            Flash::addMessage('All incomes have been deleted.');
            $this->indexAction();
        }
        else{
            Flash::addMessage('Oops! Something went wrong. Please try again later.' , $type='info');  
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
        
        if ($_POST['incomeCategoryName'] != "Other")
         {
           
          if( Income::deleteSingleIncomeCategory($income_category_id) )
             {
                 Flash::addMessage('The selected income category has been deleted.');
                 $this->indexAction();
 
             } else {
 
                 Flash::addMessage('Oops! Something went wrong. Please try again later.' , $type='info');
                 $this->indexAction();
             }       
        
         }else{

              $this->displayInfoWhenTryingToMessWithInneAction();
        }
    }

    
    /**
     * Add a new income category
     * 
     * @return void
     */
    public function addNewIncomeCategoryAction()
    {
        $new_category_name = $_POST['new_category_name'];

        $new_category_name = Settings::mb_ucfirst($new_category_name, 'UTF-8', true);
    
        if(!Income::CategoryExists($new_category_name))
        {
            if(Income::addNewIncomeCategory($new_category_name))
            {
               Flash::addMessage('A new income category has been added.');
               http_response_code(201);
                $this->indexAction(); 

            } else {
                Flash::addMessage('Oops! Something went wrong. Please enter a valid category name or try again later.' , $type='info');
                $this->indexAction();
            }
           
        } else {

            Flash::addMessage('An income category with that name already exists.' , $type='warning');
            $this->indexAction();
        } 
    }

        /**
     * Update a name of existing income category
     * 
     * @return void 
     */
    public function updateIncomeCategoryAction()
    {
        $new_category_name = $_POST['new_category_name'];
        $new_category_name = Settings::mb_ucfirst($new_category_name, 'UTF-8', true);

        $category_id = $_POST['incomeCategoryId'];

        if ($new_category_name != "Other")
        {
    
            if(! Income::CategoryExists($new_category_name, $category_id))
            {
                if(Income::updateIncomeCategory($new_category_name, $category_id))
                {
                Flash::addMessage('The selected income category has been updated.');
                    $this->indexAction(); 

                } else {
                    Flash::addMessage('Oops! Something went wrong. Please enter a valid category name or try again later.' , $type='info');
                    $this->indexAction();
                }
           
        } else {

            Flash::addMessage('An income category with that name already exists.' , $type='warning');
            $this->indexAction();
        }

        } else {

            $this->displayInfoWhenTryingToMessWithInneAction();
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
            Flash::addMessage('All expenses have been deleted.');
            $this->indexAction();
           
        }else{
            Flash::addMessage('Oops! Something went wrong. Please try again later.' , $type='info');
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
        
        if ($_POST['expenseCategoryName'] != "Other")
         {
           
          if( Expense::deleteSingleExpenseCategory($expense_category_id) )
             {
                 Flash::addMessage('The selected expense category has been deleted.');
                 $this->indexAction();
 
             } else {
 
                 Flash::addMessage('Oops! Something went wrong. Please try again later.' , $type='info');
                 $this->indexAction();
             }       
        
         }else{

            $this->displayInfoWhenTryingToMessWithInneAction();
        }
    }

    

    /**
     * Add a new expense category
     * 
     * @return void
     */
    public function addNewExpenseCategoryAction()
    {
        $new_category_name = $_POST['new_category_name'];

        $new_category_name = Settings::mb_ucfirst($new_category_name, 'UTF-8', true);
    
        if(! Expense::CategoryExists($new_category_name))
        {
            if(Expense::addNewExpenseCategory($new_category_name))
            {
               Flash::addMessage('A new expense category has been added.');
               http_response_code(201);
                $this->indexAction(); 

            } else {
                Flash::addMessage('Oops! Something went wrong. Please enter a valid category name or try again later.' , $type='info');
                $this->indexAction();
            }
           
        } else {

            Flash::addMessage('An expense category with that name already exists.' , $type='warning');
            $this->indexAction();
        } 
    }

    /**
     * Update a name of existing expense category
     * 
     * @return void 
     */
    public function updateExpenseCategoryAction()
    {
        $new_category_name = $_POST['new_category_name'];
        $new_category_name = Settings::mb_ucfirst($new_category_name, 'UTF-8', true);

        $category_id = $_POST['expenseCategoryId'];

        if (isset($_POST['set_limit']))
        {
            $set_limit = $_POST['set_limit'];
        }

        if (isset($_POST['limit']))
        {
            $limit = $_POST['limit'];

        }

        if ($new_category_name != "Other")
        {
    
            if(! Expense::CategoryExists($new_category_name, $category_id))
            {
                if(Expense::updateExpenseCategory($new_category_name, $category_id, $set_limit ?? null, $limit ?? null))
                {
                Flash::addMessage('The selected expense category has been updated.');
                    $this->indexAction(); 

                } else {
                    Flash::addMessage('Oops! Something went wrong. Please enter a valid category name or try again later.' , $type='info');
                    $this->indexAction();
                }
           
        } else {

            Flash::addMessage('An expense category with that name already exists.' , $type='warning');
            $this->indexAction();
        }

        } else {

            $this->displayInfoWhenTryingToMessWithInneAction();
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
        
       if ($_POST['methodName'] != "Other")
        {
         if(Expense::deleteSinglePaymentMethod( $payment_method_id))
            {
                Flash::addMessage('The selected payment method has been deleted.');
                $this->indexAction();

            } else {

                Flash::addMessage('Oops! Something went wrong. Please try again later.' , $type='info');
                $this->indexAction();
            }
        }else{

            $this->displayInfoWhenTryingToMessWithInneAction();
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
               Flash::addMessage('A payment method has been added.');
               http_response_code(201);
                $this->indexAction(); 

            } else {
                Flash::addMessage('Oops! Something went wrong. Please enter a valid method name or try again later.' , $type='info');
                $this->indexAction();
            }
           
        } else {

            Flash::addMessage('A payment method with that name already exists.' , $type='warning');
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
        $new_method_name = $_POST['new_method_name'];
        $new_method_name = Settings::mb_ucfirst($new_method_name, 'UTF-8', true);

        $method_id = $_POST['paymentId'];

        if ($new_method_name != "Other")
        {
    
        if(!Expense::MethodExists($new_method_name, $method_id))
        {
            if(Expense::updatePaymentMethod($new_method_name,  $method_id))
            {
               Flash::addMessage('The selected payment method has been updated.');
                $this->indexAction(); 

            } else {
                Flash::addMessage('Oops! Something went wrong. Please enter a valid method name or try again later.' , $type='info');
                $this->indexAction();
            }
           
        } else {

            Flash::addMessage('A payment method with that name already exists.' , $type='warning');
            $this->indexAction();
        }

        } else {

            $this->displayInfoWhenTryingToMessWithInneAction();
        } 
      
    }
    
    protected function displayInfoWhenTryingToMessWithInneAction()
    {
        Flash::addMessage('Payment methods, income and expense categories named "Other" cannot be deleted or edited.' , $type='warning');
        $this->indexAction();
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
          Flash::addMessage('The new data has been saved.');
         $this->indexAction();
      }
      else{
         Flash::addMessage('The profile information has not been changed.', $type='warning');
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
             Flash::addMessage('The password has been changed.');
             $this->indexAction();
         }
         else{
             Flash::addMessage('Something went wrong. Your password hasn\'t been changed. Please try again later.');
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
             Flash::addMessage('The account and all data associated with it has been deleted.');
             $this->redirect('/');
         }
         else{
             Flash::addMessage('Oops! Something went wrong. Please try again later.');
            $this->redirect('/');
         }
     }

    
}
