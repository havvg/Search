<?php

namespace Havvg\Component\Search\Engine;

use Havvg\Component\Search\Exception\DomainException;
use Havvg\Component\Search\Exception\InvalidArgumentException;
use Havvg\Component\Search\Result\ResultCollection;
use Havvg\Component\Search\Result\ResultInterface;

class ChainEngine implements EngineInterface
{
    /**
     * @var EngineInterface[]
     */
    protected $engines;

    public function __construct(array $engines = array())
    {
        foreach ($engines as $eachEngine) {
            if (!$eachEngine instanceof EngineInterface) {
                throw new InvalidArgumentException('At least one of the given engine is invalid.');
            }
        }

        $this->engines = $engines;
    }

    /**
     * Add another search engine to the chain.
     *
     * @param EngineInterface $engine
     *
     * @return ChainEngine
     */
    public function addEngine(EngineInterface $engine)
    {
        $this->engines[] = $engine;

        return $this;
    }

    /**
     * Perform the search based on the query.
     *
     * The query may be anything, from a simple search string to a complex query structure.
     * It's based on a contract between the engine and the application.
     *
     * @param mixed $query
     *
     * @return ResultInterface[]|ResultCollection
     */
    public function search($query)
    {
        $results = new ResultCollection();

        foreach ($this->engines as $eachEngine) {
            if (!$eachEngine->supports($query)) {
                continue;
            }

            if ($more = $eachEngine->search($query)) {
                if (!is_array($more) and !$more instanceof \Traversable) {
                    throw new DomainException('The returned result set is not traversable.');
                }

                foreach ($more as $eachResult) {
                    $results->add($eachResult);
                }
            }
        }

        return $results;
    }

    /**
     * Check whether this engines supports the given query type.
     *
     * The chain engine supports the query, if at least one chained engine supports it.
     *
     * @param mixed $query
     *
     * @return bool
     */
    public function supports($query)
    {
        foreach ($this->engines as $eachEngine) {
            if ($eachEngine->supports($query)) {
                return true;
            }
        }

        return false;
    }
}
