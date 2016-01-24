<?php

namespace MB\DashboardBundle\Model\Connector;

use MB\DashboardBundle\Exception\FunctionNotImplementedException;
use MB\DashboardBundle\Model\Project\SourceProjectInterface;
use MB\DashboardBundle\Model\Group\SourceGroupInterface;
use MB\DashboardBundle\Model\Commit\CommitInterface;

abstract class BaseConnector implements ConnectorInterface
{
    protected $name;
    protected $type;

    protected $host;
    protected $ch;
    protected $paramsGet;
    protected $paramsPost;
    protected $headers;
    protected $userAgent;

    public function __construct()
    {
        $this->init();
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::getProjectId()
     */
    public function getProjectId(\stdClass $project)
    {
        return $project->id;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::getGroupId()
     */
    public function getGroupId(\stdClass $project)
    {
        return $project->group->id;
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
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::getName()
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::getType()
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::getParamsGet()
     */
    public function getParamsGet()
    {
        return $this->paramsGet;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::getParamsPost()
     */
    public function getParamsPost()
    {
        return $this->paramsPost;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::getHeaders()
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::getUserAgent()
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    public function init()
    {
        $this->paramsGet = array();
        $this->paramsPost = array();
        $this->headers = array();
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::prepareQuery()
     */
    public function prepareQuery($target = null)
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        $this->addAuthentication();

        if (!empty($this->headers)) {
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        }

        if (!empty($this->paramsGet)) {
            $target = $target . '?' . http_build_query($this->paramsGet);
        }

        if (strlen(trim($this->userAgent)) > 0) {
            curl_setopt($this->ch, CURLOPT_USERAGENT, $this->userAgent);
        }

        curl_setopt($this->ch, CURLOPT_URL, $this->host . $target);
        if (!empty($this->paramsPost)) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($this->paramsPost));
        }
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::execute()
     */
    public function execute($target = null)
    {
        $this->prepareQuery($target);

        $result = curl_exec($this->ch);
        curl_close($this->ch);
        $this->init();
        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::importAllProjects()
     */
    public function importAllProjects()
    {
        throw new FunctionNotImplementedException('importAllProjects');
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::importAllCommits()
     */
    public function importAllCommits(SourceProjectInterface $project)
    {
        throw new FunctionNotImplementedException('importAllCommits');
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::addAuthentication()
     */
    public function addAuthentication()
    {
        throw new FunctionNotImplementedException('addAuthentication');
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::fillProject()
     */
    public function fillProject(SourceProjectInterface $project, \stdClass $data, SourceGroupInterface $sourceGroup = null)
    {
        throw new FunctionNotImplementedException('fillProject');
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::fillGroup()
     */
    public function fillGroup(SourceGroupInterface $group, \stdClass $data)
    {
        throw new FunctionNotImplementedException('fillGroup');
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Connector\ConnectorInterface::fillCommit()
     */
    public function fillCommit(CommitInterface $commit, \stdClass $data, SourceProjectInterface $project)
    {
        throw new FunctionNotImplementedException('fillCommit');
    }
}
