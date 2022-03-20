<?php

namespace App\Controllers;

use \Core\View;

/**
 * MainMenu controller
 *
 * PHP version 7.4
 */
class MainMenu extends Authenticated
{

    /**
     * Show the main menu  page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('MainMenu/new.html');
    }
}
