<?php

/**
 * CurrentExpenses filter form base class.
 *
 * @package    Finsys
 * @subpackage filter
 * @author     Stepix
 */
abstract class BaseCurrentExpensesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'business_unit_id' => new sfWidgetFormPropelChoice(array('model' => 'BusinessUnit', 'add_empty' => true)),
      'expences_type_id' => new sfWidgetFormPropelChoice(array('model' => 'ExpencesType', 'add_empty' => true)),
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'business_unit_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'BusinessUnit', 'column' => 'id')),
      'expences_type_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ExpencesType', 'column' => 'id')),
      'name'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('current_expenses_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CurrentExpenses';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'business_unit_id' => 'ForeignKey',
      'expences_type_id' => 'ForeignKey',
      'name'             => 'Text',
    );
  }
}
