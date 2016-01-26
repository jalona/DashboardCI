<?php

namespace MB\DashboardBundle\Model\Connector;

use MB\DashboardBundle\Model\Connector\BaseConnector;
use MB\DashboardBundle\Model\Project\SourceProjectInterface;
use MB\DashboardBundle\Model\Group\SourceGroupInterface;
use MB\DashboardBundle\Model\Commit\CommitInterface;

class StashConnector extends BaseConnector
{
    protected $username;
    protected $password;

    public function __construct($name, $host, $username, $password)
    {
        $this->type = 'stash';

        $this->name = $name;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::getGroupId()
     */
    public function getGroupId(\stdClass $project)
    {
        return $project->project->id;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::getCommitId()
     */
    public function getCommitId(\stdClass $commit)
    {
        return $commit->id;
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
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::importProject()
     */
    public function importProject(SourceProjectInterface $project)
    {
        /*
         * We need to list all projects since the stash API require to use the group identifier
         * in the url and we cannot assume that the group doesn't changed it name between the previous
         * sync and now. So we browse all project to find the matching one.
         */
        $projects = $this->importAllProjects();
        foreach ($projects as $rawProject) {
            if ($rawProject->id == $project->getSourceId()) {
                return $rawProject;
            }
        }
        return null;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::importAllCommits()
     */
    public function importAllCommits(SourceProjectInterface $project)
    {
        $commits = array();

        // Get all commits
        $startIndex = 0;
        do {
            $this->paramsGet['start'] = $startIndex;
            $result = json_decode($this->execute('/rest/api/1.0/projects/' . $project->getSourceGroup()->getPath() . '/repos/' . $project->getSourcePath() . '/commits'));

            if (isset($result->errors)) {
                return array();
                } else {

                $commits = array_merge($commits, $result->values);

                if (!$result->isLastPage) {
                    $startIndex = $result->nextPageStart;
                } else {
                    $startIndex = 0;
                }
            }

        } while ($startIndex > 0);

        return $commits;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::addAuthentication()
     */
    public function addAuthentication()
    {
        $chain = $this->username . ':' . $this->password;

        $this->headers[] = 'Authorization: Basic ' . base64_encode($chain);
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::fillGroup()
     */
    public function fillGroup(SourceGroupInterface $group, \stdClass $data)
    {
        $group->setSourceId($data->project->id);
        $group->setSourceConnectorIdentifier($this->getName());
        $group->setTitle($data->project->name);
        $group->setUrl($this->host . $data->project->link->url);
        $group->setPath($data->project->key);

        return $group;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::fillProject()
     */
    public function fillProject(SourceProjectInterface $project, \stdClass $data, SourceGroupInterface $sourceGroup = null)
    {
        $project->setSourceId($data->id);
        $project->setSourceConnectorIdentifier($this->getName());
        if ($sourceGroup) {
            $project->setSourceGroup($sourceGroup);
            $sourceGroup->addProject($project);
        }
        $project->setSourceTitle($data->name);
        $project->setSourceUrl($this->host .  $data->link->url);
        $project->setSourceDescription( (isset($data->project->description) ? $data->project->description : null) );
        $project->setSourcePath($data->slug);

        return $project;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::fillCommit()
     */
    public function fillCommit(CommitInterface $commit, \stdClass $data, SourceProjectInterface $project)
    {
        $commit->setSourceId($data->id);
        $commit->setAuthorEmail($data->author->emailAddress);
        $commit->setAuthorName( (isset($data->author->displayName) ? $data->author->displayName : $data->author->name) );
        $commit->setHash($data->id);
        $commit->setComment($data->message);
        $commit->setProject($project);
        $commit->setUrl($this->host . '/projects/' . $project->getSourceGroup()->getPath() . '/repos/' . $project->getSourcePath() . '/commits/' . $data->id);
        $datetime = new \DateTime();
        $datetime->setTimestamp($data->authorTimestamp / 1000);
        $commit->setDatetime($datetime);

        return $commit;
    }
}
