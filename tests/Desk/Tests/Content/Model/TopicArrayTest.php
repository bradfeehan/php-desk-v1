<?php

namespace Desk\Tests\Content\Model;

class TopicArrayTest extends \Desk\Testing\ModelArrayTestCase
{

    /**
     * {@inheritdoc}
     */
    protected function getModelName()
    {
        return 'Desk\\Content\\Model\\TopicArray';
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
                        0 => array('topic' => array('foo' => 'bar')),
                        1 => array('topic' => array('bar' => 'baz')),
                    ),
                ),
                'GetTopics', 2, 'Desk\\Content\\Model\\TopicModel'
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
                'GetTopics'
            ),
        );
    }
}
