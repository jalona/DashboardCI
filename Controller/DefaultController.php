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
            $repo = $this->getDoctrine()->getRepository('MBDashboardBundle:Project');
            $project = $repo->find($projectId);
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

    public function listAction()
    {
        $repo = $this->getDoctrine()->getRepository('MBDashboardBundle:Project');

        $projects = $repo->findBy(array(), array('sourceConnectorIdentifier' => 'ASC'));

        return $this->render('MBDashboardBundle:Default:list.html.twig', array('projects' => $projects));
    }
}
