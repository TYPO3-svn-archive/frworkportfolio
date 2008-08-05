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
 * Class that implements the model for table tx_frworkportfolio_record.
 *
 * Work Portfolio Years
 *
 *
 * @author	Paul Schweppe <paul@fluid-rock.com>
 * @package	TYPO3
 * @subpackage	tx_frworkportfolio
 */

class tx_frworkportfolio_models_years extends tx_lib_object {

		var $clientWorkFolder;
		
        function tx_frworkportfolio_models_years($controller = null, $parameter = null) {
                parent::tx_lib_object($controller, $parameter);
        }

        function load($parameters = null) {

                // fix settings
                $fields = 'MIN(year) as minyear, MAX(year) as maxyear';
                $tables = 'tx_frworkportfolio_record';
                $groupBy = 'deleted';
                $orderBy = 'sorting';
                $where = 'hidden = 0 AND deleted = 0 AND pid='.intval($this->clientWorkFolder);

                // variable settings
                if($parameters) {

                }

                // query
                $query = $GLOBALS['TYPO3_DB']->SELECTquery($fields, $tables, $where, $groupBy, $orderBy);

                $result = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fields, $tables, $where, $groupBy, $orderBy);
                if($result) {
                    while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {

                    		$startyear = mktime(0,0,0,1,1,date('Y',$row['minyear']));
                    		$endYear = mktime(23,59,59,12,31,date('Y',$row['maxyear']));

                    		while ($startyear < $endYear){
                    			$years = array('yeartimestamp' => $startyear,
                    							'yeartext'=> date("Y",$startyear));
                    			$startyear = strtotime(date("Y-m-d", $startyear) . " +1 year");
                    			
                    			$entry = new tx_lib_object($years);
                            	$this->append($entry);
                    		}
                    		
                            
                    }
                }
        }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/models/class.tx_frworkportfolio_models_category.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/models/class.tx_frworkportfolio_models_category.php']);
}

?>