<?php

namespace App\Models;
use PDO;

/**
 * Income model
 *
 * PHP version 7.4
 */
class Income extends \Core\Model
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

    /**
     * Find income categories names by activation token 
     * 
     * @param string $value Activation token from the URL
     * 
     * @return $categories
     */
    public static function getIncomeCategories()
    {
        $id= $_SESSION['user_id'];

        $sql = 'SELECT name, id FROM incomes_category_assigned_to_users
        WHERE user_id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $categories = $stmt->fetchAll();
      
        return $categories;
    }

    /**
     * Save the income model with the current property values
     *
     * @return boolean  True if the income was saved, false otherwise
     */
    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            $category_name = $this->category;
            $category_id = $this->extractCategoryIdByName($category_name);

            $sql = 'INSERT INTO incomes
            VALUES ( NULL, :id , :category_id ,:amount, :date, :comment)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
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
            $this->errors[] = 'Kwota przychodu nie może być mniejsza od 0.';
        }

        // date
        $date_now = date("Y-m-d"); 
        if ($this->date > $date_now) {
            $this->errors[] = 'Data przychodu nie może być późniejsza od dzisiejszej';
        }

        if ($this->date == '') {
            $this->errors[] = 'Podaj datę przychodu.';
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
        $sql = 'SELECT id FROM incomes_category_assigned_to_users
        WHERE user_id= :id AND name=  :category_name limit 1';

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

    /**
     * delete all income categories assigned to the user
     * 
     * @return boolean
     */
    public static function deleteLinkedIncomeCategories() 
    {
        $sql = 'DELETE FROM incomes_category_assigned_to_users
        WHERE user_id = :user_id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * delete all of the user's incomes
     * 
     * @return boolean
     */
    public static function deleteAllIncomes() 
    {
        $sql = 'DELETE FROM incomes
        WHERE user_id = :user_id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);

        return $stmt->execute();
    }

  
}
