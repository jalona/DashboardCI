<?php

namespace MB\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use MB\DashboardBundle\Entity\Dashboard;
use MB\DashboardBundle\Form\Type\DashboardType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

class DashboardController extends Controller
{
    public function listAction()
    {
        $dashbboards = $this->getDoctrine()->getRepository('MBDashboardBundle:Dashboard')->findAll();

        return $this->render('MBDashboardBundle:Dashboard:list.html.twig',
            array(
                'dashboards' => $dashbboards
            )
        );
    }

    public function addAction(Request $request)
    {
        $projects = $this->getDoctrine()->getRepository('MBDashboardBundle:Project')->findAll();

        $dashboard = new Dashboard();

        $form = $this->createForm(DashboardType::class, $dashboard, array('projects' => $projects));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $dashboard->setConfig($this->getFormConfig($form, $projects));

            $em = $this->getDoctrine()->getManager();
            $em->persist($dashboard);
            $em->flush();

            return $this->redirectToRoute('mb_dashboard_list_dashboards');
        }

        return $this->render('MBDashboardBundle:Dashboard:edit.html.twig',
            array(
                'form' => $form->createView(),
                'projects' => $projects
            )
        );
    }

    /**
     * @ParamConverter("dashboard", class="MBDashboardBundle:Dashboard")
     */
    public function editAction(Request $request, Dashboard $dashboard)
    {
        $projects = $this->getDoctrine()->getRepository('MBDashboardBundle:Project')->findAll();

        $form = $this->createForm(DashboardType::class, $dashboard, array('projects' => $projects, 'config' => $dashboard->getConfig()));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $dashboards = $this->getDoctrine()->getRepository('MBDashboardBundle:Dashboard')->findAll();

            foreach ($dashboards as $dash) {
                if ($dash->getId() != $dashboard->getId()) {
                    $dash->setHomepage(false);
                    $em->persist($dash);
                }
            }

            $dashboard->setConfig($this->getFormConfig($form, $projects));

            $em->persist($dashboard);

            $em->flush();

            return $this->redirectToRoute('mb_dashboard_list_dashboards');
        }

        return $this->render('MBDashboardBundle:Dashboard:edit.html.twig',
            array(
                'form' => $form->createView(),
                'projects' => $projects
            )
        );
    }

    protected function getFormConfig(Form $form, $projects)
    {
        $form = $form->all();
        $config = array();
        foreach ($projects as $project) {
            $key = 'project_' . $project->getId() . '_show';
            if (isset($form[$key]) && $form[$key]->getViewData() !== null) {
                if (!isset($config[$project->getId()])) {
                    $config[$project->getId()] = array('id' => $project->getId());
                }

                $key = 'project_' . $project->getId() . '_commits';
                if (isset($form[$key]) && $form[$key]->getViewData()) {
                    $config[$project->getId()]['commits'] = true;
                }
                $key = 'project_' . $project->getId() . '_order';
                if (isset($form[$key]) && $form[$key]->getViewData() !== null) {
                    $config[$project->getId()]['order'] = intval($form[$key]->getViewData(), 10);
                }
            }
        }
        return $config;
    }
}
