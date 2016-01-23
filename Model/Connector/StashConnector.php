<?php

namespace MB\DashboardBundle\Model\Connector;

use MB\DashboardBundle\Model\Connector\BaseConnector;
use MB\DashboardBundle\Model\Project\ISourceProject;

class StashConnector extends BaseConnector
{
    protected $username;
    protected $password;

    public function __construct($name, $host, $username, $password)
    {
        $this->name = $name;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::importAllProjects()
     */
    public function importAllProjects()
    {
        /**
         * Projects are divided like this:
         *      my_project
         *          my_repo_1
         *          my_repo_2
         *          ...
         *
         * So we need to loop into each projects to get all repositories.
         * N.B.: Results are paginated
         */


        $projects = array();
        $repos = array();

        // Get all projects
        $startIndex = 0;
        do {
            $this->paramsGet['start'] = $startIndex;
            $result = json_decode($this->execute('/rest/api/1.0/projects'));

            $projects = array_merge($projects, $result->values);

            if (!$result->isLastPage) {
                $startIndex = $result->nextPageStart;
            } else {
                $startIndex = 0;
            }

        } while ($startIndex > 0);

        // Get all repositories
        foreach ($projects as $project) {
            do {
                $this->paramsGet['start'] = $startIndex;
                $result = json_decode($this->execute('/rest/api/1.0/projects/' . $project->key . '/repos'));

                $repos = array_merge($repos, $result->values);

                if (!$result->isLastPage) {
                    $startIndex = $result->nextPageStart;
                } else {
                    $startIndex = 0;
                }

            } while ($startIndex > 0);
        }

        return $repos;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::addAuthentication()
     */
    public function addAuthentication()
    {
        $chain = $this->username . ':' . $this->password;

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($chain)
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
        $project->setSourceUrl($this->host .  $data->link->url);
        $project->setSourceTitle($data->project->name . '/' . $data->name);
        $project->setSourceDescription( (isset($data->project->description) ? $data->project->description : null) );

        return $project;
    }
}
