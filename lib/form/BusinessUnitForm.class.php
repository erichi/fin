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
  }
}
