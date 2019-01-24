<?php
namespace IonPot\AddressBook\Common;
define("APP_NAME", 'XLRI Address Book');
define("APP_ROOT", 'https://www.localhost');
define("WORK_ROOT", '/IonPot-AddressBook/');
define("DEBUG", true);
define("LOG_FILE", "app.log");
define("ERROR_PAGE", ".");

// SMTP settings - to send email for forgot password
define('SMTP_EMAIL_USERNAME', "a@gmail.com");
define('SMTP_EMAIL_PASSWORD', 'a##');
define('SMTP_HOST', "smtp.gmail.com");
define('SMTP_PORT', 465);
define('MAILER', "smtp");

define('SMTP_AUTH', true); // should the smtp server do authentication
define('SMTP_SECURE', 'ssl'); // tls or ssl

// Sender Configuration
define('SENDER_NAME', "SENDER_NAME");
define('SENDER_EMAIL', "SENDER_EMAIL");

/*
 * Application level constants
 */
define("DATE_SHOW", "m/d/Y");
define("TIMEZONE", "America/New_York");
define("LOG_ACTIVITY", true);
define("DATA_FOLDER", '../../data');
// PAGINATION: number of records shown in the list per page.
define("LIMIT_PER_PAGE", 10);
define("FILTER_CONDITION", "AND");
define("IMPORT_RECORD_LIMIT", 500);
