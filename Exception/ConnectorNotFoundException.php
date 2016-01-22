<?php

namespace MB\DashboardBundle\Exception;

use MB\DashboardBundle\Model\Connector\IConnector;

class ConnectorNotFoundException extends \Exception
{
    public function __construct(IConnector $connect)
    {
        parent::__construct('The type of connector "' . $connect->getName() . "' does not exists");
    }
}
