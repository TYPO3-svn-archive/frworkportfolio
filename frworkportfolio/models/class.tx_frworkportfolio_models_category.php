<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Paul Schweppe <paul@fluid-rock.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/




/**
 * Class that implements the model for table workportfolio.
 *
 * Work Portfolio
 *
 *
 * @author	Paul Schweppe <paul@fluid-rock.com>
 * @package	TYPO3
 * @subpackage	tx_frworkportfolio
 */

class tx_frworkportfolio_models_category extends tx_lib_object {
		
		var $folderUid = 0;
	    var $languageUid = 0;
	    var $tables;
	    var $fields = '*';
	    var $groupBy = null;
        var $orderBy = 'sorting';
	    var $recordId; // Optional
	    var $foreignTable; // Optional
	    var $mmtable; // Optional
	
    
        function tx_frworkportfolio_models_category($controller = null, $parameter = null) {
                parent::tx_lib_object($controller, $parameter);
        }

        function load($parameters = null) {

                // fix settings
                $fields = '*';
                $tables = 'tx_frworkportfolio_category';
                $groupBy = null;
                $orderBy = 'sorting';
                

                // variable settings
                if($this->recordId) {

                	$where = ' AND '.$this->foreignTable.'.hidden = 0 AND '.$this->foreignTable.'.deleted = 0 ';
                	$where .= ' AND uid_local = '.intval($this->recordId);
                	$result = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query($this->fields,$this->tables,$this->mmtable,$this->foreignTable,$where,$this->groupBy,$this->orderBy);

                }else{
                	$where = ' hidden = 0 AND deleted = 0 ';
                	$result = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $tables, $where, $groupBy, $orderBy);
                }
                if($result) {
                    while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
                        $entry = new tx_lib_object($row);
                        $this->append($entry);
                    }
                }
        }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/models/class.tx_frworkportfolio_models_category.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/models/class.tx_frworkportfolio_models_category.php']);
}

?>