<?php

require_once dirname(__FILE__).'/../lib/business_unitGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/business_unitGeneratorHelper.class.php';

/**
 * business_unit actions.
 *
 * @package    Finsys
 * @subpackage business_unit
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class business_unitActions extends autoBusiness_unitActions
{
	public function executeProjectReport(sfWebRequest $request)
	{
		if ($this->getUser()->hasAttribute('return_to_pr')) {
			$this->getUser()->getAttributeHolder()->remove('return_to_pr');
		}
		
		if ($this->getUser()->hasCredential('admin')) {
			$business_unit_id = $request->getParameter('id');
		} else {
			$business_unit_id = $this->getUser()->getProfile()->getBusinessUnitId();
		}
		if ($this->getUser()->getProfile()->getBusinessUnitId()) {
			$business_unit_id = $this->getUser()->getProfile()->getBusinessUnitId();
		}
		$this->business_unit = BusinessUnitPeer::retrieveByPK($business_unit_id);
		$this->job_orders = JobOrderPeer::retrieveByBU($business_unit_id);
		$this->tenders = TenderPeer::doSelect(new Criteria());
		$this->plans = PlanPeer::doSelect(new Criteria());
	}
	
	public function executeLoseTender(sfWebRequest $request)
	{
		$tender_id = $request->getParameter('tender_id');
		$business_unit_id = $request->getParameter('bu_id');
		$tender = TenderPeer::retrieveByPK($tender_id);
		$tender->setStatus('lost');
		$tender->save();
		
		return $this->redirect('@project_report?id='.$business_unit_id);
	}
	
	public function executeCurrentExpenses(sfWebRequest $request)
	{
		if ($this->getUser()->hasCredential('admin')) {
			$this->business_unit_id = $request->getParameter('id');
		} else {
			$this->business_unit_id = $this->getUser()->getProfile()->getBusinessUnitId();
		}
		$this->expenses = CurrentExpensesPeer::retrieveByBU($this->business_unit_id, new Criteria());
		$this->expence_types = ExpencesTypePeer::doSelect(new Criteria());
	}

	protected function createDateRangeArray($strDateFrom,$strDateTo)
	{
	    // takes two dates formatted as YYYY-MM-DD and creates an
	    // inclusive array of the dates between the from and to dates.
	
	    // could test validity of dates here but I'm already doing
	    // that in the main script
	
	    $aryRange=array();
	
	    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));
	
	    if ($iDateTo>=$iDateFrom)
	    {
	        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	        while ($iDateFrom<$iDateTo)
	        {
	            $iDateFrom+=86400; // add 24 hours
	            if(date('N',$iDateFrom) != 6 && date('N',$iDateFrom) != 7)
	            	array_push($aryRange,date('Y-m-d',$iDateFrom));
	        }
	    }
	    return $aryRange;
	}

	public function executeCashflow(sfWebRequest $request) {

		$bu_id = $request->getParameter('id');

		$jos = JobOrderPeer::retrieveByBU($bu_id);

		$jo_payments = array();
		$dates = array();

		foreach ($jos as $jo) {
			$ins = IncomePaymentPeer::retrieveByJobOrderId($jo->getId());
			foreach ($ins as $in) {
				$jo_payments[$jo->getId()][$in->getDate()]['in'][] = $in->getAmount();
				$dates[] = $in->getDate();
			}
			$outs = JobPaymentPeer::retrieveByJobId($jo->getId());
			foreach ($outs as $out) {
				$jo_payments[$jo->getId()][$out->getDate()]['out'][] = $out->getAmount();
				$dates[] = $out->getDate();
			}
		}

		$currents = array();
		$ces = CurrentExpensesPeer::retrieveByBU($bu_id);

		foreach ($ces as $ce) {
			$payments = RegularPaymentPeer::getByCE($ce->getId());
			foreach ($payments as $p) {
				$date = explode('-', $p->getMonth());
				$date = date('Y-m-d', strtotime($p->getMonth().'-01 last friday'));
				$dates[] = $date;
					$currents[$ce->getExpencesTypeId()][$date]['out'][] = $p->getAmount();	
			}
			
		}
		sort($dates);
		$range = $this->createDateRangeArray($dates[0], $dates[count($dates)-1]);
		$mask = array();

		foreach ($range as $r) {
			$mask[$r] = array();
		}

		$jo_labels_arr = array();
		$ce_labels_arr = array();

		$jos_label = JobOrderPeer::doSelect(new Criteria());
		foreach ($jos_label as $l) {
			$jo_labels_arr[$l->getId()] = $l->getName();
		}

		$ce_label = ExpencesTypePeer::doSelect(new Criteria());
		foreach ($ce_label as $l) {
			$ce_labels_arr[$l->getId()] = $l->getName();
		}

		$result = array();
		$i = 0;

		//echo 'MASK: '.count($mask);

		foreach ($jos as $jo) {
			$result[$i]['name'] = $jo_labels_arr[$jo->getId()];
			$result[$i]['dates'] = array_merge($mask, $jo_payments[$jo->getId()]);
			//echo 'JO: '.count($result[$i]['dates']);
			$i++;

		}
		foreach ($ces as $ce) {
			$result[$i]['name'] = $ce_labels_arr[$ce->getExpencesTypeId()];
			$result[$i]['dates'] = array_merge($mask, $currents[$ce->getExpencesTypeId()]);
			//echo 'CE: '.count($result[$i]['dates']);
			$i++;

		}

		//exit;

		$this->range = $range;
		$this->result = $result;

		//exit;


	}

	
	public function executeCashflowNew(sfWebRequest $request)
	{
		if ($this->getUser()->hasCredential('admin')) {
			$this->business_unit_id = $request->getParameter('id');
		} else {
			$this->business_unit_id = $this->getUser()->getProfile()->getBusinessUnitId();
		}
		if ($request->hasParameter('date')) {
			$this->date = $request->getParameter('date');
		} else {
			$this->date = date('m/d/Y');
		}
		
		$this->columns = $this->getColumns($this->date);
		$cashflow_data = $this->getCashflowData($this->columns, $this->business_unit_id);
		$this->data = $cashflow_data['data'];
		
		$this->col_sum = $cashflow_data['col_sum'];
		$data_new = array();
		$data = $this->data;
		//echo '<pre>';print_r($data); die();			

	  	$this->expences_type = ExpencesTypePeer::doSelect(new Criteria());
	  	foreach ($this->expences_type as $type){
			
	  		foreach ($this->data as $i=>$data_row){
	  			
				if ($data_row['type'] == 'cur_exp'){
					//echo '<pre>';print_r($data_row['expences_type']); 	
					if ($data_row['expences_type'] == $type->getId() ){
						
						foreach ($data_row['columns'] as $j => $data_column){
							
							foreach ($data_column as $k => $column){
																
								$data_new[$type->getId()][$i][] = $column;								
							}
						}
					}
				}
		    } 
	  	}
	  //echo '<pre>';print_r( $data_new); die();		
	  	$this->data_expences = array();
	    $start = 1;
		  	foreach ($data_new as $key => $new){
		  	
		  		for($k = 0; $k < 17; $k++){
		  		$sum = 0;
		  	    	for($i = $start; $i < $start+count($new); $i++){
		  			
			  			
			  			if ($new[$i][$k]){
				  			foreach ($new[$i][$k] as $val){
				  				 	$sum = $sum + $val;
				  					//echo $i.','.$k.'    '.$val.'//////';
				  					
				  					
				  			}
			  			}
					  //  print_r($new[$i][$k]['amount']);
					    
		  			}
		  			$this->data_expences[$key][] = $sum;
		  		
 		  		}
 		  		$start = $start + count($new);
 		  		
		  	 
		  	}
	
	  		//echo '<pre>';print_r( $data_expences); die();		
	}
	
	protected function getColumns($selected_date)
	{
		$columns = array();
		
		if (date('N', strtotime($selected_date)) == 1) {
			$start_date = date('Y-m-d', strtotime($selected_date));
		} else {
			$start_date = date('Y-m-d', strtotime('last Monday', strtotime($selected_date)));	//first week monday
		}
		
		$columns[0] = $this->getColumnsDays($start_date);
		$columns[1] = $this->getColumnsWeeks($start_date);
		$columns[2] = $this->getColumnsBrokenMonth($start_date);
		if ($columns[2]) {
			$columns[3] = $this->getColumnsMonths($columns[2]['month_number']);
		}
		
		/* 																	Template for date array.
		 *  $columns = array(
		  0 => array( //days
		  	array('date' => '2011-10-01', 'day_name' => 'пн'),
		    array('date' => '2011-10-02', 'day_name' => 'вт'),
		    ///..................................
		  ),
			1 => array( //weeks
		    array('start_date' => '2011-10-01', 'end_date' => '2011-10-07', 'week_number' => 12, 'week_name' => 'неделя 1'),
		    array('start_date' => '2011-10-08', 'end_date' => '2011-10-15', 'week_number' => 13, 'week_name' => 'неделя 2'),
			),
			2 => array( //broken month
		    'start_date' => '2011-10-15', 'end_date' => '2011-10-31', 'month_number' => 7, 'month_name' => 'July'
			),
			3 => array( //months
		    array('start_date' => '2011-08-01', 'end_date' => '2011-08-31', 'month_number' => 8, 'month_name' => 'August'),
		    array('start_date' => '2011-09-01', 'end_date' => '2011-09-30', 'month_number' => 9, 'month_name' => 'September'),
		    array('start_date' => '2011-10-01', 'end_date' => '2011-10-31', 'month_number' => 10, 'month_name' => 'October'),
		    ///..................................
			),
		);
		*
		**/
		
		return $columns;
	}
	
	protected function getColumnsDays($start_date)
	{
		$week_days = array("пн", "вт", "ср", "чт", "пт", "сб", "вс", "пн", "вт", "ср", "чт", "пт", "сб", "вс");
		$next_year_day = (date('Y')+1).'-01-01';
		$columns = array();
		
		for ($i=0; $i<14; $i++) {
			//14 days, 2 weeks
			$cur_date = date('Y-m-d', strtotime('+'.$i.' day', strtotime($start_date)));
			if ($cur_date >= $next_year_day) {
				break;
			}
			if (date('N', strtotime($cur_date)) == 6 || date('N', strtotime($cur_date)) == 7) {
				//if saturday or sunday - go to next $i
				continue;
			}
			$columns[] = array(
				'date' => $cur_date,
				'day_name' => $week_days[$i],
			);
		}
		return $columns;
	}
	
	protected function getColumnsWeeks($start_date)
	{
		$result = array();
		$next_year_day = (date('Y')+1).'-01-01';
		
		$weeks[0]['start'] = date('Y-m-d', strtotime('+14 day', strtotime($start_date)));
		$weeks[0]['end'] = date('Y-m-d', strtotime('+20 day', strtotime($start_date)));
		$weeks[1]['start'] = date('Y-m-d', strtotime('+21 day', strtotime($start_date)));
		$weeks[1]['end'] = date('Y-m-d', strtotime('+27 day', strtotime($start_date)));
		
		//check if dates do not greater than 01 january of next year
		for ($i=1; $i>=0; $i--) {
			//week 2, 1
			if ($weeks[$i]['start'] >= $next_year_day) {
				unset($weeks[$i]);
			} elseif ($weeks[$i]['end'] >= $next_year_day) {
				for ($j=1; $j<7; $j++) {
					//reduce end date while it will be less than 01.01 of next year
					$weeks[$i]['end'] = date('Y-m-d', strtotime('-1 day', strtotime($weeks[$i]['end'])));
					if ($weeks[$i]['end'] < $next_year_day) {
						//stop and save end date
						break;
					}
				}
			}
		}
		
		if ($weeks) {
			foreach ($weeks as $week) {
				$result[] = array(
					'start_date' 	=> $week['start'],
			    'end_date' 		=> $week['end'], 
			    'week_number' => date('W', strtotime($week['start'])),
			    'week_name' 	=> 'неделя '.date('W', strtotime($week['start'])),
				);
			}
		}
		
		return $result;
	}
	
	protected function getColumnsBrokenMonth($start_date)
	{
		$next_year_day = (date('Y')+1).'-01-01';
		$date = date('Y-m-d', strtotime('+28 day', strtotime($start_date)));
		//array('start_date' => '2011-10-15', 'end_date' => '2011-10-31', 'month_number' => 7, 'month_name' => 'July')
		if ($date >= $next_year_day) {
			return array();
		} else {
			return array(
				'start_date' => $date,
				'end_date' => date('Y-m-d', strtotime('last day of '.date('F Y', strtotime($date)))),
				'month_number' => date('m', strtotime($date)),
				'month_name' => date('F', strtotime($date))
			);
		}
	}
	
	protected function getColumnsMonths($last_month)
	{
		$arr = array();
		for ($i = $last_month+1; $i <=12; $i++) {
			$arr[] = array(
				'start_date' => date('Y').'-'.$i.'-01',
				'end_date' => date('Y-m-d', strtotime('last day of '.date('F Y', strtotime(date('Y').'-'.$i)))),
				'month_number' => $i,
				'month_name' => date('F', strtotime(date('Y').'-'.$i)));
		}
		return $arr;
	}
	
	protected function formIncomePaymentsByDay($jo, $date)
	{
		$arr = array();
		foreach ($jo->getIncomePaymentsByDatePeriod($date) as $jo_ip){
			$arr[] = array('id' => $jo_ip->getId(), 'amount' => $jo_ip->getAmount(), 'approved' => $jo_ip->getIsConfirmed());
		}
		return $arr;
	}
	
	protected function formOutcomePaymentsByDay($jo, $date)
	{
		$arr = array();
		foreach ($jo->getJobs() as $job){
			foreach ($job->getJobPaymentsByDatePeriod($date) as $jo_jp){
				$arr[] = array('id' => $jo_jp->getId(), 'amount' => $jo_jp->getAmount(), 'approved' => $jo_jp->getIsConfirmed(), 'filename' => $jo_jp->getFilename());
			}
		}
		return $arr;
	}
	
	protected function countIncomePaymentsByPeriod($jo, $start_date, $end_date)
	{
		$jo_ip_sum = 0;
		foreach ($jo->getIncomePaymentsByDatePeriod($start_date, $end_date) as $jo_ip) {
			$jo_ip_sum += $jo_ip->getAmount();
		}
		return $jo_ip_sum;
	}
	
	protected function countOutcomePaymentsByPeriod($jo, $start_date, $end_date)
	{
		$jo_jp_sum = 0;
		foreach ($jo->getJobs() as $job){
			foreach ($job->getJobPaymentsByDatePeriod($start_date, $end_date) as $jo_jp) {
				$jo_jp_sum += $jo_jp->getAmount(); 
			}
		} 
		return $jo_jp_sum;
	}
	
	protected function getCashflowData($columns, $bu_id)
	{
		$data = array();
		$cnt = 0;
		$col_sum = array();
		
		$jos = JobOrderPeer::retrieveByBU($bu_id);															// Job Orders
		foreach ($jos as $jo) {
			
			$data[$cnt] = array(
				'type'					=> 'jo',
				'id'						=> $jo->getId(),
				'name'					=> $jo->getName(),
				'total_income'	=> 0,
				'total_outcome'	=> 0, 
				'columns'				=> array(), // array for save amounts data
			);
			
			if ($columns[0]) { //get data for days
				$col_cnt = 0;
				foreach ($columns[0] as $info) {						//$info['date'], $info['day_name']
					$incomes = $this->formIncomePaymentsByDay($jo, $info['date']);
					$outcomes = $this->formOutcomePaymentsByDay($jo, $info['date']);
					$data[$cnt]['columns'][0][$col_cnt] = array('income' => $incomes, 'outcome' => $outcomes);
					
					if (!isset($col_sum[0][$col_cnt]['income'])) {
						$col_sum[0][$col_cnt]['income'] = 0;
					}
					if (!isset($col_sum[0][$col_cnt]['outcome'])) {
						$col_sum[0][$col_cnt]['outcome'] = 0;
					}
					
					if ($incomes) {																				//sum data
						foreach ($incomes as $inc) {
							$data[$cnt]['total_income'] += $inc['amount'];
							$col_sum[0][$col_cnt]['income'] += $inc['amount'];
						}
					}
					
					if ($outcomes) {
						foreach ($outcomes as $out) {
							$data[$cnt]['total_outcome'] += $out['amount'];
							$col_sum[0][$col_cnt]['outcome'] += $out['amount'];
						}
					}
					$col_cnt++;
				}
			}
			
		 	if ($columns[1]) { //get data for weeks
		 		$col_cnt = 0;
				foreach ($columns[1] as $info) { 	//$info = array('start_date' => '2011-10-01', 'end_date' => '2011-10-07', 'week_number' => 12, 'week_name' => 'неделя 1'),
					$income = $this->countIncomePaymentsByPeriod($jo, $info['start_date'], $info['end_date']);
					$outcome = $this->countOutcomePaymentsByPeriod($jo, $info['start_date'], $info['end_date']);
					$data[$cnt]['columns'][1][] = array(
						'income' => $income,
					  'outcome' => $outcome,
					);
					
					if (!isset($col_sum[1][$col_cnt]['income'])) {
						$col_sum[1][$col_cnt]['income'] = 0;
					}
					if (!isset($col_sum[1][$col_cnt]['outcome'])) {
						$col_sum[1][$col_cnt]['outcome'] = 0;
					}
										
					if ($income) {					//sum data
						$data[$cnt]['total_income'] += $income;
						@$col_sum[1][$col_cnt]['income'] += $income;
					}
					if ($outcome) {
						$data[$cnt]['total_outcome'] += $outcome;
						@$col_sum[1][$col_cnt]['outcome'] += $outcome;
					}
					
					$col_cnt++;
				}
			}
			
			if ($columns[2]) { //get data for broken month
				$income = $this->countIncomePaymentsByPeriod($jo, $columns[2]['start_date'], $columns[2]['end_date']);
				$outcome = $this->countOutcomePaymentsByPeriod($jo, $columns[2]['start_date'], $columns[2]['end_date']);
				$data[$cnt]['columns'][2] = array(
					'income' => $income,
				  'outcome' => $outcome,
				);
				
				if (!isset($col_sum[2][0]['income'])) {
					$col_sum[2][0]['income'] = 0;
				}
				if (!isset($col_sum[2][0]['outcome'])) {
					$col_sum[2][0]['outcome'] = 0;
				}
				
				if ($income) {					//sum data
					$data[$cnt]['total_income'] += $income;
					$col_sum[2][0]['income'] += $income;
				}
				if ($outcome) {
					$data[$cnt]['total_outcome'] += $outcome;
					$col_sum[2][0]['outcome'] += $outcome;
				}
			}
			
			if (isset($columns[3])) { //get data for months
				$col_cnt = 0;
				foreach ($columns[3] as $info) {
					$income = $this->countIncomePaymentsByPeriod($jo, $info['start_date'], $info['end_date']);
					$outcome = $this->countOutcomePaymentsByPeriod($jo, $info['start_date'], $info['end_date']);
					$data[$cnt]['columns'][3][$col_cnt] = array(
						'income' => $income,
					  'outcome' => $outcome,
					);
					
					if (!isset($col_sum[3][$col_cnt]['income'])) {
						$col_sum[3][$col_cnt]['income'] = 0;
					}
					if (!isset($col_sum[3][$col_cnt]['outcome'])) {
						$col_sum[3][$col_cnt]['outcome'] = 0;
					}
					
					if ($income) {					//sum data
						$data[$cnt]['total_income'] += $income;
						$col_sum[3][$col_cnt]['income'] += $income;
					}
					if ($outcome) {
						$data[$cnt]['total_outcome'] += $outcome;
						$col_sum[3][$col_cnt]['outcome'] += $outcome;
					}
					
					$col_cnt++;
				}
			}
			$cnt++;
		}
		
		$cur_exps = CurrentExpensesPeer::retrieveByBU($bu_id);											//Current Expenses
		foreach ($cur_exps as $cur_exp) {
			
			$data[$cnt] = array(
						'type'					=> 'cur_exp',
						'id'						=> $cur_exp->getId(),
						'name'					=>  $cur_exp->getName(),
						'expences_type'			=>	$cur_exp->getExpencesTypeId(),
						'total_income'	=> 0,
						'total_outcome'	=> 0, 
						'columns'				=> array(),  // array for save amounts data
			);
				
			if ($columns[0]) {			//get data for days
				$col_cnt = 0;
				foreach ($columns[0] as $info) {		//$info['date'], $info['day_name']
					$outcome = $this->generateLastFridayOfMonth($cur_exp, $info);
					$data[$cnt]['columns'][0][$col_cnt] = array('amount' => $outcome);
					
					
					if (!isset($col_sum[0][$col_cnt]['outcome'])) {
						$col_sum[0][$col_cnt]['outcome'] = 0;
					}
					
					if ($outcome) {																	//sum data
						$data[$cnt]['total_outcome'] += $outcome;
						
						@$col_sum[0][$col_cnt]['outcome'] += $outcome;
					}
					
					$col_cnt++;
				}
			}
			
		 	if ($columns[1]) { //get data for weeks
		 		$col_cnt = 0;
				foreach ($columns[1] as $info) { // $info = array('start_date' => '2011-10-01', 'end_date' => '2011-10-07', 'week_number' => 12, 'week_name' => 'неделя 1');
					$outcome = $this->generateLastFridayOfMonth($cur_exp, $info);
					$data[$cnt]['columns'][1][] = array('outcome' => $outcome);
					
					if (!isset($col_sum[1][$col_cnt]['outcome'])) {
						$col_sum[1][$col_cnt]['outcome'] = 0;
					}
					if ($outcome) {						//sum data
						$data[$cnt]['total_outcome'] += $outcome;
						@$col_sum[1][$col_cnt]['outcome'] += $outcome;
					}
					
					$col_cnt++;
				}
			}			
			
			if ($columns[2]) {	//get data for broken month
				//array('start_date' => '2011-10-15', 'end_date' => '2011-10-31', 'month_number' => 7, 'month_name' => 'July')
				$outcome = $this->generateLastFridayOfMonth($cur_exp, $columns[2]);
				$data[$cnt]['columns'][2] = array('outcome' => $outcome);
				
				if (!isset($col_sum[2][0]['outcome'])) {
					$col_sum[2][0]['outcome'] = 0;
				}
				if ($outcome) {					//sum data
					$data[$cnt]['total_outcome'] += $outcome;
					@$col_sum[2][0]['outcome'] += $outcome;
				}
			}
			
			if (isset($columns[3])) { //get data for months
				$col_cnt = 0;
				//print_r($columns); exit;
				foreach ($columns[3] as $info) {
				
					$date = explode('-', $info['start_date']);
					$bydate = (strlen($date[1]) == 1)?'0'.$date[1]:$date[1];
					$bydate = $date[0].'-'.$bydate;
					
					//$get_by_month = 'getM'.$info['month_number'];
					//$outcome = $cur_exp->$get_by_month();
					
					$outcome = RegularPaymentPeer::getByMonth($bydate, $cur_exp->getId());
					if(!$outcome)
						$outcome = 0;
					$data[$cnt]['columns'][3][$col_cnt] = array('outcome' => $outcome);
					
					if (!isset($col_sum[3][$col_cnt]['outcome'])) {
						$col_sum[3][$col_cnt]['outcome'] = 0;
					}
					if ($outcome) {						//sum data
						$data[$cnt]['total_outcome'] += $outcome;
						@$col_sum[3][$col_cnt]['outcome'] += $outcome;
					}
					
					$col_cnt++;
				}
			}
			
			$cnt++;
		}
		//echo '<pre>';print_r($data); die();
		return array('data' => $data, 'col_sum' => $col_sum);
	}
	
	protected function generateLastFridayOfMonth($cur_exp, $info)											//yyyy"-" mm "-" dd - standart in DB
	{
		$this->month_fridays = array();
		$year = date('Y');
		$amount = 0;
		
		for ($i = 1; $i <= 12; $i++) { //generate Last Fridays array('#Month' => 'yyyy-mm-dd', ...) in the current Year
			$this->month_fridays[$i] = date('Y-m-d', strtotime('last Friday of', strtotime($year.'-'.$i)));
		}
				
		foreach ($this->month_fridays as $month => $date) {
			//echo $date; exit;
			$tmp_date = explode('-', $date);
			$bydate = $tmp_date[0].'-'.$tmp_date[0];
			//$get_by_month = 'getM'.$month;
			if (isset($info['date']) && ($info['date'] == $date)) {				//set CurrentExpenses by Month into Last Friday
				$amount = RegularPaymentPeer::getByMonth($bydate, $cur_exp->getId());
			} elseif (isset($info['start_date']) && isset($info['end_date'])) {		//set CurrentExpenses by Month into WeekSection, if Last Friday is on the Week section
					if ((strtotime($date) >= strtotime($info['start_date'])) && (strtotime($date) <= strtotime($info['end_date']))) {
						$amount = RegularPaymentPeer::getByMonth($bydate, $cur_exp->getId());
						
					}
			}
		}
		return $amount;
	}
	
	public function executeApproveIncomePayment(sfWebRequest $request)
	{
		$this->forward404Unless($request->isXmlHttpRequest());
		
		$income_payment = IncomePaymentPeer::retrieveByPK($request->getParameter('income_payment_id'));
		$income_payment->setIsConfirmed(true);
		$income_payment->save();
		
		return $this->renderText('Confirmed Income Payment with ID = '.$income_payment->getId());
	}
	
	public function executeApproveOutcomePayment(sfWebRequest $request)
	{
		$this->forward404Unless($request->isXmlHttpRequest());
		
		$outcome_payment = JobPaymentPeer::retrieveByPK($request->getParameter('outcome_payment_id'));
		$outcome_payment->setIsConfirmed(true);
		$outcome_payment->save();
		
		return $this->renderText('Confirmed Outcome Payment with ID = '.$outcome_payment->getId());
	}
	
	public function executeConfirmExp(sfWebRequest $request)
	{
		$id = $request->getParameter('id');
		
		$rp = RegularPaymentPeer::retrieveByPk($id);
		$result = 'success';
		if(!$rp instanceof RegularPayment)
		{
			$result = 'error';
		}
		$rp->setIsConfirmed(1);
		$rp->save();
		
		return $this->renderText(json_encode(array('status' => $result)));
		
		
	}
	
	public function executeLoadExp(sfWebRequest $request)
	{
		$id = $request->getParameter('id');
		
		$rp = RegularPaymentPeer::retrieveByPk($id);
		$result = 'success';
		if(!$rp instanceof RegularPayment)
		{
			return $this->renderText('0');
		}
		else
		{
			return $this->renderText($rp->getAmount());
		}
	}
	
	public function executeSaveFile(sfWebRequest $request)
	{
		echo('sdasdsa'.$_FILES['fileToUpload']);
		exit;
	}
	
	public function executeBuStats(sfWebRequest $request)
	{
		$this->bus = BusinessUnitPeer::doSelect(new Criteria());
		
	}
}
