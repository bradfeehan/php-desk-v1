<?php

namespace Desk\Tests\Client\Content\Model;

class TopicArrayTest extends \Desk\Testing\ModelArrayTestCase
{

    /**
     * {@inheritdoc}
     */
    protected function getModelName()
    {
        return 'Desk\\Client\\Content\\Model\\TopicArray';
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
                'GetTopics', 2, 'Desk\\Client\\Content\\Model\\TopicModel'
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
