<?php
require_once "environments.php";
require_once "lib/ga_keyword.php";
require_once "lib/googleanalytics.class.php";

try {
	// create an instance of the GoogleAnalytics class using your own Google {email} and {password}
	$ga = new GoogleAnalytics(SUGGEST_CONF_GA_ACCOUNT, SUGGEST_CONF_GA_PASSWORD);
	
	// set the Google Analytics profile you want to access - format is 'ga:123456';
	$ga->setProfile(SUGGEST_CONF_GA_PROFILE);
	
	// set the date range we want for the report - format is YYYY-MM-DD
	$ga->setDateRange(date('Y-m-d', SUGGEST_CONF_START_DATE), date('Y-m-d', SUGGEST_CONF_END_DATE));
	
	// get the report for date and country filtered by Australia, showing pageviews and visits
	$report = $ga->getReport(
		array('dimensions'=>urlencode('ga:keyword'),
			'metrics'=>urlencode('ga:visits'),
			'sort'=>'-ga:visits'
			)
		);
	
	//print out the $report array
	//print_r($report);

} catch (Exception $e) { 
	print 'Error: ' . $e->getMessage();
}


// キーワードを設定する
$oGAKeyword = new ga_keyword();
$oGAKeyword->setKeywords($report);
?>