<?php
namespace IonPot\AddressBook\Model;

use \IonPot\AddressBook\Common\EntityDaoDecorator;
use \IonPot\AddressBook\Common\U;
use \IonPot\AddressBook\Common\GenericDaoDecorator;

/*
 * This is a domain class.
 * Mostly it does data access.
 * In selected functions, it includes business logic also.
 */
class Contact extends EntityDaoDecorator
{

    public $tblName = "tbl_contact";

    public function processUIForm(){
        $ary = null;
        U::buildAry($ary, "name", ltrim($_POST["name"]));
        U::buildAry($ary, "nick_name", $_POST["nick_name"]);
        U::buildAry($ary, "company", $_POST["company"]);
        U::buildAry($ary, "job_title", $_POST["job_title"]);
        if (! empty($_POST["date_of_birth"])) {
            U::buildAry($ary, "birth_dt", date("Y-m-d", strtotime($_POST["date_of_birth"])));
        } else {
            U::buildAry($ary, "birth_dt", null);
        }
        U::buildAry($ary, "geo", $_POST["geo"]);
        U::buildAry($ary, "user_email", $_POST["user_email"]);
        U::buildAry($ary, "user_mobile_no", $_POST["user_mobile_no"]);
        U::buildAry($ary, "user_landline_no", $_POST["user_landline_no"]);
        U::buildAry($ary, "user_residential_no", $_POST["user_residential_no"]);
        U::buildAry($ary, "user_office_no", $_POST["user_office_no"]);
        U::buildAry($ary, "destination", $_POST["destination"]);
        U::buildAry($ary, "user_address", $_POST["user_address"]);
        U::buildAry($ary, "user_city", $_POST["user_city"]);
        U::buildAry($ary, "user_state", $_POST["user_state"]);
        U::buildAry($ary, "website", $_POST["website"]);
        U::buildAry($ary, "relationship", $_POST["relationship"]);
        U::buildAry($ary, "im", $_POST["im"]);
        U::buildAry($ary, "notes", $_POST["notes"]);
        U::buildAry($ary, "create_at", date("Y-m-d H:i:s"));
        U::buildAry($ary, "edit_at", date("Y-m-d H:i:s"));
        if (! empty($_POST["image_url"])) {
            U::buildAry($ary, "user_photo", $_POST["image_url"]);
        }
        return $ary;
    }

    public function deletePhoto($photoUrl)
    {
        if ($photoUrl != null) {
            $imageFolder = explode("/", $photoUrl);
            unlink("data/" . $photoUrl);
            rmdir("data/" . $imageFolder[0]);
        }
    }

    public function deleteImage($id)
    {
        $ary = null;
        $image = $this->getById($id);
        $imageFolder = explode("/", $image[0]["user_photo"]);
        unlink("data/" . $image[0]["user_photo"]);
        rmdir("data/" . $imageFolder[0]);
        U::buildAry($ary, "user_photo", "", "s");
        $result = $this->update($ary, "id", $id, "i");
        return $result;
    }

    public function toggleFavorite($workroot, $toggleStatus, $id)
    {
        $ary = null;
        U::buildAry($ary, "favorite", $toggleStatus, "i");
        $result = $this->update($ary, "id", $id, "i");
        return $result;
    }

    public function contactSearch($conditionFieldAry, $orderFieldAry, $keyword = "")
    {
        $start = 0;
        if (! empty($_GET["start"])) {
            $start = $_GET["start"];
        }

        if (! empty($keyword)) {
            $conditionFieldAry = [];
            
            if(isset($keyword['uname'])&&$keyword['uname']){
                U::buildAry($conditionFieldAry, 'name', '%'.$keyword['uname'].'%', 's', 'AND', 'LIKE');
            }
            
            if(isset($keyword['POR'])&&$keyword['POR']){
                U::buildAry($conditionFieldAry, '(user_mobile_no like "%'.$keyword['POR'].'%" or user_office_no like "%'.$keyword['POR'].'%" or user_residential_no like "%'.$keyword['POR'].'%")', '1', 's', 'AND');
            }
            
            if(isset($keyword['email'])&&$keyword['email']){
                U::buildAry($conditionFieldAry, 'user_email', '%'.$keyword['email'].'%', 's', 'AND', 'LIKE');
            }
            
            if(isset($keyword['EDG'])&&$keyword['EDG']){
                U::buildAry($conditionFieldAry, '(relationship like "%'.$keyword['EDG'].'%" or destination like "%'.$keyword['EDG'].'%" or company like "%'.$keyword['EDG'].'%")', '1', 's', 'AND');
            }
            
        }
        $result = $this->getByOffset($start, LIMIT_PER_PAGE, $conditionFieldAry, $orderFieldAry);
        
        return $result;
    }

    public function contactSearchCount($keyword = "")
    {
        $conditionFieldAry = "";
        if (! empty($keyword)) {
            $conditionFieldAry = [];
            
            if(isset($keyword['uname'])&&$keyword['uname']){
                U::buildAry($conditionFieldAry, 'name', '%'.$keyword['uname'].'%', 's', 'AND', 'LIKE');
            }
            
            if(isset($keyword['POR'])&&$keyword['POR']){
                U::buildAry($conditionFieldAry, '(user_mobile_no like "%'.$keyword['POR'].'%" or user_office_no like "%'.$keyword['POR'].'%" or user_residential_no like "%'.$keyword['POR'].'%")', '1', 's', 'AND');
            }
            
            if(isset($keyword['email'])&&$keyword['email']){
                U::buildAry($conditionFieldAry, 'user_email', '%'.$keyword['email'].'%', 's', 'AND', 'LIKE');
            }
            
            if(isset($keyword['EDG'])&&$keyword['EDG']){
                U::buildAry($conditionFieldAry, '(relationship like "%'.$keyword['EDG'].'%" or destination like "%'.$keyword['EDG'].'%" or company like "%'.$keyword['EDG'].'%")', '1', 's', 'AND');
            }
            
        }
        $count = $this->getCount($conditionFieldAry);
        return $count;
    }

    public function getCondition($keyword)
    {
        $ary = null;
        U::buildAry($ary, 'name', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'nick_name', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'company', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'job_title', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'user_email', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'user_mobile_no', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'user_landline_no', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'user_residential_no', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'user_office_no', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'destination', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'user_address', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'user_city', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'user_state', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'website', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'relationship', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'im', '%' . $keyword . '%', 's', 'OR', 'LIKE');
        U::buildAry($ary, 'notes', '%' . $keyword . '%', 's', null, 'LIKE');
        return $ary;
    }

    public function groupSearch($conditionFieldAry, $orderFieldAry)
    {
        $start = 0;
        if (! empty($_GET["start"])) {
            $start = $_GET["start"];
        }
        if (! empty($orderFieldAry)) {
            if ($orderFieldAry[0]["Field"] == "id") {
                $orderFieldAry[0]["Field"] = $this->tblName . ".id";
            }
        }
        $baseQuery = "SELECT * FROM tbl_contact_group JOIN tbl_contact ON tbl_contact.id = tbl_contact_group.contact_id ";
        $gDao = new GenericDaoDecorator();
        $result = $gDao->getByOffset($start, LIMIT_PER_PAGE, $conditionFieldAry, $orderFieldAry, $baseQuery);
        return $result;
    }

    public function groupSearchCount($conditionFieldAry)
    {
        $baseQuery = "SELECT count(*) as count FROM tbl_contact_group JOIN tbl_contact ON tbl_contact.id = tbl_contact_group.contact_id ";
        $gDao = new GenericDaoDecorator();
        $result = $gDao->get($conditionFieldAry, null, $baseQuery);
        return $result[0]["count"];
    }

    public function getFilterAry()
    {
        $ary = null;
        if (! empty($_GET["from-dt"])) {
            if (! empty($_GET["to-dt"])) {
                U::buildAry($ary, 'birth_dt', date("Y-m-d", strtotime($_GET["from-dt"])), 's', 'AND', '>=');
            }
        }
        $condition = null;
        if (! empty($_GET["to-dt"])) {
            if (! empty($_GET["search-group"])) {
                $condition = "AND";
            }
            U::buildAry($ary, 'birth_dt', date("Y-m-d", strtotime($_GET["to-dt"])), 's', $condition, '<=');
        }
        if (! empty($_GET["search-group"])) {
            U::buildAry($ary, 'group_name', $_GET["search-group"], 's', null, '=');
        }
        return $ary;
    }

    public function addContactExcel($contactInfo)
    {
        $ary = null;
        U::buildAry($ary, "name", $contactInfo["A"]);
        U::buildAry($ary, "nick_name", $contactInfo["B"]);
        U::buildAry($ary, "company", $contactInfo["C"]);
        U::buildAry($ary, "job_title", $contactInfo["D"]);
        U::buildAry($ary, "birth_dt", date("Y-m-d", strtotime($contactInfo["E"])));
        U::buildAry($ary, "geo", $contactInfo["F"]);
        U::buildAry($ary, "user_email", $contactInfo["G"]);
        U::buildAry($ary, "user_mobile_no", $contactInfo["H"]);
        U::buildAry($ary, "user_address", $contactInfo["I"]);
        U::buildAry($ary, "user_city", $contactInfo["J"]);
        U::buildAry($ary, "user_state", $contactInfo["K"]);
        U::buildAry($ary, "website", $contactInfo["L"]);
        U::buildAry($ary, "relationship", $contactInfo["M"]);
        U::buildAry($ary, "im", $contactInfo["N"]);
        U::buildAry($ary, "notes", $contactInfo["O"]);
        U::buildAry($ary, "favorite", $contactInfo["P"]);
        $id = $this->insert($ary);
        return $id;
    }
    public function insertData($contactInfo)
    {
        $ary = null;
        U::buildAry($ary, "name", $contactInfo[1]);
        U::buildAry($ary, "user_mobile_no", $contactInfo[2]);
        U::buildAry($ary, "user_landline_no", $contactInfo[3]);
        U::buildAry($ary, "user_residential_no", $contactInfo[4]);
        U::buildAry($ary, "user_office_no", $contactInfo[5]);
        U::buildAry($ary, "user_email", $contactInfo[6]);
        U::buildAry($ary, "destination", $contactInfo[7]);
        U::buildAry($ary, "relationship", $contactInfo[8]);
        $id = $this->insert($ary);
        return $id;
    }
}
