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

class tx_frworkportfolio_models_gallery extends tx_lib_object {

		var $config;
		var $uniqueId;
		var $gallery;
		var $galleryImages;
		var $galleryCaptions;
		var $content;
		
		var $lightBox;
		var $lightbox2;
		var $duration;
		var $showThumbs;
		var $arrows;
		var $advancedSettings;
		var $externalControl1;
		var $externalControl2;
		
		var $originalImageFolder = 'uploads/tx_frworkportfolio/';
		
		//Lightbox Image
		var $lightBoxMaxWidth;
		var $lightBoxMaxHeight;
		var $lightBoxParams = 'class="open"';
		
		//Gallery Image
		var $bigImageMaxWidth;
		var $bigImageMaxHeight;
		var $bigImageParams  = 'class="full"';
		
		//Thumb Nail Image
		var $thumbnailMaxWidth;
		var $thumbnailMaxHeight;
		var $thumbnailParams = 'class="thumbnail"';
		
		
        function tx_frworkportfolio_models_gallery($controller = null, $parameter = null) {
                parent::tx_lib_object($controller, $parameter);
                $this->uniqueId = uniqid ();
        }

        function load($parameters = null) {
        	$this->_initaliseGallery();
        }
        
        function _initaliseGallery(){
        	if(!t3lib_extMgm::isLoaded('rgsmoothgallery')){
				die('rgsmoothgallery is not installed.');
			}else{
				require_once( t3lib_extMgm::extPath('rgsmoothgallery').'pi1/class.tx_rgsmoothgallery_pi1.php'); 
		  		$this->gallery = t3lib_div::makeInstance('tx_rgsmoothgallery_pi1');
			}
        }
        
        function setConfig($config){
        	//print_r($config);
        	if ($config['externalControl']==1) {
	          $this->externalControl1 = 'var myGallery'.$uniqueId.';';
	        } else {
	          $this->externalControl2 = 'var';  
	        }
        
        	$this->lightBox = ($config['lightbox']==1) ? 'true' : 'false';
        	$this->lightbox2 = ($config['lightbox']==1) ? 'var mylightbox = new Lightbox();' : '';
        	$this->duration = ($config['duration']) ? 'timed:true,delay: '.$config['duration'] : 'timed:false';
        	$this->showThumbs   = ($config['showThumbs']==1) ? 'true' : 'false';
        	$this->arrows  = ($config['arrows']==1) ? 'true' : 'false';
        	
        	 // advanced settings (from TS + tab flexform configuration)
        	$advancedSettings = ($config['hideInfoPane']==1) ? 'showInfopane: false,' : '';
        	$advancedSettings.=  ($config['hideInfoPane']==1) ? 'showInfopane: false,' : ''; 
        	if ($config['thumbOpacity'] && $config['thumbOpacity'] > 0 && $config['thumbOpacity']<=1){
        		$advancedSettings.= 'thumbOpacity: '.$config['thumbOpacity'].',';
        	}
        	if ($config['slideInfoZoneOpacity'] && $config['slideInfoZoneOpacity'] && $config['slideInfoZoneOpacity'] > 0 && $config['slideInfoZoneOpacity']<=1) {
        		$advancedSettings.= 'slideInfoZoneOpacity: '.$config['slideInfoZoneOpacity'].',';   
        	}
        	$advancedSettings.=  ($config['thumbSpacing']) ? 'thumbSpacing: '.$config['thumbSpacing'].',' : ''; 
    
        	// external thumbs
        	$advancedSettings.= ($config['externalThumbs']) ? 'useExternalCarousel:true,carouselElement:$("'.$config['externalThumbs'].'"),' : '';
        	
        	$this->advancedSettings = $config['advancedSettings'] = $advancedSettings;
        	
        	 // configuration
	    	$config['rgconfiguration']  = '		
	  
	    		<script type="text/javascript">'.$externalControl1.'
	    			function startGallery'.$this->uniqueId.'() {
	    				//alert("PAUL");
	    			  if(window.gallery'.$this->uniqueId.')
	    			    {
	    			    //try
	    			      //{ 
	    				    '.$externalControl2.' myGallery'.$this->uniqueId.' = new gallery($(\'myGallery'.$this->uniqueId.'\'), {
	    					    
	    					    '.$config['duration'].',
	    					      showArrows: '.$config['arrows'].',
	                  showCarousel: '.$config['showThumbs'].',
	                  embedLinks:'.$config['lightbox'].',
	                  '.$advancedSettings.'
	    					    lightbox:true    					    
	    				    });
	    				    
	    				    var mylightbox = new Lightbox();
	    				    //}catch(error){
	    				    //window.setTimeout("startGallery'.$this->uniqueId.'();",2500);
	    				    //}
	    				  }else{
	    				  window.gallery'.$this->uniqueId.'=true;
	    				  if(this.ie)
	    				    {
	    				    window.setTimeout("startGallery'.$this->uniqueId.'();",3000);
	    				    }else{
	    				    window.setTimeout("startGallery'.$this->uniqueId.'();",100);
	    				    }
	    				  }
	    			}
	    			window.onDomReady(startGallery'.$this->uniqueId.');
	    		</script>
	      <noscript>
	  		  <div><img src="typo3temp/pics/0b87c74604.jpg" /></div>
	  		</noscript>
	        ';       
        	
			$this->config = $config;
			$this->_configImages();

         }
        
        function setGalleryImages($galleryImages){
        	$this->galleryImages = explode(',',$galleryImages);
        }
        
        function setGalleryCaptions($galleryCaptions){
      		$this->galleryCaptions = explode("\n",$galleryCaptions);
        }
        
        function _configImages(){
        	$this->bigImageMaxWidth = $this->config['big.']['file.']['maxW'];
		   	$this->bigImageMaxHeight = $this->config['big.']['file.']['maxH'];
		   	
		   	$this->lightBoxMaxWidth = $this->config['lightbox.']['file.']['maxW'];
		   	$this->lightBoxMaxHeight = $this->config['lightbox.']['file.']['maxH'];
		   	
		   	$this->thumbnailMaxWidth = $this->config['thumb.']['file.']['maxW'];
		   	$this->thumbnailMaxHeight = $this->config['thumb.']['file.']['maxH']; 
		   	
        }
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/models/class.tx_frworkportfolio_models_category.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/models/class.tx_frworkportfolio_models_category.php']);
}

?>