<?php
namespace IonPot\AddressBook\Model;

use \IonPot\AddressBook\Common\EntityDaoDecorator;
use \IonPot\AddressBook\Common\U;
use IonPot\AddressBook\Common\GenericDaoDecorator;

/*
 * This is a domain class.
 * Mostly it does data access.
 * In selected functions, it includes business logic also.
 */
class Group extends EntityDaoDecorator
{

    public $tblName = "tbl_contact_group";

    public function processUIGroup($id, $index)
    {
        $ary = null;
        U::buildAry($ary, "contact_id", $id);
        U::buildAry($ary, "group_name", $index);
        U::buildAry($ary, "create_at", date("Y-m-d H:i:s"));
        return $ary;
    }

    public function addGroup($id, $i)
    {
        $ary = $this->processUIGroup($id, $i);
        $id = $this->insert($ary);
        return $id;
    }

    public function getGroupByContactID($id)
    {
        $result = $this->getByField("contact_id", $id, "i");
        return $result;
    }

    public function deleteGroupById($id)
    {
        $result = $this->deleteByField("contact_id", $id, "i");
        return $result;
    }

    public function getGroup()
    {
        $sql = "SELECT DISTINCT group_name FROM tbl_contact_group";
        $gDao = new GenericDaoDecorator();
        $result = $gDao->getByBaseQuery($sql);
        return $result;
    }
}
