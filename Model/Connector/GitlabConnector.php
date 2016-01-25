<?php

namespace MB\DashboardBundle\Model\Connector;

use MB\DashboardBundle\Model\Connector\BaseConnector;
use MB\DashboardBundle\Model\Project\SourceProjectInterface;
use MB\DashboardBundle\Model\Group\SourceGroupInterface;
use MB\DashboardBundle\Model\Commit\CommitInterface;

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
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::getGroupId()
     */
    public function getGroupId(\stdClass $project)
    {
        return $project->namespace->id;
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
        return json_decode($this->execute('/api/v3/projects'));
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::importAllCommits()
     */
    public function importAllCommits(SourceProjectInterface $project)
    {
        return json_decode($this->execute('/api/v3/projects/' . $project->getSourceId() . '/repository/commits'));
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
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::fillGroup()
     */
    public function fillGroup(SourceGroupInterface $group, \stdClass $data)
    {
        $group->setSourceId($data->namespace->id);
        $group->setSourceConnectorIdentifier($this->getName());
        $group->setTitle($data->namespace->name);
        $group->setUrl($this->host . '/' .  $data->namespace->path);
        $group->setPath($data->namespace->path);

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
        $project->setSourceTitle($data->path);
        $project->setSourceUrl($data->web_url);
        $project->setSourceDescription($data->description);
        $project->setSourcePath($data->path);

        return $project;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::fillCommit()
     */
    public function fillCommit(CommitInterface $commit, \stdClass $data, SourceProjectInterface $project)
    {
        $commit->setSourceId($data->id);
        $commit->setAuthorEmail($data->author_email);
        $commit->setAuthorName($data->author_name);
        $commit->setHash($data->id);
        $commit->setComment($data->message);
        $commit->setProject($project);
        $commit->setUrl($project->getSourceUrl() . '/commit/' .  $data->id);
        $datetime = substr($data->created_at, 0, 19) . substr($data->created_at, -6);
        dump($data->created_at);
        dump($datetime);
        $commit->setDatetime(\DateTime::createFromFormat(\DateTime::ISO8601, $datetime));

        return $commit;
    }
}
