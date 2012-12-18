<?php

/**
 * Base class that represents a row from the 'job_order' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseJobOrder extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        JobOrderPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the business_unit_id field.
	 * @var        int
	 */
	protected $business_unit_id;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the client_id field.
	 * @var        int
	 */
	protected $client_id;

	/**
	 * The value for the indulgence field.
	 * @var        string
	 */
	protected $indulgence;

	/**
	 * @var        BusinessUnit
	 */
	protected $aBusinessUnit;

	/**
	 * @var        Client
	 */
	protected $aClient;

	/**
	 * @var        array JobOrderManager[] Collection to store aggregation of JobOrderManager objects.
	 */
	protected $collJobOrderManagers;

	/**
	 * @var        Criteria The criteria used to select the current contents of collJobOrderManagers.
	 */
	private $lastJobOrderManagerCriteria = null;

	/**
	 * @var        array IncomePayment[] Collection to store aggregation of IncomePayment objects.
	 */
	protected $collIncomePayments;

	/**
	 * @var        Criteria The criteria used to select the current contents of collIncomePayments.
	 */
	private $lastIncomePaymentCriteria = null;

	/**
	 * @var        array Job[] Collection to store aggregation of Job objects.
	 */
	protected $collJobs;

	/**
	 * @var        Criteria The criteria used to select the current contents of collJobs.
	 */
	private $lastJobCriteria = null;

	/**
	 * @var        array Tender[] Collection to store aggregation of Tender objects.
	 */
	protected $collTenders;

	/**
	 * @var        Criteria The criteria used to select the current contents of collTenders.
	 */
	private $lastTenderCriteria = null;

	/**
	 * @var        array Plan[] Collection to store aggregation of Plan objects.
	 */
	protected $collPlans;

	/**
	 * @var        Criteria The criteria used to select the current contents of collPlans.
	 */
	private $lastPlanCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	// symfony behavior
	
	const PEER = 'JobOrderPeer';

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [business_unit_id] column value.
	 * 
	 * @return     int
	 */
	public function getBusinessUnitId()
	{
		return $this->business_unit_id;
	}

	/**
	 * Get the [name] column value.
	 * 
	 * @return     string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the [client_id] column value.
	 * 
	 * @return     int
	 */
	public function getClientId()
	{
		return $this->client_id;
	}

	/**
	 * Get the [indulgence] column value.
	 * 
	 * @return     string
	 */
	public function getIndulgence()
	{
		return $this->indulgence;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     JobOrder The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = JobOrderPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [business_unit_id] column.
	 * 
	 * @param      int $v new value
	 * @return     JobOrder The current object (for fluent API support)
	 */
	public function setBusinessUnitId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->business_unit_id !== $v) {
			$this->business_unit_id = $v;
			$this->modifiedColumns[] = JobOrderPeer::BUSINESS_UNIT_ID;
		}

		if ($this->aBusinessUnit !== null && $this->aBusinessUnit->getId() !== $v) {
			$this->aBusinessUnit = null;
		}

		return $this;
	} // setBusinessUnitId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     JobOrder The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = JobOrderPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [client_id] column.
	 * 
	 * @param      int $v new value
	 * @return     JobOrder The current object (for fluent API support)
	 */
	public function setClientId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->client_id !== $v) {
			$this->client_id = $v;
			$this->modifiedColumns[] = JobOrderPeer::CLIENT_ID;
		}

		if ($this->aClient !== null && $this->aClient->getId() !== $v) {
			$this->aClient = null;
		}

		return $this;
	} // setClientId()

	/**
	 * Set the value of [indulgence] column.
	 * 
	 * @param      string $v new value
	 * @return     JobOrder The current object (for fluent API support)
	 */
	public function setIndulgence($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->indulgence !== $v) {
			$this->indulgence = $v;
			$this->modifiedColumns[] = JobOrderPeer::INDULGENCE;
		}

		return $this;
	} // setIndulgence()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->business_unit_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->client_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->indulgence = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 5; // 5 = JobOrderPeer::NUM_COLUMNS - JobOrderPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating JobOrder object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aBusinessUnit !== null && $this->business_unit_id !== $this->aBusinessUnit->getId()) {
			$this->aBusinessUnit = null;
		}
		if ($this->aClient !== null && $this->client_id !== $this->aClient->getId()) {
			$this->aClient = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(JobOrderPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = JobOrderPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aBusinessUnit = null;
			$this->aClient = null;
			$this->collJobOrderManagers = null;
			$this->lastJobOrderManagerCriteria = null;

			$this->collIncomePayments = null;
			$this->lastIncomePaymentCriteria = null;

			$this->collJobs = null;
			$this->lastJobCriteria = null;

			$this->collTenders = null;
			$this->lastTenderCriteria = null;

			$this->collPlans = null;
			$this->lastPlanCriteria = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(JobOrderPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseJobOrder:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				JobOrderPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseJobOrder:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(JobOrderPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseJobOrder:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseJobOrder:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				JobOrderPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aBusinessUnit !== null) {
				if ($this->aBusinessUnit->isModified() || $this->aBusinessUnit->isNew()) {
					$affectedRows += $this->aBusinessUnit->save($con);
				}
				$this->setBusinessUnit($this->aBusinessUnit);
			}

			if ($this->aClient !== null) {
				if ($this->aClient->isModified() || $this->aClient->isNew()) {
					$affectedRows += $this->aClient->save($con);
				}
				$this->setClient($this->aClient);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = JobOrderPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = JobOrderPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += JobOrderPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collJobOrderManagers !== null) {
				foreach ($this->collJobOrderManagers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collIncomePayments !== null) {
				foreach ($this->collIncomePayments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collJobs !== null) {
				foreach ($this->collJobs as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTenders !== null) {
				foreach ($this->collTenders as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPlans !== null) {
				foreach ($this->collPlans as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aBusinessUnit !== null) {
				if (!$this->aBusinessUnit->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aBusinessUnit->getValidationFailures());
				}
			}

			if ($this->aClient !== null) {
				if (!$this->aClient->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aClient->getValidationFailures());
				}
			}


			if (($retval = JobOrderPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collJobOrderManagers !== null) {
					foreach ($this->collJobOrderManagers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collIncomePayments !== null) {
					foreach ($this->collIncomePayments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collJobs !== null) {
					foreach ($this->collJobs as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTenders !== null) {
					foreach ($this->collTenders as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPlans !== null) {
					foreach ($this->collPlans as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = JobOrderPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getBusinessUnitId();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getClientId();
				break;
			case 4:
				return $this->getIndulgence();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = JobOrderPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getBusinessUnitId(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getClientId(),
			$keys[4] => $this->getIndulgence(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = JobOrderPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setBusinessUnitId($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setClientId($value);
				break;
			case 4:
				$this->setIndulgence($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = JobOrderPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setBusinessUnitId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setClientId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setIndulgence($arr[$keys[4]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);

		if ($this->isColumnModified(JobOrderPeer::ID)) $criteria->add(JobOrderPeer::ID, $this->id);
		if ($this->isColumnModified(JobOrderPeer::BUSINESS_UNIT_ID)) $criteria->add(JobOrderPeer::BUSINESS_UNIT_ID, $this->business_unit_id);
		if ($this->isColumnModified(JobOrderPeer::NAME)) $criteria->add(JobOrderPeer::NAME, $this->name);
		if ($this->isColumnModified(JobOrderPeer::CLIENT_ID)) $criteria->add(JobOrderPeer::CLIENT_ID, $this->client_id);
		if ($this->isColumnModified(JobOrderPeer::INDULGENCE)) $criteria->add(JobOrderPeer::INDULGENCE, $this->indulgence);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);

		$criteria->add(JobOrderPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of JobOrder (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setBusinessUnitId($this->business_unit_id);

		$copyObj->setName($this->name);

		$copyObj->setClientId($this->client_id);

		$copyObj->setIndulgence($this->indulgence);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getJobOrderManagers() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addJobOrderManager($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getIncomePayments() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addIncomePayment($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getJobs() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addJob($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getTenders() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addTender($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPlans() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPlan($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     JobOrder Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     JobOrderPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new JobOrderPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a BusinessUnit object.
	 *
	 * @param      BusinessUnit $v
	 * @return     JobOrder The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setBusinessUnit(BusinessUnit $v = null)
	{
		if ($v === null) {
			$this->setBusinessUnitId(NULL);
		} else {
			$this->setBusinessUnitId($v->getId());
		}

		$this->aBusinessUnit = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the BusinessUnit object, it will not be re-added.
		if ($v !== null) {
			$v->addJobOrder($this);
		}

		return $this;
	}


	/**
	 * Get the associated BusinessUnit object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     BusinessUnit The associated BusinessUnit object.
	 * @throws     PropelException
	 */
	public function getBusinessUnit(PropelPDO $con = null)
	{
		if ($this->aBusinessUnit === null && ($this->business_unit_id !== null)) {
			$this->aBusinessUnit = BusinessUnitPeer::retrieveByPk($this->business_unit_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aBusinessUnit->addJobOrders($this);
			 */
		}
		return $this->aBusinessUnit;
	}

	/**
	 * Declares an association between this object and a Client object.
	 *
	 * @param      Client $v
	 * @return     JobOrder The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setClient(Client $v = null)
	{
		if ($v === null) {
			$this->setClientId(NULL);
		} else {
			$this->setClientId($v->getId());
		}

		$this->aClient = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Client object, it will not be re-added.
		if ($v !== null) {
			$v->addJobOrder($this);
		}

		return $this;
	}


	/**
	 * Get the associated Client object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Client The associated Client object.
	 * @throws     PropelException
	 */
	public function getClient(PropelPDO $con = null)
	{
		if ($this->aClient === null && ($this->client_id !== null)) {
			$this->aClient = ClientPeer::retrieveByPk($this->client_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aClient->addJobOrders($this);
			 */
		}
		return $this->aClient;
	}

	/**
	 * Clears out the collJobOrderManagers collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addJobOrderManagers()
	 */
	public function clearJobOrderManagers()
	{
		$this->collJobOrderManagers = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collJobOrderManagers collection (array).
	 *
	 * By default this just sets the collJobOrderManagers collection to an empty array (like clearcollJobOrderManagers());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initJobOrderManagers()
	{
		$this->collJobOrderManagers = array();
	}

	/**
	 * Gets an array of JobOrderManager objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this JobOrder has previously been saved, it will retrieve
	 * related JobOrderManagers from storage. If this JobOrder is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array JobOrderManager[]
	 * @throws     PropelException
	 */
	public function getJobOrderManagers($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collJobOrderManagers === null) {
			if ($this->isNew()) {
			   $this->collJobOrderManagers = array();
			} else {

				$criteria->add(JobOrderManagerPeer::JOB_ORDER_ID, $this->id);

				JobOrderManagerPeer::addSelectColumns($criteria);
				$this->collJobOrderManagers = JobOrderManagerPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(JobOrderManagerPeer::JOB_ORDER_ID, $this->id);

				JobOrderManagerPeer::addSelectColumns($criteria);
				if (!isset($this->lastJobOrderManagerCriteria) || !$this->lastJobOrderManagerCriteria->equals($criteria)) {
					$this->collJobOrderManagers = JobOrderManagerPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastJobOrderManagerCriteria = $criteria;
		return $this->collJobOrderManagers;
	}

	/**
	 * Returns the number of related JobOrderManager objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related JobOrderManager objects.
	 * @throws     PropelException
	 */
	public function countJobOrderManagers(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collJobOrderManagers === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(JobOrderManagerPeer::JOB_ORDER_ID, $this->id);

				$count = JobOrderManagerPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(JobOrderManagerPeer::JOB_ORDER_ID, $this->id);

				if (!isset($this->lastJobOrderManagerCriteria) || !$this->lastJobOrderManagerCriteria->equals($criteria)) {
					$count = JobOrderManagerPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collJobOrderManagers);
				}
			} else {
				$count = count($this->collJobOrderManagers);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a JobOrderManager object to this object
	 * through the JobOrderManager foreign key attribute.
	 *
	 * @param      JobOrderManager $l JobOrderManager
	 * @return     void
	 * @throws     PropelException
	 */
	public function addJobOrderManager(JobOrderManager $l)
	{
		if ($this->collJobOrderManagers === null) {
			$this->initJobOrderManagers();
		}
		if (!in_array($l, $this->collJobOrderManagers, true)) { // only add it if the **same** object is not already associated
			array_push($this->collJobOrderManagers, $l);
			$l->setJobOrder($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this JobOrder is new, it will return
	 * an empty collection; or if this JobOrder has previously
	 * been saved, it will retrieve related JobOrderManagers from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in JobOrder.
	 */
	public function getJobOrderManagersJoinsfGuardUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collJobOrderManagers === null) {
			if ($this->isNew()) {
				$this->collJobOrderManagers = array();
			} else {

				$criteria->add(JobOrderManagerPeer::JOB_ORDER_ID, $this->id);

				$this->collJobOrderManagers = JobOrderManagerPeer::doSelectJoinsfGuardUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(JobOrderManagerPeer::JOB_ORDER_ID, $this->id);

			if (!isset($this->lastJobOrderManagerCriteria) || !$this->lastJobOrderManagerCriteria->equals($criteria)) {
				$this->collJobOrderManagers = JobOrderManagerPeer::doSelectJoinsfGuardUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastJobOrderManagerCriteria = $criteria;

		return $this->collJobOrderManagers;
	}

	/**
	 * Clears out the collIncomePayments collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addIncomePayments()
	 */
	public function clearIncomePayments()
	{
		$this->collIncomePayments = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collIncomePayments collection (array).
	 *
	 * By default this just sets the collIncomePayments collection to an empty array (like clearcollIncomePayments());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initIncomePayments()
	{
		$this->collIncomePayments = array();
	}

	/**
	 * Gets an array of IncomePayment objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this JobOrder has previously been saved, it will retrieve
	 * related IncomePayments from storage. If this JobOrder is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array IncomePayment[]
	 * @throws     PropelException
	 */
	public function getIncomePayments($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collIncomePayments === null) {
			if ($this->isNew()) {
			   $this->collIncomePayments = array();
			} else {

				$criteria->add(IncomePaymentPeer::JOB_ORDER_ID, $this->id);

				IncomePaymentPeer::addSelectColumns($criteria);
				$this->collIncomePayments = IncomePaymentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(IncomePaymentPeer::JOB_ORDER_ID, $this->id);

				IncomePaymentPeer::addSelectColumns($criteria);
				if (!isset($this->lastIncomePaymentCriteria) || !$this->lastIncomePaymentCriteria->equals($criteria)) {
					$this->collIncomePayments = IncomePaymentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastIncomePaymentCriteria = $criteria;
		return $this->collIncomePayments;
	}

	/**
	 * Returns the number of related IncomePayment objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related IncomePayment objects.
	 * @throws     PropelException
	 */
	public function countIncomePayments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collIncomePayments === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(IncomePaymentPeer::JOB_ORDER_ID, $this->id);

				$count = IncomePaymentPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(IncomePaymentPeer::JOB_ORDER_ID, $this->id);

				if (!isset($this->lastIncomePaymentCriteria) || !$this->lastIncomePaymentCriteria->equals($criteria)) {
					$count = IncomePaymentPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collIncomePayments);
				}
			} else {
				$count = count($this->collIncomePayments);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a IncomePayment object to this object
	 * through the IncomePayment foreign key attribute.
	 *
	 * @param      IncomePayment $l IncomePayment
	 * @return     void
	 * @throws     PropelException
	 */
	public function addIncomePayment(IncomePayment $l)
	{
		if ($this->collIncomePayments === null) {
			$this->initIncomePayments();
		}
		if (!in_array($l, $this->collIncomePayments, true)) { // only add it if the **same** object is not already associated
			array_push($this->collIncomePayments, $l);
			$l->setJobOrder($this);
		}
	}

	/**
	 * Clears out the collJobs collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addJobs()
	 */
	public function clearJobs()
	{
		$this->collJobs = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collJobs collection (array).
	 *
	 * By default this just sets the collJobs collection to an empty array (like clearcollJobs());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initJobs()
	{
		$this->collJobs = array();
	}

	/**
	 * Gets an array of Job objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this JobOrder has previously been saved, it will retrieve
	 * related Jobs from storage. If this JobOrder is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Job[]
	 * @throws     PropelException
	 */
	public function getJobs($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collJobs === null) {
			if ($this->isNew()) {
			   $this->collJobs = array();
			} else {

				$criteria->add(JobPeer::JOB_ORDER_ID, $this->id);

				JobPeer::addSelectColumns($criteria);
				$this->collJobs = JobPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(JobPeer::JOB_ORDER_ID, $this->id);

				JobPeer::addSelectColumns($criteria);
				if (!isset($this->lastJobCriteria) || !$this->lastJobCriteria->equals($criteria)) {
					$this->collJobs = JobPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastJobCriteria = $criteria;
		return $this->collJobs;
	}

	/**
	 * Returns the number of related Job objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Job objects.
	 * @throws     PropelException
	 */
	public function countJobs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collJobs === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(JobPeer::JOB_ORDER_ID, $this->id);

				$count = JobPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(JobPeer::JOB_ORDER_ID, $this->id);

				if (!isset($this->lastJobCriteria) || !$this->lastJobCriteria->equals($criteria)) {
					$count = JobPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collJobs);
				}
			} else {
				$count = count($this->collJobs);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Job object to this object
	 * through the Job foreign key attribute.
	 *
	 * @param      Job $l Job
	 * @return     void
	 * @throws     PropelException
	 */
	public function addJob(Job $l)
	{
		if ($this->collJobs === null) {
			$this->initJobs();
		}
		if (!in_array($l, $this->collJobs, true)) { // only add it if the **same** object is not already associated
			array_push($this->collJobs, $l);
			$l->setJobOrder($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this JobOrder is new, it will return
	 * an empty collection; or if this JobOrder has previously
	 * been saved, it will retrieve related Jobs from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in JobOrder.
	 */
	public function getJobsJoinJobType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collJobs === null) {
			if ($this->isNew()) {
				$this->collJobs = array();
			} else {

				$criteria->add(JobPeer::JOB_ORDER_ID, $this->id);

				$this->collJobs = JobPeer::doSelectJoinJobType($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(JobPeer::JOB_ORDER_ID, $this->id);

			if (!isset($this->lastJobCriteria) || !$this->lastJobCriteria->equals($criteria)) {
				$this->collJobs = JobPeer::doSelectJoinJobType($criteria, $con, $join_behavior);
			}
		}
		$this->lastJobCriteria = $criteria;

		return $this->collJobs;
	}

	/**
	 * Clears out the collTenders collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addTenders()
	 */
	public function clearTenders()
	{
		$this->collTenders = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collTenders collection (array).
	 *
	 * By default this just sets the collTenders collection to an empty array (like clearcollTenders());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initTenders()
	{
		$this->collTenders = array();
	}

	/**
	 * Gets an array of Tender objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this JobOrder has previously been saved, it will retrieve
	 * related Tenders from storage. If this JobOrder is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Tender[]
	 * @throws     PropelException
	 */
	public function getTenders($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTenders === null) {
			if ($this->isNew()) {
			   $this->collTenders = array();
			} else {

				$criteria->add(TenderPeer::JOB_ORDER_ID, $this->id);

				TenderPeer::addSelectColumns($criteria);
				$this->collTenders = TenderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TenderPeer::JOB_ORDER_ID, $this->id);

				TenderPeer::addSelectColumns($criteria);
				if (!isset($this->lastTenderCriteria) || !$this->lastTenderCriteria->equals($criteria)) {
					$this->collTenders = TenderPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTenderCriteria = $criteria;
		return $this->collTenders;
	}

	/**
	 * Returns the number of related Tender objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Tender objects.
	 * @throws     PropelException
	 */
	public function countTenders(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collTenders === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(TenderPeer::JOB_ORDER_ID, $this->id);

				$count = TenderPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(TenderPeer::JOB_ORDER_ID, $this->id);

				if (!isset($this->lastTenderCriteria) || !$this->lastTenderCriteria->equals($criteria)) {
					$count = TenderPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collTenders);
				}
			} else {
				$count = count($this->collTenders);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Tender object to this object
	 * through the Tender foreign key attribute.
	 *
	 * @param      Tender $l Tender
	 * @return     void
	 * @throws     PropelException
	 */
	public function addTender(Tender $l)
	{
		if ($this->collTenders === null) {
			$this->initTenders();
		}
		if (!in_array($l, $this->collTenders, true)) { // only add it if the **same** object is not already associated
			array_push($this->collTenders, $l);
			$l->setJobOrder($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this JobOrder is new, it will return
	 * an empty collection; or if this JobOrder has previously
	 * been saved, it will retrieve related Tenders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in JobOrder.
	 */
	public function getTendersJoinBusinessUnit($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTenders === null) {
			if ($this->isNew()) {
				$this->collTenders = array();
			} else {

				$criteria->add(TenderPeer::JOB_ORDER_ID, $this->id);

				$this->collTenders = TenderPeer::doSelectJoinBusinessUnit($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(TenderPeer::JOB_ORDER_ID, $this->id);

			if (!isset($this->lastTenderCriteria) || !$this->lastTenderCriteria->equals($criteria)) {
				$this->collTenders = TenderPeer::doSelectJoinBusinessUnit($criteria, $con, $join_behavior);
			}
		}
		$this->lastTenderCriteria = $criteria;

		return $this->collTenders;
	}

	/**
	 * Clears out the collPlans collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPlans()
	 */
	public function clearPlans()
	{
		$this->collPlans = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPlans collection (array).
	 *
	 * By default this just sets the collPlans collection to an empty array (like clearcollPlans());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPlans()
	{
		$this->collPlans = array();
	}

	/**
	 * Gets an array of Plan objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this JobOrder has previously been saved, it will retrieve
	 * related Plans from storage. If this JobOrder is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array Plan[]
	 * @throws     PropelException
	 */
	public function getPlans($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPlans === null) {
			if ($this->isNew()) {
			   $this->collPlans = array();
			} else {

				$criteria->add(PlanPeer::JOB_ORDER_ID, $this->id);

				PlanPeer::addSelectColumns($criteria);
				$this->collPlans = PlanPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PlanPeer::JOB_ORDER_ID, $this->id);

				PlanPeer::addSelectColumns($criteria);
				if (!isset($this->lastPlanCriteria) || !$this->lastPlanCriteria->equals($criteria)) {
					$this->collPlans = PlanPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPlanCriteria = $criteria;
		return $this->collPlans;
	}

	/**
	 * Returns the number of related Plan objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Plan objects.
	 * @throws     PropelException
	 */
	public function countPlans(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPlans === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PlanPeer::JOB_ORDER_ID, $this->id);

				$count = PlanPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PlanPeer::JOB_ORDER_ID, $this->id);

				if (!isset($this->lastPlanCriteria) || !$this->lastPlanCriteria->equals($criteria)) {
					$count = PlanPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collPlans);
				}
			} else {
				$count = count($this->collPlans);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a Plan object to this object
	 * through the Plan foreign key attribute.
	 *
	 * @param      Plan $l Plan
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPlan(Plan $l)
	{
		if ($this->collPlans === null) {
			$this->initPlans();
		}
		if (!in_array($l, $this->collPlans, true)) { // only add it if the **same** object is not already associated
			array_push($this->collPlans, $l);
			$l->setJobOrder($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this JobOrder is new, it will return
	 * an empty collection; or if this JobOrder has previously
	 * been saved, it will retrieve related Plans from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in JobOrder.
	 */
	public function getPlansJoinBusinessUnit($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(JobOrderPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPlans === null) {
			if ($this->isNew()) {
				$this->collPlans = array();
			} else {

				$criteria->add(PlanPeer::JOB_ORDER_ID, $this->id);

				$this->collPlans = PlanPeer::doSelectJoinBusinessUnit($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PlanPeer::JOB_ORDER_ID, $this->id);

			if (!isset($this->lastPlanCriteria) || !$this->lastPlanCriteria->equals($criteria)) {
				$this->collPlans = PlanPeer::doSelectJoinBusinessUnit($criteria, $con, $join_behavior);
			}
		}
		$this->lastPlanCriteria = $criteria;

		return $this->collPlans;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collJobOrderManagers) {
				foreach ((array) $this->collJobOrderManagers as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collIncomePayments) {
				foreach ((array) $this->collIncomePayments as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collJobs) {
				foreach ((array) $this->collJobs as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collTenders) {
				foreach ((array) $this->collTenders as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPlans) {
				foreach ((array) $this->collPlans as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collJobOrderManagers = null;
		$this->collIncomePayments = null;
		$this->collJobs = null;
		$this->collTenders = null;
		$this->collPlans = null;
			$this->aBusinessUnit = null;
			$this->aClient = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseJobOrder:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseJobOrder::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseJobOrder
