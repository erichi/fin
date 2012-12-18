<?php


/**
 * Skeleton subclass for performing query and update operations on the 'current_expenses' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class CurrentExpensesPeer extends BaseCurrentExpensesPeer
{
	public static function retrieveByBU($id, Criteria $c = NULL)
	{
		if (!$c){
			$c = new Criteria();
		}
		$c->add(parent::BUSINESS_UNIT_ID, $id);
		
		return parent::doSelect($c);
	}
	
} // CurrentExpensesPeer
