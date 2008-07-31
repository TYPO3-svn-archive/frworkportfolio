<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_frworkportfolio_record"] = array (
	"ctrl" => $TCA["tx_frworkportfolio_record"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,title,client,project,year,cms,options,category,url,url_caption,flash,gallery,gallerycaptions"
	),
	"feInterface" => $TCA["tx_frworkportfolio_record"]["feInterface"],
	"columns" => array (
		't3ver_label' => array (		
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max'  => '30',
			)
		),
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_frworkportfolio_record',
				'foreign_table_where' => 'AND tx_frworkportfolio_record.pid=###CURRENT_PID### AND tx_frworkportfolio_record.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(0, 0, 0, 12, 31, 2020),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "80",	
				"eval" => "required,trim",
			)
		),
		"client" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.client",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "80",	
				"eval" => "required,trim",
			)
		),
		"project" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.project",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "80",	
				"eval" => "trim",
			)
		),
		"year" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.year",		
			"config" => Array (
				"type"     => "input",
				"size"     => "8",
				"max"      => "20",
				"eval"     => "date",
				"checkbox" => "0",
				"default"  => "0"
			)
		),
		"cms" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.cms",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"options" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.options",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_frworkportfolio_options",	
				"foreign_table_where" => "ORDER BY tx_frworkportfolio_options.uid",	
				"size" => 3,	
				"minitems" => 0,
				"maxitems" => 15,	
				"MM" => "tx_frworkportfolio_record_options_mm",
			)
		),
		"category" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.category",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_frworkportfolio_category",	
				"foreign_table_where" => "ORDER BY tx_frworkportfolio_category.uid",	
				"size" => 3,	
				"minitems" => 0,
				"maxitems" => 10,	
				"MM" => "tx_frworkportfolio_record_category_mm",
			)
		),
		"url" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.url",		
			"config" => Array (
				"type"     => "input",
				"size"     => "15",
				"max"      => "255",
				"checkbox" => "",
				"eval"     => "trim",
				"wizards"  => array(
					"_PADDING" => 2,
					"link"     => array(
						"type"         => "popup",
						"title"        => "Link",
						"icon"         => "link_popup.gif",
						"script"       => "browse_links.php?mode=wizard",
						"JSopenParams" => "height=300,width=500,status=0,menubar=0,scrollbars=1"
					)
				)
			)
		),
		"url_caption" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.url_caption",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "80",	
				"eval" => "trim",
			)
		),
		"flash" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.flash",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => "",	
				"disallowed" => "php,php3",	
				"max_size" => 1000,	
				"uploadfolder" => "uploads/tx_frworkportfolio",
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"gallery" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.gallery",		
			"config" => Array (
				"type" => "group",
				"internal_type" => "file",
				"allowed" => $GLOBALS["TYPO3_CONF_VARS"]["GFX"]["imagefile_ext"],	
				"max_size" => 1000,	
				"uploadfolder" => "uploads/tx_frworkportfolio",
				"show_thumbs" => 1,	
				"size" => 3,	
				"minitems" => 0,
				"maxitems" => 15,
			)
		),
		"gallerycaptions" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_record.gallerycaptions",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",	
				"rows" => "6",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, title;;;;2-2-2, client;;;;3-3-3, project, year, cms, options, category, url, url_caption, flash, gallery, gallerycaptions")
	),
	"palettes" => array (
		"1" => array("showitem" => "starttime, endtime")
	)
);



$TCA["tx_frworkportfolio_options"] = array (
	"ctrl" => $TCA["tx_frworkportfolio_options"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,title"
	),
	"feInterface" => $TCA["tx_frworkportfolio_options"]["feInterface"],
	"columns" => array (
		't3ver_label' => array (		
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max'  => '30',
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_options.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "80",	
				"eval" => "required,trim",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, title;;;;2-2-2")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_frworkportfolio_category"] = array (
	"ctrl" => $TCA["tx_frworkportfolio_category"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,title"
	),
	"feInterface" => $TCA["tx_frworkportfolio_category"]["feInterface"],
	"columns" => array (
		't3ver_label' => array (		
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array (
				'type' => 'input',
				'size' => '30',
				'max'  => '30',
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"title" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:frworkportfolio/locallang_db.xml:tx_frworkportfolio_category.title",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "80",	
				"eval" => "required,trim",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, title;;;;2-2-2")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);
?>