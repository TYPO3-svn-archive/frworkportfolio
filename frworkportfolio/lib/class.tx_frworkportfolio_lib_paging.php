<?php

/**
 * Pagination Class:
 * 
 * markers: {PREV} 				- Previous Page link
 * 			{PAGELIST}			- List page numbers ie (PAGE  1 2 3 4 )
 * 			{NEXT}  			- Next Page link
 * 			{RECORD_FROM} 		- Record from ie (10)
 * 			{RECORD_TO} 		- Record to   ie (20)
 * 			{TOTAL_RECORDS} 	- Total number of records
 * 			{TOTAL_ALL_RECORDS} - Used to display fill total number of records if search is filtered. (IE search)
 *
 */
class tx_frworkportfolio_lib_paging {
	
	//var $displayMsg;
	var $emptyMsg;
	var $recordsPerPage;
	var $currentPage;
	var $totalCurrentRecords;
	var $totalRecords;
	var $maxPages;
	var $minPages;
	var $pageSeparator;
	var $prevText;
	var $nextText;
	var $template;
	var $extName;
	
	
	function tx_frworkportfolio_lib_paging(){
		$this->init();
	}
	
	function init(){
		$this->displayMsg = 'Displaying {0} - {1} of {2}';
		$this->emptyMsg = '';
	 	$this->recordsPerPage = 10;
		$this->maxPages = 10;
		$this->minPages = 0;
		$this->pageSeparator = '|';
		$this->prevText = '<< Prev';
		$this->nextText = 'Next  >>';
		$this->template = '{PREV} <ul>{PAGELIST}</ul> {NEXT}  Displaying {RECORD_FROM} to {RECORD_TO} of {TOTAL_RECORDS}';
	}
	
	
	/**
	 * Generates a html pagination block. Gets the template file from the configuration. 
	 * Replaces all the markers in the template file. 
	 *
	 * @param unknown_type $currentPage	- The current page number. ie if $record_per_page = 10 then 
	 * 												  the page number will be 0 10 20 30 etc
	 * @param unknown_type $record_per_page			- The number of records to be displayed on each page
	 * @param unknown_type $total_count				- Total number of records for the serch query
	 * @param unknown_type $total_num_records		- Total number of records for in the database for the year 
	 * @return html									- Pagination Browser block
	 */
	function render(){
			
		if(ceil(($this->totalCurrentRecords / $this->recordsPerPage)) > 1 || ($this->totalCurrentRecords == $this->recordsPerPage)){
			
			// Initializing variables:
			$pointer=$this->currentPage;
			$count=$this->totalCurrentRecords;
			
			$pointer_page = ($this->currentPage==0)?$this->currentPage:$this->currentPage/$this->recordsPerPage;
	
			//$this->recordsPerPage	= $record_per_page;// Number of results to show in a listing.
			$maxPages			= 10;			   // Number of pages to show in a listing.
			$least 				= 0;
				
			$max = $this->intInRange(ceil($count/$this->recordsPerPage),1,$this->maxPages);
			
			if ($pointer_page > ($max - 1) && $pointer_page < ceil($count/$this->recordsPerPage)){
				$least = $pointer_page - ($max - 1);
				$max = $pointer_page + 1;	
			}
			
			$pointer=intval($pointer);
			$links=array();
			
			// Make browse/links:
			for($a=$this->minPages;$a<$max;$a++)	{
				
				$listpointer = $this->recordsPerPage * $a;
				$pagelink = '<li><a href="'.$this->getCurrentUrl().'&'.$this->getParamName('currentPage').'='.$listpointer.'">'.($a+1).'</a></li>';
				
				$pageList[] = $pagelink;
				$markerArray['{PAGELIST}'] = implode($this->pageSeparator,$pageList); 
			}
				
			if ($pointer>0)	{
				$prevPointer = $this->currentPage - $this->recordsPerPage;
				$markerArray['{PREV}'] = 
					'<a href="'.$this->getCurrentUrl().'&'.$this->getParamName('currentPage').'='.$prevPointer.'">'.$this->prevText.'</a> ';
			} else{
				$markerArray['{PREV}'] = "";
			}
			
	
			
			if ($pointer < ($count - $this->recordsPerPage))	{
				$nextPointer = $this->currentPage + $this->recordsPerPage;
				$markerArray['{NEXT}'] =
					'<a href="'.$this->getCurrentUrl().'&'.$this->getParamName('currentPage').'='.$nextPointer.'">'.$this->nextText.'</a>';
			} else{
					$markerArray['{NEXT}'] = "";
				}
			$reminder = fmod($this->totalCurrentRecords, $this->recordsPerPage);
			if($reminder > 0){
				$record_count = intval($this->totalCurrentRecords/$this->recordsPerPage)+1;
			}else{
				$record_count = intval($this->totalCurrentRecords/$this->recordsPerPage);
			}
			
			$markerArray['{TOTAL_PAGE}'] = $record_count;
			$markerArray['{TOTAL_RECORDS}'] = $this->totalCurrentRecords;
			$markerArray['{RECORD_FROM}'] = $pointer + 1; 
			$markerArray['{RECORD_TO}'] = ($pointer + $this->recordsPerPage) <= $this->totalCurrentRecords? $pointer + $this->recordsPerPage:$this->totalCurrentRecords;
			$markerArray['{TOTAL_ALL_RECORDS}'] = $this->totalRecords;
			
			$paging = $this->template;
			foreach ($markerArray AS $marker=>$value){
				$paging = str_replace($marker,$value,$paging);
			}
			
			return $paging;
		}else{
			return $this->emptyMsg;
		}
	}
	
	function getParamName($name){
		if($this->extName){
			return  $this->extName.'['.$name.']';
		}else{
			return $name;
		}
	}
	
	function intInRange($theInt,$min,$max=2000000000,$zeroValue=0)	{
		// Returns $theInt as an integer in the integerspace from $min to $max
		$theInt = intval($theInt);
		if ($zeroValue && !$theInt)	{$theInt=$zeroValue;}	// If the input value is zero after being converted to integer, zeroValue may set another default value for it.
		if ($theInt<$min){$theInt=$min;}
		if ($theInt>$max){$theInt=$max;}
		return $theInt;
	}
	
	/**
	 * Gets the current url
	 * TO DO: NEED TO SET PARAMS IF  $includeParams=true
	 *
	 * @param boolean $includeParams
	 * @return string
	 */
	function getCurrentUrl($includeParams=true){
 		$pageURL = 'http';
 		if(isset($_SERVER["HTTPS"])){
			 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 		}
			 $pageURL .= "://";
			 if ($_SERVER["SERVER_PORT"] != "80") {
			  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			 } else {
			 	if($includeParams){
			  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			 	}else{
			  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
			  	}
			 }
		return $pageURL;
 	}
}
?>