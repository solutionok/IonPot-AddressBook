<?php
namespace IonPot\AddressBook\Service;

use \PHPExcel_IOFactory;

/*
 * To read a excel file
 * Uses component PHPExcel https://github.com/PHPOffice/PHPExcel
 */
class ExcelService
{

    private $inputFile;

    public function __construct($inFile)
    {
        $this->inputFile = $inFile;
    }

    /*
     * reads an excel and returns the values as an array
     */
    public function read()
    {
        /**
         * Include path *
         */
        set_include_path(get_include_path() . PATH_SEPARATOR . 'vendor/PHPExcel');
        include 'PHPExcel/IOFactory.php';

        // $inputFile = './in.xls'; // Input Excel File to read - use this bypass for testing.
        try {
            $objPHPExcel = PHPExcel_IOFactory::load($this->inputFile);
        } catch (Exception $e) {
            die('Error loading input file "' . pathinfo($this->inputFile, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $sheetDataArr = $objPHPExcel->getActiveSheet()->toArray(null, true, false, true);

        return $sheetDataArr;
    }
}
