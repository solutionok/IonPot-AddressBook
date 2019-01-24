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
class MemberForgot extends EntityDaoDecorator
{

    public $tblName = "tbl_member_forgot";

    public function addRecovery($memberId)
    {
        $ary = null;
        U::buildAry($ary, "member_id", $memberId);
        $resetToken = $this->getToken(97);
        U::buildAry($ary, "reset_token", $resetToken);
        U::buildAry($ary, "is_valid", 1);
        $time = date('Y-m-d H:i:s');
        U::buildAry($ary, "create_at", $time);
        $id = $this->insert($ary);

        return $resetToken;
    }

    public function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i ++) {
            $token .= $codeAlphabet[$this->cryptoRandSecure(0, $max)];
        }
        return $token;
    }

    public function cryptoRandSecure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) {
            return $min; // not so random...
        }
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public function getMemberForgotByResetToken($recoveryToken)
    {
        $ary = null;
        U::buildAry($ary, "reset_token", $recoveryToken, "s", "AND");
        U::buildAry($ary, "is_valid", 1, "i");
        $result = $this->get($ary);
        return $result;
    }

    public function expireForgotResetToken($id)
    {
        $ary = null;
        U::buildAry($ary, "is_valid", 0);
        $id = $this->update($ary, "id", $id, "i");
        return $id;
    }
}
