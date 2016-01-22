<?php

namespace MB\DashboardBundle\Manager;

use MB\DashboardBundle\Service\ServiceConnector;
use MB\DashboardBundle\Repository\ProjectRepository;
use Doctrine\ORM\EntityManager;
use MB\DashboardBundle\Entity\Project;
use MB\DashboardBundle\Exception\ConnectorNotFoundException;

class ProjectManager
{
    protected $em;
    protected $repo;
    protected $connections;

    /**
     * List all types of source connectors
     *
     * @return array
     */
    public static function getSourceConnectorTypes()
    {
        return array('gitlab', 'github', 'stash');
    }

    /**
     * List all types of Continuous Integration connectors
     *
     * @return array
     */
    public static function getCiConnectorTypes()
    {
        return array('gitlabci', 'bamboo', 'jenkins');
    }

    public function __construct(EntityManager $em, ProjectRepository $repo, ServiceConnector $connections)
    {
        $this->em = $em;
        $this->repo = $repo;
        $this->connections = $connections->getConnections();
    }

    /**
     * Import all projects from connectors and add/update them into the DB
     *
     * @throws ConnectorNotFoundException
     */
    public function importAll()
    {
        foreach ($this->connections as $connect)
        {
            $projects = $connect->importAllProjects();
            foreach ($projects as $project)
            {
                $row = null;
                $fieldId = null;
                $connectorIdentifier = null;
                $fieldTitle = null;

                // Determine which fields we need to use to fetch a row from the DB (source VS CI)
                if (in_array($connect->getName(), static::getSourceConnectorTypes())) {
                    $fieldId = 'sourceId';
                    $connectorIdentifier = 'sourceConnectorIdentifier';
                } else if (in_array($connect->getName(), static::getCiConnectorTypes())) {
                    $fieldId = 'ciId';
                    $connectorIdentifier = 'ciConnectorIdentifier';
                } else {
                    throw new ConnectorNotFoundException($connect);
                }

                // Get the row, create if doesn't exists, fill/update and store
                $row = $this->repo->findOneBy(array($fieldId => $project->id, $connectorIdentifier => $connect->getName()));
                if (!$row) {
                    $row = new Project();
                }
                $row = $connect->fillProject($row, $project);
                $this->em->persist($row);
            }
        }

        $this->em->flush();
    }
}
