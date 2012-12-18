<?php

/**
 * ContactPerson filter form base class.
 *
 * @package    Finsys
 * @subpackage filter
 * @author     Stepix
 */
abstract class BaseContactPersonFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'client_id' => new sfWidgetFormPropelChoice(array('model' => 'Client', 'add_empty' => true)),
      'name'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'client_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Client', 'column' => 'id')),
      'name'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contact_person_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContactPerson';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'client_id' => 'ForeignKey',
      'name'      => 'Text',
    );
  }
}
