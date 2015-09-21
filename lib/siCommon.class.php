<?php

/**
 * StepIn Solutions venture
 *
 *
 * @package stepone
 */
class siCommon extends mySql {

    //Constructer
    public function __construct($sDbHost = "", $sDbUser = "", $sDbPassword = "", $sDbName = "") {
        parent::__construct($sDbHost, $sDbUser, $sDbPassword, $sDbName);
    }

    /**
     * To get records
     * @param type $sQuery
     * @param type $aLimit
     * @param type $aGroupBy
     * @param type $aSearch
     * @param type $aSort
     * @param type $sMode
     * @param type $aHaving
     * @return type
     */
    public function getList($sQuery, $aLimit = array(), $aGroupBy = array(), $aSearch = array(), $aSort = array(), $sMode = '', $aHaving = array()) {
        $ssSearch = '';
        $ssGroupBy = '';
        $ssSort = '';
        $limit = '';
        $ssHaving = '';
        if (count($aLimit) && is_array($aLimit)) {
            foreach ($aLimit as $sLimit) {
                foreach ($sLimit as $sLimitValue => $limitValue) {
                    $limit = $limitValue;
                }
            }
        }
        if (count($aSearch) && is_array($aSearch)) {
            switch ($sMode) {
                case 'LIKE':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch .= $sSearch . ' ' . 'LIKE' . ' ' . '"%' . $sSearchValue . '%"' . ' ';
                        }
                    }
                    break;
                case 'IN':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch = $sSearch . ' IN ' . "('" . '' . $sSearchValue . "') ";
                        }
                    }
                    break;
                case '=':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch .= $sSearch . ' = ' . "'" . '' . $sSearchValue . "' ";
                        }
                    }
                    break;
                case '!=':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch = $sSearch . ' != ' . "'" . '' . $sSearchValue . "' ";
                        }
                    }
                    break;
                case '>=':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch = $sSearch . ' >= ' . "'" . '' . $sSearchValue . "' ";
                        }
                    }
                    break;
                case '<=':
                    if ($aSearch != '') {
                        foreach ($aSearch as $sSearch => $sSearchValue) {
                            $ssSearch = $sSearch . ' <= ' . "'" . '' . $sSearchValue . "' ";
                        }
                    }
                    break;
            }
        }

        if (count($aSort) && is_array($aSort)) {
            foreach ($aSort as $sSort) {
                foreach ($sSort as $sSortValues => $sSortRow) {
                    $ssSort = $sSortValues;
                    foreach ($sSortRow as $sSortValue) {
                        $ssSort.= $sSortValue;
                    }
                }
            }
        }
        if (count($aGroupBy) && is_array($aGroupBy)) {
            foreach ($aGroupBy as $sGroupBy => $eValue) {
                $ssGroupBy = $sGroupBy;
                $ssGroupBy .= $eValue;
            }
        }
        if (count($aHaving) && is_array($aHaving)) {
            foreach ($aHaving as $sHaving => $eValue) {
                $ssHaving = $sHaving;
                $ssHaving .= $eValue;
            }
        }
        $aQuery = $sQuery . $ssSearch . $ssGroupBy . $ssHaving . $ssSort . $limit;
        return $this->executeQuery($aQuery);
    }

    /**
     * To delete records
     * @param type $sTableName
     * @param type $aFieldId
     * @param type $bPhDelete
     * @param type $aFieldName
     * @return type
     */
    public function deleteRecordById($sTableName, $aFieldId, $bPhDelete, $sFieldName) {
        if ($bPhDelete) {
            $sDelete = "DELETE FROM " . $sTableName . " WHERE " . $sFieldName . " IN (" . implode(",", $aFieldId[0]).")";
            return $this->executeQuery($sDelete);
        } else {
            $sUpdate = "UPDATE " . $sTableName . " SET deleted = " . "'" . "1" . "'" . " WHERE " . $sFieldName . " IN (" . implode(",", $aFieldId[0]) . ")";
            return $this->executeQuery($sUpdate);
        }
    }
    /**
     * To take validations
     * @param type $aValidation
     * @return boolean
     */
    public function validateData($aValidation) {
        global $oSession;
        $bIsValid = true;
        foreach ($aValidation as $aValidationDetails) {
            if ($aValidationDetails['validation'] == "required") {
                if (trim($aValidationDetails['value']) == "") {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "email") {
                if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $aValidationDetails['value'])) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "fileType") {
                $mType = isset($aValidationDetails['value']['type']) ? $aValidationDetails['value']['type'] : '';
                $validTypes = $aValidationDetails['validTypes'];
                if (!in_array($mType, $validTypes)) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "unique") {
                $sQuery = " SELECT "
                        . $aValidationDetails['table_field_name'] .
                        " FROM "
                        . $aValidationDetails['table_name'] .
                        " WHERE "
                        . $aValidationDetails['table_field_name'] . " = '" . $aValidationDetails['value'] . "' AND " . $aValidationDetails['table_field_id'] . "!= '" . $aValidationDetails['id'] . "' AND deleted = '0' " . " LIMIT 1";
                $mQueryHandler = $this->executeQuery($sQuery);
                $aInfo = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aInfo);
                if ($nCountRecord != '') {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "uniqueentity") {
                $sWhere = " 1 ";
                if (isset($aValidationDetails['table_field_id']) && !empty($aValidationDetails['table_field_id'])) {
                    $sWhere .= " AND " . $aValidationDetails['table_field_id'] . " != '" . $aValidationDetails['id'] . "'";
                }

                if (isset($aValidationDetails['table_field_name']) && !empty($aValidationDetails['table_field_name'])) {
                    $sWhere .= " AND " . $aValidationDetails['table_field_name'] . " = '" . $aValidationDetails['value'] . "'";
                }

                if (isset($aValidationDetails['table_field_name2']) && !empty($aValidationDetails['table_field_name2'])) {
                    $sWhere .= " AND " . $aValidationDetails['table_field_name2'] . " = '" . $aValidationDetails['value2'] . "'";
                }

                $sWhere .= " AND deleted = '0' ";

                $sQuery = " SELECT "
                        . $aValidationDetails['table_field_name'] .
                        " FROM "
                        . $aValidationDetails['table_name'] .
                        " WHERE " . $sWhere
                        . " LIMIT 1";
                $mQueryHandler = $this->executeQuery($sQuery);
                $aInfo = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aInfo);
                if ($nCountRecord != '') {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "alphanumeric") {
                if (!preg_match('/^[\w_]+$/', $aValidationDetails['value'])) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "confirm") {
                if ($aValidationDetails['value'][0] != $aValidationDetails['value'][1]) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);

                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "currentPass") {

                $sSql = "SELECT
                                      password
                                FROM " . $aValidationDetails['tableName'] . "
                                WHERE " . $aValidationDetails['idField'] . "
                                = " . $aValidationDetails['idValue'];

                $mQueryHandler = $this->executeQuery($sSql);
                $aUserInfo = $this->getData($mQueryHandler, "ARRAY");

                $sPassword = $aUserInfo[0]['password'];
                $sCurrentPassword = md5($aValidationDetails['value']);

                if ($sPassword != $sCurrentPassword) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }

            if ($aValidationDetails['validation'] == "currentPassword") {                
                 $sSql = "SELECT
                                      salt,password
                                FROM " . $aValidationDetails['tableName'] . "
                                WHERE " . $aValidationDetails['idField'] . "
                                = " . $aValidationDetails['idValue'];
                
                $mQueryHandler = $this->executeQuery($sSql);
                $aInfo = $this->getData($mQueryHandler, "ARRAY");
                
                $sPassword = $aInfo[0]['password'];
                $sCurrentPassword = sha1($aInfo[0]['salt'] . $aValidationDetails['value']);
                 
                if ($sPassword != $sCurrentPassword) {                 
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                } else {
                 
                    $bIsValid = $aInfo;
                }
            
            }
            if ($aValidationDetails['validation'] == "minimumlength") {

                if (strlen($aValidationDetails['value'][0]) < $aValidationDetails['value'][1]) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "maximumlength") {

                if (strlen($aValidationDetails['value'][0]) > $aValidationDetails['value'][1]) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "isValidUrl") {
                if (!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $aValidationDetails['value'])) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            if ($aValidationDetails['validation'] == "isSpecialCharacter") {
                if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $aValidationDetails['value'])) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
            //Captcha validation changes
            if ($aValidationDetails['validation'] == "isCaptcha") {
                $sCaptchaSession = $oSession->getSession('captcha');
                if (empty($sCaptchaSession) || trim(strtolower($aValidationDetails['value'])) != $sCaptchaSession) {
                    $oSession->setError('captchaError', $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }

            if ($aValidationDetails['validation'] == "isLoggedin") {
                $sAndWhere = '1 = 1';
                $sAndWhere .= ' AND ' . $aValidationDetails['aCredentials'][0] . '="' . $aValidationDetails['value'][0] . '"';
                $sAndWhere .= ' AND activated = 1 AND deleted = 0';

                $sSql = "SELECT
                                    salt,password," . implode(",", $aValidationDetails['aDataForSession']) .
                        " FROM "
                        . $aValidationDetails['tableName'] .
                        " WHERE " . $sAndWhere;
                $mQueryHandler = $this->executeQuery($sSql);
                $aUserInfo = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aUserInfo);
                if (!$nCountRecord || sha1($aUserInfo[0]['salt'] . $aValidationDetails['value'][1]) != $aUserInfo[0]['password']) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                } else {
                    unset($aUserInfo[0]['salt']);
                    unset($aUserInfo[0]['password']);
                    $bIsValid = $aUserInfo;
                }
            }
            if ($aValidationDetails['validation'] == "isClientLoggedin") {
                $sAndWhere = '1 = 1';

                $sAndWhere .= ' AND ' . $aValidationDetails['aCredentials'][0] . '="' . $aValidationDetails['value'][0] . '"';
                //$sAndWhere .= ' AND '.$aValidationDetails['aCredentials'][2].'="'.$aValidationDetails['value'][2].'"';
                $sAndWhere .= ' AND activated = 1 AND deleted = 0';
                $sSql = "SELECT
                                                salt,password," . implode(",", $aValidationDetails['aDataForSession']) .
                        " FROM "
                        . $aValidationDetails['tableName'] .
                        " WHERE " . $sAndWhere;
                $mQueryHandler = $this->executeQuery($sSql);

                $aUserInfo = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aUserInfo);
                if (!$nCountRecord || sha1($aUserInfo[0]['salt'] . $aValidationDetails['value'][1]) != $aUserInfo[0]['password']) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                } else {
                    unset($aUserInfo[0]['salt']);
                    unset($aUserInfo[0]['password']);
                    $bIsValid = $aUserInfo;
                }
            }
            if ($aValidationDetails['validation'] == "isVerified") {
                $sAndWhere = '1 = 1';

                $sAndWhere .= ' AND ' . $aValidationDetails['aCredentials'][0] . '="' . $aValidationDetails['value'][0] . '"';
                $sAndWhere .= ' AND ' . $aValidationDetails['aCredentials'][2] . '="' . $aValidationDetails['value'][2] . '"';
                $sAndWhere .= ' AND activated = 1 AND deleted = 0';

                $sSql = "SELECT
                                    salt,password," . implode(",", $aValidationDetails['aDataForSession']) .
                        " FROM "
                        . $aValidationDetails['tableName'] .
                        " WHERE " . $sAndWhere;

                $mQueryHandler = $this->executeQuery($sSql);

                $aUserInfo = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aUserInfo);


                if (!$nCountRecord || sha1($aUserInfo[0]['salt'] . $aValidationDetails['value'][1]) != $aUserInfo[0]['password']) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                } else {
                    unset($aUserInfo[0]['salt']);
                    unset($aUserInfo[0]['password']);
                    $bIsValid = $aUserInfo;
                }
            }
            if ($aValidationDetails['validation'] == "isLogged") {
                $sAndWhere = '1 = 1';

                $sAndWhere .= ' AND ' . $aValidationDetails['aCredentials'][0] . '="' . $aValidationDetails['value'][0] . '"';
                //$sAndWhere .= ' AND '.$aValidationDetails['aCredentials'][1].'="'.$aValidationDetails['value'][1].'"';
                //$sAndWhere .= ' AND activated = 1 AND deleted = 0';

                $sSql = "SELECT
                                    password," . implode(",", $aValidationDetails['aDataForSession']) .
                        " FROM "
                        . $aValidationDetails['tableName'] .
                        " WHERE " . $sAndWhere;

                $mQueryHandler = $this->executeQuery($sSql);

                $aUserInfo = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aUserInfo);

                if (!$nCountRecord || md5($aValidationDetails['value'][1]) != $aUserInfo[0]['password']) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                } else {
                    $bIsValid = $aUserInfo;
                }
            }
            if ($aValidationDetails['validation'] == "isUniqueSlug") {
                
                $sAndWhere = " 1 = 1";
                foreach ($aValidationDetails['table_fields_and_values'] as $sName => $sValue) {
                    !empty($sValue) ? $sAndWhere .= " AND " . $sName . "='" . $sValue . "'" : '';
                 }
                !empty($aValidationDetails['table_field_value']) ? $sAndWhere .= " AND ". $aValidationDetails['table_field_id']."!=".$aValidationDetails['table_field_value'] : '';
                $sAndWhere .= " LIMIT 1";
                $sQuery = " SELECT "
                        . $aValidationDetails['table_field_name'] .
                        " FROM "
                        . $aValidationDetails['table_name'] .
                        " WHERE ".$sAndWhere;
                $mQueryHandler = $this->executeQuery($sQuery);
                $aQueryResult = $this->getData($mQueryHandler, "ARRAY");
                $nCountRecord = count($aQueryResult);
                if ($nCountRecord) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
            }
             if ($aValidationDetails['validation'] == "checkMaxWords") {
                     $nCount =  str_word_count(strip_tags($aValidationDetails['value']));
                  if (!($aValidationDetails['min_length'] <= $nCount && $aValidationDetails['max_length'] >= $nCount)) {
                    $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                    $bIsValid = false;
                }
             }
             if ($aValidationDetails['validation'] == "fileSize") {
                    if (!empty($aValidationDetails['value'][0]) && ($aValidationDetails['value'][0] < $aValidationDetails['validSize']['width'] || $aValidationDetails['value'][1] < $aValidationDetails['validSize']['height'])) {
                        $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                        $bIsValid = false;
                    }
            }
            if ($aValidationDetails['validation'] == "fixedFileSize") {
                    if (!empty($aValidationDetails['value'][0]) && ($aValidationDetails['value'][0] != $aValidationDetails['validSize']['width'] || $aValidationDetails['value'][1] != $aValidationDetails['validSize']['height'])) {
                        $oSession->setError($aValidationDetails['field'], $aValidationDetails['message']);
                        $bIsValid = false;
                    }
            }
        }
        return $bIsValid;
    }
    /**
     * To insert/update records
     * @param type $sTableName
     * @param type $aFields
     * @param type $aData
     * @return type
     */
    public function saveRecords($sTableName, $aFields, $aData) {
        
        $sInsertQuery = "INSERT INTO " . $sTableName . "(" . implode(",", $aFields) . ") VALUES ";
        foreach ($aData as $aValues) {
            $sInsertQuery .= "('" . implode("','", $aValues) . "'),";
        }

        $sInsertQuery = trim($sInsertQuery, ",") . " ON DUPLICATE KEY UPDATE ";

        foreach ($aFields as $sField) {
            $sInsertQuery .= $sField . " = VALUES(" . $sField . "),";
        }
        $sInsertQuery = trim($sInsertQuery, ",");
        return $this->executeQuery($sInsertQuery);
    }
}