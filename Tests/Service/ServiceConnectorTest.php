<?php

namespace MB\DashboardBundle\Tests\Service;

use MB\DashboardBundle\Service\ServiceConnector;

class ServiceConnectorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Try to generate one connection, for github
     */
    public function testGithubConnectorGenerator()
    {
        $config = array(
            'connections' => array(
                'test_github' => array(
                    'type' => 'github',
                    'host' => 'https://api.github.com',
                    'api_token' => 'my_api_token'
                )
            )
        );

        $serviceConnector = new ServiceConnector($config);

        $this->assertCount(1, $serviceConnector->getConnections());

        $connector = $serviceConnector->getConnection('test_github');
        $this->assertNotNull($connector);
        $this->assertEquals('github', $connector->getType());
    }

    /**
     * Try to generate one connection, for gitlab
     */
    public function testGitlabConnectorGenerator()
    {
        $config = array(
            'connections' => array(
                'test_gitlab' => array(
                    'type' => 'gitlab',
                    'host' => 'https://my-gitlab.com',
                    'api_token' => 'my_api_token'
                )
            )
        );

        $serviceConnector = new ServiceConnector($config);

        $this->assertCount(1, $serviceConnector->getConnections());

        $connector = $serviceConnector->getConnection('test_gitlab');
        $this->assertNotNull($connector);
        $this->assertEquals('gitlab', $connector->getType());
    }

    /**
     * Try to generate one connection, for stash
     */
    public function testStashConnectorGenerator()
    {
        $config = array(
            'connections' => array(
                'test_stash' => array(
                    'type' => 'stash',
                    'host' => 'https://my-stash.com',
                    'api_username' => 'my_username',
                    'api_password' => 'my_password'
                )
            )
        );

        $serviceConnector = new ServiceConnector($config);

        $this->assertCount(1, $serviceConnector->getConnections());

        $connector = $serviceConnector->getConnection('test_stash');
        $this->assertNotNull($connector);
        $this->assertEquals('stash', $connector->getType());
    }

    /**
     * Try to generate multiple connections
     */
    public function testMultiConnectorGenerator()
    {
        $config = array(
            'connections' => array(
                'test_github' => array(
                    'type' => 'github',
                    'host' => 'https://api.github.com',
                    'api_token' => 'my_api_token'
                ),
                'test_gitlab' => array(
                    'type' => 'gitlab',
                    'host' => 'https://my-gitlab.com',
                    'api_token' => 'my_api_token'
                ),
                'test_stash' => array(
                    'type' => 'stash',
                    'host' => 'https://my-stash.com',
                    'api_username' => 'my_username',
                    'api_password' => 'my_password'
                )
            )
        );

        $serviceConnector = new ServiceConnector($config);

        $this->assertCount(3, $serviceConnector->getConnections());

        $connector = $serviceConnector->getConnection('test_github');
        $this->assertNotNull($connector);
        $this->assertEquals('github', $connector->getType());

        $connector = $serviceConnector->getConnection('test_gitlab');
        $this->assertNotNull($connector);
        $this->assertEquals('gitlab', $connector->getType());

        $connector = $serviceConnector->getConnection('test_stash');
        $this->assertNotNull($connector);
        $this->assertEquals('stash', $connector->getType());
    }
}
