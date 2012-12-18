<?php

/**
 * RegularPayment form base class.
 *
 * @method RegularPayment getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Stepix
 */
abstract class BaseRegularPaymentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'current_expenses_id' => new sfWidgetFormPropelChoice(array('model' => 'CurrentExpenses', 'add_empty' => true)),
      'amount'              => new sfWidgetFormInputText(),
      'is_confirmed'        => new sfWidgetFormInputCheckbox(),
      'month'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'current_expenses_id' => new sfValidatorPropelChoice(array('model' => 'CurrentExpenses', 'column' => 'id', 'required' => false)),
      'amount'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'is_confirmed'        => new sfValidatorBoolean(array('required' => false)),
      'month'               => new sfValidatorString(array('max_length' => 10)),
    ));

    $this->widgetSchema->setNameFormat('regular_payment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RegularPayment';
  }


}
