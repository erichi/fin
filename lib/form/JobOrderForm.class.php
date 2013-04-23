<?php

/**
 * JobOrder form.
 *
 * @package    Finsys
 * @subpackage form
 * @author     Your name here
 */
class JobOrderForm extends BaseJobOrderForm
{
  public function configure()
  {
  	$indulgences = array('' => '') + JobOrderPeer::$indulgences;

    $user = sfContext::getInstance()->getUser();
    if($user->hasCredential(array('director', 'fm', 'pm'), false)){
        $criteria = new Criteria();
        $criteria->addJoin(BusinessUnitPeer::ID, UserBusinessUnitPeer::BUSINESS_UNIT_ID);
        $criteria->add(UserBusinessUnitPeer::USER_ID, $user->getGuardUser()->getId());
        $this->widgetSchema['business_unit_id']->setOption('criteria', $criteria);
    }

  	$this->widgetSchema['business_unit_id']->setOption('add_empty', true);
  	
  	if (sfContext::getInstance()->getRequest()->hasParameter('return_to_pr')) {																//create JO from BusinessUnit
  		$this->widgetSchema['business_unit_id']->setOption('default', sfContext::getInstance()->getRequest()->getParameter('return_to_pr'));
  	}
  	
  	if (sfContext::getInstance()->getRequest()->hasParameter('tender_id')) {															//create JO from Tender
  		$tender = TenderPeer::retrieveByPK(sfContext::getInstance()->getRequest()->getParameter('tender_id'));
  		$this->widgetSchema['name']->setOption('default', $tender->getName());
  		$this->widgetSchema['tender_id'] = new sfWidgetFormInputHidden(array('default' => $tender->getId()));
  	}
  	
  	if (sfContext::getInstance()->getRequest()->hasParameter('plan_id')) {															//create JO from Plan
  		$plan = PlanPeer::retrieveByPK(sfContext::getInstance()->getRequest()->getParameter('plan_id'));
  		$this->widgetSchema['name']->setOption('default', $plan->getName());
  		$this->widgetSchema['plan_id'] = new sfWidgetFormInputHidden(array('default' => $plan->getId()));
  	}
  	  	
  	$this->widgetSchema['indulgence'] = new sfWidgetFormChoice(array('choices' => $indulgences));
  	$this->validatorSchema['indulgence'] = new sfValidatorChoice(array('choices' => array_keys($indulgences), 'required' => false));
  	
  	$this->widgetSchema->setNameFormat('jo[%s]');
  	$this->validatorSchema->setOption('allow_extra_fields', true);
  }
}
