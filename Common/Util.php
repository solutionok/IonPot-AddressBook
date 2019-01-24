<?php
namespace IonPot\AddressBook\Common;

use \DateTime;

class Util
{

    public function validateDate($format, $date)
    {
        if (DateTime::createFromFormat($format, $date)) {
            $date = date("Y-m-d", strtotime($date));
            return $date;
        } else {
            return 0;
        }
    }

    /*
     * returns the server root url without trailing slash.
     * example output: http://localhost
     *
     */
    public function getRootUrl()
    {
        $root = (! empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        return $root;
    }

    public function getClientUrl()
    {
        $pageURL = 'http';
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

    /**
     * Retrieves the best guess of the client's actual IP address.
     * Takes into account numerous HTTP proxy headers due to variations
     * in how different ISPs handle IP addresses in headers between hops.
     */
    public function getIpAddress()
    {
        // Check for shared internet/ISP IP
        if (! empty($_SERVER['HTTP_CLIENT_IP']) && $this->validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        // Check for IPs passing through proxies
        if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Check if multiple IP addresses exist in var
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if ($this->validate_ip($ip)) {
                    return $ip;
                }
            }
        }

        if (! empty($_SERVER['HTTP_X_FORWARDED']) && $this->validate_ip($_SERVER['HTTP_X_FORWARDED'])) {
            return $_SERVER['HTTP_X_FORWARDED'];
        }
        if (! empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && $this->validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        }
        if (! empty($_SERVER['HTTP_FORWARDED_FOR']) && $this->validate_ip($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }
        if (! empty($_SERVER['HTTP_FORWARDED']) && $this->validate_ip($_SERVER['HTTP_FORWARDED'])) {
            return $_SERVER['HTTP_FORWARDED'];
        }

        // Return unreliable IP address since all else failed
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Ensures an IP address is both a valid IP address and does not fall within
     * a private network range.
     *
     * @access public
     * @param string $ip
     */
    public function validateIp($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        self::$ip = $ip;
        return true;
    }

    public function getTimeAgo($mySqlTimestamp)
    {

        // converting the mysql timestamp to php time
        $timestamp = strtotime($mySqlTimestamp);
        $periods = array(
            "second",
            "minute",
            "hour",
            "day",
            "week",
            "month",
            "year"
        );
        $lengths = array(
            "60",
            "60",
            "24",
            "7",
            "4.35",
            "12"
        );
        $current_timestamp = time();
        if ($current_timestamp > $timestamp) {
            $difference = $current_timestamp - $timestamp;
        } else {
            $difference = 0;
        }
        for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i ++) {
            $difference /= $lengths[$i];
        }
        $difference = round($difference);
        if (isset($difference)) {
            if ($difference != 1) {
                $periods[$i] .= "s";
            }
            $output = "$difference $periods[$i] ago";
            return $output;
        }
    }

    public function dateFormat($mySqlTimestamp)
    {
        // converting the mysql timestamp to php time
        $timestamp = strtotime($mySqlTimestamp);
        $output = date("j F Y", $timestamp);
        return $output;
    }

    public function cleanUrl($str, $options = array())
    {
        $delimiter = "-";
        $str = str_replace(' ', $delimiter, $str); // Replaces all spaces with hyphens.
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str); // allows only alphanumeric and -
        $str = trim($str, $delimiter); // remove delimiter from both ends
        $regexConseqChars = '/' . $delimiter . $delimiter . '+/';
        $str = preg_replace($regexConseqChars, $delimiter, $str); // remove consequtive delimiter
        $str = mb_strtolower($str, 'UTF-8'); // convert to all lower
        return $str;
    }

    public function getAge($dob, $tdate)
    {
        $d1 = new DateTime($dob);
        $d2 = new DateTime($tdate);
        $age = $d2->diff($d1);
        return $age->y;
    }

    public function createDateRangeArray($strDateFrom, $strDateTo)
    {
        $aryRange = array();

        $iDateFrom = strtotime($strDateFrom);
        $iDateTo = strtotime($strDateTo);

        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom));
            while ($iDateFrom < $iDateTo) {
                $iDateFrom += 86400;
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        return $aryRange;
    }
}
