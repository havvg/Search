<?php

namespace Havvg\Component\Search\Tests\Result;

use Havvg\Component\Search\Tests\AbstractTest;

use Havvg\Component\Search\Result\ResultCollection;

/**
 * @covers Havvg\Component\Search\Result\ResultCollection
 */
class ResultCollectionTest extends AbstractTest
{
    public function testFilterEmpty()
    {
        $scopePersons = $this->getScopeMock();

        $collection = new ResultCollection();

        $this->assertCount(0, $collection->filter($scopePersons));
    }

    public function testFilter()
    {
        $scopePersons = $this->getScopeMock();
        $scopeLocations = $this->getScopeMock();

        $arthur = $this->getResultMock($scopePersons);
        $cologne = $this->getResultMock($scopeLocations);

        $collection = new ResultCollection();
        $collection
            ->add($arthur)
            ->add($cologne)
        ;

        $this->assertCount(2, $collection);

        $foundPersons = $collection->filter($scopePersons);
        $this->assertCount(1, $foundPersons);
        $this->assertContains($arthur, $foundPersons);

        $foundLocations = $collection->filter($scopeLocations);
        $this->assertCount(1, $foundLocations);
        $this->assertContains($cologne, $foundLocations);
    }
}
