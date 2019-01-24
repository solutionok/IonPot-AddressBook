<?php
namespace IonPot\AddressBook\Common;

use IonPot\AddressBook\Common\DataSource;

/**
 * Core DAO class responsible for low level
 * Database operations.
 * Uses MySQLi and PreparedStatement.
 *
 * Lots of conventions in place. Do a thorough analysis
 * before changing the code.
 *
 * @author Cycle
 * @version 3.1
 *
 */
class Dao
{

    private $conn;

    private $tblName;

    public function __construct($tblName = null)
    {
        require_once "DataSource.php";
        $this->conn = DataSource::getConnection();
        $this->tblName = $tblName;
    }

    /**
     *
     * @param
     *            sql
     */
    private function prepareStmt($sql)
    {
        // Prepare statement
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->conn->errno . ' ' . $this->conn->error, E_USER_ERROR);
        }
        return $stmt;
    }

    /**
     * argument for call_user_func_array should be passed
     * as reference which is going to be subsequently used
     * Therefore we are receiving both arguments as reference.
     *
     * @param unknown $paramFieldAry
     * @param unknown $param_type
     * @return arguments reference array
     */
    private function prepareParams(&$paramFieldAry, &$param_type)
    {
        $paramFieldCount = count($paramFieldAry);
        /* with call_user_func_array, array params must be passed by reference */
        $a_params[] = & $param_type;
        for ($i = 0; $i < $paramFieldCount; $i ++) {
            /* with call_user_func_array, array params must be passed by reference */
            $a_params[] = & $paramFieldAry[$i]["Value"];
        }
        return $a_params;
    }

    /**
     * 1.prepares parameters for binding
     * 2.binds the parameters to statement passed
     * Bind parameters.
     * Types: s = string, i = integer, d = double, b = blob
     *
     * @param
     *            stmt, ...
     *
     */
    private function bindParams($stmt, $paramFieldAry, $param_type)
    {
        // step 1: prepare params before binding
        $a_params = $this->prepareParams($paramFieldAry, $param_type);
        
        // step 2: bind the parameters to the statement
        /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
        call_user_func_array(array(
            $stmt,
            'bind_param'
        ), $a_params);
    }

    /**
     *
     * @return The ID generated for an AUTO_INCREMENT column
     *         by the previous query on success,
     *         0 if the previous query does not generate
     *         an AUTO_INCREMENT value, or
     *         FALSE if no MySQL connection was established.
     */
    public function insert($paramFieldAry, $tableName = null)
    {
        if (is_array($paramFieldAry)) {
            $fields = '';
            $paramType = '';
            $prepareStmtArg = '';
            $i = 0;
            $paramFieldCount = count($paramFieldAry);
            while ($i < $paramFieldCount) {
                if ($i != 0) {
                    $fields .= "," . $paramFieldAry[$i]["Field"] . "";
                    $paramType .= $paramFieldAry[$i]["Type"];
                    $prepareStmtArg .= ",?";
                } else {
                    $fields = $paramFieldAry[$i]["Field"];
                    $paramType = $paramFieldAry[$i]["Type"];
                    $prepareStmtArg = "?";
                }
                $i ++;
            }
        }

        if ($tableName == null) {
            if (! ($this->tblName == null)) {
                $tableName = $this->tblName;
            } else {
                throw new \Exception("Table name not found in INSERT query!");
            }
        }

        $sql = "insert into " . $tableName . " (" . $fields . ") values (" . $prepareStmtArg . ")";
        $stmt = $this->prepareStmt($sql);
        $this->bindParams($stmt, $paramFieldAry, $paramType);
        $stmt->execute();

        $id = mysqli_insert_id($this->conn);
        return $id;
    }

    /**
     * Bind parameters.
     * Types: s = string, i = integer, d = double, b = blob
     * updates based on the primary key field assuming
     * only one field forms the primary key
     *
     * scope for improvement: the WHERE clause can be changed
     * similar to SELECT or DELETE function done below
     *
     * @return Returns the number of rows affected by
     *         the last query.
     */
    public function update($paramFieldAry, $primaryKeyFieldName, $primaryKeyFieldValue, $primaryKeyType, $tableName = null)
    {
        $result = false;
        if ($tableName == null) {
            if (! ($this->tblName == null)) {
                $tableName = $this->tblName;
            } else {
                throw new \Exception("Table name not found in UPDATE query!");
            }
        }
        $sql = "UPDATE " . $tableName;
        $whereCondition = " where " . $primaryKeyFieldName . " =?";
        if (is_array($paramFieldAry)) {
            $paramFieldCount = count($paramFieldAry);
            $values = '';
            $paramType = '';
            $i = 0;
            $param_list = '';
            while ($i < $paramFieldCount) {
                if ($i != 0) {
                    $param_list = $param_list . ", " . $paramFieldAry[$i]["Field"] . "=?";

                    $values .= ",'" . $paramFieldAry[$i]["Value"] . "'";
                    $paramType .= $paramFieldAry[$i]["Type"];
                } else {
                    $param_list = $paramFieldAry[$i]["Field"] . "=?";

                    $values = "'" . $paramFieldAry[$i]["Value"] . "'";
                    $paramType = $paramFieldAry[$i]["Type"];
                }
                $i ++;
            }

            // adding the primary key type
            // for binding the primary key value
            $paramType = $paramType . $primaryKeyType;
            $paramFieldAry[$paramFieldCount]["Value"] = $primaryKeyFieldValue;

            $sql = $sql . " SET " . $param_list . $whereCondition;
            $stmt = $this->prepareStmt($sql);
            $this->bindParams($stmt, $paramFieldAry, $paramType);
            $result = $stmt->execute();
        }

        return mysqli_affected_rows($this->conn);
    }

    /**
     * to create the WHERE clause of the sql query
     * $conditionFieldAry - list of fields that forms the
     * WHERE condition.
     * If there is a second field present in the
     * condition, then the first field should have that respective
     * condition like AND or OR.
     *
     * $param_type - is used as a reference variable. The param type
     * to be used in the prepared statment will be set in this. As a
     * reference the values set in the paramtype can be used from the
     * calling method.
     *
     * Field: name of the column
     * Types: s = string, i = integer, d = double, b = blob
     * Condition: OR, ||, XOR, AND, &&
     * Operator: = | >= | > | <= | < | <> | != | LIKE {If not supplied, default is =}
     *
     * example field construction:
     * $conditionFieldAry[0]["Field"] = "animal_type";
     * $conditionFieldAry[0]["Type"] = "s";
     * $conditionFieldAry[0]["Condition"] = "AND";
     * $conditionFieldAry[1]["Field"] = "animal_color";
     * $conditionFieldAry[1]["Type"] = "s";
     * $conditionFieldAry[1]["Operator"] = "!=";
     */
    private function createWhereCondition($conditionFieldAry, &$param_type)
    {
        $i = 0;
        $queryCondition = " WHERE ";
        $count = count($conditionFieldAry);
        while ($i < $count) {
            if (isset($conditionFieldAry[$i]["Operator"])) {
                $operator = $conditionFieldAry[$i]["Operator"];
            } else {
                $operator = "="; // assigning the default operator
            }
            $queryCondition = $queryCondition . $conditionFieldAry[$i]["Field"] . " " . $operator . " ?";
            if (isset($conditionFieldAry[$i]["Condition"]) && ! empty($conditionFieldAry[$i]["Condition"])) {
                $queryCondition = $queryCondition . " " . $conditionFieldAry[$i]["Condition"] . " ";
            }
            $param_type .= $conditionFieldAry[$i]["Type"];
            $i ++;
        }
        
        return strpos($queryCondition,'AND')===false?$queryCondition:substr($queryCondition,0,-4);
    }

    /**
     * creates ORDER BY clause to be used in SELECT query
     * multiple fields can be sent in the array as argument
     *
     * ASC or DESC is optional, if sent it will be suffixed
     * else will be left empty and just the field name will
     * be used. As per MySQL default sorting is ascending, so
     * without ASC or DESC will behave as default ASC order.
     *
     * example field construction:
     * $orderFieldAry[0]["Field"] = "animal_name";
     * $orderFieldAry[0]["Order"] = "DESC";
     * $orderFieldAry[1]["Field"] = "animal_color";
     * $orderFieldAry[2]["Field"] = "animal_age";
     * $orderFieldAry[2]["Order"] = "ASC";
     *
     * example output: ORDER BY animal_name DESC, animal_color, animal_age ASC
     *
     * @param string-array $orderFieldAry
     * @return string
     */
    private function createOrderBy($orderFieldAry)
    {
        $orderBy = "";
        if (! empty($orderFieldAry)) {
            $i = 0;
            $orderBy = " ORDER BY ";
            $count = count($orderFieldAry);
            while ($i < $count) {
                if ($i != 0) {
                    $orderBy = $orderBy . ", " . $orderFieldAry[$i]["Field"];
                } else {
                    $orderBy = $orderBy . $orderFieldAry[$i]["Field"];
                }
                if (isset($orderFieldAry[$i]["Order"]) && ! empty($orderFieldAry[$i]["Order"])) {
                    $orderBy = $orderBy . " " . $orderFieldAry[$i]["Order"];
                }
                $i ++;
            }
        }
        return $orderBy;
    }

    /**
     * creates GROUP BY clause to be used in SELECT query
     * multiple fields can be sent in the array as argument
     *
     *
     * example field construction:
     * $groupFieldAry[0]["Field"] = "animal_name";
     * $groupFieldAry[1]["Field"] = "animal_color";
     * $groupFieldAry[2]["Field"] = "animal_age";
     *
     * example output: GROUP BY animal_name, animal_color, animal_age
     *
     * @param string-array $groupFieldAry
     * @return string
     */
    private function createGroupBy($groupFieldAry)
    {
        $groupBy = "";
        if (! empty($groupFieldAry)) {
            $i = 0;
            $groupBy = " GROUP BY ";
            $count = count($groupFieldAry);
            while ($i < $count) {
                if ($i != 0) {
                    $groupBy = $groupBy . ", " . $groupFieldAry[$i]["Field"];
                } else {
                    $groupBy = $groupBy . $groupFieldAry[$i]["Field"];
                }
                $i ++;
            }
        }
        return $groupBy;
    }

    /**
     * to select records
     *
     * condition can be AND, OR
     * scope for improvement: LIMIT clause
     *
     * $baseQuery - part of the query before the WHERE clause
     *
     * @param fields $paramFieldAry
     * @return dbresult[]
     */
    public function select($paramFieldAry = null, $orderFieldAry = null, $offset = null, $rowCount = null, $baseQuery = null, $groupFieldAry = null)
    {
        $paramType = "";
        // 1 base query
        if (empty($baseQuery)) {
            $baseQuery = "SELECT * from " . $this->tblName;
        } else {
            // to ensure that the developer doesnot bypass the bind-params
            // if this check is not done, developer can form the complete
            // query including WHERE clause and user input values as parameter
            // to stop that this exception is thrown
            $stopWord = " where ";

            if (stripos($baseQuery, $stopWord) !== false) {
                throw new \Exception("Base Query should not contain WHERE clause!");
            }
        }
        $sql = $baseQuery;

        // 2 WHERE clause
        if (is_array($paramFieldAry)) {
            $queryCondition = $this->createWhereCondition($paramFieldAry, $paramType);
            $sql = $sql . $queryCondition;
        }

        // 3 GROUP BY clause
        $groupBy = $this->createGroupBy($groupFieldAry);
        if (! empty($groupBy)) {
            $sql = $sql . $groupBy;
        }

        // 4 ORDER BY clause
        $orderBy = $this->createOrderBy($orderFieldAry);
        if (! empty($orderBy)) {
            $sql = $sql . $orderBy;
        }

        // 5 LIMIT clause
        // [LIMIT {[offset,] row_count}]
        if (! empty($rowCount)) {
            $limit = " LIMIT";
            if (! empty($offset)) {
                $limit = $limit . " ?,";
                $paramType = $paramType . "i";
                $aryIndex = empty($paramFieldAry)?0:count($paramFieldAry);
                $paramFieldAry[$aryIndex]["Value"] = $offset;
            }
            $limit = $limit . " ?";
            $paramType = $paramType . "i";
            $aryIndex = 0;
            if (is_array($paramFieldAry)) {
                $aryIndex = count($paramFieldAry);
            }
            $paramFieldAry[$aryIndex]["Value"] = $rowCount;
            $sql = $sql . $limit;
            
        }

        // 6 prepare statement
        $stmt = $this->prepareStmt($sql);

        // 7 bind params
        if (is_array($paramFieldAry)) {
            $this->bindParams($stmt, $paramFieldAry, $paramType);
        }
        // 8 execute
        $stmt->execute();

        // 9 get result
        $results = $this->parseResult($stmt);
        return $results;
    }

    /**
     * to parse the results from the last query execution
     * meta data is used to fetch the results
     * the fetched result is massaged to an array
     * suitable for easy use
     *
     * @param statement $stmt
     * @return resultarray
     */
    private function parseResult($stmt)
    {
        $meta = $stmt->result_metadata();

        while ($field = $meta->fetch_field()) {
            $parameters[] = &$row[$field->name];
        }

        call_user_func_array(array(
            $stmt,
            'bind_result'
        ), $parameters);
        $results = null;
        while ($stmt->fetch()) {
            foreach ($row as $key => $val) {
                $x[$key] = $val;
            }
            $results[] = $x;
        }
        return $results;
    }

    /**
     * to delete records
     *
     * condition can be AND, OR
     *
     * @param fields $paramFieldAry
     * @return Returns the number of rows affected by
     *         the last query.
     *         OR
     *         if there is a foreign key violation as defined in Config errno
     *         then it will return the negative of that errno.
     */
    public function delete($paramFieldAry = null, $tableName = null)
    {
        if ($tableName == null) {
            if (! ($this->tblName == null)) {
                $tableName = $this->tblName;
            } else {
                throw new \Exception("Table name not found in DELETE query!");
            }
        }
        $sql = "DELETE from " . $tableName;
        if (is_array($paramFieldAry)) {
            $queryCondition = $this->createWhereCondition($paramFieldAry, $paramType);
            $sql = $sql . $queryCondition;
            $stmt = $this->prepareStmt($sql);
            $this->bindParams($stmt, $paramFieldAry, $paramType);
        } else {
            $stmt = $this->prepareStmt($sql);
        }
        $stmt->execute();

        // if affected rows is -1 then there is error in query execution
        // if errno is 1451 (should be defined in config) then foreign key violation
        // in deletion
        if (mysqli_affected_rows($this->conn) == - 1 && $stmt->errno == DB_FOREIGN_ERRNO) {
            // returning a negative value of that errno
            // this is a convention used and the caller should handle it
            // accordingly
            return (- DB_FOREIGN_ERRNO);
        }
        return mysqli_affected_rows($this->conn);
    }

    /**
     *
     * Full query with '?' for binding param values
     * for binding param values
     * Should be used only when binding is required and in
     * other cases, use the above select function
     *
     *
     * @param unknown $query
     *            - a complete query with '?' placeholders
     * @param unknown $paramValueAry
     *            - this will contain the
     *            values and their respective types for binding
     *            Example:
     *            $paramValueAry[0]["Value"] = "Lion"
     *            $paramValueAry[0]["Type"] = "s"
     *            $paramValueAry[1]["Value"] = "23"
     *            $paramValueAry[1]["Type"] = "i"
     *
     * @return \Pot\Cart\Common\resultarray
     */
    public function execute($query, $paramValueAry)
    {
        if (stripos($query, "?") !== true) {
            throw new \Exception("Query MUST be used when binding with params required!");
        }

        // 1 prepare statement
        $stmt = $this->prepareStmt($sql);

        // 2 bind params

        // 2.1 separate param type to an array
        $paramFieldCount = count($paramValueAry);
        $i = 0;
        $paramType = "";
        while ($i < $paramFieldCount) {
            if ($i != 0) {
                $paramType .= $paramFieldAry[$i]["Type"];
            } else {
                $paramType = $paramFieldAry[$i]["Type"];
            }
            $i ++;
        }
        if (is_array($paramValueAry)) {
            $this->bindParams($stmt, $paramValueAry, $paramType);
        }
        
        // 3 execute
        $stmt->execute();

        // 4 get result
        $results = $this->parseResult($stmt);
        return $results;
    }
}
