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
 * @version    SVN: $Id: sfGuardUser.php 7634 2008-02-27 18:01:40Z fabien $
 */
class sfGuardUser extends PluginsfGuardUser
{
	public function getEmail()
	{
		return $this->getProfile()->getEmail();
	}
	public function setEmail($email)
	{
		$this->getProfile()->setEmail($email);
	} 
	public function getFirstName()
	{
		return $this->getProfile()->getFirstName();
	}
	public function getLastName()
	{
		return $this->getProfile()->getLastName();
	}
	public function getPhone()
	{
		return $this->getProfile()->getPhone();
	}

    public function hasBusinessUnit($id)
    {
        $criteria = new Criteria();
        $criteria->add(UserBusinessUnitPeer::BUSINESS_UNIT_ID, $id);
        $userBusinessUnits = $this->getUserBusinessUnits($criteria);
        return isset($userBusinessUnits[0]);
    }
}
