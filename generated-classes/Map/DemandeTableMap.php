<?php

namespace Map;

use \Demande;
use \DemandeQuery;
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
 * This class defines the structure of the 'demande' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DemandeTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DemandeTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'cra_2';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'demande';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Demande';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Demande';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the id field
     */
    const COL_ID = 'demande.id';

    /**
     * the column name for the cellule_d field
     */
    const COL_CELLULE_D = 'demande.cellule_d';

    /**
     * the column name for the etat_d field
     */
    const COL_ETAT_D = 'demande.etat_d';

    /**
     * the column name for the date_soumission field
     */
    const COL_DATE_SOUMISSION = 'demande.date_soumission';

    /**
     * the column name for the date_maj field
     */
    const COL_DATE_MAJ = 'demande.date_maj';

    /**
     * the column name for the date_livraison field
     */
    const COL_DATE_LIVRAISON = 'demande.date_livraison';

    /**
     * the column name for the charge field
     */
    const COL_CHARGE = 'demande.charge';

    /**
     * the column name for the projet field
     */
    const COL_PROJET = 'demande.projet';

    /**
     * the column name for the priorite field
     */
    const COL_PRIORITE = 'demande.priorite';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the priorite field */
    const COL_PRIORITE_BASSE = 'basse';
    const COL_PRIORITE_NORMALE = 'normale';
    const COL_PRIORITE_éLEVéE = 'élevée';
    const COL_PRIORITE_URGENTE = 'urgente';
    const COL_PRIORITE_IMMéDIATE = 'immédiate';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'CelluleD', 'EtatD', 'DateSoumission', 'DateMaj', 'DateLivraison', 'Charge', 'Projet', 'Priorite', ),
        self::TYPE_CAMELNAME     => array('id', 'celluleD', 'etatD', 'dateSoumission', 'dateMaj', 'dateLivraison', 'charge', 'projet', 'priorite', ),
        self::TYPE_COLNAME       => array(DemandeTableMap::COL_ID, DemandeTableMap::COL_CELLULE_D, DemandeTableMap::COL_ETAT_D, DemandeTableMap::COL_DATE_SOUMISSION, DemandeTableMap::COL_DATE_MAJ, DemandeTableMap::COL_DATE_LIVRAISON, DemandeTableMap::COL_CHARGE, DemandeTableMap::COL_PROJET, DemandeTableMap::COL_PRIORITE, ),
        self::TYPE_FIELDNAME     => array('id', 'cellule_d', 'etat_d', 'date_soumission', 'date_maj', 'date_livraison', 'charge', 'projet', 'priorite', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'CelluleD' => 1, 'EtatD' => 2, 'DateSoumission' => 3, 'DateMaj' => 4, 'DateLivraison' => 5, 'Charge' => 6, 'Projet' => 7, 'Priorite' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'celluleD' => 1, 'etatD' => 2, 'dateSoumission' => 3, 'dateMaj' => 4, 'dateLivraison' => 5, 'charge' => 6, 'projet' => 7, 'priorite' => 8, ),
        self::TYPE_COLNAME       => array(DemandeTableMap::COL_ID => 0, DemandeTableMap::COL_CELLULE_D => 1, DemandeTableMap::COL_ETAT_D => 2, DemandeTableMap::COL_DATE_SOUMISSION => 3, DemandeTableMap::COL_DATE_MAJ => 4, DemandeTableMap::COL_DATE_LIVRAISON => 5, DemandeTableMap::COL_CHARGE => 6, DemandeTableMap::COL_PROJET => 7, DemandeTableMap::COL_PRIORITE => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'cellule_d' => 1, 'etat_d' => 2, 'date_soumission' => 3, 'date_maj' => 4, 'date_livraison' => 5, 'charge' => 6, 'projet' => 7, 'priorite' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                DemandeTableMap::COL_PRIORITE => array(
                            self::COL_PRIORITE_BASSE,
            self::COL_PRIORITE_NORMALE,
            self::COL_PRIORITE_éLEVéE,
            self::COL_PRIORITE_URGENTE,
            self::COL_PRIORITE_IMMéDIATE,
        ),
    );

    /**
     * Gets the list of values for all ENUM and SET columns
     * @return array
     */
    public static function getValueSets()
    {
      return static::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM or SET column
     * @param string $colname
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = self::getValueSets();

        return $valueSets[$colname];
    }

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
        $this->setName('demande');
        $this->setPhpName('Demande');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Demande');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'VARCHAR', true, 255, null);
        $this->addForeignKey('cellule_d', 'CelluleD', 'INTEGER', 'cellule', 'id', false, null, null);
        $this->addForeignKey('etat_d', 'EtatD', 'INTEGER', 'etat_demande', 'id', false, null, null);
        $this->addColumn('date_soumission', 'DateSoumission', 'DATE', false, null, null);
        $this->addColumn('date_maj', 'DateMaj', 'DATE', false, null, null);
        $this->addColumn('date_livraison', 'DateLivraison', 'DATE', false, null, null);
        $this->addColumn('charge', 'Charge', 'FLOAT', false, null, null);
        $this->addColumn('projet', 'Projet', 'VARCHAR', false, 255, null);
        $this->addColumn('priorite', 'Priorite', 'ENUM', false, null, null);
        $this->getColumn('priorite')->setValueSet(array (
  0 => 'basse',
  1 => 'normale',
  2 => 'élevée',
  3 => 'urgente',
  4 => 'immédiate',
));
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Cellule', '\\Cellule', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':cellule_d',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('EtatDemande', '\\EtatDemande', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':etat_d',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Suivi', '\\Suivi', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':demande_s',
    1 => ':id',
  ),
), null, null, 'Suivis', false);
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
        return (string) $row[
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
        return $withPrefix ? DemandeTableMap::CLASS_DEFAULT : DemandeTableMap::OM_CLASS;
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
     * @return array           (Demande object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DemandeTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DemandeTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DemandeTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DemandeTableMap::OM_CLASS;
            /** @var Demande $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DemandeTableMap::addInstanceToPool($obj, $key);
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
            $key = DemandeTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DemandeTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Demande $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DemandeTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DemandeTableMap::COL_ID);
            $criteria->addSelectColumn(DemandeTableMap::COL_CELLULE_D);
            $criteria->addSelectColumn(DemandeTableMap::COL_ETAT_D);
            $criteria->addSelectColumn(DemandeTableMap::COL_DATE_SOUMISSION);
            $criteria->addSelectColumn(DemandeTableMap::COL_DATE_MAJ);
            $criteria->addSelectColumn(DemandeTableMap::COL_DATE_LIVRAISON);
            $criteria->addSelectColumn(DemandeTableMap::COL_CHARGE);
            $criteria->addSelectColumn(DemandeTableMap::COL_PROJET);
            $criteria->addSelectColumn(DemandeTableMap::COL_PRIORITE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.cellule_d');
            $criteria->addSelectColumn($alias . '.etat_d');
            $criteria->addSelectColumn($alias . '.date_soumission');
            $criteria->addSelectColumn($alias . '.date_maj');
            $criteria->addSelectColumn($alias . '.date_livraison');
            $criteria->addSelectColumn($alias . '.charge');
            $criteria->addSelectColumn($alias . '.projet');
            $criteria->addSelectColumn($alias . '.priorite');
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
        return Propel::getServiceContainer()->getDatabaseMap(DemandeTableMap::DATABASE_NAME)->getTable(DemandeTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DemandeTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DemandeTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DemandeTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Demande or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Demande object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DemandeTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Demande) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DemandeTableMap::DATABASE_NAME);
            $criteria->add(DemandeTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DemandeQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DemandeTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DemandeTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the demande table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DemandeQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Demande or Criteria object.
     *
     * @param mixed               $criteria Criteria or Demande object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DemandeTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Demande object
        }


        // Set the correct dbName
        $query = DemandeQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DemandeTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DemandeTableMap::buildTableMap();
