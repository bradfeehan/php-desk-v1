<?php

namespace Desk\Tests\Client\Cases\Model;

class CaseArrayTest extends \Desk\Testing\ModelArrayTestCase
{

    /**
     * {@inheritdoc}
     */
    protected function getModelName()
    {
        return 'Desk\\Client\\Cases\\Model\\CaseArray';
    }

    /**
     * {@inheritdoc}
     */
    public function dataSystem()
    {
        return array(
            array(
                array(
                    'results' => array(
                        0 => array('case' => array('foo' => 'bar')),
                        1 => array('case' => array('bar' => 'baz')),
                    ),
                ),
                'GetCases', 2, 'Desk\\Client\\Cases\\Model\\CaseModel'
            ),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function dataSystemInvalid()
    {
        return array(
            array(
                array('foo' => 'bar'),
                'GetCases'
            ),
        );
    }
}
