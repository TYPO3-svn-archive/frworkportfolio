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

class tx_frworkportfolio_models_clientswork extends tx_lib_object {

        function tx_frworkportfolio_models_clientswork($controller = null, $parameter = null) {
                parent::tx_lib_object($controller, $parameter);
        }

        function load($parameters = null) {

                // fix settings
                $fields = '*';
                $local_table = 'tx_frworkportfolio_record';
                $mm_table = 'tx_frworkportfolio_record_category_mm';
                $foreign_table = 'tx_frworkportfolio_category';
                $groupBy = '';
                $orderBy = 'tx_frworkportfolio_record.sorting';
                $where = ' AND tx_frworkportfolio_record.hidden = 0 AND tx_frworkportfolio_record.deleted = 0';

                // variable settings
                if($parameters) {
                	
                	if($parameters->get('cat')){
                		$where .= ' AND uid_foreign = '.intval($parameters->get('cat'));
                	}
                	
                	if($parameters->get('year')){
                		$startOfYear = intval($parameters->get('year'));
                		$endOfYear = mktime(23,59,59,12,31,date('Y',$startOfYear));
                		$where .= ' AND tx_frworkportfolio_record.year BETWEEN '.$startOfYear.' AND '.$endOfYear;
                	}
                }
				
                // query
                $result = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query($fields,$local_table,$mm_table,$foreign_table,$where,$groupBy,$orderBy);
                
                if($result) {
                    while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
                    		
                    	  	$row['options'] = $this->getOptions($row['uid_local']);
                			$entry = new tx_lib_object($row);
                        	$this->append($entry);
                    		
                            
                    }
                }
        }
        
        function getOptions($id){
        	$category = tx_div::makeInstance('tx_frworkportfolio_models_category');
			//$category->tables = 'tx_frworkportfolio_record';
			
			$category->recordId = $id;
			
			$category->foreignTable ='tx_frworkportfolio_options';
			$category->mmtable = 'tx_frworkportfolio_record_options_mm';
			$category->fields = '*';
			$category->orderBy = 'tx_frworkportfolio_record_options_mm.sorting';
			$category->load();
		
			return $category;
        }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/models/class.tx_frworkportfolio_models_clientswork.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/models/class.tx_frworkportfolio_models_clientswork.php']);
}

?>