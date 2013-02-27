<?php

namespace Desk\Tests\Cases\Model;

use Desk\Cases\Model\CaseModel;

class CaseModelTest extends \Desk\Testing\UnitTestCase
{

    public function testFromData()
    {
        $case = CaseModel::fromData(array('foo' => 'bar'));
        $this->assertInstanceOf('Desk\\Cases\\Model\\CaseModel', $case);
        $this->assertSame('bar', $case->get('foo'));
    }
}
