<?php

/**
 * Tender form.
 *
 * @package    Finsys
 * @subpackage form
 * @author     Your name here
 */
class TenderForm extends BaseTenderForm
{
  public function configure()
  {
  	unset($this['job_order_id']);
  	$this->widgetSchema['status'] = new sfWidgetFormInputHidden();
  	$this->widgetSchema['business_unit_id'] = new sfWidgetFormInputHidden();
  }
  
}
