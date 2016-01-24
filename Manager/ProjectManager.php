<?php

namespace MB\DashboardBundle\Manager;

use MB\DashboardBundle\Service\ServiceConnector;
use MB\DashboardBundle\Repository\ProjectRepository;
use Doctrine\ORM\EntityManager;
use MB\DashboardBundle\Entity\Project;
use MB\DashboardBundle\Exception\ConnectorNotFoundException;
use MB\DashboardBundle\Repository\SourceGroupRepository;
use MB\DashboardBundle\Entity\SourceGroup;

class ProjectManager
{
    protected $em;
    protected $sourceGroupRepo;
    protected $projectRepo;
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

    public function __construct(EntityManager $em, SourceGroupRepository $sourceGroupRepo, ProjectRepository $projectRepo, ServiceConnector $connections)
    {
        $this->em = $em;
        $this->sourceGroupRepo = $sourceGroupRepo;
        $this->projectRepo = $projectRepo;
        $this->connections = $connections->getConnections();
    }

    /**
     * Import all projects from connectors and add/update them into the DB
     *
     * @throws ConnectorNotFoundException
     */
    public function importAll()
    {
        $groups = array();

        foreach ($this->connections as $connect)
        {
            $projects = $connect->importAllProjects();
            foreach ($projects as $project)
            {
                $sourceGroup = null;
                $row = null;
                $fieldId = null;
                $connectorIdentifier = null;

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

                // Get the source group, create if doesn't exists, fill/update and store
                $sourceGroup = $this->sourceGroupRepo->findOneBy(array('sourceId' => $connect->getGroupId($project), $connectorIdentifier => $connect->getName()));
                $key = $connect->getName() . '-' . $connect->getGroupId($project);
                if (!$sourceGroup) {
                    if (isset($groups[$key])) {
                        $sourceGroup = $groups[$key];
                    } else {
                        $sourceGroup = new SourceGroup();
                    }
                }
                $sourceGroup = $connect->fillGroup($sourceGroup, $project);
                $groups[$key] = $sourceGroup;
                $this->em->persist($sourceGroup);

                // Get the project, create if doesn't exists, fill/update and store
                $row = $this->projectRepo->findOneBy(array($fieldId => $connect->getProjectId($project), $connectorIdentifier => $connect->getName()));
                if (!$row) {
                    $row = new Project();
                }
                $row = $connect->fillProject($row, $project, $sourceGroup);
                $this->em->persist($row);
            }
        }

        $this->em->flush();
    }
}
