<?php
use \IonPot\AddressBook\Service\UploadHandler;

require_once "../../Common/Config.php";
$dataFolderPath = DATA_FOLDER;

// Include the upload handler class
require_once "../../Service/UploadHandler.php";
$uploader = new UploadHandler();

// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
$uploader->allowedExtensions = array(); // all files types allowed by default

// Specify max file size in bytes.
$uploader->sizeLimit = null;

// Specify the input name set in the javascript.
$uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

// If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
$uploader->chunksFolder = "../../data/chunks";

// $method = $_SERVER["REQUEST_METHOD"];

// This will retrieve the "intended" request method. Normally, this is the
// actual method of the request. Sometimes, though, the intended request method
// must be hidden in the parameters of the request. For example, when attempting to
// send a DELETE request in a cross-origin environment in IE9 or older, it is not
// possible to send a DELETE request. So, we send a POST with the intended method,
// DELETE, in a "_method" parameter.

global $HTTP_RAW_POST_DATA;

// This should only evaluate to true if the Content-Type is undefined
// or unrecognized, such as when XDomainRequest has been used to
// send the request.
if (isset($HTTP_RAW_POST_DATA)) {
    parse_str($HTTP_RAW_POST_DATA, $_POST);
}

if (isset($_POST["_method"]) && $_POST["_method"] != null) {
    return $_POST["_method"];
}

$method = $_SERVER["REQUEST_METHOD"];

$headers = array();
foreach ($_SERVER as $key => $value) {
    if (substr($key, 0, 5) != 'HTTP_') {
        continue;
    }
    $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
    $headers[$header] = $value;
}
$_HEADERS = $headers;

// Determine whether we are dealing with a regular ol' XMLHttpRequest, or
// an XDomainRequest
$_HEADERS = parseRequestHeaders();
$iframeRequest = false;
if (! isset($_HEADERS['X-Requested-With']) || $_HEADERS['X-Requested-With'] != "XMLHttpRequest") {
    $iframeRequest = true;
}

/*
 * handle the preflighted OPTIONS request. Needed for CORS operation.
 */
if ($method == "OPTIONS") {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, DELETE");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Cache-Control");
} /*
   * handle a DELETE request or a POST with a _method of DELETE.
   */
elseif ($method == "DELETE") {
    header("Access-Control-Allow-Origin: *");

    $result = $uploader->handleDelete($dataFolderPath);

    // iframe uploads require the content-type to be 'text/html' and
    // return some JSON along with self-executing javascript (iframe.ss.response)
    // that will parse the JSON and pass it along to Fine Uploader via
    // window.postMessage
    if ($iframeRequest == true) {
        header("Content-Type: text/html");
        echo json_encode($result) . "<script src='http://10.0.2.2/jquery.fineuploader-4.1.1/iframe.xss.response-4.1.1.js'></script>";
    } else {
        echo json_encode($result);
    }
} elseif ($method == "POST") {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: text/plain");

    // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
    // For example: /myserver/handlers/endpoint.php?done
    if (isset($_GET["done"])) {
        $result = $uploader->combineChunks($dataFolderPath);
    } else {
        // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
        $result = $uploader->handleUpload($dataFolderPath);

        // To return a name used for uploaded file you can use the following line.
        $result["uploadName"] = $uploader->getUploadName();

        // iframe uploads require the content-type to be 'text/html' and
        // return some JSON along with self-executing javascript (iframe.ss.response)
        // that will parse the JSON and pass it along to Fine Uploader via
        // window.postMessage
        if ($iframeRequest == true) {
            header("Content-Type: text/html");
            echo json_encode($result) . "<script src='http://{{SERVER_URL}}/{{FINE_UPLOADER_FOLDER}}/iframe.xss.response.js'></script>";
        } else {
            echo json_encode($result);
        }
    }
} else {
    header("HTTP/1.0 405 Method Not Allowed");
}
