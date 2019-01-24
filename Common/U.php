<?php
namespace IonPot\AddressBook\Common;

/**
 *
 * @author Cycle
 * @version 2.1
 */
class U
{

    public function setErrorHandling()
    {
        register_shutdown_function("\\IonPot\\AddressBook\\Common\\ErrorHandler::checkForFatal");
        set_error_handler("\\IonPot\\AddressBook\\Common\\ErrorHandler::logError");
        set_exception_handler("\\IonPot\\AddressBook\\Common\\ErrorHandler::logException");
        ini_set("display_errors", "off");
        error_reporting(E_ALL);
    }

    // up: &#9650; and down: &#9660;
    public function getSortHead($fieldName, $fieldLabel, $externalQueryString = "")
    {
        $queryString = "?";

        if (! empty($externalQueryString)) {
            $queryString = $queryString . $externalQueryString;
        }

        // To retain search query string
        if (! empty($_GET["q"])) {
            $searchQuery = "q=" . $_GET["q"] . "&";
            $queryString = $queryString . $searchQuery;
        }

        $sortHead = '<a href="' . $queryString . 'o=' . $fieldName;

        $sortIcon = "&#9660";
        $sortStatus = "sortable";
        if (! empty($_GET["o"])) {
            $existingSortField = $_GET["o"];
            if ($existingSortField === $fieldName) {
                $sortStatus = "sorted";
                if (! (! empty($_GET["os"]) && $_GET["os"] === "DESC")) {
                    $sortHead = $sortHead . "&os=DESC";
                    $sortIcon = "&#9650;";
                }
            }
        }

        if (! empty($_GET["start"])) {
            $sortHead = $sortHead . "&start=" . $_GET["start"];
        }
        $sortHead = $sortHead . '">' . $fieldLabel;

        $sortHead = $sortHead . '<span class= "sort-icon ' . $sortStatus . '">' . $sortIcon . '</span>';

        $sortHead = $sortHead . '</a>';
        return $sortHead;
    }

    /**
     * To prepare the WHERE condition part of the sql-query
     * we need the conditions array.
     * The platform's DAO uses
     * the conditions array to form the where condition
     * and also to supply values for insert/update
     *
     * example: id=10 AND name=tom
     *
     * @param unknown $ary
     * @param unknown $fieldName
     * @param unknown $fieldValue
     * @param string $condition
     * @param string $fieldType
     */
    public static function buildAry(& $ary, $fieldName, $fieldValue, $fieldType = "s", $condition = "", $operator = "=")
    {
        $aryIndex = 0;
        if (is_array($ary)) {
            $aryIndex = count($ary);
        }
        $ary[$aryIndex]["Field"] = $fieldName;
        $ary[$aryIndex]["Value"] = $fieldValue;
        $ary[$aryIndex]["Type"] = $fieldType;
        $ary[$aryIndex]["Condition"] = $condition;
        $ary[$aryIndex]["Operator"] = $operator;
        return $ary;
    }

    // xss mitigation functions
    public function xssafe($data, $encoding = 'UTF-8')
    {
        return htmlspecialchars($data, ENT_QUOTES | ENT_HTML401, $encoding);
    }

    public function xecho($data)
    {
        echo $this->xssafe($data);
    }
}
