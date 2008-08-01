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
 * Class that implements the controller "default1" for tx_frworkportfolio.
 *
 * @author	Paul Schweppe <paul@fluid-rock.com>
 * @package	TYPO3
 * @subpackage	tx_frworkportfolio
 */

tx_div::load('tx_lib_controller');

class tx_frworkportfolio_controller_category extends tx_lib_controller {

	var $targetControllers = array();
	//var $defaultAction = 'show';

    function tx_frworkportfolio_controller_category($parameter1 = null, $parameter2 = null) {
    	//print_r(__FUNCTION__);
        parent::tx_lib_controller($parameter1, $parameter2);
        $this->setDefaultDesignator('tx_frworkportfolio');
    }
    
	/**
	 * Implementation of listcategoriesAction()
	 */
    function listcategoriesAction() {
    	
        $modelClassName = tx_div::makeInstanceClassName('tx_frworkportfolio_models_category');
      
        $viewClassName = tx_div::makeInstanceClassName('tx_frworkportfolio_views_category');
        //$entryClassName = tx_div::makeInstanceClassName($this->configurations->get('entryClassName'));
        $entryClassName = tx_div::makeInstanceClassName('tx_frworkportfolio_views_category');
		$translatorClassName = tx_div::makeInstanceClassName('tx_lib_translator');
		
        $view = new $viewClassName($this);
        //$view = tx_div::makeInstance('tx_frworkportfolio_views_category');
        //$view->controller($this);
        
        $model = new $modelClassName($this);
        //$model = tx_div::makeInstance('tx_frworkportfolio_models_workportfolio');
        $model->tables = 'tx_frworkportfolio_category';
        $result = $model->load($this->parameters);
      
        for($model->rewind(); $model->valid(); $model->next()) {
            $entry = new $entryClassName($model->current(), $this);
            $view->append($entry);
        }
        //$view->exchangeArray($result);
        $view->setPathToTemplateDirectory('EXT:frworkportfolio/templates/');
        $out = $view->render('category');
        
		//$translator = new $translatorClassName($this, $view);
		//$out = $translator->translateContent();
        return $out;
    }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/controllers/class.tx_frworkportfolio_controller_category.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/controllers/class.tx_frworkportfolio_controller_category.php']);
}

?>