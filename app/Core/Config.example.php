<?php
/**
 * Config - an example for setting up system settings.
 * When you are done editing, rename this file to 'Config.php'.
 *
 * @author David Carr - dave@daveismyname.com
 * @author Edwin Hoksberg - info@edwinhoksberg.nl
 * @version 2.2
 * @date June 27, 2014
 * @date updated Sept 19, 2015
 */

namespace Core;

use Helpers\Session;

/**
 * Configuration constants and options.
 */
class Config
{
    /**
     * Executed as soon as the framework runs.
     */
    public function __construct()
    {
        /**
         * Turn on output buffering.
         */
        ob_start();

        /**
         * Define relative base path.
         */
        define('DIR', '/');

        /**
         * Set default controller and method for legacy calls.
         */
        define('DEFAULT_CONTROLLER', 'welcome');
        define('DEFAULT_METHOD', 'index');

        /**
         * Set the default template.
         */
        define('TEMPLATE', 'default');

        /**
         * Set a default language.
         */
        define('LANGUAGE_CODE', 'en');

        //database details ONLY NEEDED IF USING A DATABASE

        /**
         * Database engine default is mysql.
         */
        define('DB_TYPE', 'mysql');

        /**
         * Database host default is localhost.
         */
        define('DB_HOST', 'localhost');

        /**
         * Database name.
         */
        define('DB_NAME', 'dbname');

        /**
         * Database username.
         */
        define('DB_USER', 'username');

        /**
         * Database password.
         */
        define('DB_PASS', 'password');

        /**
         * PREFER to be used in database calls default is smvc_
         */
        define('PREFIX', 'uap_');

        /**
         * Set prefix for sessions.
         */
        define('SESSION_PREFIX', 'uap_');

        /**
         * Optional create a constant for the name of the site.
         */
        define('SITETITLE', 'V2.2');

        /**
         * Optionall set a site email address.
         */
        //define('SITEEMAIL', '');

        /**
         * Turn on custom error handling.
         */
        set_exception_handler('Core\Logger::ExceptionHandler');
        set_error_handler('Core\Logger::ErrorHandler');

        /**
         * Set timezone.
         */
        date_default_timezone_set('Europe/London');

        /**
         * reCAPTCHA keys
         */
        define("RECAP_PUBLIC_KEY", ''); // reCAPCHA site key
        define("RECAP_PRIVATE_KEY", ''); // reCAPCHA secret key



        /**
         * Auth Helpers necessities
         */
        // Name of website to appear in emails
        define("SITE_NAME", "Test");

        // Email FROM address for Auth emails (Activation, password reset...)
        define("EMAIL_FROM", "someemail@email.com");

        // INT : Max number of attempts for login before user is locked out
        define("MAX_ATTEMPTS", 5);

        // URL to Auth Class installation root WITH trailing slash
        define("BASE_URL", "http://localhost/");

        // Account activation route
        define("ACTIVATION_ROUTE", 'activate');

        // Account needs email activation, false=no true=yes
        define("ACCOUNT_ACTIVATION",false);

        // Account password reset route
        define("RESET_PASSWORD_ROUTE", 'resetpassword');

        //How long a session lasts : Default = +1 month
        define("SESSION_DURATION", "+1 month");

        //Max attempts for logging in
        define("SECURITY_DURATION", "+5 minutes");

        //INT cost of BCRYPT algorithm
        define("COST", 10);

        //INT hash length of BCRYPT algorithm
        define("HASH_LENGTH", 22);

        // Language of Auth Class output : en / fr /es / de
        define("LOC", "es");

        // min length of username
        define('MIN_USERNAME_LENGTH', 5);

        // max length of username
        define('MAX_USERNAME_LENGTH', 30);

        // min length of password
        define('MIN_PASSWORD_LENGTH', 5);

        // max length of password
        define('MAX_PASSWORD_LENGTH', 30);

        //max length of email
        define('MAX_EMAIL_LENGTH', 100);

        // min length of email
        define('MIN_EMAIL_LENGTH', 5);

        //random key used for password reset or account activation
        define('RANDOM_KEY_LENGTH', 15);

        $waittime = preg_replace("/[^0-9]/", "", SECURITY_DURATION); //DO NOT MODIFY
        // this is the same as SECURITY_DURATION but in number format
        define('WAIT_TIME', $waittime); //DO NOT MODIFY

        /**
         * Start sessions.
         */
        Session::init();
    }
}
