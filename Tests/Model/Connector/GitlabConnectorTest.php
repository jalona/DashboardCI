<?php

namespace MB\DashboardBundle\Tests\Service;

use MB\DashboardBundle\Tests\Model\Connector\ConnectorTestInterface;
use MB\DashboardBundle\Service\ServiceConnector;

class GitlabConnectorTest extends \PHPUnit_Framework_TestCase implements ConnectorTestInterface
{
    protected $token = 'my_api_token';

    protected $connector;

    public function setUp()
    {
        $config = array(
            'connections' => array(
                'test_gitlab' => array(
                    'type' => 'gitlab',
                    'host' => 'https://my-gitlab.com',
                    'api_token' => $this->token
                )
            )
        );

        $serviceConnector = new ServiceConnector($config);

        $this->connector = $serviceConnector->getConnection('test_gitlab');
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
        $this->assertEquals('PRIVATE-TOKEN: ' . $this->token, $headers[0]);
    }
}
