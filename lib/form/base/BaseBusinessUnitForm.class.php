<?php

/**
 * BusinessUnit form base class.
 *
 * @method BusinessUnit getObject() Returns the current form's model object
 *
 * @package    Finsys
 * @subpackage form
 * @author     Eric Usmanov
 */
abstract class BaseBusinessUnitForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'name'                    => new sfWidgetFormInputText(),
      'plan'                    => new sfWidgetFormInputText(),
      'loans'                   => new sfWidgetFormInputText(),
      'user_business_unit_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'name'                    => new sfValidatorString(array('max_length' => 50)),
      'plan'                    => new sfValidatorNumber(),
      'loans'                   => new sfValidatorNumber(),
      'user_business_unit_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('business_unit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BusinessUnit';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['user_business_unit_list']))
    {
      $values = array();
      foreach ($this->object->getUserBusinessUnits() as $obj)
      {
        $values[] = $obj->getUserId();
      }

      $this->setDefault('user_business_unit_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUserBusinessUnitList($con);
  }

  public function saveUserBusinessUnitList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['user_business_unit_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(UserBusinessUnitPeer::BUSINESS_UNIT_ID, $this->object->getPrimaryKey());
    UserBusinessUnitPeer::doDelete($c, $con);

    $values = $this->getValue('user_business_unit_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UserBusinessUnit();
        $obj->setBusinessUnitId($this->object->getPrimaryKey());
        $obj->setUserId($value);
        $obj->save();
      }
    }
  }

}
