<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme functions.
 *
 * @package    theme_solent2019
 * @copyright  2016 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Post process the CSS tree.
 *
 * @param string $tree The CSS tree.
 * @param theme_config $theme The theme config object.
 */
function theme_solent2019_css_tree_post_processor($tree, $theme) {
    $prefixer = new theme_solent2019\autoprefixer($tree);
    $prefixer->prefix();
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_solent2019_get_extra_scss($theme) {
    $content = '';
    $imageurl = $theme->setting_file_url('backgroundimage', 'backgroundimage');

    // Sets the background image, and its settings.
    if (!empty($imageurl)) {
        $content .= 'body { ';
        $content .= "background-image: url('$imageurl'); background-size: cover;";
        $content .= ' }';
    }

    // Always return the background image with the scss when we have it.
    return !empty($theme->settings->scss) ? $theme->settings->scss . ' ' . $content : $content;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_solent2019_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM && ($filearea === 'logo' || $filearea === 'backgroundimage')) {
        $theme = theme_config::load('solent2019');
        // By default, theme files must be cache-able by both browsers and proxies.
        if (!array_key_exists('cacheability', $options)) {
            $options['cacheability'] = 'public';
        }
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_solent2019_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';
    $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
    $fs = get_file_storage();

    $context = context_system::instance();
    if ($filename == 'default.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/solent2019/scss/preset/default.scss');
    } else if ($filename == 'plain.scss') {
        $scss .= file_get_contents($CFG->dirroot . '/theme/solent2019/scss/preset/plain.scss');
    } else if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_solent2019', 'preset', 0, '/', $filename))) {
        $scss .= $presetfile->get_content();
    } else {
        // Safety fallback - maybe new installs etc.
        $scss .= file_get_contents($CFG->dirroot . '/theme/solent2019/scss/preset/default.scss');
    }

    return $scss;
}

/**
 * Get compiled css.
 *
 * @return string compiled css
 */
function theme_solent2019_get_precompiled_css() {
    global $CFG;
    return file_get_contents($CFG->dirroot . '/theme/solent2019/style/moodle.css');
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return array
 */
function theme_solent2019_get_pre_scss($theme) {
    global $CFG;

    $scss = '';
    $configurable = [
        // Config key => [variableName, ...].
        'brandcolor' => ['primary'],
    ];

    // Prepend variables first.
    foreach ($configurable as $configkey => $targets) {
        $value = isset($theme->settings->{$configkey}) ? $theme->settings->{$configkey} : null;
        if (empty($value)) {
            continue;
        }
        array_map(function($target) use (&$scss, $value) {
            $scss .= '$' . $target . ': ' . $value . ";\n";
        }, (array) $targets);
    }

    // Prepend pre-scss.
    if (!empty($theme->settings->scsspre)) {
        $scss .= $theme->settings->scsspre;
    }

    if (!empty($theme->settings->fontsize)) {
        $scss .= '$font-size-base: ' . (1 / 100 * $theme->settings->fontsize) . "rem !default;\n";
    }

    return $scss;
}

// SSU_AMEND START - ADD SECTIONS DROPDOWN
function solent_number_of_sections(){
	global $CFG, $COURSE,$PAGE, $USER, $DB;
	if ($PAGE->user_is_editing()){
// 		$i = 1;
//     $courseformat = course_get_format($COURSE);
//     $numsections = $courseformat->get_last_section_number();
// //var_dump($numsections);die();
		$oncoursepage = substr($_SERVER['REQUEST_URI'] ,1,11);
 		if ($oncoursepage == 'course/view'){
// 			echo 	'<div class="divcoursefieldset">
// 					<fieldset class="coursefieldset">
// 					<form action="'. $CFG->wwwroot .'/local/add_sections_query.php" method="post">
// 					<label for "secnumbers">Number of Weeks/Topics/Tabs:&nbsp;
// 					<select name="secnumbers">';
//       $i=1;
// 			while ($i<=52) { //use system config here
// 				   //if ($i == 0){
// 					  // $selected = 'selected = "selected"';
// 					//	}else{
// 					//	$selected ='';
// 					//	}
// 					   echo '<option value="'.$i.'"  '.$selected.'>'.$i++.' </option>';
// 			}
//
// 			echo '<input type="hidden" name="courseid" value="'. $COURSE->id .'"/>';
// 			echo '&nbsp;&nbsp;&nbsp;<input type="submit" value ="Save">
// 				 </select></label></form></fieldset></div>';


			if ($COURSE->id > 1){
				//if($COURSE->format == 'onetopic'){
					//get current option
					$option = $DB->get_record('theme_header', array('course' => $COURSE->id), '*');
					$dir = dirname(__FILE__).'/pix/unit-header';
					$files = scandir($dir);
					array_splice($files, 0, 1);
					array_splice($files, 0, 1);

					$options = array();
					foreach ($files as $k=>$v) {
						$img = substr($v, 0, strpos($v, "."));
						$options[$img] = $img;
					}

					$sections = '<div class="divcoursefieldset"><fieldset class="coursefieldset fieldsetheader">
							 <form action="'. $CFG->wwwroot .'/theme/solent2019/set_header_image.php" method="post">
							 <label for "opt">Select header image (<a href="/theme/solent2019/pix/unit-header/options.php" target="_blank">browse options</a>):&nbsp;
							 <select name="opt">';

					$sections .= '<option value="00">No image</option>';
					foreach($options as $key=>$val){
						if(($val != 'options') && ($val != 'succeed') && ($val != '')){
							$sections .= '<option value="' . $key . '"';
              if($key == $option->opt) {
                $sections .= 'selected="selected"';
              }
                $sections .= '>Option ' . $val . '</option>';
						}
					}

					$sections .= '  <input type="hidden" name="course" value="'. $COURSE->id .'"/>';
					$sections .= '  <input type="hidden" name="id" value="'. $option->id .'"/>';
					$sections .= '&nbsp;&nbsp;&nbsp;<input type="submit" value="Save">
						            </select></label></form></fieldset></div>';
          return $sections;
				//}
			}
		}
	}
}

// SSU_AMEND END
