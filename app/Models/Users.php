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
		$data = array('userId' => $userID ,'lastAccess' => date('Y-m-d G:i:s'));
        $this->db->insert(PREFIX."users_online",$data);

    }

    /**
     * Update user to latest login time
     * @param $userID
     */
    public function update($userID)
    {
        $query = $this->db->select('SELECT * FROM '.PREFIX.'users_online WHERE userId = :userID ', array(':userID' => $userID));
        var_dump( $query);
        $count = count($query);
        if($count == 0){
            self::add($userID);
        }else{
            $data = array('lastAccess' => date('Y-m-d G:i:s'));
            $where = array('userId' => $userID);
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

    public function cleanOfflineUsers()
    {
        $onlines = $this->db->select('SELECT * FROM '.PREFIX.'users_online');
        foreach($onlines as $online){
            echo $online->id . " : " . $online->lastAccess . " : " . date_add((new \DateTime($online->lastAccess))->format('Y-m-d H:i:s'), date_interval_create_from_date_string('2 minute')) . " : " . (date_add($online->lastAccess, date_interval_create_from_date_string('2 minute')) > new DateTime("now")). "<br>";
        }
        return $this->db->delete_open(PREFIX.'users_online WHERE now() > date_add(lastAccess, interval 30 minute) ');
    }
}