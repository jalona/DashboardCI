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
     * Add the authentication on all curl queries
     */
    public function addAuthentication();

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
