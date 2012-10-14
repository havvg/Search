<?php

namespace Havvg\Component\Search\Result;

/**
 * A scope defines a set of results.
 *
 * The scope defines the data the result contains.
 * For example a scope may be a set of user profiles, a list of locations, ..
 *
 * Search results within the same scope are of the same ResultInterface.
 */
interface ScopeInterface
{
    /**
     * Check whether this scope equals the given scope.
     *
     * @param ScopeInterface $scope
     *
     * @return bool
     */
    public function isEqualTo(ScopeInterface $scope);
}
