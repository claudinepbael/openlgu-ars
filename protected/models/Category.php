<?php

/**
 * This is the model class for table "Account".
 *
 * The followings are the available columns in table 'Account':
 * @property integer $acct_code
 * @property string $acct_title
 * @property string $normal_balance
 * @property string $acct_description
 * @property string $report_classification
 *
 * The followings are the available model relations:
 * @property Journal[] $journals
 */
class Category
{
	public $category_name;
	public $sub_categories;

}	
?>