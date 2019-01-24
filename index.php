<?php
session_start();
use \IonPot\AddressBook\Controller;

require_once "./Controller.php";
$objController = new Controller();
$objController->sendToController();
