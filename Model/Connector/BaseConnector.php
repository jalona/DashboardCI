<?php

namespace MB\DashboardBundle\Model\Connector;

use MB\DashboardBundle\Exception\FunctionNotImplementedException;
abstract class BaseConnector implements IConnector
{
    protected $name;

    protected $host;
    protected $ch;

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\IConnector::getName()
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * ! Do not call this function yourself !
     *
     * Build the curl query which will be used by execute()
     *
     * @param string $target
     */
    protected function prepareQuery($target = null)
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $this->host . $target);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        $this->addAuthentication();
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\IConnector::execute()
     */
    public function execute($target = null)
    {
        $this->prepareQuery($target);
        $result = curl_exec($this->ch);
        curl_close($this->ch);
        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\IConnector::importAllProjects()
     */
    public function importAllProjects()
    {
        throw new FunctionNotImplementedException('importAllProjects');
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\IConnector::addAuthentication()
     */
    public function addAuthentication()
    {
        throw new FunctionNotImplementedException('addAuthentication');
    }
}
