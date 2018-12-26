<?php

namespace Base;

use \Cellule as ChildCellule;
use \CelluleQuery as ChildCelluleQuery;
use \Demande as ChildDemande;
use \DemandeQuery as ChildDemandeQuery;
use \EtatDemande as ChildEtatDemande;
use \EtatDemandeQuery as ChildEtatDemandeQuery;
use \Suivi as ChildSuivi;
use \SuiviQuery as ChildSuiviQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\DemandeTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'demande' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Demande implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\DemandeTableMap';


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
     * @var        string
     */
    protected $id;

    /**
     * The value for the cellule_d field.
     *
     * @var        int
     */
    protected $cellule_d;

    /**
     * The value for the etat_d field.
     *
     * @var        int
     */
    protected $etat_d;

    /**
     * The value for the date_soumission field.
     *
     * @var        DateTime
     */
    protected $date_soumission;

    /**
     * The value for the date_maj field.
     *
     * @var        DateTime
     */
    protected $date_maj;

    /**
     * The value for the date_livraison field.
     *
     * @var        DateTime
     */
    protected $date_livraison;

    /**
     * The value for the charge field.
     *
     * @var        double
     */
    protected $charge;

    /**
     * The value for the projet field.
     *
     * @var        string
     */
    protected $projet;

    /**
     * The value for the priorite field.
     *
     * @var        int
     */
    protected $priorite;

    /**
     * @var        ChildCellule
     */
    protected $aCellule;

    /**
     * @var        ChildEtatDemande
     */
    protected $aEtatDemande;

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
     * @var ObjectCollection|ChildSuivi[]
     */
    protected $suivisScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Demande object.
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
     * Compares this with another <code>Demande</code> instance.  If
     * <code>obj</code> is an instance of <code>Demande</code>, delegates to
     * <code>equals(Demande)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Demande The current object, for fluid interface
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
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [cellule_d] column value.
     *
     * @return int
     */
    public function getCelluleD()
    {
        return $this->cellule_d;
    }

    /**
     * Get the [etat_d] column value.
     *
     * @return int
     */
    public function getEtatD()
    {
        return $this->etat_d;
    }

    /**
     * Get the [optionally formatted] temporal [date_soumission] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateSoumission($format = NULL)
    {
        if ($format === null) {
            return $this->date_soumission;
        } else {
            return $this->date_soumission instanceof \DateTimeInterface ? $this->date_soumission->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [date_maj] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateMaj($format = NULL)
    {
        if ($format === null) {
            return $this->date_maj;
        } else {
            return $this->date_maj instanceof \DateTimeInterface ? $this->date_maj->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [date_livraison] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateLivraison($format = NULL)
    {
        if ($format === null) {
            return $this->date_livraison;
        } else {
            return $this->date_livraison instanceof \DateTimeInterface ? $this->date_livraison->format($format) : null;
        }
    }

    /**
     * Get the [charge] column value.
     *
     * @return double
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * Get the [projet] column value.
     *
     * @return string
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * Get the [priorite] column value.
     *
     * @return string
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getPriorite()
    {
        if (null === $this->priorite) {
            return null;
        }
        $valueSet = DemandeTableMap::getValueSet(DemandeTableMap::COL_PRIORITE);
        if (!isset($valueSet[$this->priorite])) {
            throw new PropelException('Unknown stored enum key: ' . $this->priorite);
        }

        return $valueSet[$this->priorite];
    }

    /**
     * Set the value of [id] column.
     *
     * @param string $v new value
     * @return $this|\Demande The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[DemandeTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [cellule_d] column.
     *
     * @param int $v new value
     * @return $this|\Demande The current object (for fluent API support)
     */
    public function setCelluleD($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->cellule_d !== $v) {
            $this->cellule_d = $v;
            $this->modifiedColumns[DemandeTableMap::COL_CELLULE_D] = true;
        }

        if ($this->aCellule !== null && $this->aCellule->getId() !== $v) {
            $this->aCellule = null;
        }

        return $this;
    } // setCelluleD()

    /**
     * Set the value of [etat_d] column.
     *
     * @param int $v new value
     * @return $this|\Demande The current object (for fluent API support)
     */
    public function setEtatD($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->etat_d !== $v) {
            $this->etat_d = $v;
            $this->modifiedColumns[DemandeTableMap::COL_ETAT_D] = true;
        }

        if ($this->aEtatDemande !== null && $this->aEtatDemande->getId() !== $v) {
            $this->aEtatDemande = null;
        }

        return $this;
    } // setEtatD()

    /**
     * Sets the value of [date_soumission] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Demande The current object (for fluent API support)
     */
    public function setDateSoumission($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_soumission !== null || $dt !== null) {
            if ($this->date_soumission === null || $dt === null || $dt->format("Y-m-d") !== $this->date_soumission->format("Y-m-d")) {
                $this->date_soumission = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DemandeTableMap::COL_DATE_SOUMISSION] = true;
            }
        } // if either are not null

        return $this;
    } // setDateSoumission()

    /**
     * Sets the value of [date_maj] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Demande The current object (for fluent API support)
     */
    public function setDateMaj($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_maj !== null || $dt !== null) {
            if ($this->date_maj === null || $dt === null || $dt->format("Y-m-d") !== $this->date_maj->format("Y-m-d")) {
                $this->date_maj = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DemandeTableMap::COL_DATE_MAJ] = true;
            }
        } // if either are not null

        return $this;
    } // setDateMaj()

    /**
     * Sets the value of [date_livraison] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Demande The current object (for fluent API support)
     */
    public function setDateLivraison($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_livraison !== null || $dt !== null) {
            if ($this->date_livraison === null || $dt === null || $dt->format("Y-m-d") !== $this->date_livraison->format("Y-m-d")) {
                $this->date_livraison = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DemandeTableMap::COL_DATE_LIVRAISON] = true;
            }
        } // if either are not null

        return $this;
    } // setDateLivraison()

    /**
     * Set the value of [charge] column.
     *
     * @param double $v new value
     * @return $this|\Demande The current object (for fluent API support)
     */
    public function setCharge($v)
    {
        if ($v !== null) {
            $v = (double) $v;
        }

        if ($this->charge !== $v) {
            $this->charge = $v;
            $this->modifiedColumns[DemandeTableMap::COL_CHARGE] = true;
        }

        return $this;
    } // setCharge()

    /**
     * Set the value of [projet] column.
     *
     * @param string $v new value
     * @return $this|\Demande The current object (for fluent API support)
     */
    public function setProjet($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->projet !== $v) {
            $this->projet = $v;
            $this->modifiedColumns[DemandeTableMap::COL_PROJET] = true;
        }

        return $this;
    } // setProjet()

    /**
     * Set the value of [priorite] column.
     *
     * @param  string $v new value
     * @return $this|\Demande The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setPriorite($v)
    {
        if ($v !== null) {
            $valueSet = DemandeTableMap::getValueSet(DemandeTableMap::COL_PRIORITE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->priorite !== $v) {
            $this->priorite = $v;
            $this->modifiedColumns[DemandeTableMap::COL_PRIORITE] = true;
        }

        return $this;
    } // setPriorite()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : DemandeTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : DemandeTableMap::translateFieldName('CelluleD', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cellule_d = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : DemandeTableMap::translateFieldName('EtatD', TableMap::TYPE_PHPNAME, $indexType)];
            $this->etat_d = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : DemandeTableMap::translateFieldName('DateSoumission', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date_soumission = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : DemandeTableMap::translateFieldName('DateMaj', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date_maj = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : DemandeTableMap::translateFieldName('DateLivraison', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date_livraison = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : DemandeTableMap::translateFieldName('Charge', TableMap::TYPE_PHPNAME, $indexType)];
            $this->charge = (null !== $col) ? (double) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : DemandeTableMap::translateFieldName('Projet', TableMap::TYPE_PHPNAME, $indexType)];
            $this->projet = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : DemandeTableMap::translateFieldName('Priorite', TableMap::TYPE_PHPNAME, $indexType)];
            $this->priorite = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = DemandeTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Demande'), 0, $e);
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
        if ($this->aCellule !== null && $this->cellule_d !== $this->aCellule->getId()) {
            $this->aCellule = null;
        }
        if ($this->aEtatDemande !== null && $this->etat_d !== $this->aEtatDemande->getId()) {
            $this->aEtatDemande = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(DemandeTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDemandeQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCellule = null;
            $this->aEtatDemande = null;
            $this->collSuivis = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Demande::setDeleted()
     * @see Demande::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DemandeTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDemandeQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DemandeTableMap::DATABASE_NAME);
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
                DemandeTableMap::addInstanceToPool($this);
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

            if ($this->aCellule !== null) {
                if ($this->aCellule->isModified() || $this->aCellule->isNew()) {
                    $affectedRows += $this->aCellule->save($con);
                }
                $this->setCellule($this->aCellule);
            }

            if ($this->aEtatDemande !== null) {
                if ($this->aEtatDemande->isModified() || $this->aEtatDemande->isNew()) {
                    $affectedRows += $this->aEtatDemande->save($con);
                }
                $this->setEtatDemande($this->aEtatDemande);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DemandeTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(DemandeTableMap::COL_CELLULE_D)) {
            $modifiedColumns[':p' . $index++]  = 'cellule_d';
        }
        if ($this->isColumnModified(DemandeTableMap::COL_ETAT_D)) {
            $modifiedColumns[':p' . $index++]  = 'etat_d';
        }
        if ($this->isColumnModified(DemandeTableMap::COL_DATE_SOUMISSION)) {
            $modifiedColumns[':p' . $index++]  = 'date_soumission';
        }
        if ($this->isColumnModified(DemandeTableMap::COL_DATE_MAJ)) {
            $modifiedColumns[':p' . $index++]  = 'date_maj';
        }
        if ($this->isColumnModified(DemandeTableMap::COL_DATE_LIVRAISON)) {
            $modifiedColumns[':p' . $index++]  = 'date_livraison';
        }
        if ($this->isColumnModified(DemandeTableMap::COL_CHARGE)) {
            $modifiedColumns[':p' . $index++]  = 'charge';
        }
        if ($this->isColumnModified(DemandeTableMap::COL_PROJET)) {
            $modifiedColumns[':p' . $index++]  = 'projet';
        }
        if ($this->isColumnModified(DemandeTableMap::COL_PRIORITE)) {
            $modifiedColumns[':p' . $index++]  = 'priorite';
        }

        $sql = sprintf(
            'INSERT INTO demande (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_STR);
                        break;
                    case 'cellule_d':
                        $stmt->bindValue($identifier, $this->cellule_d, PDO::PARAM_INT);
                        break;
                    case 'etat_d':
                        $stmt->bindValue($identifier, $this->etat_d, PDO::PARAM_INT);
                        break;
                    case 'date_soumission':
                        $stmt->bindValue($identifier, $this->date_soumission ? $this->date_soumission->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'date_maj':
                        $stmt->bindValue($identifier, $this->date_maj ? $this->date_maj->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'date_livraison':
                        $stmt->bindValue($identifier, $this->date_livraison ? $this->date_livraison->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'charge':
                        $stmt->bindValue($identifier, $this->charge, PDO::PARAM_STR);
                        break;
                    case 'projet':
                        $stmt->bindValue($identifier, $this->projet, PDO::PARAM_STR);
                        break;
                    case 'priorite':
                        $stmt->bindValue($identifier, $this->priorite, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = DemandeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCelluleD();
                break;
            case 2:
                return $this->getEtatD();
                break;
            case 3:
                return $this->getDateSoumission();
                break;
            case 4:
                return $this->getDateMaj();
                break;
            case 5:
                return $this->getDateLivraison();
                break;
            case 6:
                return $this->getCharge();
                break;
            case 7:
                return $this->getProjet();
                break;
            case 8:
                return $this->getPriorite();
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

        if (isset($alreadyDumpedObjects['Demande'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Demande'][$this->hashCode()] = true;
        $keys = DemandeTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCelluleD(),
            $keys[2] => $this->getEtatD(),
            $keys[3] => $this->getDateSoumission(),
            $keys[4] => $this->getDateMaj(),
            $keys[5] => $this->getDateLivraison(),
            $keys[6] => $this->getCharge(),
            $keys[7] => $this->getProjet(),
            $keys[8] => $this->getPriorite(),
        );
        if ($result[$keys[3]] instanceof \DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        if ($result[$keys[4]] instanceof \DateTimeInterface) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        if ($result[$keys[5]] instanceof \DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCellule) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'cellule';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'cellule';
                        break;
                    default:
                        $key = 'Cellule';
                }

                $result[$key] = $this->aCellule->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aEtatDemande) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'etatDemande';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'etat_demande';
                        break;
                    default:
                        $key = 'EtatDemande';
                }

                $result[$key] = $this->aEtatDemande->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Demande
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DemandeTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Demande
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCelluleD($value);
                break;
            case 2:
                $this->setEtatD($value);
                break;
            case 3:
                $this->setDateSoumission($value);
                break;
            case 4:
                $this->setDateMaj($value);
                break;
            case 5:
                $this->setDateLivraison($value);
                break;
            case 6:
                $this->setCharge($value);
                break;
            case 7:
                $this->setProjet($value);
                break;
            case 8:
                $valueSet = DemandeTableMap::getValueSet(DemandeTableMap::COL_PRIORITE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setPriorite($value);
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
        $keys = DemandeTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCelluleD($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEtatD($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDateSoumission($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDateMaj($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDateLivraison($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setCharge($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setProjet($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setPriorite($arr[$keys[8]]);
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
     * @return $this|\Demande The current object, for fluid interface
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
        $criteria = new Criteria(DemandeTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DemandeTableMap::COL_ID)) {
            $criteria->add(DemandeTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(DemandeTableMap::COL_CELLULE_D)) {
            $criteria->add(DemandeTableMap::COL_CELLULE_D, $this->cellule_d);
        }
        if ($this->isColumnModified(DemandeTableMap::COL_ETAT_D)) {
            $criteria->add(DemandeTableMap::COL_ETAT_D, $this->etat_d);
        }
        if ($this->isColumnModified(DemandeTableMap::COL_DATE_SOUMISSION)) {
            $criteria->add(DemandeTableMap::COL_DATE_SOUMISSION, $this->date_soumission);
        }
        if ($this->isColumnModified(DemandeTableMap::COL_DATE_MAJ)) {
            $criteria->add(DemandeTableMap::COL_DATE_MAJ, $this->date_maj);
        }
        if ($this->isColumnModified(DemandeTableMap::COL_DATE_LIVRAISON)) {
            $criteria->add(DemandeTableMap::COL_DATE_LIVRAISON, $this->date_livraison);
        }
        if ($this->isColumnModified(DemandeTableMap::COL_CHARGE)) {
            $criteria->add(DemandeTableMap::COL_CHARGE, $this->charge);
        }
        if ($this->isColumnModified(DemandeTableMap::COL_PROJET)) {
            $criteria->add(DemandeTableMap::COL_PROJET, $this->projet);
        }
        if ($this->isColumnModified(DemandeTableMap::COL_PRIORITE)) {
            $criteria->add(DemandeTableMap::COL_PRIORITE, $this->priorite);
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
        $criteria = ChildDemandeQuery::create();
        $criteria->add(DemandeTableMap::COL_ID, $this->id);

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
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       string $key Primary key.
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
     * @param      object $copyObj An object of \Demande (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setCelluleD($this->getCelluleD());
        $copyObj->setEtatD($this->getEtatD());
        $copyObj->setDateSoumission($this->getDateSoumission());
        $copyObj->setDateMaj($this->getDateMaj());
        $copyObj->setDateLivraison($this->getDateLivraison());
        $copyObj->setCharge($this->getCharge());
        $copyObj->setProjet($this->getProjet());
        $copyObj->setPriorite($this->getPriorite());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSuivis() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSuivi($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \Demande Clone of current object.
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
     * Declares an association between this object and a ChildCellule object.
     *
     * @param  ChildCellule $v
     * @return $this|\Demande The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCellule(ChildCellule $v = null)
    {
        if ($v === null) {
            $this->setCelluleD(NULL);
        } else {
            $this->setCelluleD($v->getId());
        }

        $this->aCellule = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCellule object, it will not be re-added.
        if ($v !== null) {
            $v->addDemande($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCellule object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCellule The associated ChildCellule object.
     * @throws PropelException
     */
    public function getCellule(ConnectionInterface $con = null)
    {
        if ($this->aCellule === null && ($this->cellule_d != 0)) {
            $this->aCellule = ChildCelluleQuery::create()->findPk($this->cellule_d, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCellule->addDemandes($this);
             */
        }

        return $this->aCellule;
    }

    /**
     * Declares an association between this object and a ChildEtatDemande object.
     *
     * @param  ChildEtatDemande $v
     * @return $this|\Demande The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEtatDemande(ChildEtatDemande $v = null)
    {
        if ($v === null) {
            $this->setEtatD(NULL);
        } else {
            $this->setEtatD($v->getId());
        }

        $this->aEtatDemande = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildEtatDemande object, it will not be re-added.
        if ($v !== null) {
            $v->addDemande($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEtatDemande object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildEtatDemande The associated ChildEtatDemande object.
     * @throws PropelException
     */
    public function getEtatDemande(ConnectionInterface $con = null)
    {
        if ($this->aEtatDemande === null && ($this->etat_d != 0)) {
            $this->aEtatDemande = ChildEtatDemandeQuery::create()->findPk($this->etat_d, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEtatDemande->addDemandes($this);
             */
        }

        return $this->aEtatDemande;
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
        if ('Suivi' == $relationName) {
            $this->initSuivis();
            return;
        }
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
     * If this ChildDemande is new, it will return
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
                    ->filterByDemande($this)
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
     * @return $this|ChildDemande The current object (for fluent API support)
     */
    public function setSuivis(Collection $suivis, ConnectionInterface $con = null)
    {
        /** @var ChildSuivi[] $suivisToDelete */
        $suivisToDelete = $this->getSuivis(new Criteria(), $con)->diff($suivis);


        $this->suivisScheduledForDeletion = $suivisToDelete;

        foreach ($suivisToDelete as $suiviRemoved) {
            $suiviRemoved->setDemande(null);
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
                ->filterByDemande($this)
                ->count($con);
        }

        return count($this->collSuivis);
    }

    /**
     * Method called to associate a ChildSuivi object to this object
     * through the ChildSuivi foreign key attribute.
     *
     * @param  ChildSuivi $l ChildSuivi
     * @return $this|\Demande The current object (for fluent API support)
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
        $suivi->setDemande($this);
    }

    /**
     * @param  ChildSuivi $suivi The ChildSuivi object to remove.
     * @return $this|ChildDemande The current object (for fluent API support)
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
            $suivi->setDemande(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Demande is new, it will return
     * an empty collection; or if this Demande has previously
     * been saved, it will retrieve related Suivis from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Demande.
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
     * Otherwise if this Demande is new, it will return
     * an empty collection; or if this Demande has previously
     * been saved, it will retrieve related Suivis from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Demande.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSuivi[] List of ChildSuivi objects
     */
    public function getSuivisJoinCellule(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSuiviQuery::create(null, $criteria);
        $query->joinWith('Cellule', $joinBehavior);

        return $this->getSuivis($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Demande is new, it will return
     * an empty collection; or if this Demande has previously
     * been saved, it will retrieve related Suivis from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Demande.
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
        if (null !== $this->aCellule) {
            $this->aCellule->removeDemande($this);
        }
        if (null !== $this->aEtatDemande) {
            $this->aEtatDemande->removeDemande($this);
        }
        $this->id = null;
        $this->cellule_d = null;
        $this->etat_d = null;
        $this->date_soumission = null;
        $this->date_maj = null;
        $this->date_livraison = null;
        $this->charge = null;
        $this->projet = null;
        $this->priorite = null;
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
            if ($this->collSuivis) {
                foreach ($this->collSuivis as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSuivis = null;
        $this->aCellule = null;
        $this->aEtatDemande = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DemandeTableMap::DEFAULT_STRING_FORMAT);
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
