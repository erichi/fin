<?php

/**
 * BusinessUnit form.
 *
 * @package    Finsys
 * @subpackage form
 * @author     Your name here
 */
class BusinessUnitForm extends BaseBusinessUnitForm
{
  public function configure()
  {
  	parent::configure();
  	unset($this['loans']);
    unset($this['user_business_unit_list']);
  }
}
