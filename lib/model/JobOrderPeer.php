<?php


/**
 * Skeleton subclass for performing query and update operations on the 'job_order' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class JobOrderPeer extends BaseJobOrderPeer
{
	public static $indulgences = array(
		'0100' => '0/100',
		'1090' => '10/90',
		'2080' => '20/80',
		'3070' => '30/70',
		'4060' => '40/60',
		'5050' => '50/50',
		'6040' => '60/40',
		'7030' => '70/30',
		'8020' => '80/20',
		'9010' => '90/10',
		'1000' => '100/0');
	
	public static function retrieveByBU($id)
	{
		$c = new Criteria();
		$c->add(parent::BUSINESS_UNIT_ID, $id);
		
		return parent::doSelect($c);
	}

	public static function hasManager($jo_id, $manager_id)
	{
	 	$c = new Criteria();
		$c->add(JobOrderPeer::ID, $jo_id);
		$c->addJoin(JobOrderPeer::ID, JobOrderManagerPeer::JOB_ORDER_ID, Criteria::LEFT_JOIN);
		$c->add(JobOrderManagerPeer::USER_ID, $manager_id);
	
		$JOs = JobOrderPeer::doSelect($c);
	
		return count($JOs);
	}
}
