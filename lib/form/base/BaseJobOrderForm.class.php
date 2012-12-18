<?php

/**
 * JobOrder form base class.
 *
 * @method JobOrder getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Stepix
 */
abstract class BaseJobOrderForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'business_unit_id'       => new sfWidgetFormPropelChoice(array('model' => 'BusinessUnit', 'add_empty' => false)),
      'name'                   => new sfWidgetFormInputText(),
      'client_id'              => new sfWidgetFormPropelChoice(array('model' => 'Client', 'add_empty' => true)),
      'indulgence'             => new sfWidgetFormInputText(),
      'job_order_manager_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'business_unit_id'       => new sfValidatorPropelChoice(array('model' => 'BusinessUnit', 'column' => 'id')),
      'name'                   => new sfValidatorString(array('max_length' => 50)),
      'client_id'              => new sfValidatorPropelChoice(array('model' => 'Client', 'column' => 'id', 'required' => false)),
      'indulgence'             => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'job_order_manager_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'JobOrder', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('job_order[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'JobOrder';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['job_order_manager_list']))
    {
      $values = array();
      foreach ($this->object->getJobOrderManagers() as $obj)
      {
        $values[] = $obj->getUserId();
      }

      $this->setDefault('job_order_manager_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveJobOrderManagerList($con);
  }

  public function saveJobOrderManagerList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['job_order_manager_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(JobOrderManagerPeer::JOB_ORDER_ID, $this->object->getPrimaryKey());
    JobOrderManagerPeer::doDelete($c, $con);

    $values = $this->getValue('job_order_manager_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new JobOrderManager();
        $obj->setJobOrderId($this->object->getPrimaryKey());
        $obj->setUserId($value);
        $obj->save();
      }
    }
  }

}
