<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_extMgm::allowTableOnStandardPages('tx_frworkportfolio_record');


t3lib_extMgm::addToInsertRecords('tx_frworkportfolio_record');

$TCA["tx_frworkportfolio_record"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE, 
		'origUid' => 't3_origuid',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l18n_parent',	
		'transOrigDiffSourceField' => 'l18n_diffsource',	
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'starttime' => 'starttime',	
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_frworkportfolio_record.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, title, client, project, year, cms, options, category, url, url_caption, flash, gallery, gallerycaptions",
	)
);


t3lib_extMgm::allowTableOnStandardPages('tx_frworkportfolio_options');


t3lib_extMgm::addToInsertRecords('tx_frworkportfolio_options');

$TCA["tx_frworkportfolio_options"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_options',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE, 
		'origUid' => 't3_origuid',
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_frworkportfolio_options.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, title",
	)
);


t3lib_extMgm::allowTableOnStandardPages('tx_frworkportfolio_category');


t3lib_extMgm::addToInsertRecords('tx_frworkportfolio_category');

$TCA["tx_frworkportfolio_category"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_category',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE, 
		'origUid' => 't3_origuid',
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_frworkportfolio_category.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, title",
	)
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_mvc1']='layout,select_key,pages,recursive';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_mvc1']='pi_flexform';


t3lib_extMgm::addStaticFile('frworkportfolio', './configurations/mvc1', 'Client Work Portfolio');


t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_mvc1', 'FILE:EXT:frworkportfolio/configurations/mvc1/flexform.xml');


//t3lib_extMgm::addPlugin(array('LLL:EXT:frworkportfolio/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_mvc1'),'list_type');
t3lib_extMgm::addPlugin(array('LLL:EXT:frworkportfolio/locallang_db.xml:tt_content.list_type_pi1', 'frworkportfolio_mvc1'));



if (TYPO3_MODE=="BE")	$TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_frworkportfolio_mvc1_wizicon"] = t3lib_extMgm::extPath($_EXTKEY).'configurations/mvc1/class.tx_frworkportfolio_mvc1_wizicon.php';
?>