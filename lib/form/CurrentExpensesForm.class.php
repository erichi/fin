<?php

/**
 * CurrentExpenses form.
 *
 * @package    Finsys
 * @subpackage form
 * @author     Your name here
 */
class CurrentExpensesForm extends BaseCurrentExpensesForm
{
	public static $types = array('worker' => 'worker', 'tax' => 'tax');
	
  public function configure()
  {
  	$this->widgetSchema['type'] = new sfWidgetFormChoice(array('choices' => self::$types));
  	
  	$this->validatorSchema['type'] = new sfValidatorChoice(array('choices' => array_keys(self::$types)));
  }
}
