<?php
namespace IonPot\AddressBook\Common;

/**
 *
 * @author Cycle
 * @version 2.0
 */
class ErrorHandler
{

    /**
     * Error handler, passes flow over the exception logger with new ErrorException.
     */
    public static function logError($num, $str, $file, $line, $context = null)
    {
        if (stripos($file, "DataSource.php")) {
            $e = new \ErrorException("Error Establishing a Database Connection.");
            $showDetail = false;
        } else {
            $e = new \ErrorException($str, 0, $num, $file, $line);
            $showDetail = true;
        }
        self::logException($e, $showDetail);
    }

    /**
     * Uncaught exception handler.
     */
    public static function logException(\Exception $e, $showDetail = false)
    {
        $message = date('d-m-Y H:i:s a (T)') . "," . $e->getFile() . "," . $e->getLine() . "," . $e->getCode() . "," . get_class($e) . "," . $e->getMessage() . "," . $_SERVER['REQUEST_URI'] . "," . $e->getTraceAsString() . PHP_EOL;

        // TODO: work on rolling file appender based on file size
        error_log($message, 3, LOG_FILE);

        if (DEBUG) {
            print "<html><style>td {padding:8px;}body {font-family: Verdana, Geneva, sans-serif;}table {width: 90%;display: inline-block;text-align: left;}th {font-size: .9em;padding-left: 8px;padding-right: 8px;}</style><body>";

            print "<div style='text-align: center;'>";
            print "<h2 style='color: rgb(190, 50, 50);'>Unexpected Runtime Exception!</h2>";
            print "<table>";
            print "<tr style='background-color:rgb(230,140,140);'><th>Message</th>

<td style=\"font-size: 1.3em;\">{$e->getMessage()}</td></tr>";
            if ($showDetail) {
                print "<tr style='background-color:rgb(230,230,230);'><th>File</th><td>{$e->getFile()}</td></tr>";
                print "<tr style='background-color:rgb(240,240,240);'><th>Line</th><td>{$e->getLine()}</td></tr>";
                ?>
<tr style='background-color: rgb(240, 240, 240);'>
    <th>Trace</th>
    <td
        style='font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace; font-size: 1.2em;'>
<?php

                print(nl2br($e->getTraceAsString()))?></td>
</tr>

<?php
            }
            print "<tr style='background-color:rgb(240,240,240);'><th>REQUEST_URI</th><td>{$_SERVER['REQUEST_URI']}</td></tr>";
            print "<tr style='background-color:rgb(240,240,240);'><th>Timestamp</th><td>" . date('d-m-Y H:i:s a (T)') . "</td></tr>";
            print "</table></div></body></html>";
        } else {
            $error_msg = "Issue with the application and sorry for the inconvenience.";

            // TODO: need to test email
            // mail(ADMIN_EMAIL,$message, $errors , $head);

            // TODO: Think about redirecting - redirect is not good.
            // header( "Location: {ERROR_PAGE}" );
        }

        exit();
    }

    /**
     * Checks for a fatal error, work around for set_error_handler not working on fatal errors.
     */
    public static function checkForFatal()
    {
        // need to fix this function
        $error = error_get_last();

        // if ( $error["type"] == E_ERROR )
        if (! empty($error)) {
            self::logError($error["type"], $error["message"], $error["file"], $error["line"]);
        }
    }
}

?>