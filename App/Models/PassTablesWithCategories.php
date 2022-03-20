<?php

namespace App\Models;

use \App\Token;
use PDO;

/**
 * Pass category tables model
 *
 * PHP version 7.4
 */
class PassTablesWithCategories extends \Core\Model
{
    /**
     * Find user id by activation token 
     * 
     * @param string $value Activation token from the URL
     * 
     * @return $id user id 
     */
    protected static function findUserIDByToken($value)
    {
        $token = new Token($value);
        $hashed_token = $token->getHash();
        $sql = 'SELECT id FROM users
        WHERE activation_hash = :token_hash LIMIT 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->execute();
        $row= $stmt->fetch();
        $id=  $row['id'];
    
        return $id;
    }

    /**
     * pass the default tables incomes-category, expenses-category, payment-methods to the ones assigned to the user
     * 
     * @return void
     */

    public static function passTablesAfterActivation($value)
    {
        $id = PassTablesWithCategories::findUserIDByToken($value);
     
        //payment method
       $sql = 'INSERT INTO payment_methods_assigned_to_users (payment_methods_assigned_to_users.name,
                payment_methods_assigned_to_users.user_id)
                SELECT payment_methods_default.name, :id FROM payment_methods_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute(); 

        //expense categories
        
        $sql = 'INSERT INTO incomes_category_assigned_to_users (incomes_category_assigned_to_users.name,
        incomes_category_assigned_to_users.user_id)
        SELECT incomes_category_default.name, :id FROM incomes_category_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute(); 

        //incomes categories 

        $sql = 'INSERT INTO expenses_category_assigned_to_users (expenses_category_assigned_to_users.name,
        expenses_category_assigned_to_users.user_id)
        SELECT expenses_category_default.name, :id FROM expenses_category_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute(); 
    }




}
