<?php


/**
 * Skeleton subclass for representing a row from the 'current_expenses' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class CurrentExpenses extends BaseCurrentExpenses {

	public function getMonthPayment($m)
	{
		$date = date('Y-m', strtotime('first day of +'.$m.' month'));

		$c = new Criteria();
		$c->add(RegularPaymentPeer::CURRENT_EXPENSES_ID, $this->getId());
		$c->add(RegularPaymentPeer::MONTH, $date);
		$mp = RegularPaymentPeer::doSelectOne($c);

		if(!$mp instanceof RegularPayment)
		{
			$mp = new RegularPayment();
			$mp->setCurrentExpensesId($this->getId());
			$mp->setMonth($date);
			$mp->save();
		}

		return $mp;

	}

	public function getExpenceSumm()
	{
		$c = new Criteria();
		$c->add(RegularPaymentPeer::CURRENT_EXPENSES_ID, $this->getId());
		$c->add(RegularPaymentPeer::IS_CONFIRMED, 0);
		$payments = RegularPaymentPeer::doSelect($c);

		$summ = 0;
		foreach($payments as $p)
		{
			$summ += $p->getAmount();
		}
		return $summ;
	}
} // CurrentExpenses
