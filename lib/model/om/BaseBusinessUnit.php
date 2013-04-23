<?php

/**
 * Base class that represents a row from the 'business_unit' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseBusinessUnit extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        BusinessUnitPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the plan field.
	 * @var        string
	 */
	protected $plan;

	/**
	 * The value for the loans field.
	 * Note: this column has a database default value of: '0'
	 * @var        string
	 */
	protected $loans;

	/**
	 * @var        array UserBusinessUnit[] Collection to store aggregation of UserBusinessUnit objects.
	 */
	protected $collUserBusinessUnits;

	/**
	 * @var        Criteria The criteria used to select the current contents of collUserBusinessUnits.
	 */
	private $lastUserBusinessUnitCriteria = null;

	/**
	 * @var        array JobOrder[] Collection to store aggregation of JobOrder objects.
	 */
	protected $collJobOrders;

	/**
	 * @var        Criteria The criteria used to select the current contents of collJobOrders.
	 */
	private $lastJobOrderCriteria = null;

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
	 * @var        array CurrentExpenses[] Collection to store aggregation of CurrentExpenses objects.
	 */
	protected $collCurrentExpensess;

	/**
	 * @var        Criteria The criteria used to select the current contents of collCurrentExpensess.
	 */
	private $lastCurrentExpensesCriteria = null;

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
	
	const PEER = 'BusinessUnitPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->loans = '0';
	}

	/**
	 * Initializes internal state of BaseBusinessUnit object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

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
	 * Get the [name] column value.
	 * 
	 * @return     string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the [plan] column value.
	 * 
	 * @return     string
	 */
	public function getPlan()
	{
		return $this->plan;
	}

	/**
	 * Get the [loans] column value.
	 * 
	 * @return     string
	 */
	public function getLoans()
	{
		return $this->loans;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     BusinessUnit The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = BusinessUnitPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     BusinessUnit The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = BusinessUnitPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [plan] column.
	 * 
	 * @param      string $v new value
	 * @return     BusinessUnit The current object (for fluent API support)
	 */
	public function setPlan($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->plan !== $v) {
			$this->plan = $v;
			$this->modifiedColumns[] = BusinessUnitPeer::PLAN;
		}

		return $this;
	} // setPlan()

	/**
	 * Set the value of [loans] column.
	 * 
	 * @param      string $v new value
	 * @return     BusinessUnit The current object (for fluent API support)
	 */
	public function setLoans($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->loans !== $v || $this->isNew()) {
			$this->loans = $v;
			$this->modifiedColumns[] = BusinessUnitPeer::LOANS;
		}

		return $this;
	} // setLoans()

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
			if ($this->loans !== '0') {
				return false;
			}

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
			$this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->plan = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->loans = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 4; // 4 = BusinessUnitPeer::NUM_COLUMNS - BusinessUnitPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating BusinessUnit object", $e);
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
			$con = Propel::getConnection(BusinessUnitPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = BusinessUnitPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collUserBusinessUnits = null;
			$this->lastUserBusinessUnitCriteria = null;

			$this->collJobOrders = null;
			$this->lastJobOrderCriteria = null;

			$this->collTenders = null;
			$this->lastTenderCriteria = null;

			$this->collPlans = null;
			$this->lastPlanCriteria = null;

			$this->collCurrentExpensess = null;
			$this->lastCurrentExpensesCriteria = null;

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
			$con = Propel::getConnection(BusinessUnitPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseBusinessUnit:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				BusinessUnitPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseBusinessUnit:delete:post') as $callable)
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
			$con = Propel::getConnection(BusinessUnitPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseBusinessUnit:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseBusinessUnit:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				BusinessUnitPeer::addInstanceToPool($this);
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

			if ($this->isNew() ) {
				$this->modifiedColumns[] = BusinessUnitPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = BusinessUnitPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += BusinessUnitPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collUserBusinessUnits !== null) {
				foreach ($this->collUserBusinessUnits as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collJobOrders !== null) {
				foreach ($this->collJobOrders as $referrerFK) {
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

			if ($this->collCurrentExpensess !== null) {
				foreach ($this->collCurrentExpensess as $referrerFK) {
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


			if (($retval = BusinessUnitPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collUserBusinessUnits !== null) {
					foreach ($this->collUserBusinessUnits as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collJobOrders !== null) {
					foreach ($this->collJobOrders as $referrerFK) {
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

				if ($this->collCurrentExpensess !== null) {
					foreach ($this->collCurrentExpensess as $referrerFK) {
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
		$pos = BusinessUnitPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getName();
				break;
			case 2:
				return $this->getPlan();
				break;
			case 3:
				return $this->getLoans();
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
		$keys = BusinessUnitPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getPlan(),
			$keys[3] => $this->getLoans(),
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
		$pos = BusinessUnitPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setName($value);
				break;
			case 2:
				$this->setPlan($value);
				break;
			case 3:
				$this->setLoans($value);
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
		$keys = BusinessUnitPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPlan($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setLoans($arr[$keys[3]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);

		if ($this->isColumnModified(BusinessUnitPeer::ID)) $criteria->add(BusinessUnitPeer::ID, $this->id);
		if ($this->isColumnModified(BusinessUnitPeer::NAME)) $criteria->add(BusinessUnitPeer::NAME, $this->name);
		if ($this->isColumnModified(BusinessUnitPeer::PLAN)) $criteria->add(BusinessUnitPeer::PLAN, $this->plan);
		if ($this->isColumnModified(BusinessUnitPeer::LOANS)) $criteria->add(BusinessUnitPeer::LOANS, $this->loans);

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
		$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);

		$criteria->add(BusinessUnitPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of BusinessUnit (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setPlan($this->plan);

		$copyObj->setLoans($this->loans);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getUserBusinessUnits() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserBusinessUnit($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getJobOrders() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addJobOrder($relObj->copy($deepCopy));
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

			foreach ($this->getCurrentExpensess() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addCurrentExpenses($relObj->copy($deepCopy));
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
	 * @return     BusinessUnit Clone of current object.
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
	 * @return     BusinessUnitPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new BusinessUnitPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collUserBusinessUnits collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserBusinessUnits()
	 */
	public function clearUserBusinessUnits()
	{
		$this->collUserBusinessUnits = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserBusinessUnits collection (array).
	 *
	 * By default this just sets the collUserBusinessUnits collection to an empty array (like clearcollUserBusinessUnits());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initUserBusinessUnits()
	{
		$this->collUserBusinessUnits = array();
	}

	/**
	 * Gets an array of UserBusinessUnit objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this BusinessUnit has previously been saved, it will retrieve
	 * related UserBusinessUnits from storage. If this BusinessUnit is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array UserBusinessUnit[]
	 * @throws     PropelException
	 */
	public function getUserBusinessUnits($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserBusinessUnits === null) {
			if ($this->isNew()) {
			   $this->collUserBusinessUnits = array();
			} else {

				$criteria->add(UserBusinessUnitPeer::BUSINESS_UNIT_ID, $this->id);

				UserBusinessUnitPeer::addSelectColumns($criteria);
				$this->collUserBusinessUnits = UserBusinessUnitPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserBusinessUnitPeer::BUSINESS_UNIT_ID, $this->id);

				UserBusinessUnitPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserBusinessUnitCriteria) || !$this->lastUserBusinessUnitCriteria->equals($criteria)) {
					$this->collUserBusinessUnits = UserBusinessUnitPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserBusinessUnitCriteria = $criteria;
		return $this->collUserBusinessUnits;
	}

	/**
	 * Returns the number of related UserBusinessUnit objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserBusinessUnit objects.
	 * @throws     PropelException
	 */
	public function countUserBusinessUnits(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collUserBusinessUnits === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(UserBusinessUnitPeer::BUSINESS_UNIT_ID, $this->id);

				$count = UserBusinessUnitPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(UserBusinessUnitPeer::BUSINESS_UNIT_ID, $this->id);

				if (!isset($this->lastUserBusinessUnitCriteria) || !$this->lastUserBusinessUnitCriteria->equals($criteria)) {
					$count = UserBusinessUnitPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collUserBusinessUnits);
				}
			} else {
				$count = count($this->collUserBusinessUnits);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a UserBusinessUnit object to this object
	 * through the UserBusinessUnit foreign key attribute.
	 *
	 * @param      UserBusinessUnit $l UserBusinessUnit
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserBusinessUnit(UserBusinessUnit $l)
	{
		if ($this->collUserBusinessUnits === null) {
			$this->initUserBusinessUnits();
		}
		if (!in_array($l, $this->collUserBusinessUnits, true)) { // only add it if the **same** object is not already associated
			array_push($this->collUserBusinessUnits, $l);
			$l->setBusinessUnit($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BusinessUnit is new, it will return
	 * an empty collection; or if this BusinessUnit has previously
	 * been saved, it will retrieve related UserBusinessUnits from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BusinessUnit.
	 */
	public function getUserBusinessUnitsJoinsfGuardUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserBusinessUnits === null) {
			if ($this->isNew()) {
				$this->collUserBusinessUnits = array();
			} else {

				$criteria->add(UserBusinessUnitPeer::BUSINESS_UNIT_ID, $this->id);

				$this->collUserBusinessUnits = UserBusinessUnitPeer::doSelectJoinsfGuardUser($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserBusinessUnitPeer::BUSINESS_UNIT_ID, $this->id);

			if (!isset($this->lastUserBusinessUnitCriteria) || !$this->lastUserBusinessUnitCriteria->equals($criteria)) {
				$this->collUserBusinessUnits = UserBusinessUnitPeer::doSelectJoinsfGuardUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastUserBusinessUnitCriteria = $criteria;

		return $this->collUserBusinessUnits;
	}

	/**
	 * Clears out the collJobOrders collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addJobOrders()
	 */
	public function clearJobOrders()
	{
		$this->collJobOrders = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collJobOrders collection (array).
	 *
	 * By default this just sets the collJobOrders collection to an empty array (like clearcollJobOrders());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initJobOrders()
	{
		$this->collJobOrders = array();
	}

	/**
	 * Gets an array of JobOrder objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this BusinessUnit has previously been saved, it will retrieve
	 * related JobOrders from storage. If this BusinessUnit is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array JobOrder[]
	 * @throws     PropelException
	 */
	public function getJobOrders($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collJobOrders === null) {
			if ($this->isNew()) {
			   $this->collJobOrders = array();
			} else {

				$criteria->add(JobOrderPeer::BUSINESS_UNIT_ID, $this->id);

				JobOrderPeer::addSelectColumns($criteria);
				$this->collJobOrders = JobOrderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(JobOrderPeer::BUSINESS_UNIT_ID, $this->id);

				JobOrderPeer::addSelectColumns($criteria);
				if (!isset($this->lastJobOrderCriteria) || !$this->lastJobOrderCriteria->equals($criteria)) {
					$this->collJobOrders = JobOrderPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastJobOrderCriteria = $criteria;
		return $this->collJobOrders;
	}

	/**
	 * Returns the number of related JobOrder objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related JobOrder objects.
	 * @throws     PropelException
	 */
	public function countJobOrders(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collJobOrders === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(JobOrderPeer::BUSINESS_UNIT_ID, $this->id);

				$count = JobOrderPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(JobOrderPeer::BUSINESS_UNIT_ID, $this->id);

				if (!isset($this->lastJobOrderCriteria) || !$this->lastJobOrderCriteria->equals($criteria)) {
					$count = JobOrderPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collJobOrders);
				}
			} else {
				$count = count($this->collJobOrders);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a JobOrder object to this object
	 * through the JobOrder foreign key attribute.
	 *
	 * @param      JobOrder $l JobOrder
	 * @return     void
	 * @throws     PropelException
	 */
	public function addJobOrder(JobOrder $l)
	{
		if ($this->collJobOrders === null) {
			$this->initJobOrders();
		}
		if (!in_array($l, $this->collJobOrders, true)) { // only add it if the **same** object is not already associated
			array_push($this->collJobOrders, $l);
			$l->setBusinessUnit($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BusinessUnit is new, it will return
	 * an empty collection; or if this BusinessUnit has previously
	 * been saved, it will retrieve related JobOrders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BusinessUnit.
	 */
	public function getJobOrdersJoinClient($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collJobOrders === null) {
			if ($this->isNew()) {
				$this->collJobOrders = array();
			} else {

				$criteria->add(JobOrderPeer::BUSINESS_UNIT_ID, $this->id);

				$this->collJobOrders = JobOrderPeer::doSelectJoinClient($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(JobOrderPeer::BUSINESS_UNIT_ID, $this->id);

			if (!isset($this->lastJobOrderCriteria) || !$this->lastJobOrderCriteria->equals($criteria)) {
				$this->collJobOrders = JobOrderPeer::doSelectJoinClient($criteria, $con, $join_behavior);
			}
		}
		$this->lastJobOrderCriteria = $criteria;

		return $this->collJobOrders;
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
	 * Otherwise if this BusinessUnit has previously been saved, it will retrieve
	 * related Tenders from storage. If this BusinessUnit is new, it will return
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
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTenders === null) {
			if ($this->isNew()) {
			   $this->collTenders = array();
			} else {

				$criteria->add(TenderPeer::BUSINESS_UNIT_ID, $this->id);

				TenderPeer::addSelectColumns($criteria);
				$this->collTenders = TenderPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TenderPeer::BUSINESS_UNIT_ID, $this->id);

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
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
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

				$criteria->add(TenderPeer::BUSINESS_UNIT_ID, $this->id);

				$count = TenderPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(TenderPeer::BUSINESS_UNIT_ID, $this->id);

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
			$l->setBusinessUnit($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BusinessUnit is new, it will return
	 * an empty collection; or if this BusinessUnit has previously
	 * been saved, it will retrieve related Tenders from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BusinessUnit.
	 */
	public function getTendersJoinJobOrder($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTenders === null) {
			if ($this->isNew()) {
				$this->collTenders = array();
			} else {

				$criteria->add(TenderPeer::BUSINESS_UNIT_ID, $this->id);

				$this->collTenders = TenderPeer::doSelectJoinJobOrder($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(TenderPeer::BUSINESS_UNIT_ID, $this->id);

			if (!isset($this->lastTenderCriteria) || !$this->lastTenderCriteria->equals($criteria)) {
				$this->collTenders = TenderPeer::doSelectJoinJobOrder($criteria, $con, $join_behavior);
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
	 * Otherwise if this BusinessUnit has previously been saved, it will retrieve
	 * related Plans from storage. If this BusinessUnit is new, it will return
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
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPlans === null) {
			if ($this->isNew()) {
			   $this->collPlans = array();
			} else {

				$criteria->add(PlanPeer::BUSINESS_UNIT_ID, $this->id);

				PlanPeer::addSelectColumns($criteria);
				$this->collPlans = PlanPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PlanPeer::BUSINESS_UNIT_ID, $this->id);

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
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
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

				$criteria->add(PlanPeer::BUSINESS_UNIT_ID, $this->id);

				$count = PlanPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(PlanPeer::BUSINESS_UNIT_ID, $this->id);

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
			$l->setBusinessUnit($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BusinessUnit is new, it will return
	 * an empty collection; or if this BusinessUnit has previously
	 * been saved, it will retrieve related Plans from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BusinessUnit.
	 */
	public function getPlansJoinJobOrder($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPlans === null) {
			if ($this->isNew()) {
				$this->collPlans = array();
			} else {

				$criteria->add(PlanPeer::BUSINESS_UNIT_ID, $this->id);

				$this->collPlans = PlanPeer::doSelectJoinJobOrder($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PlanPeer::BUSINESS_UNIT_ID, $this->id);

			if (!isset($this->lastPlanCriteria) || !$this->lastPlanCriteria->equals($criteria)) {
				$this->collPlans = PlanPeer::doSelectJoinJobOrder($criteria, $con, $join_behavior);
			}
		}
		$this->lastPlanCriteria = $criteria;

		return $this->collPlans;
	}

	/**
	 * Clears out the collCurrentExpensess collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addCurrentExpensess()
	 */
	public function clearCurrentExpensess()
	{
		$this->collCurrentExpensess = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collCurrentExpensess collection (array).
	 *
	 * By default this just sets the collCurrentExpensess collection to an empty array (like clearcollCurrentExpensess());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initCurrentExpensess()
	{
		$this->collCurrentExpensess = array();
	}

	/**
	 * Gets an array of CurrentExpenses objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this BusinessUnit has previously been saved, it will retrieve
	 * related CurrentExpensess from storage. If this BusinessUnit is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array CurrentExpenses[]
	 * @throws     PropelException
	 */
	public function getCurrentExpensess($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCurrentExpensess === null) {
			if ($this->isNew()) {
			   $this->collCurrentExpensess = array();
			} else {

				$criteria->add(CurrentExpensesPeer::BUSINESS_UNIT_ID, $this->id);

				CurrentExpensesPeer::addSelectColumns($criteria);
				$this->collCurrentExpensess = CurrentExpensesPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(CurrentExpensesPeer::BUSINESS_UNIT_ID, $this->id);

				CurrentExpensesPeer::addSelectColumns($criteria);
				if (!isset($this->lastCurrentExpensesCriteria) || !$this->lastCurrentExpensesCriteria->equals($criteria)) {
					$this->collCurrentExpensess = CurrentExpensesPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCurrentExpensesCriteria = $criteria;
		return $this->collCurrentExpensess;
	}

	/**
	 * Returns the number of related CurrentExpenses objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related CurrentExpenses objects.
	 * @throws     PropelException
	 */
	public function countCurrentExpensess(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collCurrentExpensess === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(CurrentExpensesPeer::BUSINESS_UNIT_ID, $this->id);

				$count = CurrentExpensesPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(CurrentExpensesPeer::BUSINESS_UNIT_ID, $this->id);

				if (!isset($this->lastCurrentExpensesCriteria) || !$this->lastCurrentExpensesCriteria->equals($criteria)) {
					$count = CurrentExpensesPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collCurrentExpensess);
				}
			} else {
				$count = count($this->collCurrentExpensess);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a CurrentExpenses object to this object
	 * through the CurrentExpenses foreign key attribute.
	 *
	 * @param      CurrentExpenses $l CurrentExpenses
	 * @return     void
	 * @throws     PropelException
	 */
	public function addCurrentExpenses(CurrentExpenses $l)
	{
		if ($this->collCurrentExpensess === null) {
			$this->initCurrentExpensess();
		}
		if (!in_array($l, $this->collCurrentExpensess, true)) { // only add it if the **same** object is not already associated
			array_push($this->collCurrentExpensess, $l);
			$l->setBusinessUnit($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this BusinessUnit is new, it will return
	 * an empty collection; or if this BusinessUnit has previously
	 * been saved, it will retrieve related CurrentExpensess from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in BusinessUnit.
	 */
	public function getCurrentExpensessJoinExpencesType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(BusinessUnitPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCurrentExpensess === null) {
			if ($this->isNew()) {
				$this->collCurrentExpensess = array();
			} else {

				$criteria->add(CurrentExpensesPeer::BUSINESS_UNIT_ID, $this->id);

				$this->collCurrentExpensess = CurrentExpensesPeer::doSelectJoinExpencesType($criteria, $con, $join_behavior);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(CurrentExpensesPeer::BUSINESS_UNIT_ID, $this->id);

			if (!isset($this->lastCurrentExpensesCriteria) || !$this->lastCurrentExpensesCriteria->equals($criteria)) {
				$this->collCurrentExpensess = CurrentExpensesPeer::doSelectJoinExpencesType($criteria, $con, $join_behavior);
			}
		}
		$this->lastCurrentExpensesCriteria = $criteria;

		return $this->collCurrentExpensess;
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
			if ($this->collUserBusinessUnits) {
				foreach ((array) $this->collUserBusinessUnits as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collJobOrders) {
				foreach ((array) $this->collJobOrders as $o) {
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
			if ($this->collCurrentExpensess) {
				foreach ((array) $this->collCurrentExpensess as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collUserBusinessUnits = null;
		$this->collJobOrders = null;
		$this->collTenders = null;
		$this->collPlans = null;
		$this->collCurrentExpensess = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseBusinessUnit:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseBusinessUnit::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseBusinessUnit
