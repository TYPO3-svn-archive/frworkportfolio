<?php
/**
 * Template for client work portfolio pagination
 */
?>

<?php if (!defined ('TYPO3_MODE'))      die ('Access denied.'); 

$pagingConf = $this->get($type);
		
$paging = tx_div::makeInstance('tx_frworkportfolio_lib_paging');

$paging->extName = 'tx_frworkportfolio';
$paging->recordsPerPage = 10;
//$paging->currentPage = $pagingConf->get('currentPage');
//$paging->totalCurrentRecords = $pagingConf->get('totalCurrentRecords');
$paging->maxPages = 20;
$paging->minPages = 0;
$paging->prevText = '<< Prev';
$paging->nextText = 'Next >>';
$paging->template = '{PREV} <ul>{PAGELIST}</ul> {NEXT}  Displaying {RECORD_FROM} to {RECORD_TO} of {TOTAL_RECORDS}';
$paging->emptyMsg = '';

?>

<?php if($this->isNotEmpty()) { ?>
      
<?php } ?>
<?php for($this->rewind(); $this->valid(); $this->next()) {
     $entry = $this->current();
     $paging->currentPage = $entry->get('currentPage');
	 $paging->totalCurrentRecords = $entry->get('totalCurrentRecords');
?>
        
<?php echo print($paging->render()); ?>
        
<?php } ?>

