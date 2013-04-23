<?php


/**
 * Skeleton subclass for representing a row from the 'job_order' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class JobOrder extends BaseJobOrder
{
	public function __toString()
	{
		return $this->getName();
	}
	
	public function getIncomePaymentsByDatePeriod($date_start, $date_end = null)
	{
		$criteria = new Criteria();
		if (!$date_end) {
			$criteria->add(IncomePaymentPeer::DATE, date('Y-m-d', strtotime($date_start)));
		} else {
			//$criteria->add(IncomePaymentPeer::DATE, date('Y-m-d', strtotime($date_start)), Criteria::GREATER_EQUAL);
			//$criteria->add(IncomePaymentPeer::DATE, date('Y-m-d', strtotime($date_end)), Criteria::LESS_EQUAL);
			$crit0 = $criteria->getNewCriterion(IncomePaymentPeer::DATE, date('Y-m-d', strtotime($date_start)), Criteria::GREATER_EQUAL);
			$crit1 = $criteria->getNewCriterion(IncomePaymentPeer::DATE, date('Y-m-d', strtotime($date_end)), Criteria::LESS_EQUAL);
			$crit0->addAnd($crit1);
			$criteria->add($crit0);

		}
		$criteria->add(IncomePaymentPeer::IS_CONFIRMED, true);
		return $this->getIncomePayments($criteria);
	}
	
	public function getBudget()
	{
		$c = new Criteria();
		$c->add(IncomePaymentPeer::JOB_ORDER_ID, $this->getId());
		//$c->add(IncomePaymentPeer::IS_CONFIRMED, true);
		$jos = IncomePaymentPeer::doSelect($c);
		
		$b = 0;
		foreach($jos as $j)
		{
			$b += $j->getAmount();
		}
		return $b;
	}
	
	public function getProductionCost()
	{
		 $c = new Criteria();
		 $c->add(JobPeer::JOB_ORDER_ID, $this->getId());
		 $jobs = JobPeer::doSelect($c);
		 
		 $c = 0;
		 foreach($jobs as $j)
		 {
		 	$c += $j->getAmount();
		 }
		 return $c;
	}
	
	public function getMargin()
	{
		return $this->getBudget() - $this->getProductionCost();
	}
	
	public function getMarginPercent()
	{
		$divide = $this->getBudget();
		if($divide == 0) $divide = 1;
		return number_format($this->getMargin()/$divide*100, 2);
	}

	public function getIncome()
	{
		$c = new Criteria();
		$c->add(IncomePaymentPeer::JOB_ORDER_ID, $this->getId());
		$c->add(IncomePaymentPeer::IS_CONFIRMED, true);
		$incomes = IncomePaymentPeer::doSelect($c);
		
		$sum = 0;
		foreach($incomes as $i)
		{
			$sum += $i->getAmount();
		}
		return $sum;
	}

	public function getOutcome()
	{
		$c = new Criteria();
		$c->add(JobPeer::JOB_ORDER_ID, $this->getId());
		$c->addJoin(JobPaymentPeer::JOB_ID, JobPeer::ID);
		$c->add(JobPaymentPeer::IS_CONFIRMED, true);
		$outcomes = JobPaymentPeer::doSelect($c);	
		
		$sum = 0;
		foreach($outcomes as $o)
		{
			$sum += $o->getAmount();
		}
		return $sum;
	}
	
	public function getTurnoverShare()
	{
		$c = new Criteria();
		$c->add(JobOrderPeer::BUSINESS_UNIT_ID, $this->getBusinessUnitId());
		$b_units = JobOrderPeer::doSelect($c);
		
		$all_sum = 0;
		foreach($b_units as $bu)
		{
			$all_sum += $bu->getBudget();
		}
		return number_format($this->getBudget()/$all_sum*100, 2);
	}

	public function getPlanShare()
	{
		
		return number_format($this->getMargin()/$this->getBusinessUnit()->getPlan()*100, 2);
	}
	
	
	public function getDebet()
	{
		return $this->getBudget() - $this->getIncome();
	} 

	public function getCredit()
	{
		return $this->getProductionCost() - $this->getOutcome();
	} 

	public function getSaldo()
	{
		return $this->getIncome() - $this->getOutcome();
	} 
} // JobOrder
