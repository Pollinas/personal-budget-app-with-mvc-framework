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

        $sql = 'SELECT name FROM expenses_category_assigned_to_users
        WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_COLUMN);
      
        return $categories;
    }

    public static function getPaymentMethods()
    {
        $id= $_SESSION['user_id'];

        $sql = 'SELECT name FROM payment_methods_assigned_to_users
        WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $methods = $stmt->fetchAll(PDO::FETCH_COLUMN);
      
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

            //wywołanie metod do porbania category id i payment method 
            $category_name = $this->category;
            $category_id = $this->extractCategoryIdByName($category_name);

            $method_name = $this->method;
            $method_id= $this->extractPaymentMethodIdByName($method_name);

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
    protected function extractCategoryIdByName($category_name)
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
        $category_id= $row['id'];
    
        return $category_id;

    } 

    protected function extractPaymentMethodIdByName($method_name)
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
        $method_id= $row['id'];
    
        return $method_id;
    }





  
}
