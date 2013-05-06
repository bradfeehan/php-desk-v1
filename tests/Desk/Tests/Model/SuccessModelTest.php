<?php

namespace Desk\Tests\Model;

use Desk\Model\SuccessModel;

class SuccessModelTest extends \Desk\Testing\UnitTestCase
{

    /**
     * @covers Desk\Model\SuccessModel::getResponseKeyFor()
     */
    public function testGetResponseKeyFor()
    {
        $responseKey = $this->model()->getResponseKeyFor('foo');
        $this->assertInternalType('string', $responseKey);
    }

    private function model()
    {
        return new SuccessModel();
    }
}
