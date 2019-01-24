<?php
namespace IonPot\AddressBook\Common;

use IonPot\AddressBook\Common\Dao;

/**
 * Dao decorator class that acts upon multiple entities
 * Database operations.
 *
 * @version 3.0
 */
class GenericDaoDecorator
{

    private $dao;

    public function __construct()
    {
        $this->dao = new Dao();
    }

    /**
     * generic insert method.
     *
     * @param fields $ary
     * @return number the auto-id of the latest inserted record.
     */
    public function insert($ary, $tableName)
    {
        $id = $this->dao->insert($ary, $tableName);
        return $id;
    }

    /**
     *
     * generic update method
     *
     * @param fields $ary
     * @param String $primaryKeyFieldName
     * @param int $primaryKeyFieldValue
     * @return number of records updated
     */
    public function update($ary, $primaryKeyFieldName, $primaryKeyFieldValue, $primaryKeyType, $tableName)
    {
        $id = $this->dao->update($ary, $primaryKeyFieldName, $primaryKeyFieldValue, $primaryKeyType, $tableName);
        return $id;
    }

    public function get($conditionFieldAry, $orderFieldAry, $baseQuery, $groupFieldAry = null)
    {
        $result = $this->dao->select($conditionFieldAry, $orderFieldAry, null, null, $baseQuery, $groupFieldAry);
        return $result;
    }

    /**
     * Will give paginated results.
     * IMPORTANT: When called without any arguments, will respond with first page result
     *
     * @param unknown $conditionFieldAry
     * @param unknown $orderFieldAry
     * @param int $offset
     *            starting index of the result, starts with '0'
     * @param int $rowCount
     *            number of records to be returned
     *            Examples:
     *            0, 1 returns first row
     *            0, 2 returns first two rows
     *            2, 1 returns the third row only
     *            LIMIT 5; # Retrieve first 5 rows
     *            In other words, LIMIT $rowCount is equivalent to LIMIT 0, row_count.
     * @return dbresult[]
     */
    public function getByOffset($offset, $rowCount, $conditionFieldAry, $orderFieldAry, $baseQuery, $groupFieldAry = null)
    {
        $result = $this->dao->select($conditionFieldAry, $orderFieldAry, $offset, $rowCount, $baseQuery, $groupFieldAry);
        return $result;
    }

    /**
     * used when there is no WHERE clause and no param binding required
     *
     * @param unknown $query
     * @return \Pot\Cart\Common\dbresult[]
     */
    public function getByBaseQuery($query)
    {
        $result = $this->dao->select(null, null, null, null, $query);
        return $result;
    }

    public function delete($conditionFieldAry, $tableName)
    {
        $result = $this->dao->delete($conditionFieldAry, $tableName);
        return $result;
    }
}
