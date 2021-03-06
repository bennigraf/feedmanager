<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as 
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Plugin' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'Model' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'View' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'Controller' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'Model/Datasource' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'Model/Behavior' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'Controller/Component' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'View/Helper' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'Vendor' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'Console/Command' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */


// Some custom configuration for this installation of this app:
include('feedmanager.php');

// Some more general configuration data:

// language-settings provided for itunesu-feeds
Configure::write('itunesu-feed-languages', array(
	'de' => 'German',
	'en' => 'English',
	'fr' => 'Frech',
	'es' => 'Spanish',
	'pt' => 'Portuguese',
	'zh' => 'Chinese'));


// hd-format-codes (to determine hd content)
Configure::write('itunesu-format-codes.hd', array(
	'com.apple.video.appletv.hd',
	'com.apple.video.computer.hd',
	'com.apple.video.computer.sd',
	'com.apple.video.appletv.sd'
	));
// sd-format-codes (to determine sd content)
Configure::write('itunesu-format-codes.sd', array(
	'com.apple.video.ipod.lc',
	'com.apple.video.ipod.sd'
	));
// audio-format-codes (to determine audio-only content)
Configure::write('itunesu-format-codes.audio', array(
	'com.apple.audio'
	));
	
// iTunes U Categories for items
Configure::write('itunesu-categories', array(
	'Fine Arts' => array(  
		'102107' => 'Music',
		'102100' => 'Architecture',
		'102101' => 'Art',
		'102102' => 'Art History',
		'102103' => 'Dance',
		'102104' => 'Film',
		'102105' => 'Graphic Design',
		'102106' => 'Interior Design',
		'102108' => 'Theater'
	),
	
	'Business' => array(
		'100100' => 'Economics',
		'100101' => 'Finance',
		'100102' => 'Hospitality',
		'100103' => 'Management',
		'100104' => 'Marketing',
		'100105' => 'Personal Finance',
		'100106' => 'Real Estate'
	),

	// 101 Engineering
	'Engineering' => array(
		'101100' => 'Chemical & Petroleum',
		'101101' => 'Civil',
		'101102' => 'Computer Science',
		'101103' => 'Electrical',
		'101104' => 'Environmental',
		'101105' => 'Mechanical'
	),
	
	'Health & Medicine' => array(
		'103100' => 'Anatomy & Physiology',
		'103101' => 'Behavioral Science',
		'103102' => 'Dentistry',
		'103103' => 'Diet & Nutrition',
		'103104' => 'Emergency',
		'103105' => 'Genetics',
		'103106' => 'Gerontology',
		'103107' => 'Health & Exercise Science',
		'103108' => 'Immunology',
		'103109' => 'Neuroscience',
		'103110' => 'Pharmacology & Toxicology',
		'103111' => 'Psychiatry',
		'103112' => 'Public Health',
		'103113' => 'Radiology'
	),
	
	'History' => array(
		'104100' => 'Ancient',
		'104101' => 'Medieval',
		'104102' => 'Military',
		'104103' => 'Modern',
		'104104' => 'African',
		'104105' => 'Asian',
		'104106' => 'European',
		'104107' => 'Middle Eastern',
		'104108' => 'North American',
		'104109' => 'South American'
	),
	
	'Humanities' => array(
		'105100' => 'Communications',
		'105101' => 'Philosophy',
		'105102' => 'Religion'
	),
	
	'Language' => array(
		'106100' => 'African',
		'106101' => 'Ancient',
		'106102' => 'Asian',
		'106103' => 'Eastern European/Slavic',
		'106104' => 'English',
		'106105' => 'English Language Learners',
		'106106' => 'French',
		'106107' => 'German',
		'106108' => 'Italian',
		'106109' => 'Linguistics',
		'106110' => 'Middle Eastern',
		'106111' => 'Spanish & Portuguese',
		'106112' => 'Speech Pathology'
	),
	
	'Literature' => array(
		'107100' => 'Anthologies',
		'107101' => 'Biography',
		'107102' => 'Classics',
		'107103' => 'Criticism',
		'107104' => 'Fiction',
		'107105' => 'Poetry'
	),

	'Mathematics' => array(
		'108100' => 'Advanced Mathematics',
		'108101' => 'Algebra',
		'108102' => 'Arithmetic',
		'108103' => 'Calculus',
		'108104' => 'Geometry',
		'108105' => 'Statistics'
	),
	
	'Science' => array(
		'109100' => 'Agricultural',
		'109101' => 'Astronomy',
		'109102' => 'Atmospheric',
		'109103' => 'Biology',
		'109104' => 'Chemistry',
		'109105' => 'Ecology',
		'109106' => 'Geography',
		'109107' => 'Geology',
		'109108' => 'Physics'
	),
	
	'Social Science' => array(
		'110100' => 'Law',
		'110101' => 'Political Science',
		'110102' => 'Public Administration',
		'110103' => 'Psychology',
		'110104' => 'Social Welfare',
		'110105' => 'Sociology'
	),
	
	'Society' => array(
		'111100' => 'African-American Studies',
		'111101' => 'Asian Studies',
		'111102' => 'European & Russian Studies',
		'111103' => 'Indigenous Studies',
		'111104' => 'Latin & Caribbean Studies',
		'111105' => 'Middle Eastern Studies',
		'111106' => 'Women’s Studies'
	),
		
	'Teaching & Education' => array(
		'112100' => 'Curriculum & Teaching',
		'112101' => 'Educational Leadership',
		'112102' => 'Family & Childcare',
		'112103' => 'Learning Resources',
		'112104' => 'Psychology & Research',
		'112105' => 'Special Education'
	),
));




// Some small helpers

// Delete directory recursively. Use php's built in function, since that seems more secure than doing exec() or system()
function delete_directory($dirname) {
	$dir_handle = false;
	if (is_dir($dirname))
		$dir_handle = opendir($dirname);
	if (!$dir_handle)
		return false;
	while($file = readdir($dir_handle)) {
		if ($file != "." && $file != "..") {
			if (!is_dir($dirname."/".$file))
				unlink($dirname."/".$file);
			else
				delete_directory($dirname.'/'.$file);     
		}
	}
	closedir($dir_handle);
	if(!rmdir($dirname))
		return false;
	return true;
}
