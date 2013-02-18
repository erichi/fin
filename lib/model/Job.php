<?php


/**
 * Skeleton subclass for representing a row from the 'job' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Job extends BaseJob 
{
	public function getJobPaymentsByDatePeriod($date_start, $date_end = null)
	{
		$criteria = new Criteria();
		if (!$date_end) {
			$criteria->add(JobPaymentPeer::DATE, $date_start);
		} else {
			//$criteria->add(JobPaymentPeer::DATE, date('Y-m-d', strtotime($date_start)), Criteria::GREATER_EQUAL);
			//$criteria->add(JobPaymentPeer::DATE, date('Y-m-d', strtotime($date_end)), Criteria::LESS_EQUAL);
			$crit0 = $criteria->getNewCriterion(JobPaymentPeer::DATE, $date_start, Criteria::GREATER_EQUAL);
			$crit1 = $criteria->getNewCriterion(JobPaymentPeer::DATE, $date_end, Criteria::LESS_EQUAL);
			$crit0->addAnd($crit1);
			$criteria->add($crit0);
		}
		
		return $this->getJobPayments($criteria);
	}
} // Job
