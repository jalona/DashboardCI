<?php

namespace MB\DashboardBundle\Model\Connector;

use MB\DashboardBundle\Model\Connector\BaseConnector;
use MB\DashboardBundle\Model\Project\SourceProjectInterface;

class GitlabConnector extends BaseConnector
{
    protected $token;

    public function __construct($name, $host, $token)
    {
        $this->type = 'gitlab';

        $this->name = $name;
        $this->host = $host;
        $this->token = $token;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::importAllProjects()
     */
    public function importAllProjects()
    {
        return json_decode($this->execute('/api/v3/projects'));
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::addAuthentication()
     */
    public function addAuthentication()
    {
        $this->headers[] = 'PRIVATE-TOKEN: ' . $this->token;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::fillProject()
     */
    public function fillProject(SourceProjectInterface $project, \stdClass $data)
    {
        $project->setSourceId($data->id);
        $project->setSourceConnectorIdentifier($this->getName());
        $project->setSourceGroupTitle($data->namespace->name);
        $project->setSourceGroupUrl($this->host . '/' . $data->namespace->path);
        $project->setSourceTitle($data->path);
        $project->setSourceUrl($data->web_url);
        $project->setSourceDescription($data->description);

        return $project;
    }
}
