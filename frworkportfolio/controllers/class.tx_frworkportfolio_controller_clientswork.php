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
 * Class that implements the controller "clientswork" for tx_frworkportfolio. Output a list of 
 * client work portfolios in flash or gallery format
 *
 * @author	Paul Schweppe <paul@fluid-rock.com>
 * @package	TYPO3
 * @subpackage	tx_frworkportfolio
 */

tx_div::load('tx_lib_controller');

class tx_frworkportfolio_controller_clientswork extends tx_lib_controller {

	var $targetControllers = array();

    function tx_frworkportfolio_controller_clientswork($parameter1 = null, $parameter2 = null) {
        parent::tx_lib_controller($parameter1, $parameter2);
        $this->setDefaultDesignator('tx_frworkportfolio');
    }
    
	/**
	 * Implementation of listclientworkAction()
	 */
    function listclientworkAction() {
    	
        $modelClassName = tx_div::makeInstanceClassName('tx_frworkportfolio_models_clientswork');
      
        $viewClassName = tx_div::makeInstanceClassName('tx_frworkportfolio_views_clientswork');
        $entryClassName = tx_div::makeInstanceClassName('tx_frworkportfolio_views_clientswork');
		$translatorClassName = tx_div::makeInstanceClassName('tx_lib_translator');
		
        $view = new $viewClassName($this);

        $model = new $modelClassName($this);
        $model->paging = true;
		$this->parameters->set('recordsPerPage',10);
        $result = $model->load($this->parameters);
      
        for($model->rewind(); $model->valid(); $model->next()) {
            $entry = new $entryClassName($model->current(), $this);
            $view->append($entry);
        }

        $view->setPathToTemplateDirectory('EXT:frworkportfolio/templates/');
        $out = $view->render('clientswork');
        
        return $out;
    }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/controllers/class.tx_frworkportfolio_controller_clientswork.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/controllers/class.tx_frworkportfolio_controller_clientswork.php']);
}

?>