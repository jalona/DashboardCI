<?php

namespace MB\DashboardBundle\Model\Connector;

use MB\DashboardBundle\Model\Connector\BaseConnector;
use MB\DashboardBundle\Model\Project\SourceProjectInterface;
use MB\DashboardBundle\Model\Group\SourceGroupInterface;
use MB\DashboardBundle\Model\Commit\CommitInterface;

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
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::getGroupId()
     */
    public function getGroupId(\stdClass $project)
    {
        return $project->owner->id;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::getCommitId()
     */
    public function getCommitId(\stdClass $commit)
    {
        return $commit->sha;
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
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::importAllCommits()
     */
    public function importAllCommits(SourceProjectInterface $project)
    {
        $result = json_decode($this->execute('/repos/' . $project->getSourceGroup()->getPath() . '/' . $project->getSourcePath() . '/commits'));
        if (isset($result->message)) {
            return array();
        } else {
            return $result;
        }
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
     * @see \MB\DashboardBundle\Model\Connector\BaseConnector::fillGroup()
     */
    public function fillGroup(SourceGroupInterface $group, \stdClass $data)
    {
        $group->setSourceId($data->owner->id);
        $group->setSourceConnectorIdentifier($this->getName());
        $group->setTitle($data->owner->login);
        $group->setUrl($data->owner->html_url);
        $group->setPath($data->owner->login);

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
        $project->setSourceUrl($data->html_url);
        $project->setSourceDescription($data->description);
        $project->setSourcePath($data->name);

        return $project;
   }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::fillCommit()
     */
    public function fillCommit(CommitInterface $commit, \stdClass $data, SourceProjectInterface $project)
    {
        $commit->setSourceId($data->sha);
        $commit->setAuthorEmail($data->commit->author->email);
        $commit->setAuthorName($data->commit->author->name);
        $commit->setHash($data->sha);
        $commit->setComment($data->commit->message);
        $commit->setProject($project);
        $commit->setUrl($data->html_url);

        return $commit;
    }
}
