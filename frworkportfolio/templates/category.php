<?php
/**
 * Template for category menu
 *
 * 
 */
?>

<?php if (!defined ('TYPO3_MODE'))      die ('Access denied.'); 

$link = tx_div::makeInstance('tx_lib_link');
$link->destination($GLOBALS['TSFE']->id);
$link->designator($this->getDesignator());
$link->noHash();

?>

<?php if($this->isNotEmpty()) { ?>
        <ul>
<?php } ?>
<?php for($this->rewind(); $this->valid(); $this->next()) {
     $entry = $this->current();
     $link->parameters(array('cat' => $entry->get('uid'), 'backId' => $this->getDestination()));
     $link->label($entry->get('title'));
?>
        <li>
			<?php echo $link->makeTag();?>
        </li>
<?php } ?>
<?php if($this->isNotEmpty()) { ?>
        </ul>
<?php } ?>

