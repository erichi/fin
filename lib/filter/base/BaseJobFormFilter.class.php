<?php

/**
 * Job filter form base class.
 *
 * @package    Finsys
 * @subpackage filter
 * @author     Stepix
 */
abstract class BaseJobFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'job_order_id' => new sfWidgetFormPropelChoice(array('model' => 'JobOrder', 'add_empty' => true)),
      'name'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'job_type_id'  => new sfWidgetFormPropelChoice(array('model' => 'JobType', 'add_empty' => true)),
      'supplier'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'amount'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'job_order_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'JobOrder', 'column' => 'id')),
      'name'         => new sfValidatorPass(array('required' => false)),
      'job_type_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'JobType', 'column' => 'id')),
      'supplier'     => new sfValidatorPass(array('required' => false)),
      'amount'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('job_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Job';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'job_order_id' => 'ForeignKey',
      'name'         => 'Text',
      'job_type_id'  => 'ForeignKey',
      'supplier'     => 'Text',
      'amount'       => 'Number',
    );
  }
}
