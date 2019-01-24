<?php
namespace IonPot\AddressBook\Service;

use JeroenDesloovere\VCard\VCard;
use IonPot\AddressBook\Model\Group;

class VcardExport
{

    public function contactVcardExportService($contactResult)
    {
        // Get group name data starts
        $contactGroupObj = new Group();
        $groupResult = $contactGroupObj->getByField("contact_id", $contactResult[0]["id"]);
        if (! empty($groupResult)) {
            $group_names = array_column($groupResult, 'group_name');
        }
        // Get group name data ends
        require_once 'vendor/Behat-Transliterator/Transliterator.php';
        require_once 'vendor/jeroendesloovere-vcard/VCard.php';
        // define vcard
        $vcardObj = new VCard();

        // add personal data
        $vcardObj->addName($contactResult[0]["name"]);
        $vcardObj->addNickName($contactResult[0]["nick_name"]);
        // add work data
        $vcardObj->addCompany($contactResult[0]["company"]);
        $vcardObj->addJobtitle($contactResult[0]["job_title"]);
        $vcardObj->addBirthday($contactResult[0]["birth_dt"]);
        $vcardObj->addEmail($contactResult[0]["user_email"]);
        $vcardObj->addPhoneNumber($contactResult[0]["user_mobile_no"], 'PREF;WORK');
        $vcardObj->addAddress($contactResult[0]["user_address"]);
        $vcardObj->addURL($contactResult[0]["website"]);
        $vcardObj->addGEO($contactResult[0]["geo"]);
        $vcardObj->addImpp($contactResult[0]["im"]);

        if (! empty($group_name)) {
            $vcardObj->addCategories($group_names);
        }

        $vcardObj->addProdId(APP_NAME);

        $vcardObj->addNote($contactResult[0]["notes"]);

        // return vcard as a download
        return $vcardObj->download();
    }
}
