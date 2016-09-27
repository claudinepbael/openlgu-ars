<?php

/*
* /protected/components/CommonMethods.php
*
*/class CommonMethods {

private $data = array();

	public function makeDropDown($parents){
		global $data;
		$num=1;
		$data = array();
		$data['0'] = '-- ROOT --';
		foreach($parents as $parent){

			$data[$parent->category_acct_code] = " ".$parent->category_acct_title;
			var_dump($parent->children);
			echo"<hr/>";
			$this->subDropDown($parent->children,$space='<',$parent->category_acct_code);
		}
		var_dump($data);
		return $data;
	}


	public function subDropDown($children,$space = '---',$parent_acct_code){
		global $data;

		foreach($children as $child){
			$data[$child->category_acct_code] = $space.$parent_acct_code.":::".$child->category_acct_title;

			$this->subDropDown($child->children,$space.'---',$child->category_acct_code);
		}

	}


}

?>