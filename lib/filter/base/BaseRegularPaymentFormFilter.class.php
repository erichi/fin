<?php

/**
 * RegularPayment filter form base class.
 *
 * @package    Finsys
 * @subpackage filter
 * @author     Stepix
 */
abstract class BaseRegularPaymentFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'current_expenses_id' => new sfWidgetFormPropelChoice(array('model' => 'CurrentExpenses', 'add_empty' => true)),
      'amount'              => new sfWidgetFormFilterInput(),
      'is_confirmed'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'month'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'current_expenses_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'CurrentExpenses', 'column' => 'id')),
      'amount'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_confirmed'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'month'               => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('regular_payment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'RegularPayment';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'current_expenses_id' => 'ForeignKey',
      'amount'              => 'Number',
      'is_confirmed'        => 'Boolean',
      'month'               => 'Text',
    );
  }
}
