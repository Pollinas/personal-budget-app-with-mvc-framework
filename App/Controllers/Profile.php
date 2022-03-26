<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\User;


/**
 * Edit controller
 *
 * PHP version 7.4
 */
class Profile extends Authenticated
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
     * Show the profile page
     *
     * @return void
     */
    public function showAction()
    {

        View::renderTemplate('Profile/show.html',[
            'user' => $this->user
        ]);
    }

    /**
     * update the profile data 
     * 
     * @return void
     */

  public function updateProfileAction()
 {
     if($this->user->updateProfile($_POST)){
         Flash::addMessage('Nowe dane zostały zapisane.');
        $this->redirect('/Profile/show');
     }
     else{
        Flash::addMessage('Dane profilowe nie zostały zmienione.', $type='warning');
         View::renderTemplate('Profile/show.html',[
             'user' => $this->user
         ]);
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
            Flash::addMessage('Hasło zostało zmienione.');
            $this->redirect('/Profile/show');
        }
        else{
            Flash::addMessage('Hasło nie zostało zmienione.');
            View::renderTemplate('Profile/show.html',[
               'user' => $this->user 
            ]);
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
            Flash::addMessage('Konto i wszystkie dane z nim powiązane zostały usunięte.');
            $this->redirect('/');
        }
        else{
            Flash::addMessage('Ups! Coś poszło nie tak.');
            View::renderTemplate('Profile/show.html',[
               'user' => $this->user 
            ]);
        }
    }
    
}
