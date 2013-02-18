<?php

/**
 * Tender filter form base class.
 *
 * @package    Finsys
 * @subpackage filter
 * @author     Stepix
 */
abstract class BaseTenderFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'budget'           => new sfWidgetFormFilterInput(),
      'amount'           => new sfWidgetFormFilterInput(),
      'status'           => new sfWidgetFormFilterInput(),
      'job_order_id'     => new sfWidgetFormPropelChoice(array('model' => 'JobOrder', 'add_empty' => true)),
      'business_unit_id' => new sfWidgetFormPropelChoice(array('model' => 'BusinessUnit', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorPass(array('required' => false)),
      'budget'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'amount'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'status'           => new sfValidatorPass(array('required' => false)),
      'job_order_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'JobOrder', 'column' => 'id')),
      'business_unit_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'BusinessUnit', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('tender_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tender';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'name'             => 'Text',
      'budget'           => 'Number',
      'amount'           => 'Number',
      'status'           => 'Text',
      'job_order_id'     => 'ForeignKey',
      'business_unit_id' => 'ForeignKey',
    );
  }
}
