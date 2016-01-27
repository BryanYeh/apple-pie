<?php
/**
 * Routes - all standard routes are defined here.
 *
 * @author David Carr - dave@daveismyname.com
 * @version 2.2
 * @date updated Sept 19, 2015
 */

/** Create alias for Router. */
use Core\Router;
use Helpers\Hooks;

/** Define routes. */
Router::any('', 'Controllers\Welcome@index');
Router::any('subpage', 'Controllers\Welcome@subPage');

Router::any('login', 'Controllers\Auth@login');
Router::any('logout', 'Controllers\Auth@logout');
Router::any('register', 'Controllers\Auth@register');
Router::any('activate', 'Controllers\Auth@activate');
Router::any('settings', 'Controllers\Auth@settings');
Router::any('edit-password', 'Controllers\Auth@changePassword');
Router::any('edit-email', 'Controllers\Auth@changeEmail');
Router::any('forgot-password', 'Controllers\Auth@forgotEmail');
Router::any('reset-password', 'Controllers\Auth@resetPassword');
Router::any('resend-activation-email', 'Controllers\Auth@resendActivation');


/** Module routes. */
$hooks = Hooks::get();
$hooks->run('routes');

/** If no route found. */
Router::error('Core\Error@index');

/** Turn on old style routing. */
Router::$fallback = false;

/** Execute matched routes. */
Router::dispatch();
