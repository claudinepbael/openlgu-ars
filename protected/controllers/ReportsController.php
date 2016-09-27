<?php


class ReportsController extends Controller
{

	public static $daterange =  array(
			01=>	'January',
			02=>	'February',
			03=>	'March',
			04=>	'April',
			05=>	'May',
			06=>	'June',
			07=>	'July',
			08=>	'August',
			09=>	'September',
			10=>	'October',
			11=>	'November',
			12=>	'December',
			13=>	'First Quarter',
			14=>	'Second Quarter',
			15=>	'Third Quarter',
			16=>	'Fourth Quarter',
			17=>	'Year Ended'
		);

	public function actionIndex(){
  		$this->render('index');
	}
	
	public function accessRules(){
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
			'actions'=>array('index'),
			'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'admin', 'delete', 'order'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				//'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	private function getConstants(){
		$fh = fopen(Yii::app()->getBasePath().'/data/constants.txt','w+') or exit("Unable to open file!");
		
		var_dump(fread($fh));
		// $constants['lgu']=fgets($fh);
		// $constants['accountant']=fgets($fh);
		$constants=0;
		return $constants;
	}

	//This function serves as the basis for all other reports.
	//Balance Sheet and Statement of Income and expenses rely on this function
	private function getWorksheet($fr_month,$to_month,$fr_year,$to_year){

		$worksheet = array();

		// Get all ledger entries for the date range
		$ledger_entries = Ledger::model()->getLedgerAdjustedEntries($fr_month, $fr_year, $to_month, $to_year);

		// Generate trial balance entries in the worksheet
		foreach ($ledger_entries as $ledger_entry) {
			$acct_code = $ledger_entry['acct_code'];
				
			if (isset($worksheet[$acct_code])){ 
				//Already has an entry
				$worksheet[$acct_code]['tb_credit'] += $ledger_entry['credit'];
				$worksheet[$acct_code]['tb_debit'] 	+= $ledger_entry['debit'];

				//Check the difference then save to the higher one.
				if($worksheet[$acct_code]['tb_credit'] > $worksheet[$acct_code]['tb_debit']){
					$worksheet[$acct_code]['tb_credit'] = $worksheet[$acct_code]['tb_credit'] - $worksheet[$acct_code]['tb_debit'];
					$worksheet[$acct_code]['tb_debit']	= 0;
				}else{
					$worksheet[$acct_code]['tb_debit']	= $worksheet[$acct_code]['tb_debit']-$worksheet[$acct_code]['tb_credit'];
					$worksheet[$acct_code]['tb_credit']	= 0;
				}

			}else{
				//New entry for the account
				$worksheet[$acct_code]['title'] = $ledger_entry['acct_title'];
				$worksheet[$acct_code]['report_classification'] = $ledger_entry['report_classification'];

				if($ledger_entry['credit'] > $ledger_entry['debit']){
					$worksheet[$acct_code]['tb_credit']	= $ledger_entry['credit'] - $ledger_entry['debit'];
					$worksheet[$acct_code]['tb_debit']	= 0;
				}else{
					$worksheet[$acct_code]['tb_debit']	= $ledger_entry['debit'] - $ledger_entry['credit'];
					$worksheet[$acct_code]['tb_credit']	= 0;
				}

				//Set adjusments
				//For now, set to 0 since the entries already has the adjustments
				$worksheet[$acct_code]['adj_credit'] 	= 0;
				$worksheet[$acct_code]['adj_debit'] 	= 0;
			}
		}


		//var_dump($worksheet);
		//get Adjustment Entries
		/*$sql= '	SELECT * from "{{Ledger}}" "t" LEFT OUTER JOIN "{{Account}}" "a" ON ("t"."acct_code" = "a"."acct_code") WHERE
						to_date(\''.$to_year. ' ' .$to_month . ' 01\',\'YYYY MM DD\') > date 
				        AND date >= to_date(\''.$_POST['year_to_generate']. ' ' . $fr_month. ' 01\',\'YYYY MM DD\')
				        order by t.acct_code
					';
				        //AND is_adjustment = \'1\' order by t.acct_code
		
		$adj_data=Yii::app()->db->createCommand($sql)->queryAll();	

		foreach ($adj_data as $key => $value) {
			$id=$value['acct_code'];
			if (isset($worksheet[$id])){ //if may naisave na dun sa credit o debit
				$worksheet[$id]['adj_credit'] = $worksheet[$id]['adj_credit'] + $value['credit'];
				$worksheet[$id]['adj_debit'] = $worksheet[$id]['adj_debit'] + $value['debit'];
				//$adjustments[$id]['title'] = $value['acct_title'];
			}else{
				$worksheet[$id]['title'] = $value['acct_title'];
				$worksheet[$id]['report_classification'] = $value['report_classification'];
				$worksheet[$id]['adj_credit'] = $value['credit'];
				$worksheet[$id]['adj_debit'] = $value['debit'];
				/*if($value['is_adjustment']==1){
					$worksheet[$id-100]['adj_credit'] +=$value['debit'];
					$worksheet[$id-100]['adj_debit'] +=$value['credit'];
				}//
				$worksheet[$id]['tb_credit'] = 0;
				$worksheet[$id]['tb_debit'] = 0;
			}

		}*/

		// Generate Adjusted Trial Balance Entries
		foreach ($worksheet as $acct_code => $entry) {
			$credit = $entry['tb_credit'] + $entry['adj_credit'];
			$debit 	= $entry['tb_debit']  + $entry['adj_debit'];
			
			if($debit > $credit){
				$worksheet[$acct_code]['adj_tb_debit'] = $debit - $credit;
				$worksheet[$acct_code]['adj_tb_credit'] = 0;
			}else{
				$worksheet[$acct_code]['adj_tb_credit'] = $credit - $debit;
				$worksheet[$acct_code]['adj_tb_debit'] = 0;					
			}

		}

		// Generate Balance Sheet and Income Statement
		foreach ($worksheet as $acct_code => $value) {
			if($value['report_classification'] == 'B'){ //If account is to classified to be in the Balance Sheet
				$worksheet[$acct_code]['bs_credit'] = $value['adj_tb_credit'];
				$worksheet[$acct_code]['bs_debit'] 	= $value['adj_tb_debit'];
				$worksheet[$acct_code]['is_credit'] = 0;
				$worksheet[$acct_code]['is_debit'] 	= 0;
			}else{	//If account is to classified to be in the Income Statement
				$worksheet[$acct_code]['is_credit'] = $value['adj_tb_credit'];
				$worksheet[$acct_code]['is_debit'] 	= $value['adj_tb_debit'];
				$worksheet[$acct_code]['bs_credit'] = 0;
				$worksheet[$acct_code]['bs_debit'] 	= 0;
			}
		}

		$worksheet_total= array( 	
			'tb_credit'		=> 0,	'tb_debit'	=> 0,
			'adj_credit'	=> 0,	'adj_debit'	=> 0,
			'adj_tb_credit'	=> 0,	'adj_tb_debit'	=> 0,
			'bs_credit'		=> 0,	'bs_debit'	=> 0, 
			'is_credit'		=> 0, 	'is_debit'	=> 0,
			'bs_net_loss'	=> 0, 	'bs_net_profit'	=> 0,
			'is_net_loss'	=> 0, 	'is_net_profit'	=> 0,
			'bs_bal_cr'		=> 0, 	'bs_bal_dr'	=> 0,
			'is_bal_cr'		=> 0, 	'is_bal_dr'	=> 0,
		);

		//Get total of each reports
		foreach ($worksheet as $key => $value) {

			$worksheet_total['tb_credit']		+= $value['tb_credit'];
			$worksheet_total['tb_debit']		+= $value['tb_debit'];
			$worksheet_total['adj_credit']		+= $value['adj_credit'];
			$worksheet_total['adj_debit']		+= $value['adj_debit'];
			$worksheet_total['adj_tb_credit']	+= $value['adj_tb_credit'];
			$worksheet_total['adj_tb_debit']	+= $value['adj_tb_debit'];

			if($value['report_classification'] == 'B'){
				$worksheet_total['bs_debit']  += $value['bs_debit'];
				$worksheet_total['bs_credit'] += $value['bs_credit'];
			}else{
				$worksheet_total['is_debit']  += $value['is_debit'];
				$worksheet_total['is_credit'] += $value['is_credit'];
			}
		}

		if($worksheet_total['is_credit'] > $worksheet_total['is_debit']){		//credit>debit, so net profit
			$worksheet_total['is_net_profit'] = $worksheet_total['is_credit'] - $worksheet_total['is_debit'];
		}else{
			$worksheet_total['is_net_loss'] = $worksheet_total['is_debit'] - $worksheet_total['is_credit'];
		}


		if($worksheet_total['bs_credit'] > $worksheet_total['bs_debit']){		//credit>debit, net profit
			$worksheet_total['bs_net_profit'] = $worksheet_total['bs_credit'] - $worksheet_total['bs_debit'];
		}else{
			$worksheet_total['bs_net_loss']	= $worksheet_total['bs_debit'] - $worksheet_total['bs_credit'];
		}

		$worksheet_total['is_bal_cr'] = $worksheet_total['is_credit'] + $worksheet_total['is_net_loss'];
		$worksheet_total['is_bal_dr'] = $worksheet_total['is_debit']  + $worksheet_total['is_net_profit'];
		$worksheet_total['bs_bal_dr'] = $worksheet_total['bs_debit']  + $worksheet_total['bs_net_profit'];
		$worksheet_total['bs_bal_cr'] = $worksheet_total['bs_credit'] + $worksheet_total['bs_net_loss'];

		return array("worksheet"=>$worksheet,"total"=>$worksheet_total);	
	}

	//This function is used by Worksheet, Balance Sheet and Income Statement
	//All of them has the same input (month and year to gereate report)
	//It returns a worksheet and the date range that was used to generate the worksheet
	private function getWorksheetFromInput(){

		$daterange = self::$daterange;

		if(isset($_POST['month_to_generate']) && !empty($_POST['month_to_generate'])){
			if(isset($_POST['year_to_generate']) && !empty($_POST['year_to_generate'])){
				//insert mo dito yung pagdagdag ng month depende kung month, annual or quarter yung pinili
				//gawin na lang switch case na pag less than 12, yung mga month + 1 lang, if hindi, +4 pag annual, yung year na lang
				$fr_year = $to_year = $_POST['year_to_generate'];

				if($_POST['month_to_generate'] < 13){
					//Monthly Report
					$to_month = $_POST['month_to_generate'] + 1;
					$fr_month = $_POST['month_to_generate'];
				}else if($_POST['month_to_generate']>12 and $_POST['month_to_generate']<17){
					//Quarterly Report
					$fr_month = (($_POST['month_to_generate'] - 13) * 3 )+1;
					$to_month = ($_POST['month_to_generate'] -12 ) * 3;	
				}else{	
					//Annual Report
					$to_month = 1;
					$fr_month = 1;
					$to_year = $to_year +1;	
				}

				if($to_month < 10){
					$to_month='0'.$to_month;
				}
				if($fr_month<10){
					$fr_month='0'.$fr_month;
				}

				$worksheet = $this->getWorksheet($fr_month,$to_month,$fr_year,$to_year);
			}
		}
		if(!isset($worksheet)){
			 $worksheet['total']=null;
			 $worksheet['worksheet']=null;
		}
		return array('ws'=>$worksheet,'daterange'=>$daterange);
	}

	//Function to display /reports/worksheet
	//Returns a view of the worksheet generated
	public function actionWorksheet(){
		
		$data = $this->getWorksheetFromInput();

		$this->render('worksheet',
			array(
				'yearNow'	=> date("Y"),
				'yearFrom'	=> (date("Y")-100),
				'daterange'	=> $data['daterange'],
				'total'		=> $data['ws']['total'],
				'worksheet'	=> $data['ws']['worksheet'],
		));
	}

	public function generateWorkSheetFromGETParamaters(){
		$for = "for the ";

		$daterange = self::$daterange;

		if(isset($_GET['m'])){
			$month = $_GET['m'];
			if(isset($_GET['y'])){
				$fr_year = $to_year = $_GET['y'];
				if($month < 13){
					$to_month = $month + 1;
					$fr_month = $month;
					$for .= "month of ". $daterange[$month] . ", " . $fr_year;
				}else if($_GET['m']>12 and $_GET['m']<17){
					$fr_month = (($month- 13) * 3 )+1;
					$to_month = ($month -12 ) * 3;	
					$for .= $daterange[$month] . " of " . $fr_year;
				}else{
					$for .= "year ". $to_year;
					$to_month = 1;
					$fr_month = 1;
					$to_year = $to_year +1;	
				}

				if($to_month < 10){
					$to_month='0'.$to_month;
				}
				if($fr_month < 10){
					$fr_month='0'.$fr_month;
				}

				$ws = $this->getWorksheet($fr_month,$to_month,$fr_year,$to_year);

			}
		}

		return array('sheet'=> $ws, 'for' => $for);
	}

/***************************************************
* Balance Sheet Generators
***************************************************/

	//private global $tree;
	private $ws_a;
	private $ws_t;
	private $bs_tree;

	public function designateAmount(){

		global $bs_tree;
		global $ws_a;
		global $ws_t;

		foreach($bs_tree as $code => &$category){
		//get the main categories (Assets and Liabilities&Equity)
			
			if(isset($category['children']) and !empty($category['children'])){	//Category has subategories
				
				if($category['amt_type']==2 ){//if amount of category will be the total of its subcategory
					$category['amount']=0;
					$this->subAmount($category['children']);
					foreach ($category['children'] as $key => $subs) {
						$category['amount'] += $subs['amount'];
					}
				}else if($category['amt_type']==1){//label
					foreach ($bs_tree[$category['parent_id']] as $key => $cosubs) {
						$category['amount'] += $cosubs['amount'];
					}
				}else{
					$this->subAmount($category['children']);
				}

			}else{	//Category has no subcategories

				if($category['type']==0 && isset($ws_a[$code])){ //if the category is independent and will be assigned its true amount (e.g) Notes Payable assuming it is not under payables
					if($category['is_added']==0)
						$category['amount']= $ws_a[$code]['bs_debit']>0 ? $ws_a[$code]['bs_debit'] : $ws_a[$code]['bs_credit'];
					else
						$category['amount']= $ws_a[$code]['bs_debit']>0 ? - $ws_a[$code]['bs_debit'] : - $ws_a[$code]['bs_credit'];
					//assumption: it is not possible that an account has both balance sheet debit and credit
					if($code==501){
						$changes = $ws_t['is_net_profit'] + $ws_t['is_net_loss'];
						//echo $changes;
						$category['amount'] += $changes;
					}
				}//end if category-independent
			}//end else has no subcategories	

		}//end for each
	}//end designateAmount


	public function subAmount(&$categories){
		global $ws_a;
		global $bs_tree;
		global $ws_t;
			foreach($categories as $code=>&$category){	

				if(isset($category['children']) and !empty($category['children'])){	//if the category has subategories
					
					if($category['amt_type']==2 or $category['amt_type']==-1){//if amoount of category will be the total of its subcategory
						$this->subAmount($category['children']);
						foreach ($category['children'] as $key => $subs) {
							if(isset($subs['amount'])){
								if(isset($category['amount'])){
									$category['amount'] += $subs['amount'];
								}else{
									$category['amount'] = $subs['amount'];
								}
							}
						}
					}else if($category['amt_type']==1){
						foreach ($bs_tree[$category['parent_id']] as $key => $cosubs) {
							$category['amount'] += $cosubs['amount'];
						}
					}else{
						$this->subAmount($category['children']);
					}
				}//endif category has children
				else{//if category has no subs
					if($category['amt_type']==0 && isset($ws_a[$code])){ //if the category is independent and will be assigned its true amount (e.g) Notes Payable assuming it is not under payables
						if($category['is_added']==0)
							$category['amount']= $ws_a[$code]['bs_debit']>0 ? $ws_a[$code]['bs_debit'] : $ws_a[$code]['bs_credit'];
						else
							$category['amount']= $ws_a[$code]['bs_debit']>0 ? - $ws_a[$code]['bs_debit'] : - $ws_a[$code]['bs_credit'];
						//assumption: it is not possible that an account has both balance sheet debit and credit
					}
					if($code==501){
					$changes = $ws_t['is_net_profit'] + $ws_t['is_net_loss'];
					//echo $changes;
					$category['amount'] += $changes;
				}
				}
			}//endforeach
	}

	public function assignTotal(){
		global $ws_a;
		
		global $bs_tree;
			foreach($bs_tree as $code=>&$category){	

				if(isset($category['children']) and !empty($category['children'])){	//if the category has subategories
					foreach ($category['children'] as  &$child) {
						if($child['amt_type']==1){
							$child['amount']=$category['amount'];
						}
					}
					$this->assignSubTotal($category['children']);
				}//endif category has children
			}//endforeach
	}

	public function assignSubTotal(&$categories){
		global $ws_a;
		
		global $bs_tree;
			foreach($categories as $code=>&$category){	

				if(isset($category['children']) and !empty($category['children'])){	//if the category has subategories
					foreach ($category['children'] as  &$child) {
						if($child['amt_type']==1){
							$child['amount']=$category['amount'];
						}
					}
					
					$this->assignSubTotal($category['children']);
				}//endif category has children
				
			}//endforeach
	}

	private $view_data;
	private function generateBalanceSheetView(){
        global $view_data;
        global $bs_tree;
        $view_data = array();
        //var_dump($bs_tree);
        //$view_data['0'] = '-- ROOT --';
        foreach($bs_tree[0]['children'] as $parent){

        	if($parent['is_added'] == 1){
	            $text = "<tr>
	        		<td colspan='12' id='acct_title' style='border:none;text-align:center'>
	        			<h4>Less:".$parent['text']."</h4>
	        		</td>";
            }else{	
            	$text = "<tr>
            		<td colspan='12' id='acct_title' style='border:none;text-align:center'>
            			<h4>".$parent['text']."</h4>
            		</td>";
            }

            if(isset($parent['amount']) and $parent['amt_type']!=-1){
            	if($parent['amount']<0){
            		$text .= "<td colspan='".$colspan."' style='border:none;text-align:left' >("
            			.Yii::app()->format->number($parent['amount']*(-1)).
            			")</td>";
            	}else{
            		$text .= "<td colspan='".$colspan."' style='border:none;text-align:right' >";
            		$text .= Yii::app()->format->number($parent['amount'])."</td>";
            	}
            }
            $text .= "</tr>";
            $view_data[] = $text;
            if(isset($parent['children']) and $parent['amt_type']==-1){
            	$this->subView($parent['children']);
        	}
        	$view_data[] = '<tr><td height="30px" style="border:none"></td></tr>';
        }
    }

    private function subView($children,$space = "<td style='border:none'></td>",$colspan=10){
        global $view_data;
        foreach($children as $child){
        	$text = "<tr>".$space;

        	if($child['is_added']==1){
            	$text .= "<td id='acct_title' style='border:none' colspan='".($colspan-1)."' >
            		Less: ".$child['text'].
            		"</td>";
            }else{
            	$text .= "<td id='acct_title' style='border:none' colspan='".($colspan-1)."' >".
            		$child['text'].
            		"</td>";
            }

            if(isset($child['amount']) and $child['amt_type']!=-1){
            	if($child['amount']<0){
            		$text .= "<td colspan='".$colspan."' style='border:none;text-align:left' >
            			(".Yii::app()->format->number($child['amount']*(-1)).")
            			</td>";
            	}else{
            		$text .= "<td colspan='".$colspan."' style='border:none;text-align:right' >".
            			Yii::app()->format->number($child['amount']).
            			"</td>";
            	}
            }
            $text .= "</tr>";
            $view_data[] = $text;
            if(isset($child['children']) and $child['amt_type']==-1){
            	$this->subView($child['children'],$space."<td style='border:none'></td>",$colspan-1);
        	}
        }

    }

	public function actionBalanceSheet(){

		global $bs_tree;
		global $ws_a ;
		global $ws_t ;
		global $view_data;

		$data = $this->getWorksheetFromInput();
		$bs_tree = BalanceSheetCategories::model()->generateDataTree();
		$ws_a= $data['ws']['worksheet'];
		$ws_t= $data['ws']['total'];
		if($ws_a!=null){
			$this->designateAmount();
			$this->assignTotal();
		}
		//assumption: government equity is added or lessen by net income/loss

		$this->generateBalanceSheetView();
		
		$this->render('balanceSheet',array(
			'yearNow'=>date("Y"),
			'yearFrom'=>(date("Y")-100),
			'daterange'=>$data['daterange'],
			'tree'=>$bs_tree,
			'view_data'=>$view_data,
			'for' => "FOR",
		));
	}

	public function generateBalanceSheetPDF($for){
		global $daterange;
		global $view_data;

		$mpdf = Yii::app()->ePdf->mpdf();
		$mpdf->setDisplayMode('fullpage');
  		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css').'/main.css');
  		$pdfstylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css').'/pdf.css');

        $mpdf->WriteHTML($pdfstylesheet,1);
       	
       	$content = $this->renderPartial('_balancesheet',
       					array(
							'daterange'=>$daterange,
							'view_data'=>$view_data,
							'for' => $for,	
						),
       					true,
       					false
       			);

       	$mpdf->WriteHTML($content);

       	$mpdf->Output('Balance Sheet '.$for,'I');
	}

	public function actionBalanceSheetOnPDF(){
		global $bs_tree;
		global $ws_a ;
		global $ws_t ;
		global $view_data;
		
		$ws = $this->generateWorkSheetFromGETParamaters();

		if(!isset($ws) && !isset($ws['sheet'])){
			 $ws['total']=null;
			 $ws['worksheet']=null;
		}

		$bs_tree = BalanceSheetCategories::model()->generateDataTree();
		$ws_a = $ws['sheet']['worksheet'];
		$ws_t = $ws['sheet']['total'];
		$this->designateAmount();
		$this->assignTotal();
		$this->generateBalanceSheetView();
		$this->generateBalanceSheetPDF($ws['for']);

	}

/***************************************************
* Income Statement Generators
***************************************************/

	private $is_tree;

	const INCOME_STATEMENT_DOCUMENT_TITLE_ID = -1;

	const DOES_NOT_CONTAIN_AMOUNT			= -1;
	const AMOUNT_OF_DESIGNATED_ACCOUNT 		= 0;
	const AMOUNT_OF_ALL_CO_SUBCATEGORIES 	= 1;
	const AMOUNT_OF_ALL_SUBCATEGORIES 		= 2;

	const TO_BE_ADDED = 0;
	const TO_BE_DEDUCTED = 1;

	public function designateIncomeStatementAmount(){
		global $is_tree;
		global $ws_a;
		global $ws_t;

		//Get the first main categories (Income and Expenses)
		foreach($is_tree as $code => &$category){
			$category['amount'] = 0;
			if(isset($category['children']) and !empty($category['children'])){

				if($category['amt_type'] == self::AMOUNT_OF_ALL_SUBCATEGORIES ){
					$this->designateAmountToSubCategoriesOfIS($category['children']);
					foreach ($category['children'] as $key => $subs) {
						$category['amount'] += $subs['amount']; 
					}
				}else if($category['amt_type'] == self::AMOUNT_OF_ALL_CO_SUBCATEGORIES){
					foreach ($is_tree[$category['parent_id']]['children'] as $key => $cosubs) {
						$category['amount'] += $cosubs['amount'];
					}
				}else{
					$this->designateAmountToSubCategoriesOfIS($category['children']);
				}	

			}else{ //Category has no subcategories
				if($category['amt_type'] == self::AMOUNT_OF_DESIGNATED_ACCOUNT && isset($ws_a[$code])){ 
					if($category['is_added'] == self::TO_BE_ADDED){
						$category['amount'] = $ws_a[$code]['is_debit'] > 0 ? $ws_a[$code]['is_debit'] : $ws_a[$code]['is_credit'];
					}else{
						$category['amount'] = $ws_a[$code]['is_debit'] > 0 ? - $ws_a[$code]['is_debit'] : - $ws_a[$code]['is_credit'];
					}
					//Assumption: it is not possible that an account has both balance sheet debit and credit
				}
				if($category['amt_type'] == self::AMOUNT_OF_ALL_CO_SUBCATEGORIES){
					 foreach ($is_tree[$category['parent_id']]['children'] as $key => $cosubs) {
					 	if($category['title'] != $cosubs['title']){
					 		if($cosubs['is_added']== self::TO_BE_DEDUCTED){
					 			$category['amount'] -= $cosubs['amount'];
					 		}else{
					 			$category['amount'] += $cosubs['amount'];
					 		}
					 	}
					}
				}
			}
		}
	}


	public function designateAmountToSubCategoriesOfIS(&$categories){
		global $ws_a;
		global $is_tree;
		foreach($categories as $code=>&$category){	

			if(isset($category['children']) and !empty($category['children'])){	//If the category has subategories
				
				if($category['amt_type']==self::AMOUNT_OF_ALL_SUBCATEGORIES or $category['amt_type']==self::DOES_NOT_CONTAIN_AMOUNT){
					$this->designateAmountToSubCategoriesOfIS($category['children']);
					foreach ($category['children'] as $key => $subs) {
						if(isset($subs['amount'])){
							if(isset($category['amount'])){
								$category['amount'] += $subs['amount'];
							}else{
								$category['amount'] = $subs['amount'];
							}
						}
					}
				}else if($category['amt_type'] == self::AMOUNT_OF_ALL_CO_SUBCATEGORIES){
					foreach ($is_tree[$category['parent_id']]['children'] as $key => $cosubs) {
						$category['amount'] += $cosubs['amount'];
					}
				}else{
					$this->designateAmountToSubCategoriesOfIS($category['children']);
				}
		
			}else{

				$category['amount'] = 0;
				if($category['amt_type'] == self::AMOUNT_OF_DESIGNATED_ACCOUNT && isset($ws_a[$code])){ 
					if($category['is_added']==self::TO_BE_ADDED)
						$category['amount']= $ws_a[$code]['is_debit'] >0 ? $ws_a[$code]['is_debit'] : $ws_a[$code]['is_credit'];
					else
						$category['amount']= $ws_a[$code]['is_debit'] >0 ? - $ws_a[$code]['is_debit'] : - $ws_a[$code]['is_credit'];
					//assumption: it is not possible that an account has both balance sheet debit and credit
				}else if($category['amt_type'] == self::AMOUNT_OF_ALL_CO_SUBCATEGORIES){
					 foreach ($is_tree[$category['parent_id']]['children'] as $key => $cosubs) {
					 	if($category['title']!=$cosubs['title']){
					 		if($cosubs['is_added'] ==  self::TO_BE_DEDUCTED){
					 			$category['amount'] -= $cosubs['amount'];
					 		}else{
					 			$category['amount'] += $cosubs['amount'];
					 		}
					 	}
					}
				}
			}
		}
	}

	private $view_is_data;

	private function generateIncomeStatementView(){
        global $view_is_data;
        global $is_tree;
        $view_is_data = array();
        
        //$view_data['0'] = '-- ROOT --';
        foreach($is_tree as $id=>$parent){

            $text  = "<tr><td colspan='12' id='acct_title' ";
            $text .= "style='border:none;text-align:center'><h4>";
            $text .= $parent['text']."</h4></td>";

            if(isset($parent['amount']) && $id != self::INCOME_STATEMENT_DOCUMENT_TITLE_ID){
            	$text .= "<td style='text-align:right'>";

            	if($parent['amt_type'] == self::AMOUNT_OF_ALL_SUBCATEGORIES){
            		$text .= "<b>".Yii::app()->format->number($parent['amount'])."</b>";	
            	}else{
            		$text .= Yii::app()->format->number($parent['amount']);
            	}

            	$text .= "</td>";
            }
            	
            $text .= "</tr>";
            $view_is_data[] = $text;

            if(isset($parent['children']) and $parent['amt_type'] == self::DOES_NOT_CONTAIN_AMOUNT){
            	$this->subISView($parent['children']);
        	}

        	$view_is_data[] = '<tr><td height="30px" style="border:none"></td></tr>';
        }
      
    }
    private function subISView($children,$space = "<td style='border:none'></td>",$colspan=10){
        global $view_is_data;
        foreach($children as $child){
            $text= "<tr>".$space."<td id='acct_title' style='border:none' colspan='".($colspan-1)."' >".$child['text']."</td>";
            
            if(isset($child['amount']) && $child['amt_type']!=self::DOES_NOT_CONTAIN_AMOUNT){
            	$text .= "<td colspan='".$colspan."' style='border:none;text-align:right' >";
            	if($child['amt_type'] == self::DOES_NOT_CONTAIN_AMOUNT){
            		$text .= "<b>".Yii::app()->format->number($child['amount'])."</b>";	
            	}else{
            		$text .= Yii::app()->format->number($child['amount']);
            	}
            	
            	$text .= "</td>";
            }
            	
            $text .= "</tr>";
            $view_is_data[] = $text;
            if(isset($child['children']) and $child['amt_type'] == self::DOES_NOT_CONTAIN_AMOUNT){
            	$this->subISView($child['children'],$space."<td style='border:none'></td>",$colspan-1);
        	}
        }
    }

	public function actionIncomeStatement(){

		global $is_tree;
		global $ws_a ;
		global $view_is_data;

		$data = $this->getWorksheetFromInput();
		$is_tree = IncomeStatementCategories::model()->dataTree();
		$ws_a= $data['ws']['worksheet'];
		$this->designateIncomeStatementAmount();
		$this->generateIncomeStatementView();

		//Note: This is temporary. 
		//It is assumed that the government equity will always be added by the net income or less by net loss
		
		$this->render('incomestatement',array(
			'yearNow'=>date("Y"),
			'yearFrom'=>(date("Y")-100),
			'daterange'=>$data['daterange'],
			'tree'=>$is_tree,
			'view_data'=>$view_is_data
		));

	}

	public function generateIncomeStatementPDF($for){
		global $daterange;
		global $view_is_data;

		$mpdf = Yii::app()->ePdf->mpdf();
		$mpdf->setDisplayMode('fullpage');
  		$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css').'/main.css');
  		$pdfstylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css').'/pdf.css');

        $mpdf->WriteHTML($pdfstylesheet,1);
       	$content = $this->renderPartial('_incomestatement',
       				array(
						'daterange'=>$daterange,
						'view_data'=>$view_is_data,
						'for' => $for,	
					),
					true, false);

       	$mpdf->WriteHTML($content);
       	$mpdf->Output('Income Statement '.$for,'I');
	}

	public function actionIncomeStatementOnPDF(){
		global $is_tree;
		global $ws_a ;
		global $view_is_data;
		
		$ws = $this->generateWorkSheetFromGETParamaters();

		if(!isset($ws) && !isset($ws['sheet'])){
			 $ws['total']=null;
			 $ws['worksheet']=null;
		}

		$is_tree = IncomeStatementCategories::model()->dataTree();
		$ws_a = $ws['sheet']['worksheet'];
		$this->designateIncomeStatementAmount();
		$this->generateIncomeStatementView();
		$this->generateIncomeStatementPDF($ws['for']);

	}

}