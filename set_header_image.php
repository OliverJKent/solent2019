<?php
// SSU_AMEND START - UPDATE HEADER IMAGE
//Called by form in theme/solent20xx/layout/columns3.php
require('../../config.php');
global $DB;

$i = $_POST["id"];
$c = $_POST["course"];
$o = $_POST["opt"];

$record = new stdclass;
$record->id = $i;
$record->course = $c;
$record->opt = $o;

$opt = $DB->get_record('theme_header', array('course' => $c), '*');
$sql = "UPDATE {theme_header} SET opt = ? WHERE course = ?";
$DB->execute($sql, array($o, $c));

header( 'Location: '.$_SERVER['HTTP_REFERER'] ) ; 
// SSU_AMEND END
?>