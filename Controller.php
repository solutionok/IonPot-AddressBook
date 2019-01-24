<?php
namespace IonPot\AddressBook;

use \IonPot\AddressBook\Common\Dao;
use \IonPot\AddressBook\Common\U;
use \IonPot\AddressBook\Common\ErrorHandler;
use \IonPot\AddressBook\Model\Contact;
use \IonPot\AddressBook\Model\Custom;
use \IonPot\AddressBook\Model\Group;
use \IonPot\AddressBook\Model\Member;
use \IonPot\AddressBook\Model\MemberForgot;
use \IonPot\AddressBook\Service\MailService;
use \IonPot\AddressBook\Service\VcardExport;
use \IonPot\AddressBook\Service\ExcelService;
use \IonPot\AddressBook\Service\ContactImportService;
use \IonPot\AddressBook\Common\AntiCSRF;

class Controller
{

    public function sendToController()
    {
        require_once "./Common/AntiCSRF.php";
        require_once "./Common/EntityDaoDecorator.php";
        require_once "./Common/GenericDaoDecorator.php";
        require_once "./Common/Dao.php";
        require_once "./Common/ErrorHandler.php";

        require_once "./Common/Config.php";
        require_once "./Common/U.php";

        require_once "./Model/Contact.php";
        require_once "./Model/Member.php";
        require_once "./Model/Custom.php";
        require_once "./Model/Group.php";
        require_once "./Service/VcardExport.php";
        require_once './Service/ContactImportService.php';

        date_default_timezone_set(TIMEZONE);

        $u = new U();
        $u->setErrorHandling();
        $antiCSRF = new AntiCSRF();
        $antiCSRF->validate();

        $page_key = "";
        if (isset($_GET["page_key"])) {
            $page_key = $_GET["page_key"];
        }
        switch ($page_key) {
            case "login":
                if (isset($_POST["login"])) {
                    $obj = new Member();
                    $isDashboard = false;
                    $result = $obj->adminLogin($isDashboard);
                    if (! empty($result)) {
                        header("Location:" . WORK_ROOT . "contact/");
                    } else {
                        $message_type = "error";
                        $message = "Invalid Credentials";
                    }
                }
                require_once "view/login.php";
                break;

            case "admin-edit":
                require_once "Common/SessionValidate.php";
                $obj = new Member();
                if (! empty($_POST)) {
                    $result = $obj->editById($_SESSION["member_id"]);
                    echo $result;
                } else {
                    require_once "Common/SessionValidate.php";
                    $obj = new Member();
                    $result = $obj->getById($_SESSION["member_id"]);
                    require_once "view/admin-edit-modal.php";
                }
                break;

            case "contact":
                require_once "Common/SessionValidate.php";
                $obj = new Contact();
                $message = "";
                if (! empty($_GET["status"])) {
                    if ($_GET["status"] == "add-success") {
                        $message = "Added successfully. ";
                    } elseif ($_GET["status"] == "delete-success") {
                        $message = "Deleted successfully. ";
                    }
                }

                $start = 0;
                if (! empty($_GET["start"])) {
                    $start = $_GET["start"];
                }
                $orderFieldAry = null;
                if (! empty($_GET["o"])) {
                    $orderFieldAry[0]["Field"] = $_GET["o"];
                    if (! empty($_GET["os"])) {
                        $orderFieldAry[0]["Order"] = $_GET["os"];
                    }
                } else {
                    $orderFieldAry[0]["Field"] = "id";
                    $orderFieldAry[0]["Order"] = "DESC";
                }
                $totalCount = 0;

                // checks if the filter is clicked.
                // if clicked creates the filter condition array and returns
                $_q = "";
                if (!(empty($_GET["uname"])&&empty($_GET["POR"])&&empty($_GET["email"])&&empty($_GET["EDG"]))) {
                    $result = $obj->contactSearch(null, null, $_GET);
                    $totalCount = $obj->contactSearchCount($_GET);
                } else {
                    // default landing
                    $result = $obj->getByOffset($start, LIMIT_PER_PAGE, null, $orderFieldAry);
                    $totalCount = $obj->getCount();
                }
                if (! empty($_GET["request-type"])) {
                    require_once "view/contact-list-ajax.php";
                } else {
                    require_once "view/contact-list.php";
                }

                break;

            case "member":
                require_once "Common/SessionValidate.php";
                $obj = new Member();
                $message = "";
                if (! empty($_GET["status"])) {
                    if ($_GET["status"] == "add-success") {
                        $message = "Added successfully. ";
                    } elseif ($_GET["status"] == "delete-success") {
                        $message = "Deleted successfully. ";
                    }
                }

                $start = 0;
                if (! empty($_GET["start"])) {
                    $start = $_GET["start"];
                }
                $orderFieldAry = null;
                if (! empty($_GET["o"])) {
                    $orderFieldAry[0]["Field"] = $_GET["o"];
                    if (! empty($_GET["os"])) {
                        $orderFieldAry[0]["Order"] = $_GET["os"];
                    }
                } else {
                    $orderFieldAry[0]["Field"] = "id";
                    $orderFieldAry[0]["Order"] = "DESC";
                }
                $result = $obj->getByOffset($start, LIMIT_PER_PAGE, null, $orderFieldAry);

                $totalCount = $obj->getCount();
                if (! empty($_GET["request-type"])) {
                    require_once "view/member-list-ajax.php";
                } else {
                    require_once "view/member-list.php";
                }

                break;

            case "favorite-list":
                require_once "Common/SessionValidate.php";
                $obj = new Contact();

                $result = $obj->getByField("favorite", 1);
                require_once "view/contact-list-ajax.php";

                break;
            case "filter":
                require_once "Common/SessionValidate.php";
                $obj = new Contact();

                $result = $obj->getFilterByDate();
                require_once "view/contact-list-ajax.php";
                break;
            case "common-search":
                $obj = new Contact();

                $result = $obj->commonSearch();
                require_once "view/contact-list-ajax.php";
                break;

            case "contact-add":
                require_once "Common/SessionValidate.php";
                $obj = new Contact();
                if (! empty($_POST)) {
                    $contact_id = $obj->add();
                    if (! empty($_POST["label"])) {
                        foreach ($_POST["label"] as $k => $v) {
                            if (! empty($_POST["label"][$k]) && ! empty($_POST["value"][$k])) {
                                $obj = new Custom();
                                $obj->addCustom($contact_id, $k);
                            }
                        }
                    }
                    if (! empty($_POST["group"])) {
                        $group = explode(",", $_POST['group']);
                        for ($i = 0; $i < count($group); $i ++) {
                            $groupObj = new Group();
                            $groupObj->addGroup($contact_id, $group[$i]);
                        }
                    }
                    echo $contact_id;
                } else {
                    require_once "Common/SessionValidate.php";
                    require_once "view/contact-add-modal.php";
                }
                break;

            case "contact-edit":
                require_once "Common/SessionValidate.php";
                $obj = new Contact();
                if (! empty($_POST)) {
                    $result = $obj->getById($_GET['id']);
                    if (isset($_POST['image_url'])) {
                        $obj->deletePhoto($result[0]["user_photo"]);
                    }
                    $contact_id = $obj->editById($_GET['id']);
                    $customObj = new Custom();
                    $customresult = $customObj->getCustomByContactID($_GET["id"]);
                    $groupObj = new Group();
                    $groupresult = $groupObj->getGroupByContactID($_GET['id']);
                    // delete custom and insert custom
                    if (! empty($_POST["label"])) {
                        $customObj->deletecustomById($_GET["id"]);
                        foreach ($_POST["label"] as $k => $v) {
                            if (! empty($_POST["label"][$k]) && ! empty($_POST["value"][$k])) {
                                // $obj = new Custom ();
                                $customObj->addCustom($_GET["id"], $k);
                            }
                        }
                    }
                    if (! empty($_POST["group"])) {
                        $groupObj->deleteGroupById($_GET["id"]);
                        $group = explode(",", $_POST['group']);
                        for ($i = 0; $i < count($group); $i ++) {
                            $groupObj->addGroup($_GET["id"], $group[$i]);
                        }
                    } else {
                        $groupObj->deleteGroupById($_GET["id"]);
                    }
                    echo $contact_id;
                } else {
                    require_once "Common/SessionValidate.php";
                    // echo $_GET['id'];
                    $obj = new Contact();
                    $result = $obj->getById($_GET['id']);
                    $customObj = new Custom();
                    $customresult = $customObj->getCustomByContactID($_GET['id']);
                    $groupObj = new Group();
                    $groupresult = $groupObj->getGroupByContactID($_GET['id']);
                    require_once "view/contact-edit-modal.php";
                }
                break;

            case "contact-view-modal":
                require_once "Common/SessionValidate.php";
                // echo $_GET['id'];
                $obj = new Contact();
                $result = $obj->getById($_GET['id']);
                $customObj = new Custom();
                $customresult = $customObj->getCustomByContactID($_GET['id']);
                $groupObj = new Group();
                $groupresult = $groupObj->getGroupByContactID($_GET['id']);
                require_once "view/contact-view-modal.php";
                break;

            case "member-add":
                require_once "Common/SessionValidate.php";
                $obj = new Member();
                if (! empty($_POST)) {
                    $member_id = $obj->add();
                    echo $member_id;
                } else {
                    require_once "Common/SessionValidate.php";
                    require_once "view/member-add-modal.php";
                }
                break;

            case "member-edit":
                require_once "Common/SessionValidate.php";
                $obj = new Member();
                if (! empty($_POST)) {
                    $member_id = $obj->editById($_GET['id']);
                    echo $member_id;
                } else {
                    require_once "Common/SessionValidate.php";
                    $obj = new Member();
                    $result = $obj->getById($_GET['id']);
                    require_once "view/member-edit-modal.php";
                }
                break;

            case "about-version":
                require_once "Common/SessionValidate.php";
                require_once "view/about-modal.php";
                break;

            case "contact-delete":
                require_once "Common/SessionValidate.php";
                $contactObj = new Contact();
                $mudule_name = "contact";
                $result = $contactObj->getById($_GET['id']);
                if (! empty($_POST)) {
                    $valid = 0;
                    $obj = new Custom();
                    $groupObj = new Group();
                    if (! empty($result)) {
                        $contactObj->deletePhoto($result[0]["user_photo"]);
                        $contactObj->deleteById($_GET["id"]);
                        $obj->deletecustomById($_GET["id"]);
                        $groupObj->deleteGroupById($_GET["id"]);
                        $valid ++;
                    }
                    echo $valid;
                } else {
                    require_once "view/delete-modal.php";
                }
                break;

            case "member-delete":
                require_once "Common/SessionValidate.php";
                $mudule_name = "member";
                $memberObj = new Member();
                $result = $memberObj->getById($_GET['id']);
                if (! empty($_POST)) {
                    $valid = 0;

                    if (! empty($result)) {
                        $memberObj->deleteById($_GET["id"]);
                        $valid ++;
                    }
                    echo $valid;
                } else {
                    require_once "view/delete-modal.php";
                }
                break;

            case "photo-delete":
                require_once "Common/SessionValidate.php";
                $valid = 0;
                if (! empty($_GET["id"])) {
                    $obj = new Contact();
                    $obj->deleteImage($_GET["id"]);
                    $valid ++;
                }
                echo $valid ++;
                break;
            case "custom-delete":
                require_once "Common/SessionValidate.php";
                $mudule_name = "custom";
                $customObj = new Custom();
                $result = $customObj->getById($_GET['id']);

                if (! empty($_POST)) {
                    $valid = 0;
                    if (! empty($_GET["id"])) {
                        $customObj = new Custom();
                        $customObj->deletecustomaddById($_GET["id"]);
                        $valid ++;
                    }
                    echo $valid;
                } else {
                    require_once "view/delete-modal.php";
                }
                break;

            case "contact-view":
                require_once "Common/SessionValidate.php";
                $obj = new Contact();
                $customObj = new Custom();
                $groupObj = new Group();
                $message = "";
                if (! empty($_GET["id"])) {
                    $result = $obj->getByID($_GET["id"]);
                    // custom fields
                    $customresult = $customObj->getCustomByContactID($_GET["id"]);
                    $groupresult = $groupObj->getGroupByContactID($_GET["id"]);
                }
                if (! empty($_GET["status"])) {
                    if ($_GET["status"] == "editsuccess") {
                        $message = "Edited successfully. ";
                    }
                }
                require_once "view/contact-view.php";
                break;

            case "favorite":
                require_once "Common/SessionValidate.php";
                $obj = new Contact();
                $message = $obj->toggleFavorite(WORK_ROOT, $_GET['isfavorite'], $_GET['id']);
                echo $message;
                break;

            case "logout":
                require_once "view/logout.php";
                header("Location:" . WORK_ROOT . "login/");
                break;

            case "contact-export":
                $contact = new Contact();
                $result = $contact->get();
                require_once "view/export.php";
                header("Location:" . WORK_ROOT . "contact/");
                break;

            case "vcard-export":
                $contactObj = new Contact();
                $result = $contactObj->getById($_GET["id"]);
                $vcardObj = new VcardExport();
                if (! empty($result)) {
                    $vcardResult = $vcardObj->contactVcardExportService($result);
                }
                break;

            case "contact-import":
                if (! empty($_POST)) {
                    $uploadOk = 0;
                    if (! empty($_FILES["fileToUpload"]["name"])) {
                        // execute on upload
                        // Step 0. Upload CSV File
                        $currDate = date('Y-m-d');
                        $targetPath = "data/contact-import/" . $currDate . "/";
                        if (! file_exists($targetPath)) {
                            mkdir($targetPath, 0777, true);
                        }
                        $currentTime = time();
                        $uploadFile = $targetPath . $currentTime . "-" . basename($_FILES["fileToUpload"]["name"]);
                        $uploadOk = 1;
                        $FileType = pathinfo($uploadFile, PATHINFO_EXTENSION);
                        // Check if file already exists
                        if (file_exists($uploadFile)) {
                            $message = array(
                                "Message" => $uploadFile . " file already exists.",
                                "Type" => "Error"
                            );
                            $uploadOk = 0;
                        }
                        // to Check file size, uncomment this part
                        // Allow certain file formats
                        if ($FileType != "csv") {
                            $message = array(
                                "Message" => "Only CSV files are allowed.",
                                "Type" => "Error"
                            );
                            $uploadOk = 0;
                        } else {
                            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploadFile)) {
                                $message = "The file '" . basename($_FILES["fileToUpload"]["name"]) . "has been uploaded.";
                                $uploadOk = 1;
                            } else {
                                $uploadOk == 0;
                                $message = array(
                                    "Message" => "Sorry, there was an error uploading your file.",
                                    "Type" => "Error"
                                );
                            }
                        }
                        if ($uploadOk == 1) {
                            $row = 1;
                            if (($handle = fopen($uploadFile, "r")) !== FALSE) {
                                $contactObj = new Contact();
                                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                    if($row>1){
                                        $contactObj->insertData($data);
                                    }
                                    $row++;
                                }
                                fclose($handle);
                            }
                            
                            $message = array(
                                "Message" => 'Success!',
                                "Type" => "Success"
                            );
                        }
                    } else {
                        $message = array(
                            "Message" => "No file Chosen, please select excel file.",
                            "Type" => "Error"
                        );
                    }
                    echo json_encode($message);
                    exit();
                }
                require_once './view/import.php';
                break;

            case "forgot":
                if (! empty($_POST["submit"])) {
                    if (empty($message)) {
                        $obj = new Member();
                        $memberListAry = $obj->forgotMember($_POST["email"]);
                        if (! empty($memberListAry)) {
                            $emailsent = false;
                            require_once "Service/MailService.php";
                            $objMail = new MailService();
                            $emailsent = $objMail->sendResetPasswordEmail($memberListAry);
                        } else {
                            $message = 'Invalid credentials.';
                        }
                    }
                }
                require_once 'view/forgot.php';
                break;

            case "forgot-reset":
                require_once './Model/MemberForgot.php';
                $daoMember = new Member();
                $daoForgot = new MemberForgot();
                $isValidToken = 0;
                $memberForgotResult = $daoForgot->getMemberForgotByResetToken($_GET["recoveryToken"]);
                if (! empty($memberForgotResult)) {
                    $isValidToken = 1;
                    $memberResult = $daoMember->getById($memberForgotResult[0]['member_id']);
                    if (! empty($_POST["submit"])) {
                        $daoMember->updatePassword($memberForgotResult[0]['member_id'], $_POST['password']);
                        $daoForgot->expireForgotResetToken($memberForgotResult[0]['id']);
                        $isValidToken = 2;
                    }
                }
                require_once "view/password-reset.php";
                break;

            case "404":
                require_once "view/404.php";
                break;

            case "":
                header("Location:" . WORK_ROOT . "login/");
                break;
        }
    }
}
