<?php

namespace Base;

use \Cellule as ChildCellule;
use \CelluleQuery as ChildCelluleQuery;
use \Exception;
use \PDO;
use Map\CelluleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'cellule' table.
 *
 *
 *
 * @method     ChildCelluleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCelluleQuery orderByDesignation($order = Criteria::ASC) Order by the designation column
 * @method     ChildCelluleQuery orderByTypeC($order = Criteria::ASC) Order by the type_c column
 *
 * @method     ChildCelluleQuery groupById() Group by the id column
 * @method     ChildCelluleQuery groupByDesignation() Group by the designation column
 * @method     ChildCelluleQuery groupByTypeC() Group by the type_c column
 *
 * @method     ChildCelluleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCelluleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCelluleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCelluleQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCelluleQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCelluleQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCelluleQuery leftJoinType($relationAlias = null) Adds a LEFT JOIN clause to the query using the Type relation
 * @method     ChildCelluleQuery rightJoinType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Type relation
 * @method     ChildCelluleQuery innerJoinType($relationAlias = null) Adds a INNER JOIN clause to the query using the Type relation
 *
 * @method     ChildCelluleQuery joinWithType($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Type relation
 *
 * @method     ChildCelluleQuery leftJoinWithType() Adds a LEFT JOIN clause and with to the query using the Type relation
 * @method     ChildCelluleQuery rightJoinWithType() Adds a RIGHT JOIN clause and with to the query using the Type relation
 * @method     ChildCelluleQuery innerJoinWithType() Adds a INNER JOIN clause and with to the query using the Type relation
 *
 * @method     ChildCelluleQuery leftJoinIncident($relationAlias = null) Adds a LEFT JOIN clause to the query using the Incident relation
 * @method     ChildCelluleQuery rightJoinIncident($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Incident relation
 * @method     ChildCelluleQuery innerJoinIncident($relationAlias = null) Adds a INNER JOIN clause to the query using the Incident relation
 *
 * @method     ChildCelluleQuery joinWithIncident($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Incident relation
 *
 * @method     ChildCelluleQuery leftJoinWithIncident() Adds a LEFT JOIN clause and with to the query using the Incident relation
 * @method     ChildCelluleQuery rightJoinWithIncident() Adds a RIGHT JOIN clause and with to the query using the Incident relation
 * @method     ChildCelluleQuery innerJoinWithIncident() Adds a INNER JOIN clause and with to the query using the Incident relation
 *
 * @method     ChildCelluleQuery leftJoinDemande($relationAlias = null) Adds a LEFT JOIN clause to the query using the Demande relation
 * @method     ChildCelluleQuery rightJoinDemande($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Demande relation
 * @method     ChildCelluleQuery innerJoinDemande($relationAlias = null) Adds a INNER JOIN clause to the query using the Demande relation
 *
 * @method     ChildCelluleQuery joinWithDemande($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Demande relation
 *
 * @method     ChildCelluleQuery leftJoinWithDemande() Adds a LEFT JOIN clause and with to the query using the Demande relation
 * @method     ChildCelluleQuery rightJoinWithDemande() Adds a RIGHT JOIN clause and with to the query using the Demande relation
 * @method     ChildCelluleQuery innerJoinWithDemande() Adds a INNER JOIN clause and with to the query using the Demande relation
 *
 * @method     ChildCelluleQuery leftJoinSuivi($relationAlias = null) Adds a LEFT JOIN clause to the query using the Suivi relation
 * @method     ChildCelluleQuery rightJoinSuivi($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Suivi relation
 * @method     ChildCelluleQuery innerJoinSuivi($relationAlias = null) Adds a INNER JOIN clause to the query using the Suivi relation
 *
 * @method     ChildCelluleQuery joinWithSuivi($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Suivi relation
 *
 * @method     ChildCelluleQuery leftJoinWithSuivi() Adds a LEFT JOIN clause and with to the query using the Suivi relation
 * @method     ChildCelluleQuery rightJoinWithSuivi() Adds a RIGHT JOIN clause and with to the query using the Suivi relation
 * @method     ChildCelluleQuery innerJoinWithSuivi() Adds a INNER JOIN clause and with to the query using the Suivi relation
 *
 * @method     \TypeQuery|\IncidentQuery|\DemandeQuery|\SuiviQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCellule findOne(ConnectionInterface $con = null) Return the first ChildCellule matching the query
 * @method     ChildCellule findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCellule matching the query, or a new ChildCellule object populated from the query conditions when no match is found
 *
 * @method     ChildCellule findOneById(int $id) Return the first ChildCellule filtered by the id column
 * @method     ChildCellule findOneByDesignation(string $designation) Return the first ChildCellule filtered by the designation column
 * @method     ChildCellule findOneByTypeC(string $type_c) Return the first ChildCellule filtered by the type_c column *

 * @method     ChildCellule requirePk($key, ConnectionInterface $con = null) Return the ChildCellule by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCellule requireOne(ConnectionInterface $con = null) Return the first ChildCellule matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCellule requireOneById(int $id) Return the first ChildCellule filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCellule requireOneByDesignation(string $designation) Return the first ChildCellule filtered by the designation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCellule requireOneByTypeC(string $type_c) Return the first ChildCellule filtered by the type_c column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCellule[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCellule objects based on current ModelCriteria
 * @method     ChildCellule[]|ObjectCollection findById(int $id) Return ChildCellule objects filtered by the id column
 * @method     ChildCellule[]|ObjectCollection findByDesignation(string $designation) Return ChildCellule objects filtered by the designation column
 * @method     ChildCellule[]|ObjectCollection findByTypeC(string $type_c) Return ChildCellule objects filtered by the type_c column
 * @method     ChildCellule[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CelluleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CelluleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cra_2', $modelName = '\\Cellule', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCelluleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCelluleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCelluleQuery) {
            return $criteria;
        }
        $query = new ChildCelluleQuery();
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
     * @return ChildCellule|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CelluleTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CelluleTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCellule A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, designation, type_c FROM cellule WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCellule $obj */
            $obj = new ChildCellule();
            $obj->hydrate($row);
            CelluleTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCellule|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCelluleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CelluleTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCelluleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CelluleTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCelluleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CelluleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CelluleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CelluleTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the designation column
     *
     * Example usage:
     * <code>
     * $query->filterByDesignation('fooValue');   // WHERE designation = 'fooValue'
     * $query->filterByDesignation('%fooValue%', Criteria::LIKE); // WHERE designation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $designation The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCelluleQuery The current query, for fluid interface
     */
    public function filterByDesignation($designation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($designation)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CelluleTableMap::COL_DESIGNATION, $designation, $comparison);
    }

    /**
     * Filter the query on the type_c column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeC('fooValue');   // WHERE type_c = 'fooValue'
     * $query->filterByTypeC('%fooValue%', Criteria::LIKE); // WHERE type_c LIKE '%fooValue%'
     * </code>
     *
     * @param     string $typeC The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCelluleQuery The current query, for fluid interface
     */
    public function filterByTypeC($typeC = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($typeC)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CelluleTableMap::COL_TYPE_C, $typeC, $comparison);
    }

    /**
     * Filter the query by a related \Type object
     *
     * @param \Type|ObjectCollection $type The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCelluleQuery The current query, for fluid interface
     */
    public function filterByType($type, $comparison = null)
    {
        if ($type instanceof \Type) {
            return $this
                ->addUsingAlias(CelluleTableMap::COL_TYPE_C, $type->getId(), $comparison);
        } elseif ($type instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CelluleTableMap::COL_TYPE_C, $type->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByType() only accepts arguments of type \Type or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Type relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCelluleQuery The current query, for fluid interface
     */
    public function joinType($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Type');

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
            $this->addJoinObject($join, 'Type');
        }

        return $this;
    }

    /**
     * Use the Type relation Type object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TypeQuery A secondary query class using the current class as primary query
     */
    public function useTypeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Type', '\TypeQuery');
    }

    /**
     * Filter the query by a related \Incident object
     *
     * @param \Incident|ObjectCollection $incident the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCelluleQuery The current query, for fluid interface
     */
    public function filterByIncident($incident, $comparison = null)
    {
        if ($incident instanceof \Incident) {
            return $this
                ->addUsingAlias(CelluleTableMap::COL_ID, $incident->getCelluleI(), $comparison);
        } elseif ($incident instanceof ObjectCollection) {
            return $this
                ->useIncidentQuery()
                ->filterByPrimaryKeys($incident->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByIncident() only accepts arguments of type \Incident or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Incident relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCelluleQuery The current query, for fluid interface
     */
    public function joinIncident($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Incident');

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
            $this->addJoinObject($join, 'Incident');
        }

        return $this;
    }

    /**
     * Use the Incident relation Incident object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \IncidentQuery A secondary query class using the current class as primary query
     */
    public function useIncidentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinIncident($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Incident', '\IncidentQuery');
    }

    /**
     * Filter the query by a related \Demande object
     *
     * @param \Demande|ObjectCollection $demande the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCelluleQuery The current query, for fluid interface
     */
    public function filterByDemande($demande, $comparison = null)
    {
        if ($demande instanceof \Demande) {
            return $this
                ->addUsingAlias(CelluleTableMap::COL_ID, $demande->getCelluleD(), $comparison);
        } elseif ($demande instanceof ObjectCollection) {
            return $this
                ->useDemandeQuery()
                ->filterByPrimaryKeys($demande->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDemande() only accepts arguments of type \Demande or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Demande relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCelluleQuery The current query, for fluid interface
     */
    public function joinDemande($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Demande');

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
            $this->addJoinObject($join, 'Demande');
        }

        return $this;
    }

    /**
     * Use the Demande relation Demande object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DemandeQuery A secondary query class using the current class as primary query
     */
    public function useDemandeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDemande($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Demande', '\DemandeQuery');
    }

    /**
     * Filter the query by a related \Suivi object
     *
     * @param \Suivi|ObjectCollection $suivi the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCelluleQuery The current query, for fluid interface
     */
    public function filterBySuivi($suivi, $comparison = null)
    {
        if ($suivi instanceof \Suivi) {
            return $this
                ->addUsingAlias(CelluleTableMap::COL_ID, $suivi->getCelluleS(), $comparison);
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
     * @return $this|ChildCelluleQuery The current query, for fluid interface
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
     * @param   ChildCellule $cellule Object to remove from the list of results
     *
     * @return $this|ChildCelluleQuery The current query, for fluid interface
     */
    public function prune($cellule = null)
    {
        if ($cellule) {
            $this->addUsingAlias(CelluleTableMap::COL_ID, $cellule->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the cellule table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CelluleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CelluleTableMap::clearInstancePool();
            CelluleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CelluleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CelluleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CelluleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CelluleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CelluleQuery
