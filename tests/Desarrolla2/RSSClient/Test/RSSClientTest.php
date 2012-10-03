<?php

/**
 * This file is part of the RSSClient proyect.
 * 
 * Copyright (c)
 * Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * 
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\RSSClient\Test;

use Desarrolla2\RSSClient\RSSClient;
use Desarrolla2\RSSClient\Sanitizer\Sanitizer;
/**
 * 
 * Description of RSSClientTest
 *
 * @author : Daniel González <daniel.gonzalez@freelancemadrid.es> 
 * @file : RSSClientTest.php , UTF-8
 * @date : Oct 3, 2012 , 10:50:37 AM
 */
class RSSClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Desarrolla2\Bundle\RSSClientBundle\Service\RSSClient;
     */
    protected $client = null;

    /**
     * @var string
     */
    protected $example_feed = 'http://desarrolla2.com/feed/';

    /**
     * @var string
     */
    protected $example_feed2 = 'http://blog.desarrolla2.com/feed/';

    /**
     * 
     */
    public function setUp()
    {
        $this->client = new RSSClient(new Sanitizer());
    }

    /**
     * 
     * @return type
     */
    public function getDataForFeeds()
    {
        return array(
            array(
                array(
                    $this->example_feed,
                ),
            ),
            array(
                array(
                    $this->example_feed,
                    $this->example_feed,
                ),
            ),
            array(
                array(
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                ),
            ),
            array(
                array(
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                    $this->example_feed,
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getDataForChannels()
    {
        return array(
            array(
                array(
                    'channel1' => array(
                        $this->example_feed,
                    ),
                ),
            ),
            array(
                array(
                    'channel1' => array(
                        $this->example_feed,
                        $this->example_feed,
                    ),
                ),
                array(
                    'channel1' => array(
                        $this->example_feed,
                    ),
                    'channel2' => array(
                        $this->example_feed,
                        $this->example_feed,
                    ),
                ),
            ),
            array(
                array(
                    'channel1' => array(
                        $this->example_feed,
                    ),
                    'channel2' => array(
                        $this->example_feed,
                        $this->example_feed,
                    ),
                    'channel3' => array(
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                        $this->example_feed,
                    ),
                ),
            ),
        );
    }

    /**
     * @test
     * @dataProvider getDataForFeeds
     */
    public function testAddFeed($data)
    {
        $this->client->addFeed($this->example_feed);
        foreach ($data as $feed) {
            $this->client->addFeed($feed);
        }
        $this->assertEquals(count($this->client->getFeeds()), 1);
    }

    /**
     * @test
     * @dataProvider getDataForFeeds
     */
    public function testAddFeeds($data)
    {
        $this->client->addFeed($this->example_feed2);
        $this->client->addFeeds($data);
        $this->client->addFeeds($data);
        $this->assertEquals(count($this->client->getFeeds()), 2);
    }

    /**
     * @test
     * @dataProvider getDataForFeeds
     */
    public function testSetFeeds($data)
    {
        $this->client->addFeed($this->example_feed2);
        $this->client->setFeeds($data);
        $this->assertEquals(count($this->client->getFeeds()), 1);
    }

    /**
     * @test
     * @dataProvider getDataForFeeds
     */
    public function countFeeds($data)
    {
        $this->client->addFeed($this->example_feed2);
        $this->client->addFeeds($data);
        $this->assertEquals($this->client->countFeeds(), 2);
    }

    /**
     * @test
     * @dataProvider getDataForChannels
     */
    public function testCountChannels($data)
    {
        $this->client->setChannels($data);
        $this->assertEquals(count($data), $this->client->countChannels());
    }

    /**
     * @test
     * @dataProvider getDataForChannels
     */
    public function testGetChannels($data)
    {
        $this->client->setChannels($data);
        $this->assertEquals(count($data), count($this->client->getChannels()));
    }

    /**
     * @test
     * @dataProvider getDataForChannels
     */
    public function testGetChannelsNames($data)
    {
        $this->client->setChannels($data);
        $this->assertEquals(array_keys($data), $this->client->getChannelsNames());
    }

    /**
     * @test
     * @dataProvider getDataForChannels
     */
    public function testAddChannels($data)
    {
        $this->client->addChannels(array(
            'test1' => array(
                $this->example_feed,
            ),
        ));
        $this->client->addChannels($data);
        $this->assertEquals((count($data) + 1), $this->client->countChannels());
    }

    /**
     * @test
     * @dataProvider getDataForChannels
     */
    public function testClearChannels($data)
    {
        $this->client->setChannels($data);
        $this->client->setChannels($data);
        $this->assertEquals(count($data), $this->client->countChannels());
    }

}
