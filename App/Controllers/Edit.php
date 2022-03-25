<?php

namespace App\Controllers;

use \Core\View;


/**
 * Edit controller
 *
 * PHP version 7.4
 */
class Profile extends Authenticated
{

    /**
     * Show the add income  page
     *
     * @return void
     */
    public function showAction()
    {

        View::renderTemplate('Edit/show.html');
    }

    
}
