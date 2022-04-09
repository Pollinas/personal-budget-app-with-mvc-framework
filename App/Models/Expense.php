<?php

namespace App\Models;
use PDO;

/**
 * Income model
 *
 * PHP version 7.4
 */
class Expense extends \Core\Model
{
    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }


    public static function getExpenseCategories()
    {
        $id= $_SESSION['user_id'];

        $sql = 'SELECT id,name, expense_limit FROM expenses_category_assigned_to_users
        WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        return $categories;
    }

    public static function getPaymentMethods()
    {
        $id= $_SESSION['user_id'];

        $sql = 'SELECT id, name FROM payment_methods_assigned_to_users
        WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $methods = $stmt->fetchAll();
      
        return $methods;
    }

    
    /**
     * Save the expense model with the current property values
     *
     * @return boolean  True if the expense was saved, false otherwise
     */
    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

           
            $category_name = $this->category;
            $category_id = Expense::extractCategoryIdByName($category_name);

            $method_name = $this->method;
            $method_id= Expense::extractPaymentMethodIdByName($method_name);

            $sql = 'INSERT INTO expenses
            VALUES ( NULL, :id , :category_id , :payment_method_id, :amount, :date, :comment)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindValue(':payment_method_id', $method_id, PDO::PARAM_INT);
            $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
            $stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);

            return $stmt->execute();
       }

        return false;
    }

    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */
    protected function validate()
    {
        // amount
        if ($this->amount == '') {
            $this->errors[] = 'Podaj kwotę.';
        }

        if ($this->amount < 0) {
            $this->errors[] = 'Kwota wydatku nie może być mniejsza od 0.';
        }

        // date
        $date_now = date("Y-m-d"); 
        if ($this->date > $date_now) {
            $this->errors[] = 'Data wydatku nie może być późniejsza od dzisiejszej';
        }

        if ($this->date == '') {
            $this->errors[] = 'Podaj datę wydatku.';
        }
       
        //category
        if ($this->category == '') {
            $this->errors[] = 'Wybierz kategorię.';
        }

    }

    /**
     * extracting value of the category id by passing it's name 
     * 
     * @return $category_id 
     */
    protected static function extractCategoryIdByName($category_name)
    {
        $sql = 'SELECT id FROM expenses_category_assigned_to_users
        WHERE user_id= :id AND name= :category_name limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':category_name', $category_name, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row= $stmt->fetch();

        $category_id= $row['id'] ?? 0;
    
        return $category_id;

    } 

    protected static function extractPaymentMethodIdByName($method_name)
    {
        $sql = 'SELECT id FROM payment_methods_assigned_to_users
        WHERE user_id = :id AND name= :method_name limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':method_name', $method_name, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $stmt->execute();
     
        $row= $stmt->fetch();
        $method_id= $row['id'] ?? 0;
    
        return $method_id;
   
    }

 /**
     * delete all expense categories assigned to the user
     * 
     * @return boolean
     */
    public static function deleteLinkedExpenseCategories() 
    {
        $sql = 'DELETE FROM expenses_category_assigned_to_users
        WHERE user_id = :user_id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * delete all payment methods assigned to the user
     * 
     * @return boolean
     */
    public static function deleteLinkedPaymentMethods()
    {
        $sql = 'DELETE FROM payment_methods_assigned_to_users
        WHERE user_id = :user_id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * delete all of the user's expenses
     * 
     * @return boolean
     */
    public static function deleteAllExpenses() 
    {
        $sql = 'DELETE FROM expenses
        WHERE user_id = :user_id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }



    /**
     * delete a single payment method
     * 
     * @return boolean
     */
    public static function deleteSinglePaymentMethod($payment_method_id)
    {
        $paymentMethodOtherId = Expense::extractPaymentMethodIdByName('Inne');

        $sql = 'UPDATE expenses
        SET  payment_method_assigned_to_user_id = :other_id';

         $sql .= "\nWHERE payment_method_assigned_to_user_id = :payment_method_id";

        $db = static::getDB();
        $stmt1 = $db->prepare($sql);

        $stmt1->bindValue(':payment_method_id', $payment_method_id, PDO::PARAM_INT);
        $stmt1->bindValue(':other_id', $paymentMethodOtherId, PDO::PARAM_INT);
        

        if($stmt1->execute())
        {
            $sql = 'DELETE FROM payment_methods_assigned_to_users
            WHERE id = :payment_method_id';

            $db = static::getDB();
            $stmt2 = $db->prepare($sql);

            $stmt2->bindValue(':payment_method_id', $payment_method_id, PDO::PARAM_INT);

            return $stmt2->execute();
        }
    }

    /**
     * delete a single expense category
     * 
     * @return boolean
     */
    public static function deleteSingleExpenseCategory($expense_category_id)
    {
       $expenseCategoryOtherId = Expense::extractCategoryIdByName('Inne');

        $sql = 'UPDATE expenses
        SET  expense_category_assigned_to_user_id = :other_id';

         $sql .= "\nWHERE expense_category_assigned_to_user_id = :expense_category_id";

        $db = static::getDB();
        $stmt1 = $db->prepare($sql);

        $stmt1->bindValue(':expense_category_id', $expense_category_id, PDO::PARAM_INT);
        $stmt1->bindValue(':other_id', $expenseCategoryOtherId, PDO::PARAM_INT);
        

        if($stmt1->execute())
        {
            $sql = 'DELETE FROM expenses_category_assigned_to_users
            WHERE id = :expense_category_id';

            $db = static::getDB();
            $stmt2 = $db->prepare($sql);

            $stmt2->bindValue(':expense_category_id', $expense_category_id, PDO::PARAM_INT);

            return $stmt2->execute();
        }
    }

    /**
     * Check if the method with given name exists 
     * 
     * @return boolean ; true if it does, false if it does not
     */

    public static function MethodExists($new_method_name, $ignore_id = null)
    {
        $id = Expense::extractPaymentMethodIdByName($new_method_name);

        if($id != 0)
        {
            if ($id == $ignore_id)
            {
                return false;
            }  
            return true;
            
        } else {
            return false;
        }
    }


    /**
     * Check if the expense category with given name exists 
     * 
     * @return boolean ; true if it does, false if it does not
     */

    public static function CategoryExists($new_category_name , $ignore_id = null)
    {
        $id = Expense::extractCategoryIdByName($new_category_name);

        if($id != 0)
        {
            if ($id == $ignore_id)
            {
                return false;
            }  
            return true;

        } else {
            return false;
        }
    }

     /**
     * Add a new expense category
     * 
     * @return boolean ; true if the category is saved, false otherwise
     */
    public static function addNewExpenseCategory($new_category_name)
    {
        if(Expense::validateNew($new_category_name))
        {
            
            $sql = 'INSERT INTO expenses_category_assigned_to_users
            VALUES ( NULL, :id , :category_name)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':category_name', $new_category_name, PDO::PARAM_STR);

            return $stmt->execute(); 

        } else {
            return false;
        }
    }

       
    /**
     * Edit chosen expense category
     * 
     * @return boolean ; true if the method is saved, false otherwise
     */
    public static function updateExpenseCategory($new_category_name, $category_id, $set_limit = null, $limit = null)
    {
        if(Expense::validateNew($new_category_name))
        {
            $sql = 'UPDATE expenses_category_assigned_to_users
            SET name = :new_category_name,
            expense_limit = :limit';
            
            $sql .= "\nWHERE id = :category_id";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':new_category_name', $new_category_name, PDO::PARAM_STR);
            $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);

        
            if($set_limit != null)
            {
                if($limit != null && $limit != '' && $limit > 0)
                {
                    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue(':limit',NULL, PDO::PARAM_STR);
                }
               
            } else {
                    
                $stmt->bindValue(':limit',NULL, PDO::PARAM_STR);
            }

            return $stmt->execute();

        } else {
            return false;
        }
    }
 

    /**
     * validate a new name- for both payment methods and categories 
     * 
     * @return boolean : true if all is fine, false otherwise
     */
    protected static function validateNew($new_name)
    {
            if ($new_name == '') {
               return false;
            }
    
            if (strlen($new_name) < 4) {
                return false;
            }
            
            if (strlen($new_name) > 20) {
                return false;
            }
            
            return true;
    }

    /**
     * Add a new payment method 
     * 
     * @return boolean ; true if the method is saved, false otherwise
     */
    public static function addNewPaymentMethod($new_method_name)
    {
        if(Expense::validateNew($new_method_name))
        {
        $sql = 'INSERT INTO payment_methods_assigned_to_users
        VALUES ( NULL, :id , :method_name)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':method_name', $new_method_name, PDO::PARAM_STR);

        return $stmt->execute();

        } else {
            return false;
        }
    }

    
    /**
     * Edit chosen method's name
     * 
     * @return boolean ; true if the method is saved, false otherwise
     */
    public static function updatePaymentMethod($new_method_name,  $method_id)
    {
        if(Expense::validateNew($new_method_name))
        {
            $sql = 'UPDATE payment_methods_assigned_to_users
            SET name = :new_method_name';
            
            $sql .= "\nWHERE id = :method_id";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':new_method_name', $new_method_name, PDO::PARAM_STR);
            $stmt->bindValue(':method_id', $method_id, PDO::PARAM_INT);

            return $stmt->execute();

        } else {
            return false;
        }
    }

       
    /**
     * Delete a single expense from expenses table , given the income id 
     * 
     * @return boolean; true if the expense was deleted, false otherwise 
     */

    public static function deleteSingleExpense($id)
    {
        $sql = 'DELETE FROM expenses
        WHERE id = :id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }


    /**
     * validate updated expense
     * 
     * @return boolean ; true if all is ok, false otherwise 
     */
    protected static function validateUpdatedExpense($date, $amount, $category, $method)
    {
        if ($amount == '') {
           return false;
        }

        if ($amount < 0) {
            return false;
        }

        // date
        $date_now = date("Y-m-d"); 
        if ($date > $date_now) {
            return false;
        }

        if ($date == '') {
            return false;
        }
    
        //category
        if ($category == '') {
            return false;
        }

        //method
        if ($method == '') {
            return false ;
        }

        return true;
    }
    
     /**
     * Edit a single income expense in the expense table , given the expense id 
     * 
     * @return boolean; true if the expense was updated, false otherwise 
     */

    public static function editSingleExpense($id, $date, $amount, $category, $comment, $method)
    {

        $expense_category_id = Expense::extractCategoryIdByName($category);
        $payment_method_id =  Expense::extractPaymentMethodIdByName($method);

        if (Expense::validateUpdatedExpense($date, $amount, $category, $method))
        {
            $sql = 'UPDATE expenses
                    SET  amount = :amount,
                    date_of_expense = :date,
                    expense_comment = :comment,
                    expense_category_assigned_to_user_id = :expense_category_id,
                    payment_method_assigned_to_user_id = :payment_method_id';
                
                $sql .= "\nWHERE id = :id";

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
            $stmt->bindValue(':date', $date, PDO::PARAM_STR);
            $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindValue(':expense_category_id', $expense_category_id, PDO::PARAM_INT);
            $stmt->bindValue(':payment_method_id', $payment_method_id, PDO::PARAM_INT);

            return $stmt->execute();
        }
        else 
        {
            return false; 
        }
    }

    /**
     * get category limit given category name 
     * 
     * @return  value if the limit has been set or null if it hasn't
     */
    public static function getCategoryLimit($name)
    {

        $sql = 'SELECT expense_limit FROM expenses_category_assigned_to_users
        WHERE user_id= :id AND name= :category_name limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':category_name', $name, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row= $stmt->fetch();

        return $row['expense_limit'];
    }


    /**
     * get the sum of expenses in the given category in given month 
     * 
     * @return value or 0 if there hasn't been any expenses in the given category in the given month
     */
    public static function getMonthlyExpensesSumInGivenCategory($name, $date)
    {

        $id = Expense::extractCategoryIdByName($name);
        $month = date("m",strtotime($date));
        $year = date("Y", strtotime($date));

        $sql = 'SELECT SUM(amount) AS sum
        FROM expenses
        WHERE expense_category_assigned_to_user_id= :id
        AND EXTRACT(YEAR FROM date_of_expense) = :year
        AND EXTRACT(MONTH FROM date_of_expense) = :month limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':month', $month, PDO::PARAM_INT);
        $stmt->bindValue(':year', $year, PDO::PARAM_INT);
      
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row= $stmt->fetch();

        return $row['sum'] ?? 0;
    }
 
}
