<?php

namespace Map;

use \Suivi;
use \SuiviQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'suivi' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SuiviTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SuiviTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'cra_2';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'suivi';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Suivi';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Suivi';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'suivi.id';

    /**
     * the column name for the matricule_s field
     */
    const COL_MATRICULE_S = 'suivi.matricule_s';

    /**
     * the column name for the temps_passe field
     */
    const COL_TEMPS_PASSE = 'suivi.temps_passe';

    /**
     * the column name for the cellule_s field
     */
    const COL_CELLULE_S = 'suivi.cellule_s';

    /**
     * the column name for the demande_s field
     */
    const COL_DEMANDE_S = 'suivi.demande_s';

    /**
     * the column name for the incident_s field
     */
    const COL_INCIDENT_S = 'suivi.incident_s';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'MatriculeS', 'TempsPasse', 'CelluleS', 'DemandeS', 'IncidentS', ),
        self::TYPE_CAMELNAME     => array('id', 'matriculeS', 'tempsPasse', 'celluleS', 'demandeS', 'incidentS', ),
        self::TYPE_COLNAME       => array(SuiviTableMap::COL_ID, SuiviTableMap::COL_MATRICULE_S, SuiviTableMap::COL_TEMPS_PASSE, SuiviTableMap::COL_CELLULE_S, SuiviTableMap::COL_DEMANDE_S, SuiviTableMap::COL_INCIDENT_S, ),
        self::TYPE_FIELDNAME     => array('id', 'matricule_s', 'temps_passe', 'cellule_s', 'demande_s', 'incident_s', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'MatriculeS' => 1, 'TempsPasse' => 2, 'CelluleS' => 3, 'DemandeS' => 4, 'IncidentS' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'matriculeS' => 1, 'tempsPasse' => 2, 'celluleS' => 3, 'demandeS' => 4, 'incidentS' => 5, ),
        self::TYPE_COLNAME       => array(SuiviTableMap::COL_ID => 0, SuiviTableMap::COL_MATRICULE_S => 1, SuiviTableMap::COL_TEMPS_PASSE => 2, SuiviTableMap::COL_CELLULE_S => 3, SuiviTableMap::COL_DEMANDE_S => 4, SuiviTableMap::COL_INCIDENT_S => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'matricule_s' => 1, 'temps_passe' => 2, 'cellule_s' => 3, 'demande_s' => 4, 'incident_s' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('suivi');
        $this->setPhpName('Suivi');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Suivi');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('matricule_s', 'MatriculeS', 'INTEGER', 'utilisateur', 'matricule', false, null, null);
        $this->addColumn('temps_passe', 'TempsPasse', 'FLOAT', false, null, null);
        $this->addForeignKey('cellule_s', 'CelluleS', 'INTEGER', 'cellule', 'id', false, null, null);
        $this->addForeignKey('demande_s', 'DemandeS', 'INTEGER', 'demande', 'id', false, null, null);
        $this->addForeignKey('incident_s', 'IncidentS', 'INTEGER', 'incident', 'id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Utilisateur', '\\Utilisateur', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':matricule_s',
    1 => ':matricule',
  ),
), null, null, null, false);
        $this->addRelation('Cellule', '\\Cellule', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':cellule_s',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Demande', '\\Demande', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':demande_s',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Incident', '\\Incident', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':incident_s',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? SuiviTableMap::CLASS_DEFAULT : SuiviTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Suivi object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SuiviTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SuiviTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SuiviTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SuiviTableMap::OM_CLASS;
            /** @var Suivi $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SuiviTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = SuiviTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SuiviTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Suivi $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SuiviTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(SuiviTableMap::COL_ID);
            $criteria->addSelectColumn(SuiviTableMap::COL_MATRICULE_S);
            $criteria->addSelectColumn(SuiviTableMap::COL_TEMPS_PASSE);
            $criteria->addSelectColumn(SuiviTableMap::COL_CELLULE_S);
            $criteria->addSelectColumn(SuiviTableMap::COL_DEMANDE_S);
            $criteria->addSelectColumn(SuiviTableMap::COL_INCIDENT_S);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.matricule_s');
            $criteria->addSelectColumn($alias . '.temps_passe');
            $criteria->addSelectColumn($alias . '.cellule_s');
            $criteria->addSelectColumn($alias . '.demande_s');
            $criteria->addSelectColumn($alias . '.incident_s');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(SuiviTableMap::DATABASE_NAME)->getTable(SuiviTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SuiviTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SuiviTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SuiviTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Suivi or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Suivi object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SuiviTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Suivi) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SuiviTableMap::DATABASE_NAME);
            $criteria->add(SuiviTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SuiviQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SuiviTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SuiviTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the suivi table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SuiviQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Suivi or Criteria object.
     *
     * @param mixed               $criteria Criteria or Suivi object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SuiviTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Suivi object
        }


        // Set the correct dbName
        $query = SuiviQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SuiviTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SuiviTableMap::buildTableMap();
