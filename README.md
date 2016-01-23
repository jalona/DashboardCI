__/!\ UNDER DEVELOPMENT /!\__

__/!\ DO NOT USE THIS PROJECT /!\__

No, seriously. This is not even an alpha version, so please, wait.

---

# MB/Dashboard

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8bb5c589-f848-453f-b319-da61176da107/big.png)](https://insight.sensiolabs.com/projects/8bb5c589-f848-453f-b319-da61176da107)

## Introduction
MBDashboard is a Symfony 3 bundle which provide integration and communication with some famous development code hosting and continuous integration tools.

The actual list of supported tools is:

| Code hosting | Status      | Configuration key |
|--------------|-------------|-------------------|
| GitLab       | Working on  | gitlab            |
| GitHub       | Working on  | github            |
| Stash        | Working on  | stash             |

| Continuous integration | Status      | Configuration key |
|------------------------|-------------|-------------------|
| GitLab-CI              | Coming soon | gitlabci          |
| Bamboo                 | Coming soon | bamboo            |
| Jenkins                | Coming soon | jenkins           |

## Features
### 1. Multi sources
You can configure as much tool access as you want, allowing you to monitor some projects on GitHub as well as some projects on Stash, at the same time and on the same screen.

Example :

```YML
mb_dashboard:
    connections:

        # code hosting
        my_gitlab:    { type: 'gitlab',   host: 'https://my-gitlab.com',   api_token: 'abcd1234' }
        my_github:    { type: 'github',   host: 'https://api.github.com',  api_token: '1234abcd' }
        my_stash:     { type: 'stash',    host: 'https://my-stash.com'     api_username: 'my_username', api_password: 'my_password' }

        # continuous integration
        my_gitlab_ci: { type: 'gitlabci', host: 'https://my-gitlabci.com', api_token: '1a2b3c4d' }
        my_bamboo:    { type: 'bamboo',   host: 'https://my-bamboo.com',   api_username: 'my_username', api_password: 'my_password' }
```

### 2. API
The DashboardBundle is able to communicate with all the tools listed previously, through the sames fonctions, no matter the type of destination tool. This allow to develop a custom dashboard easily without having to think if the code hosting tool is GitLab or Stash or anything else. Just go straight to the goal.

Example :

```PHP
/* @var $manager \MB\DashboardBundle\Manager\ProjectManager */
$manager = $this->get('mb_dashboard.project_manager');

$project = $this->getDoctrine()->getRepository('MBDashboardBundle:Project')->find(1);

$manager->refresh($project);
```

As simple as this. You don't have to care which remote service is used or which url you should call. We do it ourself internally. Just use the functions provided by the ```MB\DashboardBundle\Model\Connector\IConnector``` interface and rock your dashboard !

### 3. Hooks (coming soon)
If you don't want the run a synchronizing task which will perform a lot of queries on the remote tools, you can configure hooks on these services to update the dashboard in live.

Just configure the webhooks on the tools to call one of these URLs:

- /api/gitlab
- /api/github
- /api/stash
- /api/gitlabci
- /api/bamboo
- /api/jenkins

## 4. Actions (coming soon)
The Dashboard bundle does not only read information from remote tools, but it can interact with them too.

Examples:

```PHP
/* @var $manager \MB\DashboardBundle\Manager\ProjectManager */
$manager = $this->get('mb_dashboard.project_manager');

$project = $this->getDoctrine()->getRepository('MBDashboardBundle:Project')->find(1);

// Run the test units on the remote tool (eg: GitLab-CI)
$manager->performBuild($project);
```

```PHP
/* @var $manager \MB\DashboardBundle\Manager\ProjectManager */
$manager = $this->get('mb_dashboard.project_manager');

$project = $this->getDoctrine()->getRepository('MBDashboardBundle:Project')->find(1);

// Deploy the project from the remote tool to the selected deployment target (eg: Bamboo)
$deployments = $project->getDeploymentTargets();

$manager->deploy($project, $deployments['staging']);
```
