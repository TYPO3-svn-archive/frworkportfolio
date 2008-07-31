<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_frworkportfolio_record=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_frworkportfolio_options=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_frworkportfolio_category=1
');
//require_once(t3lib_extMgm::extPath('div') . 'class.tx_div.php');
//if(TYPO3_MODE == 'FE') tx_div::autoLoadAll($_EXTKEY);
?>