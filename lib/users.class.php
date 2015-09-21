<?php

/**
 * StepIn Solutions venture
 * 
 *
 * @package Stepone 
 */
class users extends siCommon {

    // constructor
    public function __construct() {
        $this->oSession = new sessionManager();
        $sDbHost = getconfig('dbHost');
        $sDbUser = getconfig('dbUser');
        $sDbPassword = getconfig('dbPassword');
        $sDbName = getconfig('dbName');

        //$this->oObject = new siCommon($sDbHost,$sDbUser,$sDbPassword,$sDbName);
        parent::__construct($sDbHost, $sDbUser, $sDbPassword, $sDbName);
    }

    // Do Login
    public function doLogin($sUserCredential, $aSaveUserSession = array()) {
        if (!empty($aSaveUserSession)) {
            $nIdUser = isset($sUserCredential[0]['id_admin']) ? $sUserCredential[0]['id_admin'] : $sUserCredential[0]['id_user'];
            $nVerificationKey = isset($aSaveUserSession['verification_key']) ? $aSaveUserSession['verification_key'] : '';
            $sDateTimeFormat = getConfig('dtDateTime');
            $dCreatedAt = date($sDateTimeFormat);

            if (!empty($nIdUser)) {
                $sTableName = 'user_session';
                $aInsertFieldArray = array
                    (
                    'id_user',
                    'login_datetime',
                    'verification_key',
                );
                $aInsertValueArray = array
                    (
                    array
                        (
                        $nIdUser,
                        $dCreatedAt,
                        $nVerificationKey
                    )
                );

                $this->saveRecords($sTableName, $aInsertFieldArray, $aInsertValueArray);
                $nId = mysql_insert_id();
                $sUserCredential[]['use_session_id'] = $nId;
            }
        }
        $this->oSession->setSession(getconfig('sSessionName'), $sUserCredential);
    }

    // Is Logedin
    public function isLoggedin() {
        return $this->oSession->getSession(getconfig('sSessionName'));
    }

    // Do LogOut
    public function doLogOut() {
        
        $aUserSession = $this->oSession->getSession(getconfig('sSessionName'));
            
            $sDateTimeFormat = getConfig('dtDateTime');
            $dCreatedAt = date($sDateTimeFormat);
            $nIdUser = isset ($aUserSession[0]['id_admin']) ? $aUserSession[0]['id_admin'] : $aUserSession[0]['id_user'] ;
            if(!empty($nIdUser))
            {

                $sTableName = 'user_session';
                $aInsertFieldArray = array
                                          (
                                             'id_user_session',
                                             'logout_datetime',
                                             'verification_key'
                                          );
                $aInsertValueArray =array
                                        ( array
                                                (
                                                  isset($aUserSession[0]['use_session_id'])?$aUserSession[0]['use_session_id'] : $aUserSession[0]['id_user'],  
                                                  $dCreatedAt,
                                                  ''
                                                )
                                         );
                $this->saveRecords($sTableName,$aInsertFieldArray,$aInsertValueArray);

            }
        $this->oSession->removeSession();
    }

    /**
     * function for varification of registered user
     * @param type $sVerificationKey
     * @return boolean
     */
    public function getListingUser() {
       
        $sSql = "SELECT 
                            *
                    FROM
                            users";
                    
        $sQueryHendler = $this->getList($sSql, array(), array(), array(), array(), array());
        return $this->getData($sQueryHendler, "ARRAY");
    }

    /**
     * 
     * @param type $sEmail
     * @param type $aLimit
     * @param type $aGroupBy
     * @param type $aSearch
     * @param type $aSort
     * @param type $sMode
     * @return type
     */
    public function getUserCredential($sEmail, $aLimit = array(), $aGroupBy = array(), $aSearch = array(), $aSort = array(), $sMode = '') {
        if (empty($sEmail))
            return false;

        $sAndWhere = " 1 = 1 ";
        $sAndWhere .= " AND u.email =" . "'" . $sEmail . "'";
        $sAndWhere .= " AND u.activated = '1' AND u.deleted = '0'";

        $sQuery = "SELECT
                               id_user, 
                               first_name, 
                               last_name, 
                               user_name, 
                               password, 
                               email, 
                               image, 
                               phone, 
                               address, 
                               description                                       
                         FROM
                               users u
                         WHERE" . $sAndWhere;

        $aClientsInformation = $this->getList($sQuery);
        return $this->getData($aClientsInformation, "ARRAY");
    }

    /**
     * 
     * @param type $aUserData
     * @return type
     */
    public function updateUserCredentials($aUserData) {
        if (count($aUserData) == 0 || !is_array($aUserData))
            return false;
        $sTableName = 'users';
        $dTimeFormet = getConfig('dtDateTime');
        $dDate = date($dTimeFormet);

        $aInsertFieldArray = array(
            'id_user',
            'salt',
            'password',
            'updated_at'
        );
        $aInsertValueArray = array(
            array(
                $aUserData['id_user'],
                $aUserData['salt'],
                $aUserData['password'],
                $dDate
            )
        );
        return $this->saveRecords($sTableName, $aInsertFieldArray, $aInsertValueArray);
    }

    /**
     * get owner details from users where id_user = $nIdUser
     * @param type $nIdUser
     * @param type $aLimit
     * @return type
     */
    public function getUserDetail($nIdUser, $aLimit = array()) {
        if (empty($nIdUser) || !is_numeric($nIdUser))
            return false;

        $sAndWhere = " 1 = 1";
        $sAndWhere .= " AND u.deleted = '0'";
        $sAndWhere .= " AND u.id_user = $nIdUser";
        $sQuery = "SELECT
                               u.id_user AS id_user,
                               u.user_name AS user_name,
                               u.first_name AS first_name,
                               u.last_name AS last_name,
                               u.email AS email,
                               u.phone AS phone,
                               u.image AS image,
                               u.password AS password,
                               u.address AS address,
                               u.description AS description,
                               u.is_super_admin AS is_super_admin
                      FROM
                               users u
                      WHERE" . $sAndWhere;

        $sUSerSiteHandler = $this->getList($sQuery, $aLimit);
        return $this->getData($sUSerSiteHandler, "ARRAY");
    }

    /**
     * 
     * @param type $aUserRegister
     * @return type
     */
    public function userRegister($aUserRegister) {
        if (count($aUserRegister) == 0 || !is_array($aUserRegister))
            return false;
        $sTableName = 'users';
        $dTimeFormet = getConfig('dtDateTime');
        $dDate = date($dTimeFormet);


        $aInsertFieldArray = array(
            'first_name',
            'last_name',
            'user_name',
            'email',
            'password',
            'salt',
            'phone',
            'image',
            'address',
            'description',
            'activated',
            'created_at',
            'updated_at'
        );
        $aInsertValueArray = array(
            array(
                $aUserRegister['first_name'],
                $aUserRegister['last_name'],
                $aUserRegister['user_name'],
                $aUserRegister['email'],
                $aUserRegister['password'],
                $aUserRegister['salt'],
                $aUserRegister['phone'],
                $aUserRegister['image'],
                $aUserRegister['address'],
                $aUserRegister['description'],
                $aUserRegister['activated'],
                $dDate,
                $dDate
            )
        );

        return $this->saveRecords($sTableName, $aInsertFieldArray, $aInsertValueArray);
    }

    /**
     * 
     * @param type $aUserData
     * @return type
     */
    public function updateProfile($aUserData) {

        if (count($aUserData) == 0 || !is_array($aUserData))
            return false;


        $sTableName = 'users';
        $dTimeFormet = getConfig('dtDateTime');
        $dDate = date($dTimeFormet);

        $aInsertFieldArray = array(
            'id_user',
            'first_name',
            'last_name',
            'email',
            'phone',
            'updated_at'
        );


        $aInsertValueArray = array(
            array(
                isset($aUserData['id_user']) ? $aUserData['id_user'] : '',
                $aUserData['first_name'],
                $aUserData['last_name'],
                /* $aUserData['user_name'], */
                $aUserData['email'],
                $aUserData['phone'],
                $dDate
            )
        );


        if (empty($aUserData['id_user'])) {
            $aImageFieldArray = array(
                'salt',
                'password'
            );

            $aInsertFieldArray = array_merge($aInsertFieldArray, $aImageFieldArray);

            $aImageValueArray = array(
                $aUserData['salt'],
                $aUserData['password']
            );

            $aInsertValueArray[0] = array_merge($aInsertValueArray[0], $aImageValueArray);
        }

        if (!empty($aUserData['image'])) {
            $aImageFieldArray = array(
                'image'
            );

            $aInsertFieldArray = array_merge($aInsertFieldArray, $aImageFieldArray);

            $aImageValueArray = array(
                $aUserData['image']
            );

            $aInsertValueArray[0] = array_merge($aInsertValueArray[0], $aImageValueArray);
        }

        if (!empty($aUserData['address'])) {
            $aAddressFieldArray = array(
                'address'
            );

            $aInsertFieldArray = array_merge($aInsertFieldArray, $aAddressFieldArray);

            $aAddressValueArray = array(
                $aUserData['address']
            );

            $aInsertValueArray[0] = array_merge($aInsertValueArray[0], $aAddressValueArray);
        }

        if (!empty($aUserData['description'])) {
            $aDescFieldArray = array(
                'description'
            );

            $aInsertFieldArray = array_merge($aInsertFieldArray, $aDescFieldArray);

            $aDescValueArray = array(
                $aUserData['description']
            );

            $aInsertValueArray[0] = array_merge($aInsertValueArray[0], $aDescValueArray);
        }

        return $this->saveRecords($sTableName, $aInsertFieldArray, $aInsertValueArray);
    }

    public function getAdminDetail() {
        $sAndWhere = '1 = 1';
        $sAndWhere .= " AND a.deleted = '0'";
        $sAndWhere .= " AND a.activated = '1'";
        $sAndWhere .= " AND a.id_admin = $nIdAdmin";
        $sQuery = 'SELECT
               
                            a.admin_name,
                            a.first_name,
                            a.last_name,
                            a.email,
                            a.salt,
                            a.password,
                            a.deleted,
                            a.activated,
                            a.created_at,
                            a.updated_at
                    FROM
                            admins a
                    WHERE
                            ' . $sAndWhere;
        $sAdminSiteHandler = $this->getList($sQuery);
        return $this->getList($sAdminSiteHandler, 'ARRAY');
    }

    /**
     * get all users details
     */
    public function getUserList($aLimit = '') {
        $sAndWhere = " 1 = 1";
        $sAndWhere .= " AND u.activated='1' AND u.deleted = '0'";
        $sQuery = "SELECT
                               u.id_user AS id_user,
                               u.user_name AS user_name,
                               u.first_name AS first_name,
                               u.last_name AS last_name,
                               u.email AS email,
                               u.phone AS phone,
                               u.image AS image,
                               u.password AS password,
                               u.address AS address,
                               u.description AS description 
                      FROM
                               users u
                      WHERE" . $sAndWhere;


        $sUSerSiteHandler = $this->getList($sQuery, $aLimit);
        return $this->getData($sUSerSiteHandler, "ARRAY");
    }

    public function addedituser($aFieldValue) {
        $sTableName = "users";
        $sDateTimeFormat = getConfig('dtDateTime');
        $dCreatedAt = date($sDateTimeFormat);
        $nActivated = '1';
        $nDeleted = '0';
        $aField = array
                        (
                            "id_user",
                            "user_name",
                            "first_name",
                            "last_name",
                            "salt",
                            "password",
                            "email",
                            "image",
                            "phone",
                            "address",
                            "description",
                            "activated",
                            "deleted",
                            "created_at",
                            "updated_at",
                        );
        $aFieldValue = array
                            (
                                array
                                    (
                                    $aFieldValue['id_user'],
                                    $aFieldValue['user_name'],
                                    $aFieldValue['first_name'],
                                    $aFieldValue['last_name'],
                                    $aFieldValue['salt'],
                                    $aFieldValue['password'],
                                    $aFieldValue['email'],
                                    $aFieldValue['image'],
                                    $aFieldValue['phone'],
                                    $aFieldValue['address'],
                                    $aFieldValue['description'],
                                    $nActivated,
                                    $nDeleted,
                                    $dCreatedAt,
                                    $dCreatedAt
                                )
                        );


        $aAddUser = $this->saveRecords($sTableName, $aField, $aFieldValue);

        return $nLastUserId = empty($aFieldValue['id_user']) ? mysql_insert_id() : $aFieldValue['id_user'];
    }

    public function getEmailUserInfo($sEmail) {
        if (empty($sEmail))
            return false;
        $sAndWhere = " 1 = 1";
        $sAndWhere .= " AND deleted = '0' AND activated = '1'";
        $sAndWhere .= " AND email = '" . $sEmail . "'";
        $sQuery = "SELECT
                               id_user, 
                               user_name, 
                               email                                     
                         FROM
                               users
                         WHERE 
                                email =" . "'" . $sEmail . "'";
        $aUsersListHandler = $this->getList($sQuery);
        return $this->getData($aUsersListHandler, "ARRAY");
    }

    public function changePassword($aUsePasswordDetail) {
        $sDateTimeFormat = getConfig('dtDateTime');
        $dUpdatedAt = date($sDateTimeFormat);

        $aFields = array
            (
            'id_user',
            'password',
            'updated_at'
        );
        $asPrepareData = array(
            array(
                $aUsePasswordDetail['id_user'],
                $aUsePasswordDetail['new_password'],
                $dUpdatedAt
            )
        );
        $this->saveRecords("users", $aFields, $asPrepareData);
    }

    public function getLoginSession($bIsValid) {
        $sAndWhere = ' 1 = 1';
        $sAndWhere .= " AND u.deleted = '0' AND u.activated = '1'";
        $sAndWhere .= " AND u.id_user = " . $bIsValid['id_user'];
        $sSql = "SELECT 
                            u.id_user AS id_user,
                            u.user_name AS user_name
                   FROM
                            users u
                   WHERE " . $sAndWhere;

        $sQueryHendler = $this->getList($sSql, array(), array(), array(), array(), array());
        return $this->getData($sQueryHendler, "ARRAY");
    }
    
    /**
    * getUserSessionFromVerification
    * @param type $sVerificationKey
    * @return type
    */
   public function getUserSessionFromVerification($sVerificationKey)
   {
       if(empty($sVerificationKey)) return false;
       $sAndWhere = ' 1 = 1'; 
       $sAndWhere .= " AND u.deleted = '0' AND u.activated = '1'";
       $sAndWhere .= " AND usi.verification_key = ".$sVerificationKey;
       $sSql = "SELECT 
                       usi.id_user as id_user,
                       usi.id_user_session as id_user_session
              FROM
                       user_session usi
              LEFT JOIN
                       users u 
              ON
                       usi.id_user = u.id_user  
              WHERE ".$sAndWhere;

       $sQueryHendler = $this->getList($sSql,array(),array(),array(),array(),array());
       return $this->getData($sQueryHendler,"ARRAY"); 
   } 
   
   /**
     * get all users details
     */
    public function getUserInfo($nIdUser ='') 
    {
        $sAndWhere = " 1 = 1";
        $sAndWhere .= " AND u.id_user =".$nIdUser;
        $sAndWhere .= " AND u.activated='1' AND u.deleted = '0'";
       
        $sQuery = "SELECT
                               u.id_user AS id_user,
                               u.user_name AS user_name,
                               u.first_name AS first_name,
                               u.last_name AS last_name,
                               u.email AS email,
                               u.phone AS phone,
                               u.image AS image,
                               u.password AS password,
                               u.address AS address,
                               u.description AS description 
                      FROM
                               users u
                      WHERE ". $sAndWhere;
        $sUSerSiteHandler = $this->getList($sQuery);
        return $this->getData($sUSerSiteHandler, "ARRAY");
    }
    
    
    public function updateUserPassword($sEmailId) 
    {
        
        $sAndWhere .= " AND u.email =".$sEmailId;
        
        $sQuery = "UPDATE users 
                   SET password='354e2377fcb1bd721ed7d54e86a200629ab06727', salt='7bd87f4e2e958535e010e41a9a712f12'   
                      WHERE ". $sAndWhere;
        $sUSerSiteHandler = $this->getList($sQuery);
        return $this->getData($sUSerSiteHandler, "ARRAY");
    }
    
}




