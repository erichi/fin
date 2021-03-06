<?php


/**
 * Skeleton subclass for performing query and update operations on the 'income_payment' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class IncomePaymentPeer extends BaseIncomePaymentPeer
{
	public static function retrieveByJobOrderId($id)
	{
		$c = new Criteria();
		$c->add(self::JOB_ORDER_ID, $id);
		
		return self::doSelect($c);
	}
} // IncomePaymentPeer
