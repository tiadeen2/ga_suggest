<?php
require_once "lib/ga_keyword.php";


// 取得して改行区切りで出力するだけ
$oGAKeyword = new ga_keyword();
$aResults = $oGAKeyword->getKeywords();

echo join("\n", $aResults);
