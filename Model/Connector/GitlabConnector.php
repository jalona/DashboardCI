<?php

namespace MB\DashboardBundle\Model\Connector;

use MB\DashboardBundle\Model\Connector\BaseConnector;
use MB\DashboardBundle\Model\Project\ISourceProject;

class GitlabConnector extends BaseConnector
{
    protected $token;

    public function __construct($name, $host, $token)
    {
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
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'PRIVATE-TOKEN: ' . $this->token
        ));
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\IConnector::fillProject()
     */
    public function fillProject(ISourceProject $project, \stdClass $data)
    {
        $project->setSourceId($data->id);
        $project->setSourceConnectorIdentifier($this->getName());
        $project->setSourceUrl($data->web_url);
        $project->setSourceTitle($data->name_with_namespace);
        $project->setSourceDescription($data->description);

        return $project;
    }
}
