<?php

// Google Analytics情報

// Googleアカウント (Gmailアドレス)
define('SUGGEST_CONF_GA_ACCOUNT', 'calendar@ark-web.jp');
// Googleアカウント パスワード
define('SUGGEST_CONF_GA_PASSWORD', 'oishiso');
// Google Analytics profile ( ga:123456 形式)
define('SUGGEST_CONF_GA_PROFILE', 'ga:405125');


// ビジネスロジック

// suggestで返す文言を何件にするか
define('SUGGEST_CONF_RETURN_NUM', 10);

// GAから取得する期間
define('SUGGEST_CONF_START_DATE', time() - 3600 * 24 * 30 * 2);		// 60日前を指定
define('SUGGEST_CONF_END_DATE',   time());							// 本日


// mysql情報

// 『mysql://DBユーザ:DBパスワード@DBホスト/DB名』のPEAR::DB形式
define('SUGGEST_CONF_MYSQL_INFO', 'mysql://root@localhost/takemura_suggest_utf8');
// DBの文字コード
define('SUGGEST_CONF_MYSQL_CHARSET', 'UTF8');
