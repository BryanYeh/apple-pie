<?php

namespace Models;

/**
 * Class Users
 * @package Models
 */
use Core\Model;

class Users extends Model
{
    /**
     * Add user to online table
     * @param $userID
     */
    public function add($userID)
    {
$data = array('userID' => $userID ,'lastAccess' => date('Y-m-d G:i:s'));
var_dump($data);
var_dump($this->db->insert(PREFIX."users_online",$data));
    }

    /**
     * Update user to latest login time
     * @param $userID
     */
    public function update($userID)
    {
        $query = $this->db->select('SELECT * FROM '.PREFIX.'users_online WHERE userID = :userID ', array(':userID' => $userID));
        $count = count($query);
        if($count == 0){
            self::add($userID);
        }else{
            $data = array('lastAccess' => date('Y-m-d G:i:s'));
            $where = array('userID' => $userID);
            $this->db->update(PREFIX."users_online",$data,$where);
        }
    }

    /**
     * Get current user's id from database
     * @param $where_username
     * @return int
     */
    public function getUserID($where_username)
    {
        $data = $this->db->select("SELECT userID FROM ".PREFIX."users WHERE username = :username",
            array(':username' => $where_username));
        return $data[0]->userID;
    }

    /**
     * Remove user from online status - Logged Out or Idle
     * @param $userID
     * @return int
     */
    public function remove($userID)
    {
        return $this->db->delete(PREFIX.'users_online', array('userId' => $userID));
    }

    public function cleanOfflineUsers(){
        return $this->db->delete_open(PREFIX.'users_online WHERE unix_timestamp(date_add(lastAccess, interval 30 minute)) < unix_timestamp(now()) ');
    }
}