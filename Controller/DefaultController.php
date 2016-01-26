<?php

namespace MB\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MBDashboardBundle:Default:index.html.twig');
    }

    public function importAction($projectId = null)
    {
        /* @var $manager \MB\DashboardBundle\Manager\ProjectManager */
        $manager = $this->get('mb_dashboard.project_manager');

        if ($projectId !== null) {
            $project = $this->getDoctrine()->getRepository('MBDashboardBundle:Project')->find($projectId);
            if ($project) {
                $manager->importProject($project, true);
            } else {
                $this->createNotFoundException('There is no project associated with the given id');
            }
        } else {
            $manager->importAll();
        }

        return $this->render('MBDashboardBundle:Default:import.html.twig');
    }

    public function listRepositoriesAction($groupId = null)
    {
        $projects = array();
        if ($groupId !== null) {
            $group = $this->getDoctrine()->getRepository('MBDashboardBundle:SourceGroup')->find($groupId);
            if ($group) {
                $projects = $this->getDoctrine()->getRepository('MBDashboardBundle:Project')->findBy(array('sourceGroup' => $group), array('sourceTitle' => 'ASC'));
            } else {
                $this->createNotFoundException('There is no group associated with the given id');
            }
        } else {
            $projects = $this->getDoctrine()->getRepository('MBDashboardBundle:Project')->findBy(array(), array('sourceTitle' => 'ASC'));
        }

        return $this->render('MBDashboardBundle:Default:listRepositories.html.twig', array('projects' => $projects));
    }


    public function listGroupsAction()
    {
        $groups = $this->getDoctrine()->getRepository('MBDashboardBundle:SourceGroup')->findBy(array(), array('sourceConnectorIdentifier' => 'ASC'));

        return $this->render('MBDashboardBundle:Default:listGroups.html.twig', array('groups' => $groups));
    }

    public function listCommitsAction($groupId, $projectId)
    {
        $group = $this->getDoctrine()->getRepository('MBDashboardBundle:SourceGroup')->find($groupId);
        if ($group) {
            $project = $this->getDoctrine()->getRepository('MBDashboardBundle:Project')->findOneBy(array('sourceGroup' => $group, 'id' => $projectId));
            if (!$project) {
                $this->createNotFoundException('There is no project associated with the given id');
            }
        } else {
            $this->createNotFoundException('There is no group associated with the given id');
        }

        return $this->render('MBDashboardBundle:Default:listCommits.html.twig', array('project' => $project));
    }
}
