<?php
namespace Modules\Online\Controllers;

use Core\Controller,
    Core\View,
    Core\Router,
    Helpers\Auth\Auth as AuthHelper,
    Models\Users,
    Modules\Online\Models\Online as OnlineUser;

class Online extends Controller
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

    public function index()
    {
        $onlineUsers = new OnlineUser();
        $data['activatedAccounts'] = count($onlineUsers->getActivatedAccounts());
        $data['onlineAccounts'] = count($onlineUsers->getOnlineAccounts());

        View::renderModule('Online/views/online_users',$data);
    }

    public function routes()
    {
        Router::any('members','Modules\Online\Controllers\Online@members');
    }

    public function members()
    {
        $onlineUsers = new OnlineUser();
        $data['title'] = 'Members';
        $data['isLoggedIn'] = $this->auth->isLogged();
        $data['members'] = $onlineUsers->getMembers();

        View::renderTemplate('header', $data);
        View::renderModule('Online/views/members', $data);
        View::renderTemplate('footer', $data);
    }

}