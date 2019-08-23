<?php
namespace IonPot\AddressBook\Model;

use \IonPot\AddressBook\Common\EntityDaoDecorator;
use \IonPot\AddressBook\Common\U;

/*
 * Self contained domain class
 * This class is a domain and DAO class.
 * Mostly it does data access.
 * In selected functions, it includes business logic also.
 */
class Member extends EntityDaoDecorator
{

    public $tblName = "tbl_member";

    /*
     * Check ADMIN LOGIN
     */
    public function editById($userid) {
        $ary = $this->processUIForm();
        $id = $this->update($ary, "id", $userid, "i");
        return $id;
    }

    public function processUIForm()
    {
        $ary = null;
        if (isset($_POST["username"])) {
            U::buildAry($ary, "username", ltrim($_POST["username"]));
        }
        if (isset($_POST["password"])) {
            if (! empty($_POST["password"])) {
                $inputPassword = $_POST["password"];
                $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);
                U::buildAry($ary, "password", $hashedPassword);
            }
        }
        U::buildAry($ary, "email", $_POST["email"]);
        if (isset($_POST["role"])) {
            U::buildAry($ary, "role", $_POST["role"]);
        }
        return $ary;
    }

    public function adminLogin($isDashboard)
    {
        $username = $_POST["login-username"];
        $password = $_POST["login-password"];

        $result = $this->getByField("username", $username);

        $isSuccess = 0;
        if (! empty($result)) {
            $hashedPassword = $result[0]["password"];
            if (password_verify($password, $hashedPassword)) {
                $isSuccess = 1;
            }

            // to check if the role of this member is allowed to access the Dashboard
            if ($isSuccess == 1 && $isDashboard == true) {
                if (! $this->isDashboardAllowedRole($result[0]["role"])) {
                    $isSuccess = 0;
                }
            }

            if ($isSuccess == 1) {
                $_SESSION["member_id"] = $result[0]["id"];
                $_SESSION["username"] = $result[0]["username"];
                $_SESSION["role"] = $result[0]["role"];
                return $result;
            }
        }
    }

    public function isDashboardAllowedRole($role)
    {
        $allowedRole = array(
            "Admin"
        );
        return in_array($role, $allowedRole);
    }

    public function forgotMember($email)
    {
        $memberList = $this->getByField("email", $email);
        return $memberList;
    }

    public function updatePassword($id, $password)
    {
        $ary = null;

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        U::buildAry($ary, "password", $hashedPassword);

        $id = $this->update($ary, "id", $id, "i");
        return $id;
    }
}
