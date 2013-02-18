<?php

/**
 * JobPayment filter form base class.
 *
 * @package    Finsys
 * @subpackage filter
 * @author     Stepix
 */
abstract class BaseJobPaymentFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'job_id'       => new sfWidgetFormPropelChoice(array('model' => 'Job', 'add_empty' => true)),
      'name'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'amount'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'filename'     => new sfWidgetFormFilterInput(),
      'is_confirmed' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'job_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Job', 'column' => 'id')),
      'name'         => new sfValidatorPass(array('required' => false)),
      'date'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'amount'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'filename'     => new sfValidatorPass(array('required' => false)),
      'is_confirmed' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('job_payment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'JobPayment';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'job_id'       => 'ForeignKey',
      'name'         => 'Text',
      'date'         => 'Date',
      'amount'       => 'Number',
      'filename'     => 'Text',
      'is_confirmed' => 'Boolean',
    );
  }
}
