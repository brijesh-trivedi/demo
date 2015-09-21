<?php

/**
 * StepIn Solutions venture
 *
 *
 * @package IFP
 */
class mySql {

	private $mConnection;

	public function __construct($sDbHost = "", $sDbUser = "", $sDbPassword = "", $sDbName = "") 
        {
		$this->mConnection = mysql_pconnect($sDbHost, $sDbUser, $sDbPassword);
		mysql_select_db($sDbName, $this->mConnection);
		$this->executeQuery("SET
                                        character_set_results =  'utf8',
                                        character_set_client = 'utf8',
                                        character_set_connection = 'utf8',
                                            character_set_database = 'utf8',
                                        character_set_server = 'utf8'");
	}

	public function executeQuery($sQuery, $aPlaceHolders = array()) {
		$mQuery = mysql_query($sQuery);
		return $mQuery;
	}

	public function getData($mQueryHandler, $sChoice = "ARRAY") {
		$aRecordSet = array();

		switch ($sChoice) {

			case "ROW":
				$aRecordSet = mysql_fetch_row($mQueryHandler);
				break;

			case "ARRAY":
				while ($aRecord = mysql_fetch_assoc($mQueryHandler)) {
					$aRecordSet[] = $aRecord;
				}
				break;
		}
		return $aRecordSet;
	}

	public function countQueryRow($sQuery) {
		$mQuery = mysql_num_rows($sQuery);
		return $mQuery;
	}

	public function connectionClose() {
		mysql_close($this->mConnection);
	}

}

