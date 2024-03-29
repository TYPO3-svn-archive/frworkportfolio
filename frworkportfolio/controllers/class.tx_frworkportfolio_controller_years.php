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
 * Class that implements the controller "years" for tx_frworkportfolio. Year menu for the
 * client work portfolios. Show portfolios for particular years
 *
 * @author	Paul Schweppe <paul@fluid-rock.com>
 * @package	TYPO3
 * @subpackage	tx_frworkportfolio
 */

tx_div::load('tx_lib_controller');

class tx_frworkportfolio_controller_years extends tx_lib_controller {

	var $targetControllers = array();

    function tx_frworkportfolio_controller_years($parameter1 = null, $parameter2 = null) {
        parent::tx_lib_controller($parameter1, $parameter2);
        $this->setDefaultDesignator('tx_frworkportfolio');
    }
    
	/**
	 * Implementation of listcategoriesAction()
	 */
    function listyearsAction() {
    	
        $modelClassName = tx_div::makeInstanceClassName('tx_frworkportfolio_models_years');
      
        $viewClassName = tx_div::makeInstanceClassName('tx_frworkportfolio_views_years');
        $entryClassName = tx_div::makeInstanceClassName('tx_frworkportfolio_views_years');
		$translatorClassName = tx_div::makeInstanceClassName('tx_lib_translator');
		
        $view = new $viewClassName($this);
        
        $model = new $modelClassName($this);
        $model->clientWorkFolder = (int) $this->configurations->get('clientWorkFolder');
        
        $result = $model->load($this->parameters);
      
        for($model->rewind(); $model->valid(); $model->next()) {
            $entry = new $entryClassName($model->current(), $this);
            $view->append($entry);
        }

        $view->setPathToTemplateDirectory('EXT:frworkportfolio/templates/');
        $out = $view->render('yearmenu');
        
        return $out;
    }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/controllers/class.tx_frworkportfolio_controller_default1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/controllers/class.tx_frworkportfolio_controller_default1.php']);
}

?>