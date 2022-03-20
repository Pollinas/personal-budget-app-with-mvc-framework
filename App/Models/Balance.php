<?php

namespace App\Models;
use PDO;

/**
 *Balance model
 *
 * PHP version 7.4
 */
class Balance extends \Core\Model
{
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
     * 
     */
    protected static function getPreviousMonth()
    {
        $current_date = date("Y-m-d");
        $previous_month= date("m",mktime(0,0,0,date("m", strtotime($current_date))-1,1,date("Y", strtotime($current_date))));
        return $previous_month;
    }

    /**
     * get current month incomes from the db 
     * 
     * @return $incomes array
     */
     
    public static function getCurrentMonthIncomes()
    {
        $current_month= date("m");
        $sql = 'SELECT date_of_income, amount, income_comment, name
        FROM incomes_category_assigned_to_users, incomes 
        WHERE EXTRACT(MONTH FROM date_of_income) = :current_month AND incomes.user_id = :id 
        AND incomes_category_assigned_to_users.user_id = incomes.user_id 
        AND incomes_category_assigned_to_users.id = incomes.income_category_assigned_to_user_id
        ORDER BY date_of_income ASC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':current_month', $current_month, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $incomes= $stmt->fetchAll();

        return $incomes;
    }

    /**
     * get previous month incomes from the db 
     * 
     * @return $incomes array
     */
    public static function getPreviousMonthIncomes()
    {
         $previous_month= Balance::getPreviousMonth();

        $sql = 'SELECT date_of_income, amount, income_comment, name
        FROM incomes_category_assigned_to_users, incomes 
        WHERE EXTRACT(MONTH FROM date_of_income) = :previous_month AND incomes.user_id = :id 
        AND incomes_category_assigned_to_users.user_id = incomes.user_id 
        AND incomes_category_assigned_to_users.id = incomes.income_category_assigned_to_user_id
        ORDER BY date_of_income ASC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':previous_month', $previous_month, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $incomes= $stmt->fetchAll();

        return $incomes;
    }

    /**
     * get incomes from the current year from the db 
     * 
     * @return $incomes array
     */
    public static function getCurrentYearIncomes()
    {
        $current_year = date("Y");

        $sql = 'SELECT date_of_income, amount, income_comment, name
        FROM incomes_category_assigned_to_users, incomes 
        WHERE EXTRACT(YEAR FROM date_of_income) = :current_year
         AND incomes.user_id = :id 
        AND incomes_category_assigned_to_users.user_id = incomes.user_id 
        AND incomes_category_assigned_to_users.id = incomes.income_category_assigned_to_user_id
        ORDER BY date_of_income ASC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':current_year', $current_year, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $incomes= $stmt->fetchAll();

        return $incomes;
    }


    /**
     * get custom incomes from the db 
     * 
     * @return $incomes array
     */
    public static function getCustomIncomes($begin, $end)
    {
        $sql = 'SELECT date_of_income, amount, income_comment, name
        FROM incomes_category_assigned_to_users, incomes 
        WHERE date_of_income BETWEEN  :begin AND  :end
         AND incomes.user_id = :id 
        AND incomes_category_assigned_to_users.user_id = incomes.user_id 
        AND incomes_category_assigned_to_users.id = incomes.income_category_assigned_to_user_id
        ORDER BY date_of_income DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':begin', $begin, PDO::PARAM_STR);
        $stmt->bindValue(':end', $end, PDO::PARAM_STR);
        $stmt->execute();
        $incomes= $stmt->fetchAll();

        return $incomes;
    }

   /**
     * get current month expenses from the db 
     * 
     * @return $expenses array
     */ 
    public static function getCurrentMonthExpenses()
    {
        $current_month= date("m");

        $sql = 'SELECT date_of_expense, amount, expense_comment, 
         expenses_category_assigned_to_users.name AS category,
        payment_methods_assigned_to_users.name AS method
        FROM expenses_category_assigned_to_users, expenses ,payment_methods_assigned_to_users
        WHERE EXTRACT(MONTH FROM date_of_expense) = :current_month AND expenses.user_id = :id
        AND expenses_category_assigned_to_users.user_id = expenses.user_id 
        AND expenses_category_assigned_to_users.id = expenses.expense_category_assigned_to_user_id
        AND payment_methods_assigned_to_users.user_id = expenses.user_id 
        AND payment_methods_assigned_to_users.id = expenses.payment_method_assigned_to_user_id
        ORDER BY date_of_expense ASC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':current_month', $current_month, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $expenses= $stmt->fetchAll();

        return $expenses;
    }

     /**
     * get current month expenses from the db 
     * 
     * @return $expenses array
     */ 
    public static function getPreviousMonthExpenses()
    {
        $previous_month= Balance::getPreviousMonth();

        $sql = 'SELECT date_of_expense, amount, expense_comment,
         expenses_category_assigned_to_users.name AS category,
        payment_methods_assigned_to_users.name AS method
        FROM expenses_category_assigned_to_users, expenses , payment_methods_assigned_to_users
        WHERE EXTRACT(MONTH FROM date_of_expense) = :previous_month AND expenses.user_id = :id 
        AND expenses_category_assigned_to_users.user_id = expenses.user_id 
        AND expenses_category_assigned_to_users.id = expenses.expense_category_assigned_to_user_id
        AND payment_methods_assigned_to_users.user_id = expenses.user_id 
        AND payment_methods_assigned_to_users.id = expenses.payment_method_assigned_to_user_id
        ORDER BY date_of_expense ASC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':previous_month', $previous_month, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $expenses= $stmt->fetchAll();

        return $expenses;
    }

    /**
     * get expenses from the current year from the db 
     * 
     * @return $expenses array
     */ 
    public static function getCurrentYearExpenses()
    {
        $current_year = date("Y");

        $sql = 'SELECT date_of_expense, amount, expense_comment, 
        expenses_category_assigned_to_users.name AS category,
        payment_methods_assigned_to_users.name AS method
        FROM expenses_category_assigned_to_users, expenses , payment_methods_assigned_to_users
        WHERE EXTRACT(YEAR FROM date_of_expense) = :current_year
        AND expenses.user_id = :id 
        AND expenses_category_assigned_to_users.user_id = expenses.user_id 
        AND expenses_category_assigned_to_users.id = expenses.expense_category_assigned_to_user_id
        AND payment_methods_assigned_to_users.user_id = expenses.user_id 
        AND payment_methods_assigned_to_users.id = expenses.payment_method_assigned_to_user_id
        ORDER BY date_of_expense ASC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':current_year', $current_year, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $expenses= $stmt->fetchAll();

        return $expenses;
    }

      /**
     * get custom expenses from the db 
     * 
     * @return $expenses array
     */   
    public static function getCustomExpenses($begin, $end)
    {
        $sql = 'SELECT date_of_expense, amount, expense_comment, 
         expenses_category_assigned_to_users.name AS category,
        payment_methods_assigned_to_users.name AS method
        FROM expenses_category_assigned_to_users, expenses, payment_methods_assigned_to_users
        WHERE date_of_expense BETWEEN :begin AND :end
        AND expenses.user_id = :id 
        AND expenses_category_assigned_to_users.user_id = expenses.user_id 
        AND expenses_category_assigned_to_users.id = expenses.expense_category_assigned_to_user_id
        AND payment_methods_assigned_to_users.user_id = expenses.user_id 
        AND payment_methods_assigned_to_users.id = expenses.payment_method_assigned_to_user_id
        ORDER BY date_of_expense DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':begin', $begin, PDO::PARAM_STR);
        $stmt->bindValue(':end', $end, PDO::PARAM_STR);
        $stmt->execute();
        $incomes= $stmt->fetchAll();

        return $incomes;
    }

    /**
     * function to calculate the balance, used in all periods
     * 
     * @return $balance division between $incomes sum and $expenses_sum
     */

    protected static function calculate($incomes_sum, $expenses_sum)
    {
        $balance = $incomes_sum - $expenses_sum;
        return $balance;
    }

    public static function getCurrentMonthBalance()
    {
        $incomes_sum = Balance::getCurrentMonthIncomesSum();
        $expenses_sum = Balance::getCurrentMonthExpensesSum();
        $balance = Balance::calculate($incomes_sum, $expenses_sum);
        return $balance; 
    }

    protected static function getCurrentMonthIncomesSum()
    {
        $current_month= date("m");

        $sql = 'SELECT SUM(amount) AS sum FROM incomes
        WHERE incomes.user_id = :id AND EXTRACT(MONTH FROM date_of_income) = :current_month limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':current_month', $current_month, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row= $stmt->fetch();
        $incomes_sum= $row['sum'];
    
        return  $incomes_sum;
    }

    protected static function getCurrentMonthExpensesSum()
    {
        $current_month= date("m");

        $sql = 'SELECT SUM(amount) AS sum FROM expenses 
        WHERE EXTRACT(MONTH FROM date_of_expense) = :current_month AND expenses.user_id = :id  limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':current_month', $current_month, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row= $stmt->fetch();
        $expenses_sum= $row['sum'];
    
        return  $expenses_sum;
    }

    public static function getPreviousMonthBalance()
    {
        $incomes_sum = Balance::getPreviousMonthIncomesSum();
        $expenses_sum = Balance::getPreviousMonthExpensesSum();
        $balance = Balance::calculate($incomes_sum, $expenses_sum);
        return $balance; 
    }

    protected static function getPreviousMonthIncomesSum()
    {
        $previous_month= Balance::getPreviousMonth();

        $sql = 'SELECT SUM(amount) AS sum FROM incomes
        WHERE  incomes.user_id = :id AND EXTRACT(MONTH FROM date_of_income) = :previous_month limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':previous_month', $previous_month, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row= $stmt->fetch();
        $incomes_sum= $row['sum'];
    
        return  $incomes_sum;
    }

    protected static function getPreviousMonthExpensesSum()
    {
        $previous_month= Balance::getPreviousMonth();

        $sql = 'SELECT SUM(amount) AS sum FROM expenses 
        WHERE EXTRACT(MONTH FROM date_of_expense) = :previous_month AND expenses.user_id = :id  limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':previous_month', $previous_month, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row= $stmt->fetch();
        $expenses_sum= $row['sum'];
    
        return  $expenses_sum;
    }

    public static function getCurrentYearBalance()
    {
        $incomes_sum = Balance::getCurrentYearIncomesSum();
        $expenses_sum = Balance::getCurrentYearExpensesSum();
        $balance = Balance::calculate($incomes_sum, $expenses_sum);
        return $balance; 
    }

    protected static function getCurrentYearIncomesSum()
    {
        $current_year = date("Y");

        $sql = 'SELECT SUM(amount) AS sum FROM incomes
        WHERE  incomes.user_id = :id AND EXTRACT(YEAR FROM date_of_income) = :current_year limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':current_year', $current_year, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row= $stmt->fetch();
        $incomes_sum= $row['sum'];
    
        return  $incomes_sum;
    }

    protected static function getCurrentYearExpensesSum()
    {
        $current_year = date("Y");

        $sql = 'SELECT SUM(amount) AS sum FROM expenses 
        WHERE EXTRACT(YEAR FROM date_of_expense) = :current_year AND expenses.user_id = :id  limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':current_year',$current_year, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row= $stmt->fetch();
        $expenses_sum= $row['sum'];
    
        return  $expenses_sum;
    }

    public static function getCustomBalance($begin, $end)
    {
        $incomes_sum = Balance::getCustomIncomesSum($begin, $end);
        $expenses_sum = Balance::getCustomExpensesSum($begin, $end);
        $balance = Balance::calculate($incomes_sum, $expenses_sum);
        return $balance; 
    }

    protected static function getCustomIncomesSum($begin, $end)
    { 
        $sql = 'SELECT SUM(amount) AS sum FROM incomes
        WHERE  incomes.user_id = :id AND date_of_income BETWEEN :begin AND :end limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':begin', $begin, PDO::PARAM_STR);
        $stmt->bindValue(':end', $end, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row= $stmt->fetch();
        $incomes_sum= $row['sum'];
    
        return  $incomes_sum;
    }

    protected static function getCustomExpensesSum($begin, $end)
    {
        $sql = 'SELECT SUM(amount) AS sum FROM expenses 
        WHERE date_of_expense BETWEEN :begin AND :end AND expenses.user_id = :id  limit 1';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':begin', $begin, PDO::PARAM_STR);
        $stmt->bindValue(':end', $end, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row= $stmt->fetch();
        $expenses_sum= $row['sum'];
    
        return  $expenses_sum;
    }

    /**
     * get incomes' sums from the current month divided into categories 
     *
     * @return $incomes_sums 
     */
    public static function getCurrentMonthIncomesSumsDivedIntoCategories()
    {
        $current_month= date("m");

        $sql = 'SELECT name, SUM(amount) AS sum
        FROM incomes_category_assigned_to_users, incomes
        WHERE EXTRACT(MONTH FROM date_of_income) = :current_month AND incomes.user_id = :id 
        AND incomes_category_assigned_to_users.user_id = incomes.user_id 
        AND incomes_category_assigned_to_users.id = incomes.income_category_assigned_to_user_id
        GROUP BY name ORDER BY sum DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':current_month', $current_month, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $incomes_sums= $stmt->fetchAll();

        return $incomes_sums;
    }

    public static function getCurrentMonthExpensesSumsDivedIntoCategories()
    {
        $current_month= date("m");

        $sql = 'SELECT name, SUM(amount) AS sum
        FROM expenses_category_assigned_to_users, expenses
        WHERE EXTRACT(MONTH FROM date_of_expense) = :current_month AND expenses.user_id = :id 
        AND expenses_category_assigned_to_users.user_id = expenses.user_id 
        AND expenses_category_assigned_to_users.id = expenses.expense_category_assigned_to_user_id
        GROUP BY name ORDER BY sum DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':current_month', $current_month, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $expenses_sums= $stmt->fetchAll();

        return $expenses_sums;
    }

     /**
     * get incomes' sums from the previous month divided into categories 
     *
     * @return $incomes_sums 
     */
    public static function getPreviousMonthIncomesSumsDivedIntoCategories()
    {
        $previous_month= Balance::getPreviousMonth();

        $sql = 'SELECT name, SUM(amount) AS sum
        FROM incomes_category_assigned_to_users, incomes
        WHERE EXTRACT(MONTH FROM date_of_income) = :previous_month AND incomes.user_id = :id 
        AND incomes_category_assigned_to_users.user_id = incomes.user_id 
        AND incomes_category_assigned_to_users.id = incomes.income_category_assigned_to_user_id
        GROUP BY name ORDER BY sum DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':previous_month', $previous_month, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $incomes_sums= $stmt->fetchAll();

        return $incomes_sums;
    }

    public static function getPreviousMonthExpensesSumsDivedIntoCategories()
    {
        $previous_month= Balance::getPreviousMonth();

        $sql = 'SELECT name, SUM(amount) AS sum
        FROM expenses_category_assigned_to_users, expenses
        WHERE EXTRACT(MONTH FROM date_of_expense) = :previous_month AND expenses.user_id = :id 
        AND expenses_category_assigned_to_users.user_id = expenses.user_id 
        AND expenses_category_assigned_to_users.id = expenses.expense_category_assigned_to_user_id
        GROUP BY name ORDER BY sum DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':previous_month', $previous_month, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $expenses_sums= $stmt->fetchAll();

        return $expenses_sums;
    }

    /**
     * get incomes' sums from the current year divided into categories 
     *
     * @return $incomes_sums 
     */
    public static function getCurrentYearIncomesSumsDivedIntoCategories()
    {
        $current_year = date("Y");

        $sql = 'SELECT name, SUM(amount) AS sum
        FROM incomes_category_assigned_to_users, incomes
        WHERE EXTRACT(YEAR FROM date_of_income) = :current_year AND incomes.user_id = :id 
        AND incomes_category_assigned_to_users.user_id = incomes.user_id 
        AND incomes_category_assigned_to_users.id = incomes.income_category_assigned_to_user_id
        GROUP BY name ORDER BY sum DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':current_year', $current_year, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $incomes_sums= $stmt->fetchAll();

        return $incomes_sums;
    }

    public static function getCurrentYearExpensesSumsDivedIntoCategories()
    {
        $current_year = date("Y");

        $sql = 'SELECT name, SUM(amount) AS sum
                        FROM expenses_category_assigned_to_users, expenses
                        WHERE EXTRACT(YEAR FROM date_of_expense) = :current_year AND expenses.user_id = :id 
                        AND expenses_category_assigned_to_users.user_id = expenses.user_id 
                        AND expenses_category_assigned_to_users.id = expenses.expense_category_assigned_to_user_id
                        GROUP BY name ORDER BY sum DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':current_year', $current_year, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $expenses_sums= $stmt->fetchAll();

        return $expenses_sums;
    }

     /**
     * get incomes' sums from the dates between given $begin and $end divided into categories 
     *
     * @return $incomes_sums 
     */
    public static function getCustomIncomesSumsDivedIntoCategories($begin, $end)
    {
        $sql = 'SELECT name, SUM(amount) AS sum
        FROM incomes_category_assigned_to_users, incomes
        WHERE date_of_income BETWEEN :begin AND :end
        AND incomes.user_id = :id 
        AND incomes_category_assigned_to_users.user_id = incomes.user_id 
        AND incomes_category_assigned_to_users.id = incomes.income_category_assigned_to_user_id
        GROUP BY name ORDER BY sum DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':begin', $begin, PDO::PARAM_STR);
        $stmt->bindValue(':end', $end, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $incomes_sums= $stmt->fetchAll();

        return $incomes_sums;
    }

    public static function getCustomExpensesSumsDivedIntoCategories($begin, $end)
    {

        $sql = 'SELECT name, SUM(amount) AS sum
        FROM expenses_category_assigned_to_users, expenses
        WHERE date_of_expense BETWEEN :begin AND :end 
        AND expenses.user_id = :id 
        AND expenses_category_assigned_to_users.user_id = expenses.user_id 
        AND expenses_category_assigned_to_users.id = expenses.expense_category_assigned_to_user_id
        GROUP BY name ORDER BY sum DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':begin', $begin, PDO::PARAM_STR);
        $stmt->bindValue(':end', $end, PDO::PARAM_STR);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();
        $expenses_sums= $stmt->fetchAll();

        return $expenses_sums;
    }




   
}
