<?php
namespace Modules\Members\Controllers;

use Core\Controller,
    Core\View,
    Core\Router,
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

    public function index()
    {
        $onlineUsers = new MembersModel();
        $data['activatedAccounts'] = count($onlineUsers->getActivatedAccounts());
        $data['onlineAccounts'] = count($onlineUsers->getOnlineAccounts());

        View::renderModule('Members/views/online_users',$data);
    }

    public function routes()
    {
        Router::any('members','Modules\Members\Controllers\Members@members');
    }

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

}