<?php

namespace MB\DashboardBundle\Model\Connector;

use MB\DashboardBundle\Model\Project\ISourceProject;
use MB\DashboardBundle\Model\Project\SourceProjectInterface;
interface ConnectorInterface
{
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
     * Fill a given ISourceProject with the given object data
     *
     * @param ISourceProject $project
     * @param \stdClass $data
     *
     * @throws FunctionNotImplementedException
     *
     * @return ISourceProject
     */
    public function fillProject(SourceProjectInterface $project, \stdClass $data);
}
