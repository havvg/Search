<?php

namespace Havvg\Component\Search\Tests;

use Havvg\Component\Search\Engine\EngineInterface;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param bool $supports
     *
     * @return EngineInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getEngineMock($supports)
    {
        $engine = $this->getMock('Havvg\Component\Search\Engine\EngineInterface');

        $engine
            ->expects($this->exactly($supports ? 2 : 1))
            ->method('supports')
            ->will($this->returnValue($supports))
        ;

        if ($supports) {
            $engine
                ->expects($this->once())
                ->method('search')
                ->will($this->returnValue(array($this->getMock('Havvg\Component\Search\Result\ResultInterface'))))
            ;
        } else {
            $engine
                ->expects($this->never())
                ->method('search')
            ;
        }

        return $engine;
    }

    protected function getResultMock($scope)
    {
        $result = $this->getMock('Havvg\Component\Search\Result\ResultInterface');
        $result
            ->expects($this->any())
            ->method('getScope')
            ->will($this->returnValue($scope))
        ;

        return $result;
    }

    protected function getScopeMock()
    {
        $className = 'Scope_'.mt_rand(10, 1000);
        $scope = $this->getMock('Havvg\Component\Search\Result\ScopeInterface', array(), array(), $className);
        $scope
            ->expects($this->any())
            ->method('isEqualTo')
            ->will($this->returnCallback(function ($scope) use ($className) {
                return get_class($scope) === $className;
            }))
        ;

        return $scope;
    }
}
