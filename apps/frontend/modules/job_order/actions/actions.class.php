<?php

require_once dirname(__FILE__).'/../lib/job_orderGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/job_orderGeneratorHelper.class.php';

/**
 * job_order actions.
 *
 * @package    Finsys
 * @subpackage job_order
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class job_orderActions extends autoJob_orderActions
{
	public function executeNew(sfWebRequest $request)
	{
		if ($request->hasParameter('return_to_pr')) {
			$this->getUser()->setAttribute('return_to_pr', $request->getParameter('return_to_pr'));
		}

		parent::executeNew($request);

		$this->clients = $this->getClientsArray();

	    $this->all_managers = sfGuardUserPeer::retrieveByPermission('pm');
	    $this->jo_managers = null;
	    $this->job_types = JobTypePeer::doSelect(new Criteria());
	    $this->income_payments = null;
	    $this->jobs	= null;
	}

  public function executeEdit(sfWebRequest $request)
  {
  	if ($this->getUser()->hasCredential('pm')) {
  		$this->forward404Unless(JobOrderPeer::hasManager($this->getRoute()->getObject()->getId(), $this->getUser()->getGuardUser()->getId()));
  	}
  	if ($this->getUser()->hasCredential(array('director', 'fm'), false)) {
  		$this->forward404Unless($this->getRoute()->getObject()->getBusinessUnitId() == $this->getUser()->getProfile()->getBusinessUnitId());
  	}
  	parent::executeEdit($request);

  	$this->clients = $this->getClientsArray();
  	$this->all_managers = sfGuardUserPeer::retrieveByPermission('pm');
    $this->jo_managers = sfGuardUserPeer::doSelectJoManagers($this->JobOrder);
  	$this->job_types = JobTypePeer::doSelect(new Criteria());
  	$this->income_payments = IncomePaymentPeer::retrieveByJobOrderId($this->JobOrder->getId());
  	$this->jobs = JobPeer::retrieveByJobOrderId($this->JobOrder->getId());
  }

  public function executeAddNewClient(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());

		$client = new Client();
		$client->setName($request->getParameter('client_name'));
		$client->save();

		$clients = $this->getClientsArray(null, $client->getId());

    return $this->renderText($clients);
  }

  protected function getClientsArray(Criteria $c = null, $new_client_id = null)
  {
  	$client_data = array();
  	if (!$c){
  		$c = new Criteria();
  	}
  	if ($clients  = ClientPeer::doSelect($c)) {
	  	foreach ($clients as $client){
		  	$contact_persons = array();
		  	foreach ($client->getContactPersons() as $ccp){
		  		$contact_persons[] = array('id' => $ccp->getId(), 'name' => $ccp->getName());
		  	}
		  	$client_data['db'][] = array('id' => $client->getId(), 'name' => $client->getName(), 'contact_persons' => $contact_persons);
	  	}
  	}
  	if ($new_client_id) {
  		$client_data['added'] = array('id' => $new_client_id);
  	}
  	return json_encode($client_data);
  }


	protected function processForm(sfWebRequest $request, sfForm $form)
  {
  	$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      $con = Propel::getConnection();
      $con->beginTransaction();
      try {
	      $JobOrder = $form->save($con);
	      $this->removeOldFields($JobOrder, $request, $con);
	      $this->saveJobOrder($JobOrder, $request, $con);									//custom developed save method
      	$con->commit();
      } catch (Exception $e) {
      	$con->rollback();
      	throw $e;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $JobOrder)));

      if ($this->getUser()->hasAttribute('return_to_pr')) {	     																	 //redirect if create JO from ProjectReport
	      $this->redirect('@project_report?id='.$this->getUser()->getAttribute('return_to_pr'));
      }
      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@job_order_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'job_order_edit', 'sf_subject' => $JobOrder));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
    }
  }

  public function executeDelete(sfWebRequest $request)
  {

	//$request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $c = new Criteria();
    $c->add(TenderPeer::JOB_ORDER_ID, $this->getRoute()->getObject()->getId());
    $del = TenderPeer::doDelete($c);

    $this->getRoute()->getObject()->delete();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@job_order');
  }


  protected function saveJobOrder($JobOrder, $request, $con)
  {
  	$jo = $request->getParameter('jo');			//save custom fields in JO

  	if (isset($jo['manager'])) {
	  	foreach ($jo['manager'] as $manager_id) {									//save JO managers
	  		$job_order_manager = new JobOrderManager();
		  	$job_order_manager->setUserId($manager_id);
		  	$job_order_manager->setJobOrder($JobOrder);
		  	$job_order_manager->save($con);
	  	}
  	}
  	if (isset($jo['income_payment'])) {
	  	foreach ($jo['income_payment'] as $ip) {									//save JO Income Payments
	  		$income_payment = new IncomePayment();
	  		$income_payment->setJobOrder($JobOrder);
	  		$income_payment->setName($ip['name']);
	  		$income_payment->setDate($ip['date']);
	  		$income_payment->setAmount($ip['amount']);
	  		$income_payment->setIsConfirmed($ip['is_confirmed']);
	  		$income_payment->save($con);
	  	}
  	}
  	if (isset($jo['outcome_payment'])) {
  		foreach ($jo['outcome_payment'] as $op) {									//save JO Outcome Payments(by Job)
	  		$job = new Job();
	  		$job->setJobOrder($JobOrder);
	  		$job->setName($op['name']);
	  		$job->setJobTypeId($op['job_type']);
	  		$job->setSupplier($op['supplier']);
	  		$job->setAmount($op['amount']);
	  		$job->save($con);
	  		if (isset($op['job_payment'])) {
		  		foreach ($op['job_payment'] as $op_jp) {

          	//save JO Outcome Payments(payments for concrete job)

            $op_jp['file'] = str_replace('C:\fakepath\\', '', $op_jp['file']);

            $job_payment = new JobPayment();
		  			$job_payment->setJob($job);
		  			$job_payment->setName($op_jp['name']);
		  			$job_payment->setDate($op_jp['date']);
		  			$job_payment->setAmount($op_jp['amount']);
		  			$job_payment->setFilename($op_jp['file']);
	  				$job_payment->setIsConfirmed($op_jp['is_confirmed']);
		  			$job_payment->save($con);
		  		}
	  		}
	  	}
  	}

  	if (isset($jo['tender_id'])) {																	// update Tender to status = won
  		$tender = TenderPeer::retrieveByPK($jo['tender_id']);
  		$tender->setName($JobOrder->getName());
  		$tender->setStatus('won');
  		$tender->setJobOrder($JobOrder);
  		$tender->save();
  	}

  	if (isset($jo['plan_id'])) {																			// update Plan to real JO
  		$plan = PlanPeer::retrieveByPK($jo['plan_id']);
  		$plan->setName($JobOrder->getName());
  		$plan->setJobOrder($JobOrder);
  		$plan->save();
  	}
  }
  protected function removeOldFields($JobOrder, $request, $con)
  {
  	$jobs = JobPeer::retrieveByJobOrderId($JobOrder->getId());
  	$income_payments = IncomePaymentPeer::retrieveByJobOrderId($JobOrder->getId());
  	foreach ($jobs as $job) {
  		$job->delete($con);
  	}
  	foreach ($income_payments as $ip) {
  		$ip->delete($con);
  	}
  }

  public function executeGetClients(sfWebRequest $request)
  {
  	$this->forward404Unless($request->isXmlHttpRequest());
  	$clients = $this->getClientsArray(null, $request->getParameter('client_id'));
  	return $this->renderText($clients);
  }

  public function executeCreateContactPerson(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    $contact_person = new ContactPerson();
    $contact_person->setClientId($request->getParameter('client_id'));
    $contact_person->setName($request->getParameter('cp_name'));
    $contact_person->save();

    $clients = $this->getClientsArray(null, $request->getParameter('client_id'));
    return $this->renderText($clients);
  }

  public function executeDeleteContactPerson(sfWebRequest $request)
  {
    $this->forward404Unless($request->isXmlHttpRequest());

    $contact_person = ContactPersonPeer::retrieveByPK($request->getParameter('cp_id'));
    $contact_person->delete();

    $clients = $this->getClientsArray(null, $request->getParameter('client_id'));
    return $this->renderText($clients);
  }

  public function executeUploadFile()
  {
  	//$this->forward404Unless($request->isXmlHttpRequest());
  	$error = "";
  	$msg = "";
  	$fileElementName = 'fileToUpload';
  	//$uploads_dir = '/uploads/';
  	//print_r($fileElementName);die();
  	if(!empty($_FILES[$fileElementName]['error']))
  	{
  		switch($_FILES[$fileElementName]['error'])
  		{

  			case '1':
  				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
  				break;
  			case '2':
  				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
  				break;
  			case '3':
  				$error = 'The uploaded file was only partially uploaded';
  				break;
  			case '4':
  				$error = 'No file was uploaded.';
  				break;

  			case '6':
  				$error = 'Missing a temporary folder';
  				break;
  			case '7':
  				$error = 'Failed to write file to disk';
  				break;
  			case '8':
  				$error = 'File upload stopped by extension';
  				break;
  			case '999':
  			default:
  				$error = 'No error code avaiable';
  		}
  	}elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
  	{
  		$error = 'No file was uploaded..';
  	}else
  	{
  		move_uploaded_file($_FILES['fileToUpload']['tmp_name'], sfConfig::get('upload_files_dir').DIRECTORY_SEPARATOR.$_FILES['fileToUpload']['name']);
  		// what after successfully uploaded file???

  		$msg .= $_FILES['fileToUpload']['name'];
  		//for security reason, we force to remove all uploaded file
  		@unlink($_FILES['fileToUpload']);
  	}
  	$status = "{error: '" . $error . "';\n msg: '" . $msg . "'\n }";
  	$text = 'file upload.....';
  	return $this->renderText($status);
  }

  protected function buildCriteria()											// form list of JO
  {
  	$c = parent::buildCriteria();

  	if ($this->getUser()->hasCredential('pm')) {
  		$c->addJoin(JobOrderPeer::ID, JobOrderManagerPeer::JOB_ORDER_ID, Criteria::LEFT_JOIN);
  		$c->add(JobOrderManagerPeer::USER_ID, $this->getUser()->getGuardUser()->getId());
  	}

  	if ($this->getUser()->hasCredential('director')) {
  		$c->add(JobOrderPeer::BUSINESS_UNIT_ID, $this->getUser()->getGuardUser()->getProfile()->getBusinessUnitId());
  	}

  	return $c;
  }

  public function executeShow(sfWebRequest $request)
  {
  	$this->JobOrder = $this->getRoute()->getObject();
  	if ($this->getUser()->hasCredential('pm')) {
  		$this->forward404Unless(JobOrderPeer::hasManager($this->JobOrder->getId(), $this->getUser()->getGuardUser()->getId()));
  	}
  	if ($this->getUser()->hasCredential(array('director', 'fm'), false)) {
  		$this->forward404Unless($this->JobOrder->getBusinessUnitId() == $this->getUser()->getProfile()->getBusinessUnitId());
  	}
  	$this->managers = sfGuardUserPeer::doSelectJoManagers($this->JobOrder);
  	$this->income_payments = IncomePaymentPeer::retrieveByJobOrderId($this->JobOrder->getId());
  	$this->jobs = JobPeer::retrieveByJobOrderId($this->JobOrder->getId());

  	$total_budget = 0;
  	if ($this->income_payments) {																							//count total budget
			foreach ($this->income_payments as $ip) {
				$total_budget += $ip->getAmount();
			}
  	}
  	$sum_op = 0;
  	if ($this->jobs) {																											//count sum outcome payments
  		foreach ($this->jobs as $job){
  			$sum_op += $job->getAmount();
  		}
  	}
		$this->total_budget = round($total_budget, 2);
  	$this->net_profit = round($total_budget - $sum_op, 2);
  	$this->margin = round(($this->net_profit / $this->total_budget) * 100, 2);
  }
}
