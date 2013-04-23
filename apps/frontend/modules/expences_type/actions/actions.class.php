<?php

require_once dirname(__FILE__).'/../lib/expences_typeGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/expences_typeGeneratorHelper.class.php';

/**
 * expences_type actions.
 *
 * @package    Finsys
 * @subpackage expences_type
 * @author     Eric Usmanov
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class expences_typeActions extends autoExpences_typeActions
{
    public function executeDelete(sfWebRequest $request)
    {
        $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
        $this->getRoute()->getObject()->delete();
        $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
        $this->redirect('@expences_type');
    }
}
