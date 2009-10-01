<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'pear');
require_once "environments.php";
require_once "DB.php";

// Google Analyetics �œ��肵���L�[���[�h�̊Ǘ��N���X
class ga_keyword {
	/**
	 * �R���X�g���N�^.
	 */
	function ga_keyword() {
	}
	
	function setKeywords($aReports) {
		// mysql�ڑ�
		$oDb = $this->_connectDB();
		
		// �\�߃f�[�^�͍폜���Ă���
		$oDb->query("DELETE FROM ga_keywords;");

		// ���񕪂�ǉ����Ă���
		foreach ($aReports as $sKey => $aValue) {
			if ($sKey == '(not set)') continue;
			
			$rPrepare = $oDb->prepare("INSERT INTO ga_keywords (keyword, count) VALUES(?,?);");
			$rResult  = $oDb->execute($rPrepare, array(addslashes($sKey), addslashes($aValue["ga:visits"])));
			if (PEAR::isError($rResult)) {
//				die($rResult->getMessage());
				echo "ERROR: $sKey\n";
			}
		}
	}
	
	function getKeywords() {
		// mysql�ڑ�
		$oDb = $this->_connectDB();
		
		// �擾
		$rPrepare = $oDb->prepare("SELECT keyword
		                             FROM ga_keywords 
		                            WHERE keyword LIKE ? 
		                         ORDER BY count DESC 
		                            LIMIT ?;");
		$rResult = $oDb->execute($rPrepare, array(addslashes($_GET['q']).'%', SUGGEST_CONF_RETURN_NUM));
		if (PEAR::isError($rResult)) {
		//	die($rResult->getMessage());
			echo "ERROR!!";
			exit;
		}

		$aResults = array();
		while ($oRow =& $rResult->fetchRow(DB_FETCHMODE_OBJECT)){
		    $aResults[] = sprintf("%s", $oRow->keyword);
		}
		
		return $aResults;
	}
	
	function _connectDB() {
		// mysql�ڑ�
		$oDb = DB::connect(SUGGEST_CONF_MYSQL_INFO);
		if (PEAR::isError($oDb)) {
		//    die($oDb->getMessage());
			echo "ERROR!!";
			exit;
		}
		$oDb->query('SET NAMES '. SUGGEST_CONF_MYSQL_CHARSET);
		
		return $oDb;
	}
}