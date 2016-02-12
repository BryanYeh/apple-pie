<?php
namespace Modules\Members\Controllers;

use Core\Controller,
    Core\View,
    Core\Router,
    Core\Error,
    Helpers\Auth\Auth as AuthHelper,
    Models\Users,
    Modules\Members\Models\Members as MembersModel;


class Members extends Controller
{
    private $auth;
    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new AuthHelper();
        $this->user = new Users();

        if ($this->auth->isLogged()) {
            $u_id = $this->auth->currentSessionInfo()['uid'];
            $this->user->update($u_id);
        }

        $this->user->cleanOfflineUsers();
    }

    /**
     * Routes for this Members Module
     */
    public function routes()
    {
        Router::any('members','Modules\Members\Controllers\Members@members');
        Router::any('online-members','Modules\Members\Controllers\Members@online');
        Router::any('profile/(:any)','Modules\Members\Controllers\Members@viewProfile');
        Router::any('edit-profile/(:any)','Modules\Members\Controllers\Members@editProfile');
    }

    /**
     * Part of page for Member status
     */
    public function index()
    {
        $onlineUsers = new MembersModel();
        $data['activatedAccounts'] = count($onlineUsers->getActivatedAccounts());
        $data['onlineAccounts'] = count($onlineUsers->getOnlineAccounts());

        View::renderModule('Members/views/online_users',$data);
    }


    /**
     * Page for list of activated accounts
     */
    public function members()
    {
        $onlineUsers = new MembersModel();
        $data['title'] = 'Members';
        $data['isLoggedIn'] = $this->auth->isLogged();
        $data['members'] = $onlineUsers->getMembers();

        View::renderTemplate('header', $data);
        View::renderModule('Members/views/members', $data);
        View::renderTemplate('footer', $data);
    }

    /**
     * Page for list of online accounts
     */
    public function online()
    {
        $onlineUsers = new MembersModel();
        $data['title'] = 'Members';
        $data['isLoggedIn'] = $this->auth->isLogged();
        $data['members'] = $onlineUsers->getOnlineMembers();

        View::renderTemplate('header', $data);
        View::renderModule('Members/views/members', $data);
        View::renderTemplate('footer', $data);
    }

    /**
     * Get profile by username
     * @param $username
     */
    public function viewProfile($username)
    {
        $onlineUsers = new MembersModel();
        $profile = $onlineUsers->getUserProfile($username);
        if(sizeof($profile)>0){
            $data['title'] = $username . "'s Profile";
            $data['profile'] = $profile[0];
            $data['isLoggedIn'] = $this->auth->isLogged();
            View::renderTemplate('header', $data);
            View::renderModule('Members/views/view_profile', $data);
            View::renderTemplate('footer', $data);
        }
        else
            Error::error404();
    }
}