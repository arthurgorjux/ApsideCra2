<?php

namespace Base;

use \Type as ChildType;
use \TypeQuery as ChildTypeQuery;
use \Exception;
use \PDO;
use Map\TypeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'type' table.
 *
 *
 *
 * @method     ChildTypeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTypeQuery orderByDesignation($order = Criteria::ASC) Order by the designation column
 *
 * @method     ChildTypeQuery groupById() Group by the id column
 * @method     ChildTypeQuery groupByDesignation() Group by the designation column
 *
 * @method     ChildTypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTypeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTypeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTypeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTypeQuery leftJoinCellule($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cellule relation
 * @method     ChildTypeQuery rightJoinCellule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cellule relation
 * @method     ChildTypeQuery innerJoinCellule($relationAlias = null) Adds a INNER JOIN clause to the query using the Cellule relation
 *
 * @method     ChildTypeQuery joinWithCellule($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Cellule relation
 *
 * @method     ChildTypeQuery leftJoinWithCellule() Adds a LEFT JOIN clause and with to the query using the Cellule relation
 * @method     ChildTypeQuery rightJoinWithCellule() Adds a RIGHT JOIN clause and with to the query using the Cellule relation
 * @method     ChildTypeQuery innerJoinWithCellule() Adds a INNER JOIN clause and with to the query using the Cellule relation
 *
 * @method     \CelluleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildType findOne(ConnectionInterface $con = null) Return the first ChildType matching the query
 * @method     ChildType findOneOrCreate(ConnectionInterface $con = null) Return the first ChildType matching the query, or a new ChildType object populated from the query conditions when no match is found
 *
 * @method     ChildType findOneById(string $id) Return the first ChildType filtered by the id column
 * @method     ChildType findOneByDesignation(string $designation) Return the first ChildType filtered by the designation column *

 * @method     ChildType requirePk($key, ConnectionInterface $con = null) Return the ChildType by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOne(ConnectionInterface $con = null) Return the first ChildType matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildType requireOneById(string $id) Return the first ChildType filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildType requireOneByDesignation(string $designation) Return the first ChildType filtered by the designation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildType[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildType objects based on current ModelCriteria
 * @method     ChildType[]|ObjectCollection findById(string $id) Return ChildType objects filtered by the id column
 * @method     ChildType[]|ObjectCollection findByDesignation(string $designation) Return ChildType objects filtered by the designation column
 * @method     ChildType[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TypeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TypeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cra_2', $modelName = '\\Type', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTypeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTypeQuery) {
            return $criteria;
        }
        $query = new ChildTypeQuery();
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
     * @return ChildType|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TypeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TypeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildType A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, designation FROM type WHERE id = :p0';
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
            /** @var ChildType $obj */
            $obj = new ChildType();
            $obj->hydrate($row);
            TypeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildType|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TypeTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TypeTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($id)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function filterByDesignation($designation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($designation)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TypeTableMap::COL_DESIGNATION, $designation, $comparison);
    }

    /**
     * Filter the query by a related \Cellule object
     *
     * @param \Cellule|ObjectCollection $cellule the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTypeQuery The current query, for fluid interface
     */
    public function filterByCellule($cellule, $comparison = null)
    {
        if ($cellule instanceof \Cellule) {
            return $this
                ->addUsingAlias(TypeTableMap::COL_ID, $cellule->getTypeC(), $comparison);
        } elseif ($cellule instanceof ObjectCollection) {
            return $this
                ->useCelluleQuery()
                ->filterByPrimaryKeys($cellule->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildTypeQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildType $type Object to remove from the list of results
     *
     * @return $this|ChildTypeQuery The current query, for fluid interface
     */
    public function prune($type = null)
    {
        if ($type) {
            $this->addUsingAlias(TypeTableMap::COL_ID, $type->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the type table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TypeTableMap::clearInstancePool();
            TypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TypeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TypeQuery
