<?php

require_once dirname(__FILE__).'/../lib/current_expensesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/current_expensesGeneratorHelper.class.php';

/**
 * current_expenses actions.
 *
 * @package    Finsys
 * @subpackage current_expenses
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class current_expensesActions extends autoCurrent_expensesActions
{
	public function executeSaveTypedData(sfWebRequest $request)
	{
		$this->forward404Unless($request->isXmlHttpRequest()); 
		
		$month_value = $request->getParameter('value');
		
		$ce = RegularPaymentPeer::retrieveByPK($request->getParameter('id'));
		$ce->setAmount($month_value);
		$ce->save();
		
		return $this->renderText($month_value);
	}
	
	public function executeAddNewRow(sfWebRequest $request)
	{
		$this->forward404Unless($request->isXmlHttpRequest()); 
		
		$ce = new CurrentExpenses();
		$ce->setBusinessUnitId($request->getParameter('business_unit_id'));
		$ce->setExpencesTypeId($request->getParameter('type'));
		$ce->setName($request->getParameter('name'));
		$ce->save();
		
		return $this->renderText($ce->getId());
		//return $this->redirect('business_unit/currentExpenses?id=1');
	}
}
