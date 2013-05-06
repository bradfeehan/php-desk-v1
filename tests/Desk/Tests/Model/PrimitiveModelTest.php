<?php

namespace Desk\Model;

use Desk\Model\PrimitiveModel;

class PrimitiveModelTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Model\PrimitiveModel::factory()
     */
    public function testFactory()
    {
        $this->assertSame($this->model()->factory('foo'), 'foo');
    }

    private function model()
    {
        return \Mockery::mock('Desk\\Model\\PrimitiveModel[getResponseKeyFor]')
            ->shouldReceive('getResponseKeyFor')
            ->andReturn(null)
            ->byDefault()
            ->mock();
    }
}
