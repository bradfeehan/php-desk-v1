<?php

namespace Desk\Tests\Model;

use Desk\Model\AbstractModel;
use Desk\Model\ResponseKeyMapModelArray;

class ResponseKeyMapModelArrayTest extends \Desk\Testing\UnitTestCase
{

    /**
     * Ensure any fiddling with the instance doesn't leak to other tests
     */
    public function tearDown()
    {
        AbstractModel::setInstance();
    }

    /**
     * @covers Desk\Model\ResponseKeyMapModelArray::factory
     */
    public function testFactory()
    {
        $model = $this->createAbstractMock('Desk\\Model\\AbstractModel', array('factory'))
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

        $modelArray = $this->createAbstractMock('Desk\\Model\\ResponseKeyMapModelArray');
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
