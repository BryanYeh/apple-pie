<?php


namespace Modules\Members\Models;


use Core\Model;

class Members extends Model
{
    public function getActivatedAccounts()
    {
        return $this->db->select('SELECT * FROM '.PREFIX.'users WHERE isactive = true');
    }

    public function getOnlineAccounts()
    {
        return $this->db->select('SELECT * FROM '.PREFIX.'users_online ');
    }

    public function getMembers()
    {
        return $this->db->select("
				SELECT
					u.userID,
					u.username,
					u.firstName,
					u.isactive,
					ug.userID,
					ug.groupID,
					g.groupID,
					g.groupName,
					g.groupFontColor,
					g.groupFontWeight
				FROM
					".PREFIX."users u
				LEFT JOIN
					".PREFIX."users_groups ug
					ON u.userID = ug.userID
				LEFT JOIN
					".PREFIX."groups g
					ON ug.groupID = g.groupID
				WHERE
					u.isactive = true
				GROUP BY
					u.userID
				ORDER BY
					u.userID ASC, g.groupID DESC");
    }

    public function getOnlineMembers(){
        return $this->db->select("
				SELECT
					u.userID,
					u.username,
					u.firstName,
					uo.userID,
					ug.userID,
					ug.groupID,
					g.groupID,
					g.groupName,
					g.groupFontColor,
					g.groupFontWeight
				FROM
					uap_users_online uo
				LEFT JOIN
					uap_users u
					ON u.userID = uo.userID
				LEFT JOIN
					uap_users_groups ug
					ON uo.userID = ug.userID
				LEFT JOIN
					uap_groups g
					ON ug.groupID = g.groupID
				GROUP BY
					u.userID
				ORDER BY
					u.userID ASC, g.groupID DESC");
    }
}