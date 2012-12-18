<?php

/**
 * Tender form base class.
 *
 * @method Tender getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Stepix
 */
abstract class BaseTenderForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'name'             => new sfWidgetFormInputText(),
      'budget'           => new sfWidgetFormInputText(),
      'amount'           => new sfWidgetFormInputText(),
      'status'           => new sfWidgetFormInputText(),
      'job_order_id'     => new sfWidgetFormPropelChoice(array('model' => 'JobOrder', 'add_empty' => true)),
      'business_unit_id' => new sfWidgetFormPropelChoice(array('model' => 'BusinessUnit', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 100)),
      'budget'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'amount'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'status'           => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'job_order_id'     => new sfValidatorPropelChoice(array('model' => 'JobOrder', 'column' => 'id', 'required' => false)),
      'business_unit_id' => new sfValidatorPropelChoice(array('model' => 'BusinessUnit', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tender[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tender';
  }


}
