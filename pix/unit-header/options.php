<?php
require_once('../../../../config.php');
	
require_login(true);
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/theme/solent2017/pix/unit-header/options.php');
$PAGE->set_title('Header options');
$PAGE->set_heading('Header options');
$PAGE->set_pagelayout('standard');
//$PAGE->navbar->add(get_string('enrol-selfservice', 'local_enrolstaff'), new moodle_url('/local/enrolstaff/enrolstaff.php'));
//$PAGE->navbar->add('Enrol onto courses');
//global $USER;
//$return = $CFG->wwwroot.'/local/enrolstaff/enrolstaff.php';	
echo $OUTPUT->header();
echo "<div class='maindiv'>";

$dir = dirname(__FILE__);
$files = scandir($dir);
array_splice($files, 0, 1);
array_splice($files, 0, 1);	
echo '<div">';				
echo '<table id="header-options" ><tr><th align="left" width="10%">Option</th><th>Image</th></tr>';

foreach ($files as $k=>$v) {
	$name = substr($v, 0, strpos($v, "."));
	//Check if the file is an image
	if(strpos($v, 'png') || strpos($v, 'jpg') || strpos($v, 'jepg')){
		if(($name != 'options') && ($v != 'succeed')){
			echo '<tr><td align="left">Option ' .$name . '</td><td><img src="' . $v . '"></td></tr>';					
		}
	}
} 
echo '</table></div></div>';
?>