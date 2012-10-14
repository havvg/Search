<?php

namespace Havvg\Component\Search\Result;

class ResultCollection implements \Iterator, \Countable
{
    /**
     * @var ResultInterface[]
     */
    protected $results = array();

    /**
     * Add another result to this collection.
     *
     * @param ResultInterface $result
     *
     * @return ResultCollection
     */
    public function add(ResultInterface $result)
    {
        $this->results[] = $result;

        return $this;
    }

    /**
     * Filter the currect set of results by the given scope.
     *
     * @param ScopeInterface $scope
     *
     * @return ResultCollection|ResultInterface[]
     */
    public function filter(ScopeInterface $scope)
    {
        $filtered = new self;

        foreach ($this as $eachResult) {
            /* @var $eachResult ResultInterface */
            if ($eachResult->getScope()->isEqualTo($scope)) {
                $filtered->add($eachResult);
            }
        }

        return $filtered;
    }

    // Iterator implementation

    public function current()
    {
        return current($this->results);
    }

    public function next()
    {
        next($this->results);
    }

    public function key()
    {
        return key($this->results);
    }

    public function valid()
    {
        return isset($this->results[$this->key()]);
    }

    public function rewind()
    {
        reset($this->results);
    }

    // Countable implementation

    public function count()
    {
        return count($this->results);
    }
}
