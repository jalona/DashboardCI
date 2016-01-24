<?php

namespace MB\DashboardBundle\Model\Connector;

use MB\DashboardBundle\Model\Connector\BaseConnector;
use MB\DashboardBundle\Model\Project\SourceProjectInterface;

class GithubConnector extends BaseConnector
{
    protected $token;

    public function __construct($name, $token)
    {
        $this->type = 'github';

        $this->name = $name;
        $this->host = 'https://api.github.com';
        $this->token = $token;
        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::importAllProjects()
     */
    public function importAllProjects()
    {
        return json_decode($this->execute('/user/repos'));
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::addAuthentication()
     */
    public function addAuthentication()
    {
        $this->paramsGet['access_token'] = $this->token;
        $this->userAgent = 'MB/DashboardBundle';
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::fillProject()
     */
    public function fillProject(SourceProjectInterface $project, \stdClass $data)
    {
        $project->setSourceId($data->id);
        $project->setSourceConnectorIdentifier($this->getName());
        $project->setSourceUrl($data->html_url);
        $project->setSourceTitle($data->full_name);
        $project->setSourceDescription($data->description);

        return $project;
    }
}
