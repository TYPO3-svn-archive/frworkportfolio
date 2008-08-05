<?php
/**
 * Template for client work portfolio listing
 */
?>

<?php if (!defined ('TYPO3_MODE'))      die ('Access denied.'); 


$link = tx_div::makeInstance('tx_lib_link');
//$link->destination($this->controller->configurations->get('detailsPage'));
$link->destination($GLOBALS['TSFE']->id);
$link->designator($this->getDesignator());
$link->noHash();

$image = tx_div::makeInstance('tx_lib_image');
$image->maxHeight('400');
$image->maxWidth('600');
$image->width('600');
$image->height('400');


?>

<?php if($this->isNotEmpty()) { ?>
        <ul>
<?php } ?>
<?php for($this->rewind(); $this->valid(); $this->next()) {
     $entry = $this->current();
?>
        <li>
        
        	<?php
        	
        	$image->path('uploads/tx_frworkportfolio/'.$entry->get('gallery'));
        	
        	
        	if(!$entry->get('gallery')){
        		$image->title('This image should be replaced by a flash banner');
        		$entry->getFlash('flash','uploads/tx_frworkportfolio/',$image->make(),$flashvars);
        	}else{
        		$entry->getImageGallery('rggallery');
        		//$image->title($entry->get('caption'));
        		//echo $image->make();
        	}
        	?>
        	
        	<?php 
        	if($entry->get('url')){
        		
        		$link->label('Visit the site >>');
        		$link->destination($entry->get('url'));
        		echo $link->makeTag();
        	}else{
        		echo 'View Screens >>';
        	}
        	?>
        	
			Client: <?php $entry->printAsText('client'); ?><br />
			Project: <?php $entry->printAsText('project'); ?><br />
			Year: <?php $entry->printAsDate('year','%Y'); ?><br />
			CMS: <?php $entry->printAsText('cms'); ?><br />
			<?php $entry->getWorkProfileOptions('options'); ?><br />
        </li>
<?php } ?>
<?php if($this->isNotEmpty()) { ?>
        </ul>
<?php } ?>
