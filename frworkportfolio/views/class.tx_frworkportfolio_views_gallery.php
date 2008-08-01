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
 * Class that implements the view for the smooth gallery.
 *
 * @author	Paul Schweppe <paul@fluid-rock.com>
 * @package	TYPO3
 * @subpackage	tx_frworkportfolio
 */

tx_div::load('tx_lib_phpTemplateEngine');

class tx_frworkportfolio_views_gallery extends tx_lib_phpTemplateEngine {
	
	var $gallery;
	
	function getImageGallery($type) {
		
		$this->gallery = $this->get($type);
		
		//print $this->gallery->content;
		
		 // configuration
	    	$javascriptConf = '		
	  
	    		<script type="text/javascript">'.$this->gallery->externalControl1.'
	    			function startGallery'.$this->gallery->uniqueId.'() {
	    				//alert("PAUL");
	    			  if(window.gallery'.$this->gallery->uniqueId.')
	    			    {
	    			    try
	    			      { 
	    				    '.$this->gallery->externalControl2.' myGallery'.$this->gallery->uniqueId.' = new gallery($(\'myGallery'.$this->gallery->uniqueId.'\'), {
	    					    
	    					    '.$this->gallery->duration.',
	    					      showArrows: '.$this->gallery->arrows.',
	                  showCarousel: '.$this->gallery->showThumbs.',
	                  embedLinks:'.$this->gallery->lightBox.',
	                  '.$this->gallery->advancedSettings.'
	    					    lightbox:true    					    
	    				    });
	    				    
	    				    var mylightbox = new Lightbox();
	    				    }catch(error){
	    				    window.setTimeout("startGallery'.$this->gallery->uniqueId.'();",2500);
	    				    }
	    				  }else{
	    				  window.gallery'.$this->gallery->uniqueId.'=true;
	    				  if(this.ie)
	    				    {
	    				    window.setTimeout("startGallery'.$this->gallery->uniqueId.'();",3000);
	    				    }else{
	    				    window.setTimeout("startGallery'.$this->gallery->uniqueId.'();",100);
	    				    }
	    				  }
	    			}
	    			window.onDomReady(startGallery'.$this->gallery->uniqueId.');
	    			</script>
			      <noscript>
			  		  <div><img src="typo3temp/pics/0b87c74604.jpg" /></div>
			  		</noscript>
	        ';       
        	//print_r($this->gallery->config);
	    	$content =  $this->gallery->gallery->getJs(1,
												    	1,
												    	1,
												    	0,
	    												$this->gallery->config['width'],
	    												$this->gallery->config['height'],
	    												$this->gallery->config['width'],
	    												$this->gallery->config['height'],
	    												'',
	    												$this->gallery->uniqueId,
	    												$this->gallery->config,
	    												$javascriptConf
	    												);
	    												
			$content .= $this->gallery->gallery->beginGallery($this->gallery->uniqueId);
			$content .= $this->initGalleryImages();
			$content .= $this->gallery->gallery->endGallery(); 
			
	    	print_r($content);

         }
         
         function initGalleryImages(){
        	$i = 0;
        	foreach ($this->gallery->galleryImages as $image){
        		$path = $this->gallery->originalImageFolder.$image;
        		$text =explode('|',$this->gallery->galleryCaptions[$i]);
        		
        		$imageContent .= $this->_addImage(
					    $path,
		          		$text[0], 
		            	$text[1],
		          		true,
		          		true,
		          		$path
		        );
        	}
        	return $imageContent;
        }
        
        function _addImage($path,$title,$description,$thumb,$lightbox,$uniqueID,$limitImages=0) {
        	
		    //if ($this->config['hideInfoPane']!=1) {
		      $text = (!$title) ? '' : "<h3>$title</h3>";
		      $text.=(!$description) ? '' : "<p>$description</p>";
		    //}
		    
			$image = tx_div::makeInstance('tx_lib_image');
			//Set path of orginal image
			$image->path($path);
			$image->title('Open Image');
			
		    //  generate big image
		   	$image->maxWidth($this->gallery->bigImageMaxWidth);
		   	$image->maxHeight($this->gallery->bigImageMaxHeight);
		   	$image->params($this->gallery->bigImageParams);
	      	$bigImage = $image->make();
	      	
	      	// Generates lightbox image 
		   	$image->maxWidth($this->gallery->lightBoxMaxWidth);
		   	$image->maxHeight($this->gallery->lightBoxMaxHeight);
		   	$image->params($this->gallery->lightBoxParams);
	      	$lightBoxImage = $image->make();
	      	
	      	//Generate Thumbnail image
		   	$image->maxWidth($this->gallery->thumbnailMaxWidth);
		   	$image->maxHeight($this->gallery->thumbnailMaxHeight);
		   	$image->params($this->gallery->thumbnailParams);
		    $thumbImage = $image->make();
	      	
		   	     
		    //print_r($this->getImageSRC($image->make()));
		    $lightbox =  ($this->gallery->lightBox ? $this->getImageSRC($lightBoxImage) : 'javascript:void(0)' );
		    //$lightbox = '<a href="javascript:void(0)" title="Open Image" class="open"></a>' ;
		  	$lightBoxImage = '<a href="'.$lightbox.'" title="Open Image" class="open"></a>';
		
		    // build the image element    
		    $singleImage .= '
		      <div class="imageElement">
		        '.$text.$lightBoxImage.'
		        '.$bigImage.'
		        '.$thumbImage.'
		      </div>';      
		    return $singleImage;
		 }
		 
		 /**
		  * Gets the src value from a img tag
		  *
		  * @param unknown_type $imageTag
		  * @return unknown
		  */
		 function getImageSRC($imageTag){
		 	$h1count = preg_match_all('/(src=.)([a-zA-Z0-9\s\/\.\_]{2,})/',$imageTag,
			$patterns);
		
			if(is_array($patterns[2])){
				return $patterns[2][0];
			}else{
			    return false; 
			}
		 }
		

}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/views/class.tx_frworkportfolio_views_gallery.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/frworkportfolio/views/class.tx_frworkportfolio_views_gallery.php']);
}

?>