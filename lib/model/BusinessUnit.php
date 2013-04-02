<?php


/**
 * Skeleton subclass for representing a row from the 'business_unit' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class BusinessUnit extends BaseBusinessUnit
{
	public function __toString()
	{
		return $this->getName();
	}

	public function getCurrentProfitPercent()
	{
		return number_format($this->getCurrentProfit()/$this->getPlan()*100, 2);
	}
	public function getCurrentProfit()
	{
		$sum = 0;
		$c = new Criteria();
		$c->add(JobOrderPeer::BUSINESS_UNIT_ID, $this->getId());
		$jos = JobOrderPeer::doSelect($c);

		foreach($jos as $j)
		{
			$sum += $j->getMargin();
		}
		return $sum;
	}

	public function getDebet()
	{
		$jos = JobOrderPeer::retrieveByBU($this->getId());
		$debet = 0;
		foreach($jos as $jo)
		{
			$debet += $jo->getDebet();
		}
		return $debet;
	}

	public function getCredit()
	{
		$jos = JobOrderPeer::retrieveByBU($this->getId());
		$credit = 0;
		foreach($jos as $jo)
		{
			$credit += $jo->getCredit();
		}
		return $credit;
	}

	public function getMonthExpences($month = 0)
	{
		$date = date('Y-m', strtotime('first day of +'.$month.' month'));
		$c = new Criteria();
		$c->add(RegularPaymentPeer::MONTH, $date);
//		$c->add(RegularPaymentPeer::IS_CONFIRMED, false);
		$c->addJoin(RegularPaymentPeer::CURRENT_EXPENSES_ID, CurrentExpensesPeer::ID);
		$c->add(CurrentExpensesPeer::BUSINESS_UNIT_ID, $this->getId());
		$payments = RegularPaymentPeer::doSelect($c);

		$sum = 0;
		foreach($payments as $p)
		{
			$sum += $p->getAmount();
		}
		return $sum;
	}

//	public function getLoans()
//	{
//		$c = new Criteria();
//		$c->add(CurrentExpensesPeer::EXPENCES_TYPE_ID, 6);
//		$c->add(CurrentExpensesPeer::BUSINESS_UNIT_ID, $this->getId());
//
//		$expences = CurrentExpensesPeer::doSelect($c);
//
//		$sum = 0;
//		foreach($expences as $ex)
//		{
//			$sum += $ex->getExpenceSumm();
//		}
//		return $sum;
//
//	}

	public function getLoans(){
		return (float)parent::getLoans();
	}

	public function getCurrentSumm($month = 0)
	{
    	$no_expences = $this->getDebet() - $this->getCredit() - $this->getLoans();

    	$summ = 0;
    	for($i = 0; $i <= $month; $i++)
    	{
    		$summ += $this->getMonthExpences($i);

    	}
		return $no_expences - $summ;
	}
} // BusinessUnit
