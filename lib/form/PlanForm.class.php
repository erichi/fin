<?php

/**
 * Plan form.
 *
 * @package    Finsys
 * @subpackage form
 * @author     Your name here
 */
class PlanForm extends BasePlanForm
{
  public function configure()
  {
  	unset($this['job_order_id']);
  	$this->widgetSchema['business_unit_id'] = new sfWidgetFormInputHidden();
  }
}
