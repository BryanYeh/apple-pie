<?php


namespace Modules\Online\Models;


use Core\Model;

class Online extends Model
{
    public function getActivatedAccounts()
    {
        return $this->db->select('SELECT * FROM '.PREFIX.'users WHERE isactive = true');
    }

    public function getOnlineAccounts()
    {
        return $this->db->select('SELECT * FROM '.PREFIX.'users_online ');
    }
}