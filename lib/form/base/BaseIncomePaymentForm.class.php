<?php

/**
 * IncomePayment form base class.
 *
 * @method IncomePayment getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Stepix
 */
abstract class BaseIncomePaymentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'job_order_id' => new sfWidgetFormPropelChoice(array('model' => 'JobOrder', 'add_empty' => false)),
      'name'         => new sfWidgetFormInputText(),
      'date'         => new sfWidgetFormDate(),
      'amount'       => new sfWidgetFormInputText(),
      'is_confirmed' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'job_order_id' => new sfValidatorPropelChoice(array('model' => 'JobOrder', 'column' => 'id')),
      'name'         => new sfValidatorString(array('max_length' => 255)),
      'date'         => new sfValidatorDate(),
      'amount'       => new sfValidatorNumber(),
      'is_confirmed' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('income_payment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'IncomePayment';
  }


}
