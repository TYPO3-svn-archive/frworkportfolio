<?php
/**
 * Example template for phpTemplateEngine.
 *
 * Edit this template to match your needs.
 * $entry is of type tx_lib_object and represents a single data row.
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
     $link->parameters(array('year' => $entry->get('yeartimestamp'), 'backId' => $this->getDestination()));
     $link->label($entry->get('yeartext'));
?>
        <li>
			<?php echo $link->makeTag();//$entry->printAsText('title'); ?>
        </li>
<?php } ?>
<?php if($this->isNotEmpty()) { ?>
        </ul>
<?php } ?>
