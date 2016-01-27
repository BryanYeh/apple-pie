<?php

namespace Controllers;


use Core\Controller,
    Helpers\Auth\Auth as AuthHelper,
    Helpers\Csrf,
    Helpers\Url;

class Auth extends Controller
{

    private $auth;

    public function __construct()
    {
        parent::__construct();
        $this->language->load('Welcome');
        $this->auth = new AuthHelper();

        if($this->auth->isLogged()){
            $u_id = $this->auth->currentSessionInfo()['uid'];
            //put the user in the online table using $u_id
        }
    }

    /**
     * Log in the user
     */
    public function login()
    {
        if($this->auth->isLogged())
            Url::redirect();

        if(isset($_POST['submit']) && Csrf::isTokenValid()){

        }

    }

    /**
     * Log the user out
     */
    public function logout()
    {
        if($this->auth->isLogged()){
            $u_id = $this->auth->currentSessionInfo()['uid'];
            //remove the user from the online table using $u_id
            $this->auth->logout();
        }
        Url::redirect();
    }

    /**
     * Register an account
     */
    public function register()
    {
        if($this->auth->isLogged())
            Url::redirect();

        if(isset($_POST['submit']) && Csrf::isTokenValid()){

        }
    }

    /**
     * Activate an account
     */
    public function activate(){
        if($this->auth->isLogged())
            Url::redirect();

        if(isset($_GET['username']) && isset($_GET['key'])){

        }
    }

    /**
     * Account settings
     */
    public function settings(){
        if(!$this->auth->isLogged())
            Url::redirect('login');

    }

    /**
     * Change user's password
     */
    public function changePassword(){
        if(!$this->auth->isLogged())
            Url::redirect('login');

    }

    /**
     * Change user's email
     */
    public function changeEmail(){
        if(!$this->auth->isLogged())
            Url::redirect('login');

    }

    /**
     * Forgotten password
     */
    public function forgotPassword(){
        if($this->auth->isLogged())
            Url::redirect();

    }

    /**
     * Reset password
     */
    public function resetPassword(){
        if($this->auth->isLogged())
            Url::redirect('login');

    }

    /**
     * Resend activation for email
     */
    public function resendActivation(){
        if(!$this->auth->isLogged())
            Url::redirect('login');

    }
}