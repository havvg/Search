<?php

namespace Havvg\Component\Search\Result;

/**
 * A single search result entry.
 */
interface ResultInterface
{
    /**
     * Return the scope of this result entry.
     *
     * @return ScopeInterface
     */
    public function getScope();

    /**
     * A unique identifier for this result entry.
     *
     * This identifier is only required to be unique within its scope.
     * The same identifier may be set within another scope.
     *
     * It may be an id of a database entry, a name, a url, ..
     *
     * @return mixed
     */
    public function getIdentifier();
}
