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
	
		var $paging;
		var $fields;
		var $local_table;
		var $mm_table;
		var $foreign_table;
		var $groupBy;
		var $orderBy;
		var $where;
		var $limit;
		var $yearFolder;
		var $clientWorkFolder;
		var $optionsFolder;
		
        function tx_frworkportfolio_models_clientswork($controller = null, $parameter = null) {
                parent::tx_lib_object($controller, $parameter);
                $this->init();
        }
        
        function init(){
        	// fix settings
            $this->fields = '*';
            $this->local_table = 'tx_frworkportfolio_record';
            $this->mm_table = 'tx_frworkportfolio_record_category_mm';
            $this->foreign_table = 'tx_frworkportfolio_category';
            $this->groupBy = '';
            $this->orderBy = 'tx_frworkportfolio_record.sorting';
            $this->where = ' AND tx_frworkportfolio_record.hidden = 0 AND tx_frworkportfolio_record.deleted = 0';
            $this->limit = '';

        }

        function load($parameters = null) {

                if($parameters) {
                	
                	if($parameters->get('cat')){
                		$this->where .= ' AND uid_foreign = '.intval($parameters->get('cat'));
                	}
                	
                	if($parameters->get('year')){
                		$startOfYear = intval($parameters->get('year'));
                		$endOfYear = mktime(23,59,59,12,31,date('Y',$startOfYear));
                		$this->where .= ' AND tx_frworkportfolio_record.year BETWEEN '.$startOfYear.' AND '.$endOfYear;
                	}
                	
                	if($this->paging){
                			$this->limit = intval($parameters->get('currentPage')).','.intval($parameters->get('recordsPerPage'));
                	}
                }
                
                $this->where .= ' AND tx_frworkportfolio_record.pid = '.intval($this->clientWorkFolder);
           
				
                // query
                $result = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query($this->fields,
                														$this->local_table,
                														$this->mm_table,
                														$this->foreign_table,
                														$this->where,
                														$this->groupBy,
                														$this->orderBy,
                														$this->limit);
                
                if($result) {
                    while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)) {
                    		if(key_exists('uid_local',$row)){
                    	  		$row['options'] = $this->getOptions($row['uid_local']);
                    	  		$row['rggallery'] = $this->getGallery($row['gallery'],$row['galleryCaptions']);
                    		}
                    		$row['currentPage'] = intVal($parameters->get('currentPage'));
                    		
                			$entry = new tx_lib_object($row);
                        	$this->append($entry);
                    		
                            
                    }
                }
        }
        
        function getOptions($id){
        	$category = tx_div::makeInstance('tx_frworkportfolio_models_category');
			//$category->tables = 'tx_frworkportfolio_record';
			
			$category->recordId = $id;
			$category->pid = $this->optionsFolder;
			
			$category->foreignTable ='tx_frworkportfolio_options';
			$category->mmtable = 'tx_frworkportfolio_record_options_mm';
			$category->fields = '*';
			$category->orderBy = 'tx_frworkportfolio_record_options_mm.sorting';
			$category->load();
		
			return $category;
        }
        
        function getGallery($images,$imageCaptions){
        	$gallery = tx_div::makeInstance('tx_frworkportfolio_models_gallery');
			//print_r($this->controller->configurations->get('rgsmoothgallery.'));
			$gallery->setConfig($this->controller->configurations->get('rgsmoothgallery.'));
			$gallery->setGalleryImages($images);
			$gallery->setGalleryCaptions($imageCaptions);
			$gallery->load();
		
			return $gallery;
        	
        }
   
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/models/class.tx_frworkportfolio_models_clientswork.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/models/class.tx_frworkportfolio_models_clientswork.php']);
}

?>