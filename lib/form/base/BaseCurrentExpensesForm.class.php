<?php

/**
 * CurrentExpenses form base class.
 *
 * @method CurrentExpenses getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Eric Usmanov
 */
abstract class BaseCurrentExpensesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'business_unit_id' => new sfWidgetFormPropelChoice(array('model' => 'BusinessUnit', 'add_empty' => true)),
      'expences_type_id' => new sfWidgetFormPropelChoice(array('model' => 'ExpencesType', 'add_empty' => true)),
      'name'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'business_unit_id' => new sfValidatorPropelChoice(array('model' => 'BusinessUnit', 'column' => 'id', 'required' => false)),
      'expences_type_id' => new sfValidatorPropelChoice(array('model' => 'ExpencesType', 'column' => 'id', 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 100)),
    ));

    $this->widgetSchema->setNameFormat('current_expenses[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CurrentExpenses';
  }


}
