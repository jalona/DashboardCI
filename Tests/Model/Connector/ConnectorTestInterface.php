<?php
namespace MB\DashboardBundle\Tests\Model\Connector;

interface ConnectorTestInterface
{
    /**
     * Test the authentication function depending the type of service used
     */
    public function testAddAuthentication();
}
