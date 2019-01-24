<?php
namespace IonPot\AddressBook\Common;

/**
 *
 * @author Cycle
 * @version 2.0
 */
class DataSource
{

    // PHP 7.1.0 visibility modifiers are allowed for class constants.
    // when using above 7.1.0, declare the below constants as private
    const HOST = 'localhost';

    const USERNAME = 'root';

    const PASSWORD = '';

    const DATABASENAME = 'addressbook';

    /**
     * PHP implicitly takes care of cleanup
     * for default connection types.
     * So no need
     * to worry about closing the connection.
     *
     * Singletons not required in PHP
     * as there is no
     * concept of shared memory.
     * Every object
     * lives only for a request.
     *
     * Keeping things simple and that works!
     *
     * @return \mysqli
     */
    public static function getConnection()
    {
        $connection = new \mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASENAME);

        if (mysqli_connect_errno()) {
            trigger_error("Problem with connecting to database.");
        }

        $connection->set_charset("utf8");
        return $connection;
    }
}
