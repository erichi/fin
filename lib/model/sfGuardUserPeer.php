<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserPeer.php 7634 2008-02-27 18:01:40Z fabien $
 */
class sfGuardUserPeer extends PluginsfGuardUserPeer
{
	public static function retrieveByUsernameOrEmail($usernameOrEmail, $isActive = true )
	{
		$c = new Criteria();
		$c->addJoin(sfGuardUserPeer::ID, sfGuardUserProfilePeer::USER_ID, Criteria::LEFT_JOIN);
		$crit1 = new Criterion($c, sfGuardUserPeer::USERNAME, $usernameOrEmail);
		$crit2 = new Criterion($c, sfGuardUserProfilePeer::EMAIL, $usernameOrEmail);
		$crit1->addOr($crit2) ;
		$c->add($crit1) ;
		$c->add(self::IS_ACTIVE, $isActive);
	
		return self::doSelectOne($c);
	}
	
	public static function doSelectJoinProfile(Criteria $criteria, PropelPDO $con = null)
	{
		if (!$criteria) {
			$criteria = new Criteria();
		}
		$criteria->addJoin(sfGuardUserPeer::ID, sfGuardUserProfilePeer::USER_ID, Criteria::LEFT_JOIN);
		return sfGuardUserPeer::doSelect($criteria, $con);
	}
	
	public static function doSelectJoManagers($jo)
	{
		$c = new Criteria();
		$c->addJoin(JobOrderManagerPeer::USER_ID,sfGuardUserPeer::ID, Criteria::LEFT_JOIN);
		$c->add(JobOrderManagerPeer::JOB_ORDER_ID, $jo->getId());
		
		return self::doSelectJoinProfile($c);
	}
	
	public function getUnitManagers($unit_id) {
		
		$all_users = self::doSelectJoinProfile(new Criteria());
		$return = array();
		foreach($all_users as $user) {
			if($user->getBusinessUnitId() == $unit_id && $user->hasPermission('pm'))
				$return[] = $user;
		}
		return $return;
	}

	public function getManagers($unit_id) {
		
		$all_users = self::doSelectJoinProfile(new Criteria());
		$return = array();
		foreach($all_users as $user) {
			if($user->hasPermission('pm'))
				$return[] = $user;
		}
		return $return;
	}
}
