<?php

require_once dirname(__FILE__).'/../lib/tenderGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/tenderGeneratorHelper.class.php';

/**
 * tender actions.
 *
 * @package    Finsys
 * @subpackage tender
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class tenderActions extends autoTenderActions
{
	 public function executeNew(sfWebRequest $request)
  {
		if ($request->hasParameter('return_to_pr')) {
			$this->getUser()->setAttribute('return_to_pr', $request->getParameter('return_to_pr'));
		}
		parent::executeNew($request);
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      $Tender = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $Tender)));

      if ($this->getUser()->hasAttribute('return_to_pr')) {																			//redirect if tender created from ProjectReport
      	$this->redirect('@project_report?id='.$this->getUser()->getAttribute('return_to_pr'));
      }
      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@tender_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'tender_edit', 'sf_subject' => $Tender));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
	}

  public function executeDelete(sfWebRequest $request)
  {
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
    $obj = $this->getRoute()->getObject();
    $id = $obj->getBusinessUnitId();
    $obj->delete();
    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
    $this->redirect('project_report', array('id' => $id));
  }
}
