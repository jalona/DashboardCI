<?php

namespace MB\DashboardBundle\Tests\Service;

use MB\DashboardBundle\Tests\Model\Connector\ConnectorTestInterface;
use MB\DashboardBundle\Service\ServiceConnector;

class GithubConnectorTest extends \PHPUnit_Framework_TestCase implements ConnectorTestInterface
{
    protected $token = 'my_api_token';

    protected $connector;

    public function setUp()
    {
        $config = array(
            'connections' => array(
                'test_github' => array(
                    'type' => 'github',
                    'host' => 'https://api.github.com',
                    'api_token' => $this->token
                )
            )
        );

        $serviceConnector = new ServiceConnector($config);

        $this->connector = $serviceConnector->getConnection('test_github');
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

        $params = $this->connector->getParamsGet();
        $this->assertCount(1, $params);
        $this->assertEquals($this->token, $params['access_token']);

        $this->assertEquals('MB/DashboardBundle', $this->connector->getUserAgent());
    }
}
