<?php


/**
 * Skeleton subclass for performing query and update operations on the 'business_unit' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class BusinessUnitPeer extends BaseBusinessUnitPeer {

	public static function getBusByUser($user) {

		$c = new Criteria();
		
		if($user->hasCredential('director')) {
			
			$c->add(self::ID, $user->getGuardUser()->getProfile()->getBusinessUnitId());
			
		}
		
		return self::doSelect($c);

	
	}

} // BusinessUnitPeer
