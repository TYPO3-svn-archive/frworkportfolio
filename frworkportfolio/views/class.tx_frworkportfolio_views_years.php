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
 * Class that implements the view for Year Menu.
 *
 * @author	Paul Schweppe <paul@fluid-rock.com>
 * @package	TYPO3
 * @subpackage	tx_frworkportfolio
 */

tx_div::load('tx_lib_phpTemplateEngine');

class tx_frworkportfolio_views_years extends tx_lib_phpTemplateEngine {
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/views/class.tx_frworkportfolio_view_Year_Menu.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/views/class.tx_frworkportfolio_view_Year_Menu.php']);
}

?>