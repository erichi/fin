<?php

/**
 * JobPayment form base class.
 *
 * @method JobPayment getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Stepix
 */
abstract class BaseJobPaymentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'job_id'       => new sfWidgetFormPropelChoice(array('model' => 'Job', 'add_empty' => false)),
      'name'         => new sfWidgetFormInputText(),
      'date'         => new sfWidgetFormDate(),
      'amount'       => new sfWidgetFormInputText(),
      'filename'     => new sfWidgetFormInputText(),
      'is_confirmed' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'job_id'       => new sfValidatorPropelChoice(array('model' => 'Job', 'column' => 'id')),
      'name'         => new sfValidatorString(array('max_length' => 100)),
      'date'         => new sfValidatorDate(),
      'amount'       => new sfValidatorNumber(),
      'filename'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_confirmed' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('job_payment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'JobPayment';
  }


}
