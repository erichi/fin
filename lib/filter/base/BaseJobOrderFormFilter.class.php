<?php

/**
 * JobOrder filter form base class.
 *
 * @package    Finsys
 * @subpackage filter
 * @author     Stepix
 */
abstract class BaseJobOrderFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'business_unit_id'       => new sfWidgetFormPropelChoice(array('model' => 'BusinessUnit', 'add_empty' => true)),
      'name'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'client_id'              => new sfWidgetFormPropelChoice(array('model' => 'Client', 'add_empty' => true)),
      'indulgence'             => new sfWidgetFormFilterInput(),
      'job_order_manager_list' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'business_unit_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'BusinessUnit', 'column' => 'id')),
      'name'                   => new sfValidatorPass(array('required' => false)),
      'client_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Client', 'column' => 'id')),
      'indulgence'             => new sfValidatorPass(array('required' => false)),
      'job_order_manager_list' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('job_order_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addJobOrderManagerListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(JobOrderManagerPeer::JOB_ORDER_ID, JobOrderPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(JobOrderManagerPeer::USER_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(JobOrderManagerPeer::USER_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'JobOrder';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'business_unit_id'       => 'ForeignKey',
      'name'                   => 'Text',
      'client_id'              => 'ForeignKey',
      'indulgence'             => 'Text',
      'job_order_manager_list' => 'ManyKey',
    );
  }
}
