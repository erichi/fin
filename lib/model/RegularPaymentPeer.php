<?php


/**
 * Skeleton subclass for performing query and update operations on the 'regular_payment' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class RegularPaymentPeer extends BaseRegularPaymentPeer {

	public static function getByMonth($m, $curr_exp_id)
	{
		$c = new Criteria();
		$c->add(self::MONTH, $m);
		$c->add(self::CURRENT_EXPENSES_ID, $curr_exp_id);
		$rp = self::doSelectOne($c);
		if($rp instanceof RegularPayment)
		{
			return $rp->getAmount();
		}
		else
		{
			return false;
		}
	}
	
} // RegularPaymentPeer
