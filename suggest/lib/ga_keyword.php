<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'pear');
require_once "environments.php";
require_once "DB.php";

// Google Analyetics で入手したキーワードの管理クラス
class ga_keyword {
	/**
	 * コンストラクタ.
	 */
	function ga_keyword() {
	}
	
	function setKeywords($aReports) {
		// mysql接続
		$oDb = $this->_connectDB();
		
		// 予めデータは削除しておく
		$oDb->query("DELETE FROM ga_keywords;");

		// 今回分を追加していく
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
		// mysql接続
		$oDb = $this->_connectDB();
		
		// 取得
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
		// mysql接続
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