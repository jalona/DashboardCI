<?php

namespace MB\DashboardBundle\Service;


use MB\DashboardBundle\Model\Connector\GitlabConnector;
use MB\DashboardBundle\Model\Connector\IConnector;
use MB\DashboardBundle\Model\Connector\GithubConnector;
use MB\DashboardBundle\Model\Connector\StashConnector;

class ServiceConnector
{
    private $connections;

    public function __construct($config)
    {
        $this->connections = array();

        $connections = $config['connections'];

        foreach ($connections as $name => $connection)
        {
            $this->addConnection($name, $connection);
        }
    }

    /**
     * Add a connection to a remote service
     *
     * @param string $name
     * @param array $connection
     * @return \MB\DashboardBundle\Service\ServiceConnector
     */
    private function addConnection($name, $connection)
    {
        switch ($connection['type']) {
            case 'gitlab':
                $this->connections[$name] = new GitlabConnector($name, $connection['host'], $connection['api_token']);
                break;
            case 'github':
                $this->connections[$name] = new GithubConnector($name, $connection['host'], $connection['api_token']);
                break;
            case 'stash':
                $this->connections[$name] = new StashConnector($name, $connection['host'], $connection['api_username'], $connection['api_password']);
                break;
            case 'gitlab-ci':
                break;
            case 'bamboo':
                break;
            default:
                break;
        }

        return $this;
    }

    /**
     * Return the connector with the given name
     *
     * @param string $name
     * @return IConnector|NULL
     */
    public function getConnection($name)
    {
        if (isset($this->connections[$name])) {
            return $this->connections[$name];
        }
        return null;
    }

    /**
     * Return the list of all configured connectors
     *
     * @return array
     */
    public function getConnections()
    {
        return $this->connections;
    }
}
