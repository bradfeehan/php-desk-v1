<?php

namespace Desk\Tests;

use Desk\AbstractModel;

class AbstractModelTest extends \Desk\Testing\UnitTestCase
{

    /**
     * Tests valid calls to Desk\AbstractModel::getResponseKey()
     *
     * @covers Desk\AbstractModel::getResponseKey
     * @dataProvider dataGetResponseKeyValid
     */
    public function testGetResponseKeyValid($content, $key, $expected)
    {
        $response = $this->mockResponse($content);
        $actual = AbstractModel::getResponseKey($response, $key);
        $this->assertSame($expected, $actual);
    }

    public function dataGetResponseKeyValid()
    {
        return array(
            array(array('foo' => 'bar'), 'foo', 'bar'),
            array(array('foo' => array('bar' => 'baz')), 'foo/bar', 'baz'),
            array(array('foo' => array('bar' => array('baz' => 'quux'))), 'foo/bar/baz', 'quux'),
            array(array('foo' => array('bar' => array('baz' => 'quux'))), 'foo/bar', array('baz' => 'quux')),
        );
    }

    private function mockResponse($content)
    {
        $class = 'Guzzle\\Http\\Message\\Response';
        return \Mockery::mock(
            $class,
            array('json' => $content, 'getBody' => json_encode($content))
        );
    }

    /**
     * Tests invalid calls to Desk\AbstractModel::getResponseKey()
     *
     * @covers Desk\AbstractModel::getResponseKey
     * @dataProvider dataGetResponseKeyInvalid
     * @expectedException Desk\Exception\ResponseFormatException
     */
    public function testGetResponseKeyInvalid($content, $key)
    {
        $response = $this->mockResponse($content);
        AbstractModel::getResponseKey($response, $key);
    }

    public function dataGetResponseKeyInvalid()
    {
        return array(
            array(array('foo' => 'bar'), 'nonexistent_key'),
            array(array('foo' => array('bar' => 'baz')), 'foo/baz'),
        );
    }
}
