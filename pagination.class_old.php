<?php
include 'head/jackus.php';

class PerPage {
	public $perpage;
	
	function __construct() {
		$this->perpage = PAGINATION_LIMIT;
	}
	
	function getAllPageLinks($count,$href) {
		$output = '';
		if(!isset($_GET["page"])) $_GET["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>1) {
			if($_GET["page"] == 1) 
				$output = $output . '<span class="page-numbers first disabled">&#8810;</span><span class="page-numbers disabled">&#60;</span>';
			else	
				$output = $output . '<a class="page-numbers first" onclick="getresult(\'' . $href . (1) . '\')" >&#8810;</a><a class="page-numbers" onclick="getresult(\'' . $href . ($_GET["page"]-1) . '\')" >&#60;</a>';
			
			
			if(($_GET["page"]-3)>0) {
				if($_GET["page"] == 1)
					$output = $output . '<span id=1 class="page-numbers current">1</span>';
				else				
					$output = $output . '<a class="page-numbers" onclick="getresult(\'' . $href . '1\')" >1</a>';
			}
			if(($_GET["page"]-3)>1) {
					$output = $output . '<span class="dot">...</span>';
			}
			
			for($i=($_GET["page"]-2); $i<=($_GET["page"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_GET["page"] == $i)
					$output = $output . '<span id='.$i.' class="page-numbers current">'.$i.'</span>';
				else				
					$output = $output . '<a class="page-numbers" onclick="getresult(\'' . $href . $i . '\')" >'.$i.'</a>';
			}
			
			if(($pages-($_GET["page"]+2))>1) {
				$output = $output . '<span class="dot">...</span>';
			}
			if(($pages-($_GET["page"]+2))>0) {
				if($_GET["page"] == $pages)
					$output = $output . '<span id=' . ($pages) .' class="page-numbers current">' . ($pages) .'</span>';
				else				
					$output = $output . '<a class="page-numbers" onclick="getresult(\'' . $href .  ($pages) .'\')" >' . ($pages) .'</a>';
			}
			
			if($_GET["page"] < $pages)
				$output = $output . '<a  class="page-numbers" onclick="getresult(\'' . $href . ($_GET["page"]+1) . '\')" >></a><a  class="page-numbers" onclick="getresult(\'' . $href . ($pages) . '\')" >&#8811;</a>';
			else				
				$output = $output . '<span class="page-numbers disabled">></span><span class="page-numbers disabled">&#8811;</span>';
			
			
		}
		return $output;
	}
	
	function getPrevNext($count,$href) {
		$output = '';
		if(!isset($_GET["page"])) $_GET["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);
		if($pages>1) {
			if($_GET["page"] == 1) 
				$output = $output . '<span class="page-numbers disabled first">Prev</span>';
			else	
				$output = $output . '<a class="page-numbers first" onclick="getresult(\'' . $href . ($_GET["page"]-1) . '\')" >Prev</a>';			
			
			if($_GET["page"] < $pages)
				$output = $output . '<a  class="page-numbers" onclick="getresult(\'' . $href . ($_GET["page"]+1) . '\')" >Next</a>';
			else				
				$output = $output . '<span class="page-numbers disabled">Next</span>';
			
			
		}
		return $output;
	}
}
?>