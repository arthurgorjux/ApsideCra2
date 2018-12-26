<?php

namespace Base;

use \Demande as ChildDemande;
use \DemandeQuery as ChildDemandeQuery;
use \Exception;
use \PDO;
use Map\DemandeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'demande' table.
 *
 *
 *
 * @method     ChildDemandeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDemandeQuery orderByCelluleD($order = Criteria::ASC) Order by the cellule_d column
 * @method     ChildDemandeQuery orderByEtatD($order = Criteria::ASC) Order by the etat_d column
 * @method     ChildDemandeQuery orderByDateSoumission($order = Criteria::ASC) Order by the date_soumission column
 * @method     ChildDemandeQuery orderByDateMaj($order = Criteria::ASC) Order by the date_maj column
 * @method     ChildDemandeQuery orderByDateLivraison($order = Criteria::ASC) Order by the date_livraison column
 * @method     ChildDemandeQuery orderByCharge($order = Criteria::ASC) Order by the charge column
 * @method     ChildDemandeQuery orderByProjet($order = Criteria::ASC) Order by the projet column
 * @method     ChildDemandeQuery orderByPriorite($order = Criteria::ASC) Order by the priorite column
 *
 * @method     ChildDemandeQuery groupById() Group by the id column
 * @method     ChildDemandeQuery groupByCelluleD() Group by the cellule_d column
 * @method     ChildDemandeQuery groupByEtatD() Group by the etat_d column
 * @method     ChildDemandeQuery groupByDateSoumission() Group by the date_soumission column
 * @method     ChildDemandeQuery groupByDateMaj() Group by the date_maj column
 * @method     ChildDemandeQuery groupByDateLivraison() Group by the date_livraison column
 * @method     ChildDemandeQuery groupByCharge() Group by the charge column
 * @method     ChildDemandeQuery groupByProjet() Group by the projet column
 * @method     ChildDemandeQuery groupByPriorite() Group by the priorite column
 *
 * @method     ChildDemandeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDemandeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDemandeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDemandeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDemandeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDemandeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDemandeQuery leftJoinCellule($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cellule relation
 * @method     ChildDemandeQuery rightJoinCellule($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cellule relation
 * @method     ChildDemandeQuery innerJoinCellule($relationAlias = null) Adds a INNER JOIN clause to the query using the Cellule relation
 *
 * @method     ChildDemandeQuery joinWithCellule($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Cellule relation
 *
 * @method     ChildDemandeQuery leftJoinWithCellule() Adds a LEFT JOIN clause and with to the query using the Cellule relation
 * @method     ChildDemandeQuery rightJoinWithCellule() Adds a RIGHT JOIN clause and with to the query using the Cellule relation
 * @method     ChildDemandeQuery innerJoinWithCellule() Adds a INNER JOIN clause and with to the query using the Cellule relation
 *
 * @method     ChildDemandeQuery leftJoinEtatDemande($relationAlias = null) Adds a LEFT JOIN clause to the query using the EtatDemande relation
 * @method     ChildDemandeQuery rightJoinEtatDemande($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EtatDemande relation
 * @method     ChildDemandeQuery innerJoinEtatDemande($relationAlias = null) Adds a INNER JOIN clause to the query using the EtatDemande relation
 *
 * @method     ChildDemandeQuery joinWithEtatDemande($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the EtatDemande relation
 *
 * @method     ChildDemandeQuery leftJoinWithEtatDemande() Adds a LEFT JOIN clause and with to the query using the EtatDemande relation
 * @method     ChildDemandeQuery rightJoinWithEtatDemande() Adds a RIGHT JOIN clause and with to the query using the EtatDemande relation
 * @method     ChildDemandeQuery innerJoinWithEtatDemande() Adds a INNER JOIN clause and with to the query using the EtatDemande relation
 *
 * @method     ChildDemandeQuery leftJoinSuivi($relationAlias = null) Adds a LEFT JOIN clause to the query using the Suivi relation
 * @method     ChildDemandeQuery rightJoinSuivi($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Suivi relation
 * @method     ChildDemandeQuery innerJoinSuivi($relationAlias = null) Adds a INNER JOIN clause to the query using the Suivi relation
 *
 * @method     ChildDemandeQuery joinWithSuivi($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Suivi relation
 *
 * @method     ChildDemandeQuery leftJoinWithSuivi() Adds a LEFT JOIN clause and with to the query using the Suivi relation
 * @method     ChildDemandeQuery rightJoinWithSuivi() Adds a RIGHT JOIN clause and with to the query using the Suivi relation
 * @method     ChildDemandeQuery innerJoinWithSuivi() Adds a INNER JOIN clause and with to the query using the Suivi relation
 *
 * @method     \CelluleQuery|\EtatDemandeQuery|\SuiviQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDemande findOne(ConnectionInterface $con = null) Return the first ChildDemande matching the query
 * @method     ChildDemande findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDemande matching the query, or a new ChildDemande object populated from the query conditions when no match is found
 *
 * @method     ChildDemande findOneById(string $id) Return the first ChildDemande filtered by the id column
 * @method     ChildDemande findOneByCelluleD(int $cellule_d) Return the first ChildDemande filtered by the cellule_d column
 * @method     ChildDemande findOneByEtatD(int $etat_d) Return the first ChildDemande filtered by the etat_d column
 * @method     ChildDemande findOneByDateSoumission(string $date_soumission) Return the first ChildDemande filtered by the date_soumission column
 * @method     ChildDemande findOneByDateMaj(string $date_maj) Return the first ChildDemande filtered by the date_maj column
 * @method     ChildDemande findOneByDateLivraison(string $date_livraison) Return the first ChildDemande filtered by the date_livraison column
 * @method     ChildDemande findOneByCharge(double $charge) Return the first ChildDemande filtered by the charge column
 * @method     ChildDemande findOneByProjet(string $projet) Return the first ChildDemande filtered by the projet column
 * @method     ChildDemande findOneByPriorite(int $priorite) Return the first ChildDemande filtered by the priorite column *

 * @method     ChildDemande requirePk($key, ConnectionInterface $con = null) Return the ChildDemande by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemande requireOne(ConnectionInterface $con = null) Return the first ChildDemande matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDemande requireOneById(string $id) Return the first ChildDemande filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemande requireOneByCelluleD(int $cellule_d) Return the first ChildDemande filtered by the cellule_d column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemande requireOneByEtatD(int $etat_d) Return the first ChildDemande filtered by the etat_d column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemande requireOneByDateSoumission(string $date_soumission) Return the first ChildDemande filtered by the date_soumission column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemande requireOneByDateMaj(string $date_maj) Return the first ChildDemande filtered by the date_maj column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemande requireOneByDateLivraison(string $date_livraison) Return the first ChildDemande filtered by the date_livraison column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemande requireOneByCharge(double $charge) Return the first ChildDemande filtered by the charge column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemande requireOneByProjet(string $projet) Return the first ChildDemande filtered by the projet column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDemande requireOneByPriorite(int $priorite) Return the first ChildDemande filtered by the priorite column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDemande[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDemande objects based on current ModelCriteria
 * @method     ChildDemande[]|ObjectCollection findById(string $id) Return ChildDemande objects filtered by the id column
 * @method     ChildDemande[]|ObjectCollection findByCelluleD(int $cellule_d) Return ChildDemande objects filtered by the cellule_d column
 * @method     ChildDemande[]|ObjectCollection findByEtatD(int $etat_d) Return ChildDemande objects filtered by the etat_d column
 * @method     ChildDemande[]|ObjectCollection findByDateSoumission(string $date_soumission) Return ChildDemande objects filtered by the date_soumission column
 * @method     ChildDemande[]|ObjectCollection findByDateMaj(string $date_maj) Return ChildDemande objects filtered by the date_maj column
 * @method     ChildDemande[]|ObjectCollection findByDateLivraison(string $date_livraison) Return ChildDemande objects filtered by the date_livraison column
 * @method     ChildDemande[]|ObjectCollection findByCharge(double $charge) Return ChildDemande objects filtered by the charge column
 * @method     ChildDemande[]|ObjectCollection findByProjet(string $projet) Return ChildDemande objects filtered by the projet column
 * @method     ChildDemande[]|ObjectCollection findByPriorite(int $priorite) Return ChildDemande objects filtered by the priorite column
 * @method     ChildDemande[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DemandeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DemandeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cra_2', $modelName = '\\Demande', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDemandeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDemandeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDemandeQuery) {
            return $criteria;
        }
        $query = new ChildDemandeQuery();
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
     * @return ChildDemande|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DemandeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DemandeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildDemande A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, cellule_d, etat_d, date_soumission, date_maj, date_livraison, charge, projet, priorite FROM demande WHERE id = :p0';
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
            /** @var ChildDemande $obj */
            $obj = new ChildDemande();
            $obj->hydrate($row);
            DemandeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildDemande|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DemandeTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DemandeTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($id)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DemandeTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the cellule_d column
     *
     * Example usage:
     * <code>
     * $query->filterByCelluleD(1234); // WHERE cellule_d = 1234
     * $query->filterByCelluleD(array(12, 34)); // WHERE cellule_d IN (12, 34)
     * $query->filterByCelluleD(array('min' => 12)); // WHERE cellule_d > 12
     * </code>
     *
     * @see       filterByCellule()
     *
     * @param     mixed $celluleD The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByCelluleD($celluleD = null, $comparison = null)
    {
        if (is_array($celluleD)) {
            $useMinMax = false;
            if (isset($celluleD['min'])) {
                $this->addUsingAlias(DemandeTableMap::COL_CELLULE_D, $celluleD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($celluleD['max'])) {
                $this->addUsingAlias(DemandeTableMap::COL_CELLULE_D, $celluleD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DemandeTableMap::COL_CELLULE_D, $celluleD, $comparison);
    }

    /**
     * Filter the query on the etat_d column
     *
     * Example usage:
     * <code>
     * $query->filterByEtatD(1234); // WHERE etat_d = 1234
     * $query->filterByEtatD(array(12, 34)); // WHERE etat_d IN (12, 34)
     * $query->filterByEtatD(array('min' => 12)); // WHERE etat_d > 12
     * </code>
     *
     * @see       filterByEtatDemande()
     *
     * @param     mixed $etatD The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByEtatD($etatD = null, $comparison = null)
    {
        if (is_array($etatD)) {
            $useMinMax = false;
            if (isset($etatD['min'])) {
                $this->addUsingAlias(DemandeTableMap::COL_ETAT_D, $etatD['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($etatD['max'])) {
                $this->addUsingAlias(DemandeTableMap::COL_ETAT_D, $etatD['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DemandeTableMap::COL_ETAT_D, $etatD, $comparison);
    }

    /**
     * Filter the query on the date_soumission column
     *
     * Example usage:
     * <code>
     * $query->filterByDateSoumission('2011-03-14'); // WHERE date_soumission = '2011-03-14'
     * $query->filterByDateSoumission('now'); // WHERE date_soumission = '2011-03-14'
     * $query->filterByDateSoumission(array('max' => 'yesterday')); // WHERE date_soumission > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateSoumission The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByDateSoumission($dateSoumission = null, $comparison = null)
    {
        if (is_array($dateSoumission)) {
            $useMinMax = false;
            if (isset($dateSoumission['min'])) {
                $this->addUsingAlias(DemandeTableMap::COL_DATE_SOUMISSION, $dateSoumission['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateSoumission['max'])) {
                $this->addUsingAlias(DemandeTableMap::COL_DATE_SOUMISSION, $dateSoumission['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DemandeTableMap::COL_DATE_SOUMISSION, $dateSoumission, $comparison);
    }

    /**
     * Filter the query on the date_maj column
     *
     * Example usage:
     * <code>
     * $query->filterByDateMaj('2011-03-14'); // WHERE date_maj = '2011-03-14'
     * $query->filterByDateMaj('now'); // WHERE date_maj = '2011-03-14'
     * $query->filterByDateMaj(array('max' => 'yesterday')); // WHERE date_maj > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateMaj The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByDateMaj($dateMaj = null, $comparison = null)
    {
        if (is_array($dateMaj)) {
            $useMinMax = false;
            if (isset($dateMaj['min'])) {
                $this->addUsingAlias(DemandeTableMap::COL_DATE_MAJ, $dateMaj['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateMaj['max'])) {
                $this->addUsingAlias(DemandeTableMap::COL_DATE_MAJ, $dateMaj['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DemandeTableMap::COL_DATE_MAJ, $dateMaj, $comparison);
    }

    /**
     * Filter the query on the date_livraison column
     *
     * Example usage:
     * <code>
     * $query->filterByDateLivraison('2011-03-14'); // WHERE date_livraison = '2011-03-14'
     * $query->filterByDateLivraison('now'); // WHERE date_livraison = '2011-03-14'
     * $query->filterByDateLivraison(array('max' => 'yesterday')); // WHERE date_livraison > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateLivraison The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByDateLivraison($dateLivraison = null, $comparison = null)
    {
        if (is_array($dateLivraison)) {
            $useMinMax = false;
            if (isset($dateLivraison['min'])) {
                $this->addUsingAlias(DemandeTableMap::COL_DATE_LIVRAISON, $dateLivraison['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateLivraison['max'])) {
                $this->addUsingAlias(DemandeTableMap::COL_DATE_LIVRAISON, $dateLivraison['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DemandeTableMap::COL_DATE_LIVRAISON, $dateLivraison, $comparison);
    }

    /**
     * Filter the query on the charge column
     *
     * Example usage:
     * <code>
     * $query->filterByCharge(1234); // WHERE charge = 1234
     * $query->filterByCharge(array(12, 34)); // WHERE charge IN (12, 34)
     * $query->filterByCharge(array('min' => 12)); // WHERE charge > 12
     * </code>
     *
     * @param     mixed $charge The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByCharge($charge = null, $comparison = null)
    {
        if (is_array($charge)) {
            $useMinMax = false;
            if (isset($charge['min'])) {
                $this->addUsingAlias(DemandeTableMap::COL_CHARGE, $charge['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($charge['max'])) {
                $this->addUsingAlias(DemandeTableMap::COL_CHARGE, $charge['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DemandeTableMap::COL_CHARGE, $charge, $comparison);
    }

    /**
     * Filter the query on the projet column
     *
     * Example usage:
     * <code>
     * $query->filterByProjet('fooValue');   // WHERE projet = 'fooValue'
     * $query->filterByProjet('%fooValue%', Criteria::LIKE); // WHERE projet LIKE '%fooValue%'
     * </code>
     *
     * @param     string $projet The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByProjet($projet = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($projet)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DemandeTableMap::COL_PROJET, $projet, $comparison);
    }

    /**
     * Filter the query on the priorite column
     *
     * @param     mixed $priorite The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByPriorite($priorite = null, $comparison = null)
    {
        $valueSet = DemandeTableMap::getValueSet(DemandeTableMap::COL_PRIORITE);
        if (is_scalar($priorite)) {
            if (!in_array($priorite, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $priorite));
            }
            $priorite = array_search($priorite, $valueSet);
        } elseif (is_array($priorite)) {
            $convertedValues = array();
            foreach ($priorite as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $priorite = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DemandeTableMap::COL_PRIORITE, $priorite, $comparison);
    }

    /**
     * Filter the query by a related \Cellule object
     *
     * @param \Cellule|ObjectCollection $cellule The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByCellule($cellule, $comparison = null)
    {
        if ($cellule instanceof \Cellule) {
            return $this
                ->addUsingAlias(DemandeTableMap::COL_CELLULE_D, $cellule->getId(), $comparison);
        } elseif ($cellule instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DemandeTableMap::COL_CELLULE_D, $cellule->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildDemandeQuery The current query, for fluid interface
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
     * Filter the query by a related \EtatDemande object
     *
     * @param \EtatDemande|ObjectCollection $etatDemande The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDemandeQuery The current query, for fluid interface
     */
    public function filterByEtatDemande($etatDemande, $comparison = null)
    {
        if ($etatDemande instanceof \EtatDemande) {
            return $this
                ->addUsingAlias(DemandeTableMap::COL_ETAT_D, $etatDemande->getId(), $comparison);
        } elseif ($etatDemande instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DemandeTableMap::COL_ETAT_D, $etatDemande->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByEtatDemande() only accepts arguments of type \EtatDemande or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the EtatDemande relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function joinEtatDemande($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('EtatDemande');

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
            $this->addJoinObject($join, 'EtatDemande');
        }

        return $this;
    }

    /**
     * Use the EtatDemande relation EtatDemande object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EtatDemandeQuery A secondary query class using the current class as primary query
     */
    public function useEtatDemandeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEtatDemande($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'EtatDemande', '\EtatDemandeQuery');
    }

    /**
     * Filter the query by a related \Suivi object
     *
     * @param \Suivi|ObjectCollection $suivi the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDemandeQuery The current query, for fluid interface
     */
    public function filterBySuivi($suivi, $comparison = null)
    {
        if ($suivi instanceof \Suivi) {
            return $this
                ->addUsingAlias(DemandeTableMap::COL_ID, $suivi->getDemandeS(), $comparison);
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
     * @return $this|ChildDemandeQuery The current query, for fluid interface
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
     * @param   ChildDemande $demande Object to remove from the list of results
     *
     * @return $this|ChildDemandeQuery The current query, for fluid interface
     */
    public function prune($demande = null)
    {
        if ($demande) {
            $this->addUsingAlias(DemandeTableMap::COL_ID, $demande->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the demande table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DemandeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DemandeTableMap::clearInstancePool();
            DemandeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DemandeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DemandeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DemandeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DemandeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // DemandeQuery
