<?php

namespace Desk\Tests;

use Desk\AbstractModel;

class AbstractModelArrayTest extends \Desk\Testing\UnitTestCase
{

    /**
     * Ensure any fiddling with the instance doesn't leak to other tests
     */
    public function tearDown()
    {
        AbstractModel::setInstance();
    }

    /**
     * @covers Desk\AbstractModelArray::factory
     */
    public function testFactory()
    {
        $model = $this->createAbstractMock('Desk\\AbstractModel', array('factory'))
            ->shouldReceive('factory')
                ->with('result1')
                ->andReturn('model1')
            ->shouldReceive('factory')
                ->with('result2')
                ->andReturn('model2')
            ->shouldReceive('factory')
                ->never()
            ->mock();

        $modelName = get_class($model);
        $modelName::setInstance($model);

        $modelArray = $this->createAbstractMock('Desk\\AbstractModelArray');
        $modelArray->shouldReceive(
            array(
                'getModelName' => $modelName,
                'getResultKey' => 'resultKey',
            )
        );

        $data = array(
            array('resultKey' => 'result1'),
            array('resultKey' => 'result2'),
        );

        $results = $modelArray->factory($data);

        $this->assertInternalType('array', $results);
        $this->assertSame(2, count($results));

        $this->assertSame('model1', $results[0]);
        $this->assertSame('model2', $results[1]);
    }
}
