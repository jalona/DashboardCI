<?php

namespace MB\DashboardBundle\Manager;

use MB\DashboardBundle\Service\ServiceConnector;
use MB\DashboardBundle\Repository\ProjectRepository;
use Doctrine\ORM\EntityManager;
use MB\DashboardBundle\Entity\Project;
use MB\DashboardBundle\Exception\ConnectorNotFoundException;
use MB\DashboardBundle\Repository\SourceGroupRepository;
use MB\DashboardBundle\Entity\SourceGroup;
use MB\DashboardBundle\Repository\CommitRepository;
use MB\DashboardBundle\Entity\Commit;
use MB\DashboardBundle\Model\Project\SourceProjectInterface;

class ProjectManager
{
    protected $em;
    protected $sourceGroupRepo;
    protected $projectRepo;
    protected $commitRepo;
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

    public function __construct(EntityManager $em, SourceGroupRepository $sourceGroupRepo, ProjectRepository $projectRepo, CommitRepository $commitRepo, ServiceConnector $connections)
    {
        $this->em = $em;
        $this->sourceGroupRepo = $sourceGroupRepo;
        $this->projectRepo = $projectRepo;
        $this->commitRepo = $commitRepo;
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
        $projects = array();

        foreach ($this->connections as $connect)
        {
            /* @var $connect \MB\DashboardBundle\Model\Connector\ConnectorInterface */

            $rows = $connect->importAllProjects();
            foreach ($rows as $row)
            {
                $sourceGroup = null;
                $project = null;
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
                $sourceGroup = $this->sourceGroupRepo->findOneBy(array('sourceId' => $connect->getGroupId($row), $connectorIdentifier => $connect->getName()));
                $key = $connect->getName() . '-' . $connect->getGroupId($row);
                if (!$sourceGroup) {
                    if (isset($groups[$key])) {
                        $sourceGroup = $groups[$key];
                    } else {
                        $sourceGroup = new SourceGroup();
                    }
                }
                $sourceGroup = $connect->fillGroup($sourceGroup, $row);
                $groups[$key] = $sourceGroup;
                $this->em->persist($sourceGroup);

                // Get the project, create if doesn't exists, fill/update and store
                $project = $this->projectRepo->findOneBy(array($fieldId => $connect->getProjectId($row), $connectorIdentifier => $connect->getName()));
                $key = $connect->getName() . '-' . $connect->getProjectId($row);
                if (!$project) {
                    $project = new Project();
                }
                $project = $connect->fillProject($project, $row, $sourceGroup);
                $projects[$key] = $project;
                $this->em->persist($project);
            }
        }

        $this->em->flush();

        foreach ($projects as $project) {
            $connect = $this->connections[$project->getSourceConnectorIdentifier()];
            if (in_array($connect->getType(), static::getSourceConnectorTypes())) {
                $commits = $connect->importAllCommits($project);
                foreach ($commits as $rawCommit) {
                    $commit = $this->commitRepo->findOneBy(array('sourceId' => $connect->getCommitId($rawCommit), 'project' => $project));
                    if (!$commit) {
                        $commit = new Commit();
                    }
                    $commit = $connect->fillCommit($commit, $rawCommit, $project);
                    $this->em->persist($commit);
                }
            }
        }

        $this->em->flush();
    }

    /**
     * Import the given project and include the commits if asked to (can be used to refresh an existing project too)
     *
     * @throws \Exception
     */
    public function importProject(SourceProjectInterface $project, $includeCommits = false)
    {
        if (!isset($this->connections[$project->getSourceConnectorIdentifier()])) {
            throw new \Exception('There is no configurer connector for the given identifier : "' . $project->getSourceConnectorIdentifier() . '"');
        } else {
            $connect = $this->connections[$project->getSourceConnectorIdentifier()];
        }

        /* @var $connect \MB\DashboardBundle\Model\Connector\ConnectorInterface */

        $rawProject = $connect->importProject($project);

        // Get the source group, create if doesn't exists, fill/update and store
        $sourceGroup = $this->sourceGroupRepo->findOneBy(array('sourceId' => $connect->getGroupId($rawProject), 'sourceConnectorIdentifier' => $connect->getName()));

        if (!$sourceGroup) {
            $sourceGroup = new SourceGroup();
        }

        $sourceGroup = $connect->fillGroup($sourceGroup, $rawProject);
        $sourceGroup = $connect->fillGroup($sourceGroup, $rawProject);
        $this->em->persist($sourceGroup);

        $project = $this->projectRepo->findOneBy(array('sourceId' => $connect->getProjectId($rawProject), 'sourceConnectorIdentifier' => $connect->getName()));

        if (!$project) {
            $project = new Project();
        }
        $project = $connect->fillProject($project, $rawProject, $sourceGroup);
        $this->em->persist($project);

        $this->em->flush();

        if ($includeCommits) {
            $commits = $connect->importAllCommits($project);
            foreach ($commits as $rawCommit) {
                $commit = $this->commitRepo->findOneBy(array('sourceId' => $connect->getCommitId($rawCommit), 'project' => $project));
                if (!$commit) {
                    $commit = new Commit();
                }
                $commit = $connect->fillCommit($commit, $rawCommit, $project);
                $this->em->persist($commit);
            }
            $this->em->flush();
        }
    }
}
