<?php

namespace Controllers;


use Core\Controller,
    Core\View,
    Helpers\Auth\Auth as AuthHelper,
    Helpers\Csrf,
    Helpers\Url,
    Helpers\Request;


class Auth extends Controller
{

    private $auth;

    public function __construct()
    {
        parent::__construct();
        $this->language->load('Welcome');
        $this->auth = new AuthHelper();

        if ($this->auth->isLogged()) {
            $u_id = $this->auth->currentSessionInfo()['uid'];
            //put the user in the online table using $u_id
        }

    }

    /**
     * Log in the user
     */
    public function login()
    {
        if ($this->auth->isLogged())
            Url::redirect();

        if (isset($_POST['submit']) && Csrf::isTokenValid()) {
            $username = Request::post('username');
            $password = Request::post('password');
            $rememberMe = Request::post('rememberMe');

            $email = $this->auth->checkIfEmail($username);
            $username = count($email) != 0 ? $email[0]->username : $username;

            if ($this->auth->login($username, $password)) {
                Url::redirect();
            }
        }

        $data['csrf_token'] = Csrf::makeToken();
        $data['title'] = 'Login to Account';
        $data['isLoggedIn'] = $this->auth->isLogged();
        View::renderTemplate('header', $data);
        View::renderTemplate('login', $data);
        View::renderTemplate('footer', $data);
    }

    /**
     * Log the user out
     */
    public function logout()
    {
        if ($this->auth->isLogged()) {
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
        //Redirect user to home page if he is already logged in
        if ($this->auth->isLogged())
            Url::redirect();

        //The form is submmited
        if (isset($_POST['submit'])) {

            //Check the CSRF token first
            if(Csrf::isTokenValid()) {
                $captcha_fail = false;

                //Check the reCaptcha if the public and private keys were provided
                if (RECAP_PUBLIC_KEY != "" && RECAP_PRIVATE_KEY != "") {
                    if (isset($_POST['g-recaptcha-response'])) {
                        $gRecaptchaResponse = $_POST['g-recaptcha-response'];

                        $recaptcha = new \ReCaptcha\ReCaptcha(RECAP_PRIVATE_KEY);
                        $resp = $recaptcha->verify($gRecaptchaResponse);
                        if (!$resp->isSuccess())
                            $captcha_fail = true;
                    }
                }

                //Only continue if captcha did not fail
                if (!$captcha_fail) {
                    $username = Request::post('username');
                    $password = Request::post('password');
                    $verifypassword = Request::post('confirmPassword');
                    $email = Request::post('email');

                    //register with our without email verification
                    $registered = ACCOUNT_ACTIVATION ?
                        $this->auth->register($username, $password, $verifypassword, $email) :
                        $this->auth->directRegister($username, $password, $verifypassword, $email);

                    if ($registered) {
                        $data['message'] = ACCOUNT_ACTIVATION ?
                            "Registration Successful! Check Your Email For Activating your Account." :
                            "Registration Successful! Click <a href='".DIR."login'>Login</a> to login.";
                        $data['type'] = "success";
                    }
                    else{
                        $data['message'] = "Registration Error: Please try again";
                        $data['type'] = "error";
                    }
                }
                else{
                    $data['message'] = "Stop being a spambot";
                    $data['type'] = "error";
                }
            }
            else{
                $data['message'] = "Stop trying to hack!";
                $data['type'] = "error";
            }
        }

        $data['csrf_token'] = Csrf::makeToken();
        $data['title'] = 'Register for an Account';
        $data['isLoggedIn'] = $this->auth->isLogged();
        //needed for recaptcha
        if (RECAP_PUBLIC_KEY != "" && RECAP_PRIVATE_KEY != "") {
            $data['ownjs'] = array(
                "<script src='https://www.google.com/recaptcha/api.js?onload=onloadCallback&amp;render=explicit' async defer></script>",
                "<script type='text/javascript'>
                    var onloadCallback = function() {
                        grecaptcha.render('html_element', {'sitekey' : '".RECAP_PUBLIC_KEY."'});
                    };
                </script>");
        }
        View::renderTemplate('header', $data);
        View::renderTemplate('register', $data);
        View::renderTemplate('footer', $data);
    }

    /**
     * Activate an account
     */
    public function activate($username,$activekey)
    {
        if ($this->auth->isLogged())
            Url::redirect();


        if($this->auth->activateAccount($username, $activekey)) {
            $data['message'] = "Your Account Has Been Activated!  You may <a href='" . DIR . "login'>Login</a> now.";
            $data['type'] = 'success';
        }
        else{
            $data['message'] = "Account Activation <strong>Failed</strong>! Try again by <a href='".DIR."resend-activation-email'>requesting a new activation key</a>";
            $data['type'] = 'error';
        }

        $data['title'] = 'Account Activation';
        $data['isLoggedIn'] = $this->auth->isLogged();
        View::renderTemplate('header', $data);
        View::renderTemplate('activate', $data);
        View::renderTemplate('footer', $data);
    }

    /**
     * Account settings
     */
    public function settings()
    {
        if (!$this->auth->isLogged())
            Url::redirect('login');

    }

    /**
     * Change user's password
     */
    public function changePassword()
    {
        if (!$this->auth->isLogged())
            Url::redirect('login');

    }

    /**
     * Change user's email
     */
    public function changeEmail()
    {
        if (!$this->auth->isLogged())
            Url::redirect('login');

    }

    /**
     * Forgotten password
     */
    public function forgotPassword()
    {
        if ($this->auth->isLogged())
            Url::redirect();

    }

    /**
     * Reset password
     */
    public function resetPassword()
    {
        if ($this->auth->isLogged())
            Url::redirect('login');

    }

    /**
     * Resend activation for email
     */
    public function resendActivation()
    {
        if ($this->auth->isLogged())
            Url::redirect('login');

    }
}