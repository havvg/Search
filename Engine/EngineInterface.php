<?php

namespace Havvg\Component\Search\Engine;

use Havvg\Component\Search\Result\ResultCollection;
use Havvg\Component\Search\Result\ResultInterface;

/**
 * A search engine defines an algorithm on retrieving search results.
 *
 * An engine implements the business logic to interact with a given search backend.
 * A backend maybe an array, a relational database, or a search engine like Apache Lucene.
 */
interface EngineInterface
{
    /**
     * Check whether this engines supports the given query type.
     *
     * @param mixed $query
     *
     * @return bool
     */
    public function supports($query);

    /**
     * Perform the search based on the query.
     *
     * The query may be anything, from a simple search string to a complex query structure.
     * It's based on a contract between the engine and the application.
     *
     * @param mixed $query
     *
     * @return ResultCollection|ResultInterface[]|\Traversable
     */
    public function search($query);
}
