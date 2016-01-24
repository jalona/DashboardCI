<?php

namespace MB\DashboardBundle\Model\Connector;

use MB\DashboardBundle\Model\Project\SourceProjectInterface;
use MB\DashboardBundle\Model\Group\SourceGroupInterface;
use MB\DashboardBundle\Model\Commit\CommitInterface;
interface ConnectorInterface
{
    /**
     * Return the id of the given project raw data
     *
     * @param \stdClass $project
     * @return integer
     */
    public function getProjectId(\stdClass $project);

    /**
     * Return the id of the given project's group raw data
     *
     * @param \stdClass $project
     * @return integer
     */
    public function getGroupId(\stdClass $project);

    /**
     * Return the id of the given commit raw data
     *
     * @param \stdClass $project
     * @return integer
     */
    public function getCommitId(\stdClass $project);

    /**
     * Return the name of the connector
     *
     * @return string
     */
    public function getName();

    /**
     * Return the type of the connector
     *
     * @return string
     */
    public function getType();

    /**
     * Return the list of parameters to include in the GET query
     *
     * @return array
     */
    public function getParamsGet();

    /**
     * Return the list of parameters to include in the POST query
     *
     * @return array
     */
    public function getParamsPost();

    /**
     * Return the list of headers to include to the HTTP query
     *
     * @return array
     */
    public function getHeaders();

    /**
     * Return the user-agent which will be used for the curl query
     *
     * @return string
     */
    public function getUserAgent();

    /**
     * Add the authentication on all curl queries
     */
    public function addAuthentication();

    /**
     * ! Do not call this function yourself !
     *
     * Build the curl query which will be used by execute()
     *
     * @param string $target
     */
    public function prepareQuery($target = null);

    /**
     * Execute the curl query with the configured host for this connection (config.yml) and the given subpath
     *
     * @param string $target
     * @return mixed
     */
    public function execute($target = null);

    /**
     * Import all projects available with the current connection
     *
     * @throws FunctionNotImplementedException
     *
     * @return array
     */
    public function importAllProjects();

    /**
     * Import all projects available with the current connection
     *
     * @param SourceProjectInterface $project
     *
     * @throws FunctionNotImplementedException
     *
     * @return array
     */
    public function importAllCommits(SourceProjectInterface $project);

    /**
     * Fill a given SourceProjectInterface with the given object data
     *
     * @param SourceProjectInterface $project
     * @param \stdClass $data
     * @param SourceGroupInterface $sourceGroup
     *
     * @throws FunctionNotImplementedException
     *
     * @return SourceProjectInterface
     */
    public function fillProject(SourceProjectInterface $project, \stdClass $data, SourceGroupInterface $sourceGroup = null);

    /**
     * Fill a given SourceGroupInterface with the given object data
     *
     * @param SourceGroupInterface $project
     * @param \stdClass $data
     *
     * @throws FunctionNotImplementedException
     *
     * @return SourceGroupInterface
     */
    public function fillGroup(SourceGroupInterface $group, \stdClass $data);

    /**
     * Fill a given CommitInterface with the given object data
     *
     * @param CommitInterface $commit
     * @param \stdClass $data
     * @param SourceProjectInterface $project
     *
     * @throws FunctionNotImplementedException
     *
     * @return CommitInterface
     */
    public function fillCommit(CommitInterface $commit, \stdClass $data, SourceProjectInterface $project);
}
