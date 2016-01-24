<?php

namespace MB\DashboardBundle\Tests\Service;

use MB\DashboardBundle\Tests\Model\Connector\ConnectorTestInterface;
use MB\DashboardBundle\Service\ServiceConnector;

class StashConnectorTest extends \PHPUnit_Framework_TestCase implements ConnectorTestInterface
{
    protected $username = 'my_username';
    protected $password = 'my_password';

    protected $connector;

    public function setUp()
    {
        $config = array(
            'connections' => array(
                'test_stash' => array(
                    'type' => 'stash',
                    'host' => 'https://my-stash.com',
                    'api_username' => $this->username,
                    'api_password' => $this->password
                )
            )
        );

        $serviceConnector = new ServiceConnector($config);

        $this->connector = $serviceConnector->getConnection('test_stash');
    }

    public function tearDown()
    {
        $this->connector = null;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Tests\Model\Connector\ConnectorTestInterface::testAddAuthentication()
     */
    public function testAddAuthentication()
    {
        $this->connector->prepareQuery();

        $headers = $this->connector->getHeaders();

        $this->assertCount(1, $headers);
        $this->assertEquals('Authorization: Basic ' . base64_encode($this->username . ':' . $this->password), $headers[0]);
    }
}
