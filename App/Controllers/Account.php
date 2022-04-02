<?php

namespace App\Controllers;

use \App\Models\User;
use \App\Models\Expense;
use \App\Models\Income;

/**
 * Account controller
 *
 * PHP version 7.4
 */
class Account extends \Core\Controller
{

  /**
   * Validate if email is available (AJAX) for a new signup.
   *
   * @return void
   */
  public function validateEmailAction()
  {
    $is_valid = ! User::emailExists($_GET['email'], $_GET['ignore_id'] ?? null);

    header('Content-Type: application/json');
    echo json_encode($is_valid);
  }

  /**
   * Validate if method name is available (AJAX) for a new payment method.
   *
   * @return void
   */
  public function validateMethodNameAction()
  {
    $is_valid = ! Expense::MethodExists($_GET['new_method_name'], $_GET['ignore_id'] ?? null);

    header('Content-Type: application/json');
    echo json_encode($is_valid);
  }

  /**
   * Validate if expense category name is available (AJAX) for a new payment method.
   *
   * @return void
   */
  public function validateExpenseCategoryNameAction()
  {
    $is_valid = ! Expense::CategoryExists($_GET['new_category_name'] ,  $_GET['ignore_id'] ?? null);

    header('Content-Type: application/json');
    echo json_encode($is_valid);
  }

  /**
   * Validate if income category name is available (AJAX) for a new payment method.
   *
   * @return void
   */
  public function validateIncomeCategoryNameAction()
  {
    $is_valid = ! Income::CategoryExists($_GET['new_category_name']);

    header('Content-Type: application/json');
    echo json_encode($is_valid);
  }

}
