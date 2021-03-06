<?php


/**
 * Skeleton subclass for representing a row from the 'job_payment' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class JobPayment extends BaseJobPayment {

    public function save(PropelPDO $con = null)
    {
        parent::save($con);
        $this->_updateJobAmount($this->getJobId());
    }

    private function _updateJobAmount($jobId)
    {
        $payments = JobPaymentPeer::retrieveByJobId($jobId);
        $sum = 0;
        foreach($payments as $p){
            $sum += $p->getAmount();
        }
        $job = JobPeer::retrieveByPK($jobId);
        $job->setAmount($sum);
        $job->save();
    }

} // JobPayment
