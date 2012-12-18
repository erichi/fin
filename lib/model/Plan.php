<?php


/**
 * Skeleton subclass for representing a row from the 'plan' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Plan extends BasePlan {

	public function getMargin()
	{
		return $this->getBudget() - $this->getAmount();
	}

	public function getMarginPercent()
	{
		return number_format($this->getMargin()/$this->getBudget()*100, 2);
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


} // Plan
