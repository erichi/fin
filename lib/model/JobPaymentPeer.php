<?php


/**
 * Skeleton subclass for performing query and update operations on the 'job_payment' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class JobPaymentPeer extends BaseJobPaymentPeer
{
	public static function retrieveByJobOrderId($id)
	{
		$c = new Criteria();
		$c->add(JobPeer::JOB_ORDER_ID, $id);
		$jobs = JobPeer::doSelect($c);
		
		$outs = array();
		foreach($jobs as $j) {
		
			$c = new Criteria();
			$c->add(self::JOB_ID, $j->getId());
			$tmp_outs = self::doSelect($c);
			foreach($tmp_outs as $o) 
				$outs[] = $o;
		
		}
		
		
		return $outs;
	}

    public static function retrieveByJobId($id){
        $c = new Criteria();
        $c->add(self::JOB_ID, $id);
        return self::doSelect($c);
    }

} // JobPaymentPeer
