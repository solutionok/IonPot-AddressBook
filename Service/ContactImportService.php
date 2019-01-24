<?php
namespace IonPot\AddressBook\Service;

use IonPot\AddressBook\Model\Contact;
use IonPot\AddressBook\Model\Group;
use IonPot\AddressBook\Model\Custom;

/**
 * To import contact from excel to database
 */
class ContactImportService
{

    /*
     * takes input the array read by ExcelService and iterates over it
     */
    public function importRecord($sheetDataArr)
    {
        $insertCount = 0;
        $totalrecord = 0;
        $failedRecords = "Failed Records Reason:";
        // $count is just used to skip the first record in excel as it is labels
        $count = 0;
        foreach ($sheetDataArr as $record) {
            $totalrecord ++;
            if ($count > 0) {
                if ($count <= IMPORT_RECORD_LIMIT) {
                    // 3. validate for empty column
                    $name = trim($record['A']);
                    if (! empty($name)) {
                        // 4. validate if email is present
                        $contactModel = new Contact();
                        $contactNameResult = $contactModel->getByField("name", $name);
                        if ((count($contactNameResult) <= 0)) {
                            $insertId = $contactModel->addContactExcel($record);
                            if ($insertId > 0) {
                                $group = explode(",", $record["Q"]);
                                for ($i = 0; $i < count($group); $i ++) {
                                    $groupModel = new Group();
                                    $groupModel->addGroup($insertId, $group[$i]);
                                }
                                $customLabel = explode(",", $record["R"]);
                                $customValue = explode(",", $record["S"]);
                                for ($i = 0; $i < count($customLabel); $i ++) {
                                    $customModel = new Custom();
                                    $customModel->addCustomFields($insertId, $customLabel[$i], $customValue[$i]);
                                }
                                $insertCount ++;
                            }
                        } elseif ((count($contactNameResult) > 0)) {
                            $failedRecords = $failedRecords . '<br> ' . $count . ' - ' . $name . ' Name already exists.';
                        }
                    }
                } else {
                    $failedRecords = $failedRecords . '<br> Record No: ' . $count . ' - Import record limit reached.';
                }
            }

            $count ++;
            $failedCount = $totalrecord - $insertCount - 1;
        }

        if ($failedCount != 0) {
            $message = "Import completed. Successfully imported " . $insertCount . " records. Failed to import " . $failedCount . " records. " . $failedRecords . ".";
        } else {
            $message = "Import completed. Successfully imported " . $insertCount . " records. Failed to import " . $failedCount . " records.";
        }
        return $message;
    }
}
