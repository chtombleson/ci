<?php

use CI\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $config = new Config(dirname(__DIR__) . '/_config.yml');

        $this->assertInstanceOf('CI\Config', $config);
    }

    public function testToArray()
    {
        $config = new Config(dirname(__DIR__) . '/_config.yml');

        $conf = [
            'test' => [
                'hello' => 'world',
                'stuff' => [
                    'crazy' => 'hi',
                    'left' => [
                        'swt' => 'dude',
                        'epic' => 'man',
                    ],
                ],
            ]
        ];

        $this->assertEquals($config->toArray(), $conf);
    }

    public function testGet()
    {
        $config = new Config(dirname(__DIR__) . '/_config.yml');

        $this->assertTrue(is_array($config->get('test')));
        $this->assertTrue(is_string($config->get('test.hello')));
        $this->assertTrue(is_string($config->get('test.stuff.crazy')));
        $this->assertTrue(is_array($config->get('test.stuff.left')));
        $this->assertTrue(is_string($config->get('test.stuff.left.swt')));
        $this->assertTrue(is_string($config->get('test.stuff.left.epic')));
    }
}
