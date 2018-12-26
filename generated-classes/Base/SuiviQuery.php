<?php

namespace Base;

use \Suivi as ChildSuivi;
use \SuiviQuery as ChildSuiviQuery;
use \Exception;
use \PDO;
use Map\SuiviTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'suivi' table.
 *
 *
 *
 * @method     ChildSuiviQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSuiviQuery orderByMatriculeS($order = Criteria::ASC) Order by the matricule_s column
 * @method     ChildSuiviQuery orderByTempsPasse($order = Criteria::ASC) Order by the temps_passe column
 * @method     ChildSuiviQuery orderByCelluleS($order = Criteria::ASC) Order by the cellule_s column
 * @method     ChildSuiviQuery orderByDemandeS($order = Criteria::ASC) Order by the demande_s column
 * @method     ChildSuiviQuery orderByIncidentS($order = Criteria::ASC) Order by the incident_s column
 *
 * @method     ChildSuiviQuery groupById() Group by the id column
 * @method     ChildSuiviQuery groupByMatriculeS() Group by the matricule_s column
 * @method     ChildSuiviQuery groupByTempsPasse() Group by the temps_passe column
 * @method     ChildSuiviQuery groupByCelluleS() Group by the cellule_s column
 * @method     ChildSuiviQuery groupByDemandeS() Group by the demande_s column
 * @method     ChildSuiviQuery groupByIncidentS() Group by the incident_s column
 *
 * @method     ChildSuiviQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSuiviQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSuiviQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSuiviQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSuiviQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSuiviQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSuiviQuery leftJoinUtilisateur($relationAlias = null) Adds a LEFT JOIN clause to the query using the Utilisateur relation
 * @method     ChildSuiviQuery rightJoinUtilisateur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Utilisateur relation
 * @method     ChildSuiviQuery innerJoinUtilisateur($relationAlias = null) Adds a INNER JOIN clause to the query using the Utilisateur relation
 *
 * @method     ChildSuiviQuery joinWithUtilisateur($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Utilisateur relation
 *
 * @method     ChildSuiviQuery leftJoinWithUtilisateur() Adds a LEFT JOIN clause and with to the query using the Utilisateur relation
 * @method     ChildSuiviQuery rightJoinWithUtilisateur() Adds a RIGHT JOIN clause and with to the query using the Utilisateur relation
 * @method     ChildSuiviQuery innerJoinWithUtilisateur() Adds a INNER JOIN clause and with to the query using the Utilisateur relation
 *
 * @method     ChildSuiviQuery leftJoinCellule($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cellule relation
 * @method     ChildSuiviQuery rightJoinCellule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cellule relation
 * @method     ChildSuiviQuery innerJoinCellule($relationAlias = null) Adds a INNER JOIN clause to the query using the Cellule relation
 *
 * @method     ChildSuiviQuery joinWithCellule($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Cellule relation
 *
 * @method     ChildSuiviQuery leftJoinWithCellule() Adds a LEFT JOIN clause and with to the query using the Cellule relation
 * @method     ChildSuiviQuery rightJoinWithCellule() Adds a RIGHT JOIN clause and with to the query using the Cellule relation
 * @method     ChildSuiviQuery innerJoinWithCellule() Adds a INNER JOIN clause and with to the query using the Cellule relation
 *
 * @method     ChildSuiviQuery leftJoinDemande($relationAlias = null) Adds a LEFT JOIN clause to the query using the Demande relation
 * @method     ChildSuiviQuery rightJoinDemande($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Demande relation
 * @method     ChildSuiviQuery innerJoinDemande($relationAlias = null) Adds a INNER JOIN clause to the query using the Demande relation
 *
 * @method     ChildSuiviQuery joinWithDemande($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Demande relation
 *
 * @method     ChildSuiviQuery leftJoinWithDemande() Adds a LEFT JOIN clause and with to the query using the Demande relation
 * @method     ChildSuiviQuery rightJoinWithDemande() Adds a RIGHT JOIN clause and with to the query using the Demande relation
 * @method     ChildSuiviQuery innerJoinWithDemande() Adds a INNER JOIN clause and with to the query using the Demande relation
 *
 * @method     ChildSuiviQuery leftJoinIncident($relationAlias = null) Adds a LEFT JOIN clause to the query using the Incident relation
 * @method     ChildSuiviQuery rightJoinIncident($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Incident relation
 * @method     ChildSuiviQuery innerJoinIncident($relationAlias = null) Adds a INNER JOIN clause to the query using the Incident relation
 *
 * @method     ChildSuiviQuery joinWithIncident($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Incident relation
 *
 * @method     ChildSuiviQuery leftJoinWithIncident() Adds a LEFT JOIN clause and with to the query using the Incident relation
 * @method     ChildSuiviQuery rightJoinWithIncident() Adds a RIGHT JOIN clause and with to the query using the Incident relation
 * @method     ChildSuiviQuery innerJoinWithIncident() Adds a INNER JOIN clause and with to the query using the Incident relation
 *
 * @method     \UtilisateurQuery|\CelluleQuery|\DemandeQuery|\IncidentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSuivi findOne(ConnectionInterface $con = null) Return the first ChildSuivi matching the query
 * @method     ChildSuivi findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSuivi matching the query, or a new ChildSuivi object populated from the query conditions when no match is found
 *
 * @method     ChildSuivi findOneById(int $id) Return the first ChildSuivi filtered by the id column
 * @method     ChildSuivi findOneByMatriculeS(int $matricule_s) Return the first ChildSuivi filtered by the matricule_s column
 * @method     ChildSuivi findOneByTempsPasse(double $temps_passe) Return the first ChildSuivi filtered by the temps_passe column
 * @method     ChildSuivi findOneByCelluleS(int $cellule_s) Return the first ChildSuivi filtered by the cellule_s column
 * @method     ChildSuivi findOneByDemandeS(string $demande_s) Return the first ChildSuivi filtered by the demande_s column
 * @method     ChildSuivi findOneByIncidentS(string $incident_s) Return the first ChildSuivi filtered by the incident_s column *

 * @method     ChildSuivi requirePk($key, ConnectionInterface $con = null) Return the ChildSuivi by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSuivi requireOne(ConnectionInterface $con = null) Return the first ChildSuivi matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSuivi requireOneById(int $id) Return the first ChildSuivi filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSuivi requireOneByMatriculeS(int $matricule_s) Return the first ChildSuivi filtered by the matricule_s column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSuivi requireOneByTempsPasse(double $temps_passe) Return the first ChildSuivi filtered by the temps_passe column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSuivi requireOneByCelluleS(int $cellule_s) Return the first ChildSuivi filtered by the cellule_s column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSuivi requireOneByDemandeS(string $demande_s) Return the first ChildSuivi filtered by the demande_s column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSuivi requireOneByIncidentS(string $incident_s) Return the first ChildSuivi filtered by the incident_s column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSuivi[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSuivi objects based on current ModelCriteria
 * @method     ChildSuivi[]|ObjectCollection findById(int $id) Return ChildSuivi objects filtered by the id column
 * @method     ChildSuivi[]|ObjectCollection findByMatriculeS(int $matricule_s) Return ChildSuivi objects filtered by the matricule_s column
 * @method     ChildSuivi[]|ObjectCollection findByTempsPasse(double $temps_passe) Return ChildSuivi objects filtered by the temps_passe column
 * @method     ChildSuivi[]|ObjectCollection findByCelluleS(int $cellule_s) Return ChildSuivi objects filtered by the cellule_s column
 * @method     ChildSuivi[]|ObjectCollection findByDemandeS(string $demande_s) Return ChildSuivi objects filtered by the demande_s column
 * @method     ChildSuivi[]|ObjectCollection findByIncidentS(string $incident_s) Return ChildSuivi objects filtered by the incident_s column
 * @method     ChildSuivi[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SuiviQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\SuiviQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cra_2', $modelName = '\\Suivi', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSuiviQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSuiviQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSuiviQuery) {
            return $criteria;
        }
        $query = new ChildSuiviQuery();
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
     * @return ChildSuivi|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SuiviTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SuiviTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildSuivi A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, matricule_s, temps_passe, cellule_s, demande_s, incident_s FROM suivi WHERE id = :p0';
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
            /** @var ChildSuivi $obj */
            $obj = new ChildSuivi();
            $obj->hydrate($row);
            SuiviTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSuivi|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSuiviQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SuiviTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSuiviQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SuiviTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildSuiviQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SuiviTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SuiviTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SuiviTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the matricule_s column
     *
     * Example usage:
     * <code>
     * $query->filterByMatriculeS(1234); // WHERE matricule_s = 1234
     * $query->filterByMatriculeS(array(12, 34)); // WHERE matricule_s IN (12, 34)
     * $query->filterByMatriculeS(array('min' => 12)); // WHERE matricule_s > 12
     * </code>
     *
     * @see       filterByUtilisateur()
     *
     * @param     mixed $matriculeS The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSuiviQuery The current query, for fluid interface
     */
    public function filterByMatriculeS($matriculeS = null, $comparison = null)
    {
        if (is_array($matriculeS)) {
            $useMinMax = false;
            if (isset($matriculeS['min'])) {
                $this->addUsingAlias(SuiviTableMap::COL_MATRICULE_S, $matriculeS['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($matriculeS['max'])) {
                $this->addUsingAlias(SuiviTableMap::COL_MATRICULE_S, $matriculeS['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SuiviTableMap::COL_MATRICULE_S, $matriculeS, $comparison);
    }

    /**
     * Filter the query on the temps_passe column
     *
     * Example usage:
     * <code>
     * $query->filterByTempsPasse(1234); // WHERE temps_passe = 1234
     * $query->filterByTempsPasse(array(12, 34)); // WHERE temps_passe IN (12, 34)
     * $query->filterByTempsPasse(array('min' => 12)); // WHERE temps_passe > 12
     * </code>
     *
     * @param     mixed $tempsPasse The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSuiviQuery The current query, for fluid interface
     */
    public function filterByTempsPasse($tempsPasse = null, $comparison = null)
    {
        if (is_array($tempsPasse)) {
            $useMinMax = false;
            if (isset($tempsPasse['min'])) {
                $this->addUsingAlias(SuiviTableMap::COL_TEMPS_PASSE, $tempsPasse['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tempsPasse['max'])) {
                $this->addUsingAlias(SuiviTableMap::COL_TEMPS_PASSE, $tempsPasse['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SuiviTableMap::COL_TEMPS_PASSE, $tempsPasse, $comparison);
    }

    /**
     * Filter the query on the cellule_s column
     *
     * Example usage:
     * <code>
     * $query->filterByCelluleS(1234); // WHERE cellule_s = 1234
     * $query->filterByCelluleS(array(12, 34)); // WHERE cellule_s IN (12, 34)
     * $query->filterByCelluleS(array('min' => 12)); // WHERE cellule_s > 12
     * </code>
     *
     * @see       filterByCellule()
     *
     * @param     mixed $celluleS The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSuiviQuery The current query, for fluid interface
     */
    public function filterByCelluleS($celluleS = null, $comparison = null)
    {
        if (is_array($celluleS)) {
            $useMinMax = false;
            if (isset($celluleS['min'])) {
                $this->addUsingAlias(SuiviTableMap::COL_CELLULE_S, $celluleS['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($celluleS['max'])) {
                $this->addUsingAlias(SuiviTableMap::COL_CELLULE_S, $celluleS['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SuiviTableMap::COL_CELLULE_S, $celluleS, $comparison);
    }

    /**
     * Filter the query on the demande_s column
     *
     * Example usage:
     * <code>
     * $query->filterByDemandeS('fooValue');   // WHERE demande_s = 'fooValue'
     * $query->filterByDemandeS('%fooValue%', Criteria::LIKE); // WHERE demande_s LIKE '%fooValue%'
     * </code>
     *
     * @param     string $demandeS The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSuiviQuery The current query, for fluid interface
     */
    public function filterByDemandeS($demandeS = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($demandeS)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SuiviTableMap::COL_DEMANDE_S, $demandeS, $comparison);
    }

    /**
     * Filter the query on the incident_s column
     *
     * Example usage:
     * <code>
     * $query->filterByIncidentS('fooValue');   // WHERE incident_s = 'fooValue'
     * $query->filterByIncidentS('%fooValue%', Criteria::LIKE); // WHERE incident_s LIKE '%fooValue%'
     * </code>
     *
     * @param     string $incidentS The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSuiviQuery The current query, for fluid interface
     */
    public function filterByIncidentS($incidentS = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($incidentS)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SuiviTableMap::COL_INCIDENT_S, $incidentS, $comparison);
    }

    /**
     * Filter the query by a related \Utilisateur object
     *
     * @param \Utilisateur|ObjectCollection $utilisateur The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSuiviQuery The current query, for fluid interface
     */
    public function filterByUtilisateur($utilisateur, $comparison = null)
    {
        if ($utilisateur instanceof \Utilisateur) {
            return $this
                ->addUsingAlias(SuiviTableMap::COL_MATRICULE_S, $utilisateur->getMatricule(), $comparison);
        } elseif ($utilisateur instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SuiviTableMap::COL_MATRICULE_S, $utilisateur->toKeyValue('PrimaryKey', 'Matricule'), $comparison);
        } else {
            throw new PropelException('filterByUtilisateur() only accepts arguments of type \Utilisateur or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Utilisateur relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSuiviQuery The current query, for fluid interface
     */
    public function joinUtilisateur($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Utilisateur');

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
            $this->addJoinObject($join, 'Utilisateur');
        }

        return $this;
    }

    /**
     * Use the Utilisateur relation Utilisateur object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UtilisateurQuery A secondary query class using the current class as primary query
     */
    public function useUtilisateurQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUtilisateur($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Utilisateur', '\UtilisateurQuery');
    }

    /**
     * Filter the query by a related \Cellule object
     *
     * @param \Cellule|ObjectCollection $cellule The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSuiviQuery The current query, for fluid interface
     */
    public function filterByCellule($cellule, $comparison = null)
    {
        if ($cellule instanceof \Cellule) {
            return $this
                ->addUsingAlias(SuiviTableMap::COL_CELLULE_S, $cellule->getId(), $comparison);
        } elseif ($cellule instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SuiviTableMap::COL_CELLULE_S, $cellule->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSuiviQuery The current query, for fluid interface
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
     * Filter the query by a related \Demande object
     *
     * @param \Demande|ObjectCollection $demande The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSuiviQuery The current query, for fluid interface
     */
    public function filterByDemande($demande, $comparison = null)
    {
        if ($demande instanceof \Demande) {
            return $this
                ->addUsingAlias(SuiviTableMap::COL_DEMANDE_S, $demande->getId(), $comparison);
        } elseif ($demande instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SuiviTableMap::COL_DEMANDE_S, $demande->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSuiviQuery The current query, for fluid interface
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
     * Filter the query by a related \Incident object
     *
     * @param \Incident|ObjectCollection $incident The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSuiviQuery The current query, for fluid interface
     */
    public function filterByIncident($incident, $comparison = null)
    {
        if ($incident instanceof \Incident) {
            return $this
                ->addUsingAlias(SuiviTableMap::COL_INCIDENT_S, $incident->getId(), $comparison);
        } elseif ($incident instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SuiviTableMap::COL_INCIDENT_S, $incident->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSuiviQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildSuivi $suivi Object to remove from the list of results
     *
     * @return $this|ChildSuiviQuery The current query, for fluid interface
     */
    public function prune($suivi = null)
    {
        if ($suivi) {
            $this->addUsingAlias(SuiviTableMap::COL_ID, $suivi->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the suivi table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SuiviTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SuiviTableMap::clearInstancePool();
            SuiviTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SuiviTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SuiviTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SuiviTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SuiviTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SuiviQuery
