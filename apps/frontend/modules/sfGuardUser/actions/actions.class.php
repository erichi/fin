<?php

class sfGuardUserActions extends autoSfGuardUserActions
{
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
  	$data = $request->getParameter($form->getName());
  	$vs = $form->getValidatorSchema();
//  	if ($data['sf_guard_user_permission_list'] != 1){
//  		$vs['business_unit_id']->setOption('required', true);
//  	}
    parent::processForm($request, $form);
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->delete();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@sf_guard_user');
  }

}