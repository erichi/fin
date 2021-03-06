<?php

require_once dirname(__FILE__).'/../lib/job_typeGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/job_typeGeneratorHelper.class.php';

/**
 * job_type actions.
 *
 * @package    Finsys
 * @subpackage job_type
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class job_typeActions extends autoJob_typeActions
{
	public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->delete();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@job_type');
  }

}

