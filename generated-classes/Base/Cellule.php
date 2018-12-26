<?php

namespace Base;

use \Cellule as ChildCellule;
use \CelluleQuery as ChildCelluleQuery;
use \Demande as ChildDemande;
use \DemandeQuery as ChildDemandeQuery;
use \Incident as ChildIncident;
use \IncidentQuery as ChildIncidentQuery;
use \Suivi as ChildSuivi;
use \SuiviQuery as ChildSuiviQuery;
use \Type as ChildType;
use \TypeQuery as ChildTypeQuery;
use \Exception;
use \PDO;
use Map\CelluleTableMap;
use Map\DemandeTableMap;
use Map\IncidentTableMap;
use Map\SuiviTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'cellule' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Cellule implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\CelluleTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the designation field.
     *
     * @var        string
     */
    protected $designation;

    /**
     * The value for the type_c field.
     *
     * @var        string
     */
    protected $type_c;

    /**
     * @var        ChildType
     */
    protected $aType;

    /**
     * @var        ObjectCollection|ChildIncident[] Collection to store aggregation of ChildIncident objects.
     */
    protected $collIncidents;
    protected $collIncidentsPartial;

    /**
     * @var        ObjectCollection|ChildDemande[] Collection to store aggregation of ChildDemande objects.
     */
    protected $collDemandes;
    protected $collDemandesPartial;

    /**
     * @var        ObjectCollection|ChildSuivi[] Collection to store aggregation of ChildSuivi objects.
     */
    protected $collSuivis;
    protected $collSuivisPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIncident[]
     */
    protected $incidentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDemande[]
     */
    protected $demandesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSuivi[]
     */
    protected $suivisScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Cellule object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Cellule</code> instance.  If
     * <code>obj</code> is an instance of <code>Cellule</code>, delegates to
     * <code>equals(Cellule)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Cellule The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [designation] column value.
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Get the [type_c] column value.
     *
     * @return string
     */
    public function getTypeC()
    {
        return $this->type_c;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Cellule The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CelluleTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [designation] column.
     *
     * @param string $v new value
     * @return $this|\Cellule The current object (for fluent API support)
     */
    public function setDesignation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->designation !== $v) {
            $this->designation = $v;
            $this->modifiedColumns[CelluleTableMap::COL_DESIGNATION] = true;
        }

        return $this;
    } // setDesignation()

    /**
     * Set the value of [type_c] column.
     *
     * @param string $v new value
     * @return $this|\Cellule The current object (for fluent API support)
     */
    public function setTypeC($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type_c !== $v) {
            $this->type_c = $v;
            $this->modifiedColumns[CelluleTableMap::COL_TYPE_C] = true;
        }

        if ($this->aType !== null && $this->aType->getId() !== $v) {
            $this->aType = null;
        }

        return $this;
    } // setTypeC()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
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
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CelluleTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CelluleTableMap::translateFieldName('Designation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->designation = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CelluleTableMap::translateFieldName('TypeC', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type_c = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = CelluleTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Cellule'), 0, $e);
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
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aType !== null && $this->type_c !== $this->aType->getId()) {
            $this->aType = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CelluleTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCelluleQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aType = null;
            $this->collIncidents = null;

            $this->collDemandes = null;

            $this->collSuivis = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Cellule::setDeleted()
     * @see Cellule::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CelluleTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCelluleQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CelluleTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
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
                CelluleTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aType !== null) {
                if ($this->aType->isModified() || $this->aType->isNew()) {
                    $affectedRows += $this->aType->save($con);
                }
                $this->setType($this->aType);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->incidentsScheduledForDeletion !== null) {
                if (!$this->incidentsScheduledForDeletion->isEmpty()) {
                    foreach ($this->incidentsScheduledForDeletion as $incident) {
                        // need to save related object because we set the relation to null
                        $incident->save($con);
                    }
                    $this->incidentsScheduledForDeletion = null;
                }
            }

            if ($this->collIncidents !== null) {
                foreach ($this->collIncidents as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->demandesScheduledForDeletion !== null) {
                if (!$this->demandesScheduledForDeletion->isEmpty()) {
                    foreach ($this->demandesScheduledForDeletion as $demande) {
                        // need to save related object because we set the relation to null
                        $demande->save($con);
                    }
                    $this->demandesScheduledForDeletion = null;
                }
            }

            if ($this->collDemandes !== null) {
                foreach ($this->collDemandes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->suivisScheduledForDeletion !== null) {
                if (!$this->suivisScheduledForDeletion->isEmpty()) {
                    foreach ($this->suivisScheduledForDeletion as $suivi) {
                        // need to save related object because we set the relation to null
                        $suivi->save($con);
                    }
                    $this->suivisScheduledForDeletion = null;
                }
            }

            if ($this->collSuivis !== null) {
                foreach ($this->collSuivis as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[CelluleTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CelluleTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CelluleTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(CelluleTableMap::COL_DESIGNATION)) {
            $modifiedColumns[':p' . $index++]  = 'designation';
        }
        if ($this->isColumnModified(CelluleTableMap::COL_TYPE_C)) {
            $modifiedColumns[':p' . $index++]  = 'type_c';
        }

        $sql = sprintf(
            'INSERT INTO cellule (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'designation':
                        $stmt->bindValue($identifier, $this->designation, PDO::PARAM_STR);
                        break;
                    case 'type_c':
                        $stmt->bindValue($identifier, $this->type_c, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CelluleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getDesignation();
                break;
            case 2:
                return $this->getTypeC();
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
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Cellule'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Cellule'][$this->hashCode()] = true;
        $keys = CelluleTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getDesignation(),
            $keys[2] => $this->getTypeC(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aType) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'type';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'type';
                        break;
                    default:
                        $key = 'Type';
                }

                $result[$key] = $this->aType->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collIncidents) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'incidents';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'incidents';
                        break;
                    default:
                        $key = 'Incidents';
                }

                $result[$key] = $this->collIncidents->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDemandes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'demandes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'demandes';
                        break;
                    default:
                        $key = 'Demandes';
                }

                $result[$key] = $this->collDemandes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSuivis) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'suivis';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'suivis';
                        break;
                    default:
                        $key = 'Suivis';
                }

                $result[$key] = $this->collSuivis->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Cellule
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CelluleTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Cellule
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setDesignation($value);
                break;
            case 2:
                $this->setTypeC($value);
                break;
        } // switch()

        return $this;
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
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = CelluleTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDesignation($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTypeC($arr[$keys[2]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Cellule The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CelluleTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CelluleTableMap::COL_ID)) {
            $criteria->add(CelluleTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(CelluleTableMap::COL_DESIGNATION)) {
            $criteria->add(CelluleTableMap::COL_DESIGNATION, $this->designation);
        }
        if ($this->isColumnModified(CelluleTableMap::COL_TYPE_C)) {
            $criteria->add(CelluleTableMap::COL_TYPE_C, $this->type_c);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildCelluleQuery::create();
        $criteria->add(CelluleTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Cellule (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDesignation($this->getDesignation());
        $copyObj->setTypeC($this->getTypeC());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getIncidents() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIncident($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDemandes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDemande($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSuivis() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSuivi($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Cellule Clone of current object.
     * @throws PropelException
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
     * Declares an association between this object and a ChildType object.
     *
     * @param  ChildType $v
     * @return $this|\Cellule The current object (for fluent API support)
     * @throws PropelException
     */
    public function setType(ChildType $v = null)
    {
        if ($v === null) {
            $this->setTypeC(NULL);
        } else {
            $this->setTypeC($v->getId());
        }

        $this->aType = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildType object, it will not be re-added.
        if ($v !== null) {
            $v->addCellule($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildType object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildType The associated ChildType object.
     * @throws PropelException
     */
    public function getType(ConnectionInterface $con = null)
    {
        if ($this->aType === null && (($this->type_c !== "" && $this->type_c !== null))) {
            $this->aType = ChildTypeQuery::create()->findPk($this->type_c, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aType->addCellules($this);
             */
        }

        return $this->aType;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Incident' == $relationName) {
            $this->initIncidents();
            return;
        }
        if ('Demande' == $relationName) {
            $this->initDemandes();
            return;
        }
        if ('Suivi' == $relationName) {
            $this->initSuivis();
            return;
        }
    }

    /**
     * Clears out the collIncidents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIncidents()
     */
    public function clearIncidents()
    {
        $this->collIncidents = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collIncidents collection loaded partially.
     */
    public function resetPartialIncidents($v = true)
    {
        $this->collIncidentsPartial = $v;
    }

    /**
     * Initializes the collIncidents collection.
     *
     * By default this just sets the collIncidents collection to an empty array (like clearcollIncidents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initIncidents($overrideExisting = true)
    {
        if (null !== $this->collIncidents && !$overrideExisting) {
            return;
        }

        $collectionClassName = IncidentTableMap::getTableMap()->getCollectionClassName();

        $this->collIncidents = new $collectionClassName;
        $this->collIncidents->setModel('\Incident');
    }

    /**
     * Gets an array of ChildIncident objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCellule is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildIncident[] List of ChildIncident objects
     * @throws PropelException
     */
    public function getIncidents(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIncidentsPartial && !$this->isNew();
        if (null === $this->collIncidents || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collIncidents) {
                // return empty collection
                $this->initIncidents();
            } else {
                $collIncidents = ChildIncidentQuery::create(null, $criteria)
                    ->filterByCellule($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collIncidentsPartial && count($collIncidents)) {
                        $this->initIncidents(false);

                        foreach ($collIncidents as $obj) {
                            if (false == $this->collIncidents->contains($obj)) {
                                $this->collIncidents->append($obj);
                            }
                        }

                        $this->collIncidentsPartial = true;
                    }

                    return $collIncidents;
                }

                if ($partial && $this->collIncidents) {
                    foreach ($this->collIncidents as $obj) {
                        if ($obj->isNew()) {
                            $collIncidents[] = $obj;
                        }
                    }
                }

                $this->collIncidents = $collIncidents;
                $this->collIncidentsPartial = false;
            }
        }

        return $this->collIncidents;
    }

    /**
     * Sets a collection of ChildIncident objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $incidents A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCellule The current object (for fluent API support)
     */
    public function setIncidents(Collection $incidents, ConnectionInterface $con = null)
    {
        /** @var ChildIncident[] $incidentsToDelete */
        $incidentsToDelete = $this->getIncidents(new Criteria(), $con)->diff($incidents);


        $this->incidentsScheduledForDeletion = $incidentsToDelete;

        foreach ($incidentsToDelete as $incidentRemoved) {
            $incidentRemoved->setCellule(null);
        }

        $this->collIncidents = null;
        foreach ($incidents as $incident) {
            $this->addIncident($incident);
        }

        $this->collIncidents = $incidents;
        $this->collIncidentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Incident objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Incident objects.
     * @throws PropelException
     */
    public function countIncidents(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIncidentsPartial && !$this->isNew();
        if (null === $this->collIncidents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIncidents) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getIncidents());
            }

            $query = ChildIncidentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCellule($this)
                ->count($con);
        }

        return count($this->collIncidents);
    }

    /**
     * Method called to associate a ChildIncident object to this object
     * through the ChildIncident foreign key attribute.
     *
     * @param  ChildIncident $l ChildIncident
     * @return $this|\Cellule The current object (for fluent API support)
     */
    public function addIncident(ChildIncident $l)
    {
        if ($this->collIncidents === null) {
            $this->initIncidents();
            $this->collIncidentsPartial = true;
        }

        if (!$this->collIncidents->contains($l)) {
            $this->doAddIncident($l);

            if ($this->incidentsScheduledForDeletion and $this->incidentsScheduledForDeletion->contains($l)) {
                $this->incidentsScheduledForDeletion->remove($this->incidentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildIncident $incident The ChildIncident object to add.
     */
    protected function doAddIncident(ChildIncident $incident)
    {
        $this->collIncidents[]= $incident;
        $incident->setCellule($this);
    }

    /**
     * @param  ChildIncident $incident The ChildIncident object to remove.
     * @return $this|ChildCellule The current object (for fluent API support)
     */
    public function removeIncident(ChildIncident $incident)
    {
        if ($this->getIncidents()->contains($incident)) {
            $pos = $this->collIncidents->search($incident);
            $this->collIncidents->remove($pos);
            if (null === $this->incidentsScheduledForDeletion) {
                $this->incidentsScheduledForDeletion = clone $this->collIncidents;
                $this->incidentsScheduledForDeletion->clear();
            }
            $this->incidentsScheduledForDeletion[]= $incident;
            $incident->setCellule(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cellule is new, it will return
     * an empty collection; or if this Cellule has previously
     * been saved, it will retrieve related Incidents from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cellule.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIncident[] List of ChildIncident objects
     */
    public function getIncidentsJoinEtatIncident(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIncidentQuery::create(null, $criteria);
        $query->joinWith('EtatIncident', $joinBehavior);

        return $this->getIncidents($query, $con);
    }

    /**
     * Clears out the collDemandes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDemandes()
     */
    public function clearDemandes()
    {
        $this->collDemandes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDemandes collection loaded partially.
     */
    public function resetPartialDemandes($v = true)
    {
        $this->collDemandesPartial = $v;
    }

    /**
     * Initializes the collDemandes collection.
     *
     * By default this just sets the collDemandes collection to an empty array (like clearcollDemandes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDemandes($overrideExisting = true)
    {
        if (null !== $this->collDemandes && !$overrideExisting) {
            return;
        }

        $collectionClassName = DemandeTableMap::getTableMap()->getCollectionClassName();

        $this->collDemandes = new $collectionClassName;
        $this->collDemandes->setModel('\Demande');
    }

    /**
     * Gets an array of ChildDemande objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCellule is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDemande[] List of ChildDemande objects
     * @throws PropelException
     */
    public function getDemandes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDemandesPartial && !$this->isNew();
        if (null === $this->collDemandes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDemandes) {
                // return empty collection
                $this->initDemandes();
            } else {
                $collDemandes = ChildDemandeQuery::create(null, $criteria)
                    ->filterByCellule($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDemandesPartial && count($collDemandes)) {
                        $this->initDemandes(false);

                        foreach ($collDemandes as $obj) {
                            if (false == $this->collDemandes->contains($obj)) {
                                $this->collDemandes->append($obj);
                            }
                        }

                        $this->collDemandesPartial = true;
                    }

                    return $collDemandes;
                }

                if ($partial && $this->collDemandes) {
                    foreach ($this->collDemandes as $obj) {
                        if ($obj->isNew()) {
                            $collDemandes[] = $obj;
                        }
                    }
                }

                $this->collDemandes = $collDemandes;
                $this->collDemandesPartial = false;
            }
        }

        return $this->collDemandes;
    }

    /**
     * Sets a collection of ChildDemande objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $demandes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCellule The current object (for fluent API support)
     */
    public function setDemandes(Collection $demandes, ConnectionInterface $con = null)
    {
        /** @var ChildDemande[] $demandesToDelete */
        $demandesToDelete = $this->getDemandes(new Criteria(), $con)->diff($demandes);


        $this->demandesScheduledForDeletion = $demandesToDelete;

        foreach ($demandesToDelete as $demandeRemoved) {
            $demandeRemoved->setCellule(null);
        }

        $this->collDemandes = null;
        foreach ($demandes as $demande) {
            $this->addDemande($demande);
        }

        $this->collDemandes = $demandes;
        $this->collDemandesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Demande objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Demande objects.
     * @throws PropelException
     */
    public function countDemandes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDemandesPartial && !$this->isNew();
        if (null === $this->collDemandes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDemandes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDemandes());
            }

            $query = ChildDemandeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCellule($this)
                ->count($con);
        }

        return count($this->collDemandes);
    }

    /**
     * Method called to associate a ChildDemande object to this object
     * through the ChildDemande foreign key attribute.
     *
     * @param  ChildDemande $l ChildDemande
     * @return $this|\Cellule The current object (for fluent API support)
     */
    public function addDemande(ChildDemande $l)
    {
        if ($this->collDemandes === null) {
            $this->initDemandes();
            $this->collDemandesPartial = true;
        }

        if (!$this->collDemandes->contains($l)) {
            $this->doAddDemande($l);

            if ($this->demandesScheduledForDeletion and $this->demandesScheduledForDeletion->contains($l)) {
                $this->demandesScheduledForDeletion->remove($this->demandesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDemande $demande The ChildDemande object to add.
     */
    protected function doAddDemande(ChildDemande $demande)
    {
        $this->collDemandes[]= $demande;
        $demande->setCellule($this);
    }

    /**
     * @param  ChildDemande $demande The ChildDemande object to remove.
     * @return $this|ChildCellule The current object (for fluent API support)
     */
    public function removeDemande(ChildDemande $demande)
    {
        if ($this->getDemandes()->contains($demande)) {
            $pos = $this->collDemandes->search($demande);
            $this->collDemandes->remove($pos);
            if (null === $this->demandesScheduledForDeletion) {
                $this->demandesScheduledForDeletion = clone $this->collDemandes;
                $this->demandesScheduledForDeletion->clear();
            }
            $this->demandesScheduledForDeletion[]= $demande;
            $demande->setCellule(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cellule is new, it will return
     * an empty collection; or if this Cellule has previously
     * been saved, it will retrieve related Demandes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cellule.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDemande[] List of ChildDemande objects
     */
    public function getDemandesJoinEtatDemande(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDemandeQuery::create(null, $criteria);
        $query->joinWith('EtatDemande', $joinBehavior);

        return $this->getDemandes($query, $con);
    }

    /**
     * Clears out the collSuivis collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSuivis()
     */
    public function clearSuivis()
    {
        $this->collSuivis = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSuivis collection loaded partially.
     */
    public function resetPartialSuivis($v = true)
    {
        $this->collSuivisPartial = $v;
    }

    /**
     * Initializes the collSuivis collection.
     *
     * By default this just sets the collSuivis collection to an empty array (like clearcollSuivis());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSuivis($overrideExisting = true)
    {
        if (null !== $this->collSuivis && !$overrideExisting) {
            return;
        }

        $collectionClassName = SuiviTableMap::getTableMap()->getCollectionClassName();

        $this->collSuivis = new $collectionClassName;
        $this->collSuivis->setModel('\Suivi');
    }

    /**
     * Gets an array of ChildSuivi objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCellule is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSuivi[] List of ChildSuivi objects
     * @throws PropelException
     */
    public function getSuivis(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSuivisPartial && !$this->isNew();
        if (null === $this->collSuivis || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSuivis) {
                // return empty collection
                $this->initSuivis();
            } else {
                $collSuivis = ChildSuiviQuery::create(null, $criteria)
                    ->filterByCellule($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSuivisPartial && count($collSuivis)) {
                        $this->initSuivis(false);

                        foreach ($collSuivis as $obj) {
                            if (false == $this->collSuivis->contains($obj)) {
                                $this->collSuivis->append($obj);
                            }
                        }

                        $this->collSuivisPartial = true;
                    }

                    return $collSuivis;
                }

                if ($partial && $this->collSuivis) {
                    foreach ($this->collSuivis as $obj) {
                        if ($obj->isNew()) {
                            $collSuivis[] = $obj;
                        }
                    }
                }

                $this->collSuivis = $collSuivis;
                $this->collSuivisPartial = false;
            }
        }

        return $this->collSuivis;
    }

    /**
     * Sets a collection of ChildSuivi objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $suivis A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCellule The current object (for fluent API support)
     */
    public function setSuivis(Collection $suivis, ConnectionInterface $con = null)
    {
        /** @var ChildSuivi[] $suivisToDelete */
        $suivisToDelete = $this->getSuivis(new Criteria(), $con)->diff($suivis);


        $this->suivisScheduledForDeletion = $suivisToDelete;

        foreach ($suivisToDelete as $suiviRemoved) {
            $suiviRemoved->setCellule(null);
        }

        $this->collSuivis = null;
        foreach ($suivis as $suivi) {
            $this->addSuivi($suivi);
        }

        $this->collSuivis = $suivis;
        $this->collSuivisPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Suivi objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Suivi objects.
     * @throws PropelException
     */
    public function countSuivis(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSuivisPartial && !$this->isNew();
        if (null === $this->collSuivis || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSuivis) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSuivis());
            }

            $query = ChildSuiviQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCellule($this)
                ->count($con);
        }

        return count($this->collSuivis);
    }

    /**
     * Method called to associate a ChildSuivi object to this object
     * through the ChildSuivi foreign key attribute.
     *
     * @param  ChildSuivi $l ChildSuivi
     * @return $this|\Cellule The current object (for fluent API support)
     */
    public function addSuivi(ChildSuivi $l)
    {
        if ($this->collSuivis === null) {
            $this->initSuivis();
            $this->collSuivisPartial = true;
        }

        if (!$this->collSuivis->contains($l)) {
            $this->doAddSuivi($l);

            if ($this->suivisScheduledForDeletion and $this->suivisScheduledForDeletion->contains($l)) {
                $this->suivisScheduledForDeletion->remove($this->suivisScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSuivi $suivi The ChildSuivi object to add.
     */
    protected function doAddSuivi(ChildSuivi $suivi)
    {
        $this->collSuivis[]= $suivi;
        $suivi->setCellule($this);
    }

    /**
     * @param  ChildSuivi $suivi The ChildSuivi object to remove.
     * @return $this|ChildCellule The current object (for fluent API support)
     */
    public function removeSuivi(ChildSuivi $suivi)
    {
        if ($this->getSuivis()->contains($suivi)) {
            $pos = $this->collSuivis->search($suivi);
            $this->collSuivis->remove($pos);
            if (null === $this->suivisScheduledForDeletion) {
                $this->suivisScheduledForDeletion = clone $this->collSuivis;
                $this->suivisScheduledForDeletion->clear();
            }
            $this->suivisScheduledForDeletion[]= $suivi;
            $suivi->setCellule(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cellule is new, it will return
     * an empty collection; or if this Cellule has previously
     * been saved, it will retrieve related Suivis from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cellule.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSuivi[] List of ChildSuivi objects
     */
    public function getSuivisJoinUtilisateur(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSuiviQuery::create(null, $criteria);
        $query->joinWith('Utilisateur', $joinBehavior);

        return $this->getSuivis($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cellule is new, it will return
     * an empty collection; or if this Cellule has previously
     * been saved, it will retrieve related Suivis from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cellule.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSuivi[] List of ChildSuivi objects
     */
    public function getSuivisJoinDemande(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSuiviQuery::create(null, $criteria);
        $query->joinWith('Demande', $joinBehavior);

        return $this->getSuivis($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cellule is new, it will return
     * an empty collection; or if this Cellule has previously
     * been saved, it will retrieve related Suivis from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cellule.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSuivi[] List of ChildSuivi objects
     */
    public function getSuivisJoinIncident(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSuiviQuery::create(null, $criteria);
        $query->joinWith('Incident', $joinBehavior);

        return $this->getSuivis($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aType) {
            $this->aType->removeCellule($this);
        }
        $this->id = null;
        $this->designation = null;
        $this->type_c = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collIncidents) {
                foreach ($this->collIncidents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDemandes) {
                foreach ($this->collDemandes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSuivis) {
                foreach ($this->collSuivis as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collIncidents = null;
        $this->collDemandes = null;
        $this->collSuivis = null;
        $this->aType = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CelluleTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
