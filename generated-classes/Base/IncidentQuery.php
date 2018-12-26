<?php

namespace Base;

use \Incident as ChildIncident;
use \IncidentQuery as ChildIncidentQuery;
use \Exception;
use \PDO;
use Map\IncidentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'incident' table.
 *
 *
 *
 * @method     ChildIncidentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildIncidentQuery orderByCelluleI($order = Criteria::ASC) Order by the cellule_i column
 * @method     ChildIncidentQuery orderByEtatI($order = Criteria::ASC) Order by the etat_i column
 *
 * @method     ChildIncidentQuery groupById() Group by the id column
 * @method     ChildIncidentQuery groupByCelluleI() Group by the cellule_i column
 * @method     ChildIncidentQuery groupByEtatI() Group by the etat_i column
 *
 * @method     ChildIncidentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildIncidentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildIncidentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildIncidentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildIncidentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildIncidentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildIncidentQuery leftJoinCellule($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cellule relation
 * @method     ChildIncidentQuery rightJoinCellule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cellule relation
 * @method     ChildIncidentQuery innerJoinCellule($relationAlias = null) Adds a INNER JOIN clause to the query using the Cellule relation
 *
 * @method     ChildIncidentQuery joinWithCellule($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Cellule relation
 *
 * @method     ChildIncidentQuery leftJoinWithCellule() Adds a LEFT JOIN clause and with to the query using the Cellule relation
 * @method     ChildIncidentQuery rightJoinWithCellule() Adds a RIGHT JOIN clause and with to the query using the Cellule relation
 * @method     ChildIncidentQuery innerJoinWithCellule() Adds a INNER JOIN clause and with to the query using the Cellule relation
 *
 * @method     ChildIncidentQuery leftJoinEtatIncident($relationAlias = null) Adds a LEFT JOIN clause to the query using the EtatIncident relation
 * @method     ChildIncidentQuery rightJoinEtatIncident($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EtatIncident relation
 * @method     ChildIncidentQuery innerJoinEtatIncident($relationAlias = null) Adds a INNER JOIN clause to the query using the EtatIncident relation
 *
 * @method     ChildIncidentQuery joinWithEtatIncident($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the EtatIncident relation
 *
 * @method     ChildIncidentQuery leftJoinWithEtatIncident() Adds a LEFT JOIN clause and with to the query using the EtatIncident relation
 * @method     ChildIncidentQuery rightJoinWithEtatIncident() Adds a RIGHT JOIN clause and with to the query using the EtatIncident relation
 * @method     ChildIncidentQuery innerJoinWithEtatIncident() Adds a INNER JOIN clause and with to the query using the EtatIncident relation
 *
 * @method     ChildIncidentQuery leftJoinSuivi($relationAlias = null) Adds a LEFT JOIN clause to the query using the Suivi relation
 * @method     ChildIncidentQuery rightJoinSuivi($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Suivi relation
 * @method     ChildIncidentQuery innerJoinSuivi($relationAlias = null) Adds a INNER JOIN clause to the query using the Suivi relation
 *
 * @method     ChildIncidentQuery joinWithSuivi($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Suivi relation
 *
 * @method     ChildIncidentQuery leftJoinWithSuivi() Adds a LEFT JOIN clause and with to the query using the Suivi relation
 * @method     ChildIncidentQuery rightJoinWithSuivi() Adds a RIGHT JOIN clause and with to the query using the Suivi relation
 * @method     ChildIncidentQuery innerJoinWithSuivi() Adds a INNER JOIN clause and with to the query using the Suivi relation
 *
 * @method     \CelluleQuery|\EtatIncidentQuery|\SuiviQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildIncident findOne(ConnectionInterface $con = null) Return the first ChildIncident matching the query
 * @method     ChildIncident findOneOrCreate(ConnectionInterface $con = null) Return the first ChildIncident matching the query, or a new ChildIncident object populated from the query conditions when no match is found
 *
 * @method     ChildIncident findOneById(string $id) Return the first ChildIncident filtered by the id column
 * @method     ChildIncident findOneByCelluleI(int $cellule_i) Return the first ChildIncident filtered by the cellule_i column
 * @method     ChildIncident findOneByEtatI(int $etat_i) Return the first ChildIncident filtered by the etat_i column *

 * @method     ChildIncident requirePk($key, ConnectionInterface $con = null) Return the ChildIncident by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncident requireOne(ConnectionInterface $con = null) Return the first ChildIncident matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIncident requireOneById(string $id) Return the first ChildIncident filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncident requireOneByCelluleI(int $cellule_i) Return the first ChildIncident filtered by the cellule_i column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildIncident requireOneByEtatI(int $etat_i) Return the first ChildIncident filtered by the etat_i column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildIncident[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildIncident objects based on current ModelCriteria
 * @method     ChildIncident[]|ObjectCollection findById(string $id) Return ChildIncident objects filtered by the id column
 * @method     ChildIncident[]|ObjectCollection findByCelluleI(int $cellule_i) Return ChildIncident objects filtered by the cellule_i column
 * @method     ChildIncident[]|ObjectCollection findByEtatI(int $etat_i) Return ChildIncident objects filtered by the etat_i column
 * @method     ChildIncident[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class IncidentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\IncidentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cra_2', $modelName = '\\Incident', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildIncidentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildIncidentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildIncidentQuery) {
            return $criteria;
        }
        $query = new ChildIncidentQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildIncident|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(IncidentTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = IncidentTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIncident A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, cellule_i, etat_i FROM incident WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildIncident $obj */
            $obj = new ChildIncident();
            $obj->hydrate($row);
            IncidentTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildIncident|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildIncidentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(IncidentTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildIncidentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(IncidentTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById('fooValue');   // WHERE id = 'fooValue'
     * $query->filterById('%fooValue%', Criteria::LIKE); // WHERE id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $id The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($id)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the cellule_i column
     *
     * Example usage:
     * <code>
     * $query->filterByCelluleI(1234); // WHERE cellule_i = 1234
     * $query->filterByCelluleI(array(12, 34)); // WHERE cellule_i IN (12, 34)
     * $query->filterByCelluleI(array('min' => 12)); // WHERE cellule_i > 12
     * </code>
     *
     * @see       filterByCellule()
     *
     * @param     mixed $celluleI The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentQuery The current query, for fluid interface
     */
    public function filterByCelluleI($celluleI = null, $comparison = null)
    {
        if (is_array($celluleI)) {
            $useMinMax = false;
            if (isset($celluleI['min'])) {
                $this->addUsingAlias(IncidentTableMap::COL_CELLULE_I, $celluleI['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($celluleI['max'])) {
                $this->addUsingAlias(IncidentTableMap::COL_CELLULE_I, $celluleI['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentTableMap::COL_CELLULE_I, $celluleI, $comparison);
    }

    /**
     * Filter the query on the etat_i column
     *
     * Example usage:
     * <code>
     * $query->filterByEtatI(1234); // WHERE etat_i = 1234
     * $query->filterByEtatI(array(12, 34)); // WHERE etat_i IN (12, 34)
     * $query->filterByEtatI(array('min' => 12)); // WHERE etat_i > 12
     * </code>
     *
     * @see       filterByEtatIncident()
     *
     * @param     mixed $etatI The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildIncidentQuery The current query, for fluid interface
     */
    public function filterByEtatI($etatI = null, $comparison = null)
    {
        if (is_array($etatI)) {
            $useMinMax = false;
            if (isset($etatI['min'])) {
                $this->addUsingAlias(IncidentTableMap::COL_ETAT_I, $etatI['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($etatI['max'])) {
                $this->addUsingAlias(IncidentTableMap::COL_ETAT_I, $etatI['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(IncidentTableMap::COL_ETAT_I, $etatI, $comparison);
    }

    /**
     * Filter the query by a related \Cellule object
     *
     * @param \Cellule|ObjectCollection $cellule The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIncidentQuery The current query, for fluid interface
     */
    public function filterByCellule($cellule, $comparison = null)
    {
        if ($cellule instanceof \Cellule) {
            return $this
                ->addUsingAlias(IncidentTableMap::COL_CELLULE_I, $cellule->getId(), $comparison);
        } elseif ($cellule instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IncidentTableMap::COL_CELLULE_I, $cellule->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCellule() only accepts arguments of type \Cellule or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Cellule relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIncidentQuery The current query, for fluid interface
     */
    public function joinCellule($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Cellule');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Cellule');
        }

        return $this;
    }

    /**
     * Use the Cellule relation Cellule object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CelluleQuery A secondary query class using the current class as primary query
     */
    public function useCelluleQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCellule($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cellule', '\CelluleQuery');
    }

    /**
     * Filter the query by a related \EtatIncident object
     *
     * @param \EtatIncident|ObjectCollection $etatIncident The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildIncidentQuery The current query, for fluid interface
     */
    public function filterByEtatIncident($etatIncident, $comparison = null)
    {
        if ($etatIncident instanceof \EtatIncident) {
            return $this
                ->addUsingAlias(IncidentTableMap::COL_ETAT_I, $etatIncident->getId(), $comparison);
        } elseif ($etatIncident instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(IncidentTableMap::COL_ETAT_I, $etatIncident->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByEtatIncident() only accepts arguments of type \EtatIncident or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EtatIncident relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIncidentQuery The current query, for fluid interface
     */
    public function joinEtatIncident($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EtatIncident');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'EtatIncident');
        }

        return $this;
    }

    /**
     * Use the EtatIncident relation EtatIncident object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EtatIncidentQuery A secondary query class using the current class as primary query
     */
    public function useEtatIncidentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEtatIncident($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EtatIncident', '\EtatIncidentQuery');
    }

    /**
     * Filter the query by a related \Suivi object
     *
     * @param \Suivi|ObjectCollection $suivi the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildIncidentQuery The current query, for fluid interface
     */
    public function filterBySuivi($suivi, $comparison = null)
    {
        if ($suivi instanceof \Suivi) {
            return $this
                ->addUsingAlias(IncidentTableMap::COL_ID, $suivi->getIncidentS(), $comparison);
        } elseif ($suivi instanceof ObjectCollection) {
            return $this
                ->useSuiviQuery()
                ->filterByPrimaryKeys($suivi->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySuivi() only accepts arguments of type \Suivi or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Suivi relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildIncidentQuery The current query, for fluid interface
     */
    public function joinSuivi($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Suivi');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Suivi');
        }

        return $this;
    }

    /**
     * Use the Suivi relation Suivi object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \SuiviQuery A secondary query class using the current class as primary query
     */
    public function useSuiviQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSuivi($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Suivi', '\SuiviQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildIncident $incident Object to remove from the list of results
     *
     * @return $this|ChildIncidentQuery The current query, for fluid interface
     */
    public function prune($incident = null)
    {
        if ($incident) {
            $this->addUsingAlias(IncidentTableMap::COL_ID, $incident->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the incident table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IncidentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            IncidentTableMap::clearInstancePool();
            IncidentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(IncidentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(IncidentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            IncidentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            IncidentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // IncidentQuery
