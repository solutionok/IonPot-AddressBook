<?php
namespace IonPot\AddressBook\Model;

use \IonPot\AddressBook\Common\EntityDaoDecorator;
use \IonPot\AddressBook\Common\U;

/*
 * This is a domain class.
 * Mostly it does data access.
 * In selected functions, it includes business logic also.
 */
class Custom extends EntityDaoDecorator
{

    public $tblName = "tbl_contact_custom";

    public function processUICustom($id, $index) {
        $ary = null;
        U::buildAry($ary, "contact_id", $id);
        U::buildAry($ary, "label", $_POST["label"][$index]);
        U::buildAry($ary, "value", $_POST["value"][$index]);
        U::buildAry($ary, "create_at", date("Y-m-d H:i:s"));
        return $ary;
    }

    public function addCustom($id, $index)
    {
        $ary = $this->processUICustom($id, $index);
        $id = $this->insert($ary);
        return $id;
    }

    public function getCustomByContactID($id)
    {
        $result = $this->getByField("contact_id", $id, "i");
        return $result;
    }

    public function deletecustomById($id)
    {
        $result = $this->deleteByField("contact_id", $id, "i");
        return $result;
    }

    public function deletecustomaddById($id)
    {
        $result = $this->deleteByField("id", $id, "i");
        return $result;
    }
    public function addCustomFields($id, $customLabel, $customValue)
    {
        $ary = null;
        U::buildAry($ary, "contact_id", $id);
        U::buildAry($ary, "label", $customLabel);
        U::buildAry($ary, "value", $customValue);
        U::buildAry($ary, "create_at", date("Y-m-d H:i:s"));
        $id = $this->insert($ary);
        return $id;
    }
}
