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

        $sql = 'SELECT id,name FROM expenses_category_assigned_to_users
        WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $categories = $stmt->fetchAll();
      
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

    public static function MethodExists($new_method_name)
    {
        if(Expense::extractPaymentMethodIdByName($new_method_name) != 0)
        {
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

    public static function CategoryExists($new_category_name)
    {
        if(Expense::extractCategoryIdByName($new_category_name) != 0)
        {
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
 
}
