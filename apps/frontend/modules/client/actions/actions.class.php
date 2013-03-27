<?php

require_once dirname(__FILE__).'/../lib/clientGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/clientGeneratorHelper.class.php';

/**
 * client actions.
 *
 * @package    Finsys
 * @subpackage client
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class clientActions extends autoClientActions
{
public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->delete();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@client');
  }

}
