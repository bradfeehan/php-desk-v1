<?php

namespace Desk\Tests\Model;

use Desk\Model\ResponseKeyMapModel;

class ResponseKeyMapModelTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Model\ResponseKeyMapModel::getResponseKeyFor
     * @expectedException Desk\Exception\UnexpectedValueException
     */
    public function testGetResponseKeyForThrowsExceptionForUnknownCommand()
    {
        $model = \Mockery::mock('Desk\\Model\\ResponseKeyMapModel[getResponseKeyMap]')
            ->shouldReceive('getResponseKeyMap')
                ->andReturn(array('barCommand' => 'path/to/response'))
            ->shouldReceive('getResponseKeyFor')
                ->passthru()
            ->mock();

        $model->getResponseKeyFor('notBarCommand');
    }
}
