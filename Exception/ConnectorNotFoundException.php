<?php

namespace MB\DashboardBundle\Exception;

use MB\DashboardBundle\Model\Connector\ConnectorInterface;

class ConnectorNotFoundException extends \Exception
{
    public function __construct(ConnectorInterface $connect)
    {
        parent::__construct('The type of connector "' . $connect->getName() . "' does not exists");
    }
}
