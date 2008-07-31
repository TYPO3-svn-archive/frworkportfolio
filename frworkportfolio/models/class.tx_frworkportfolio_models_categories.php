<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2006 Elmar Hinz
 *  Contact: elmar.hinz@team-red.net
 *  All rights reserved
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 ***************************************************************/

require_once(t3lib_extMgm::extPath('div') . 'class.tx_div.php');
tx_div::load('tx_lib_object');

class tx_frworkportfolio_models_categories extends tx_lib_object{

    var $folderUid = 0;
    var $languageUid = 0;
    var $recordId;
    var $table;
    var $foreignTable;


    function setLanguage($uid){
        $this->languageUid = $uid;
    }
    
    function setFolder($uid){
        $this->folderUid = $uid;
    }
    
    function setTable($table){
        $this->table = $table;
    }
    
    function setRecordId($recordId){
        $this->recordId = $recordId;
    }
    
    function load(){
        $this->exchangeArray(array()); // empty obj for next load
        $this->rewind();
        $where = ' deleted = 0 and hidden = 0';
        //$where .= ' AND pid = ' . (int) $this->folderUid;
        //$where .= ' AND sys_language_uid = ' . (int) $this->languageUid;
        if($this->recordId){
        	$where .= ' AND ';
        }
        $order = ' title ';
        $query= $GLOBALS['TYPO3_DB']->SELECTquery('*', $this->table, $where, null, $order);
        $result = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
        while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($result)){
            $this->set($row['l18n_parent'] ? $row['l18n_parent'] : $row['uid'], $row['title']);
        }      
    }
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/articles/models/class.tx_articles_models_categories.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/articles/models/class.tx_articles_models_categories.php']);
}
?>
