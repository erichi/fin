<?php

/**
 * sfGuardUserProfile filter form base class.
 *
 * @package    Finsys
 * @subpackage filter
 * @author     Stepix
 */
abstract class BasesfGuardUserProfileFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'          => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'email'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'first_name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'last_name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'address'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'phone'            => new sfWidgetFormFilterInput(),
      'bio'              => new sfWidgetFormFilterInput(),
      'business_unit_id' => new sfWidgetFormPropelChoice(array('model' => 'BusinessUnit', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'user_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'email'            => new sfValidatorPass(array('required' => false)),
      'first_name'       => new sfValidatorPass(array('required' => false)),
      'last_name'        => new sfValidatorPass(array('required' => false)),
      'address'          => new sfValidatorPass(array('required' => false)),
      'phone'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'bio'              => new sfValidatorPass(array('required' => false)),
      'business_unit_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'BusinessUnit', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'user_id'          => 'ForeignKey',
      'email'            => 'Text',
      'first_name'       => 'Text',
      'last_name'        => 'Text',
      'address'          => 'Text',
      'phone'            => 'Number',
      'bio'              => 'Text',
      'business_unit_id' => 'ForeignKey',
    );
  }
}
