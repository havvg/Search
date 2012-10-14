<?php

namespace Havvg\Component\Search\Tests\Engine;

use Havvg\Component\Search\Tests\AbstractTest;

use Havvg\Component\Search\Engine\ChainEngine;

/**
 * @covers Havvg\Component\Search\Engine\ChainEngine
 */
class ChainEngineTest extends AbstractTest
{
    public function testInvalidEngine()
    {
        $this->setExpectedException('Havvg\Component\Search\Exception\InvalidArgumentException');
        new ChainEngine(array('foo'));
    }

    public function testConstructWithoutEngines()
    {
        return new ChainEngine();
    }

    /**
     * @depends testConstructWithoutEngines
     */
    public function testNoEnginesSupportNothing(ChainEngine $engine)
    {
        $this->assertFalse($engine->supports('foo'));
        $this->assertCount(0, $engine->search('foo'));
    }

    public function testQueryWithSupportingEngine()
    {
        $engine = new ChainEngine();
        $engine->addEngine($this->getEngineMock(true));

        $this->assertTrue($engine->supports('foo'));
        $this->assertInstanceOf('Havvg\Component\Search\Result\ResultCollection', $result = $engine->search('foo'));
        $this->assertCount(1, $result);
    }

    public function testQueryWithSupportingAndNotSupportingEngine()
    {
        $engine = new ChainEngine();
        $engine
            ->addEngine($this->getEngineMock(true))
            ->addEngine($this->getEngineMock(false))
        ;

        $this->assertTrue($engine->supports('foo'));
        $this->assertInstanceOf('Havvg\Component\Search\Result\ResultCollection', $result = $engine->search('foo'));
        $this->assertCount(1, $result);
    }

    public function testQueryInvalidResult()
    {
        $invalid = $this->getMock('Havvg\Component\Search\Engine\EngineInterface');
        $invalid
            ->expects($this->once())
            ->method('supports')
            ->will($this->returnValue(true))
        ;
        $invalid
            ->expects($this->once())
            ->method('search')
            ->will($this->returnValue('bar'))
        ;

        $engine = new ChainEngine(array($invalid));

        $this->setExpectedException('Havvg\Component\Search\Exception\DomainException');

        $engine->search('foo');
    }
}
