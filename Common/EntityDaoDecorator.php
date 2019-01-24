<?php
namespace IonPot\AddressBook\Common;

use \IonPot\AddressBook\Common\Dao;
use \IonPot\AddressBook\Common\U;

/**
 * Historically 80% of the code-foot-print involves single entity DB operations
 * for micro, small and medium sized projects.
 * This single entity DB operations has code reuse possibility.
 * This EntityDaoDecorator acts as a bridge between the Entity and Dao
 *
 * @version 2.0
 */
abstract class EntityDaoDecorator
{

    private $dao;

    public $tblName;

    public function __construct()
    {
        $this->dao = new Dao($this->tblName);
    }

    /**
     * to add form values to database
     * processUIForm method should be implemented in the sub-class
     *
     * @return number the auto-id of the latest inserted record.
     */
    public function add()
    {
        $ary = $this->processUIForm();
        $id = $this->insert($ary);
        return $id;
    }

    /**
     * this method can be used from domain directly if
     * processUIForm is substituted with a special purpose
     * method
     *
     * @param fields $ary
     * @return number the auto-id of the latest inserted record.
     */
    public function insert($ary)
    {
        $id = $this->dao->insert($ary);
        return $id;
    }

    /**
     *
     * to update form values to database
     * processUIForm method should be implemented in the sub-class
     *
     * @param String $primaryKeyFieldName
     * @param int $primaryKeyFieldValue
     * @return number of records updated
     */
    public function edit($primaryKeyFieldName, $primaryKeyFieldValue, $primaryKeyType = "i")
    {
        $ary = $this->processUIForm();
        $id = $this->update($ary, $primaryKeyFieldName, $primaryKeyFieldValue, $primaryKeyType);
        return $id;
    }

    public function editById($id)
    {
        $ary = $this->processUIForm();
        $id = $this->update($ary, "id", $id, "i");
        return $id;
    }

    /**
     *
     * this method can be used from domain directly if
     * processUIForm is substituted with a special purpose
     * method
     *
     * @param fields $ary
     * @param String $primaryKeyFieldName
     * @param int $primaryKeyFieldValue
     * @return number of records updated
     */
    public function update($ary, $primaryKeyFieldName, $primaryKeyFieldValue, $primaryKeyType = "i")
    {
        $id = $this->dao->update($ary, $primaryKeyFieldName, $primaryKeyFieldValue, $primaryKeyType);
        return $id;
    }

    /* ************** SELECT part STARTS */
    public function get($conditionFieldAry = null, $orderFieldAry = null)
    {
        $result = $this->dao->select($conditionFieldAry, $orderFieldAry);
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
    public function getByOffset($offset = 0, $rowCount = LIMIT_PER_PAGE, $conditionFieldAry = null, $orderFieldAry = null)
    {
        $result = $this->dao->select($conditionFieldAry, $orderFieldAry, $offset, $rowCount);
        return $result;
    }

    public function getById($id)
    {
        $result = $this->getByField("id", $id, "i");
        return $result;
    }

    /**
     * Total count of records available
     *
     * @return int
     */
    public function getCount($conditionFieldAry = null)
    {
        $baseQuery = "SELECT count(*) as count from " . $this->tblName;
        $result = $this->dao->select($conditionFieldAry, null, null, null, $baseQuery);
        return $result[0]["count"];
    }

    /**
     * To select records based on a field
     *
     *
     * @param unknown $fieldName
     * @param unknown $fieldValue
     * @param string $fieldName
     *            - optional and default value is "s"
     */
    public function getByField($fieldName, $fieldValue, $fieldType = "s")
    {
        $ary = null;
        U::buildAry($ary, $fieldName, $fieldValue, $fieldType);
        $result = $this->get($ary);
        return $result;
    }

    /* ************** SELECT part ENDS */

    /* ************** DELETE part STARTS */
    public function delete($conditionFieldAry = null)
    {
        $result = $this->dao->delete($conditionFieldAry);
        return $result;
    }

    public function deleteById($id)
    {
        $result = $this->deleteByField("id", $id, "i");
        return $result;
    }

    /**
     * To delete records based on a field
     *
     * @param unknown $fieldName
     * @param unknown $fieldValue
     * @param string $fieldName
     *            - optional and default value is "s"
     * @return number of records affected
     */
    public function deleteByField($fieldName, $fieldValue, $fieldType)
    {
        $ary = null;
        U::buildAry($ary, $fieldName, $fieldValue, $fieldType);
        $result = $this->delete($ary);
        return $result;
    }

    /* ************** DELETE part ENDS */
}
