<?php

namespace MB\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MB\DashboardBundle\Model\Project\ProjectInterface;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="MB\DashboardBundle\Repository\ProjectRepository")
 */
class Project implements ProjectInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="source_id", type="integer", nullable=true)
     */
    private $sourceId;

    /**
     * @var int
     *
     * @ORM\Column(name="ci_id", type="integer", nullable=true)
     */
    private $ciId;

    /**
     * @var string
     *
     * @ORM\Column(name="source_connector_identifier", type="string", length=255, nullable=true)
     */
    private $sourceConnectorIdentifier;

    /**
     * @var string
     *
     * @ORM\Column(name="ci_connector_identifier", type="string", length=255, nullable=true)
     */
    private $ciConnectorIdentifier;

    /**
     * @var string
     *
     * @ORM\Column(name="source_group_title", type="string", length=255, nullable=true)
     */
    private $sourceGroupTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="source_group_url", type="string", length=255, nullable=true)
     */
    private $sourceGroupUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="source_url", type="string", length=255, nullable=true)
     */
    private $sourceUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="ci_url", type="string", length=255, nullable=true)
     */
    private $ciUrl;

    /**
     * @var bool
     *
     * @ORM\Column(name="ci_build_status", type="boolean", nullable=true)
     */
    private $ciBuildStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="ci_build_message", type="string", length=255, nullable=true)
     */
    private $ciBuildMessage;

    /**
     * @var bool
     *
     * @ORM\Column(name="ci_deploy_status", type="boolean", nullable=true)
     */
    private $ciDeployStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="ci_deploy_message", type="string", length=255, nullable=true)
     */
    private $ciDeployMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="source_title", type="string", length=255, nullable=true)
     */
    private $sourceTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="source_description", type="string", length=255, nullable=true)
     */
    private $sourceDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="ci_title", type="string", length=255, nullable=true)
     */
    private $ciTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="ci_description", type="string", length=255, nullable=true)
     */
    private $ciDescription;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /*
     * Implementing \MB\DashboardBundle\Model\Project\SourceProjectInterface
     */

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::setSourceId()
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::getSourceId()
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::setSourceConnectorIdentifier()
     */
    public function setSourceConnectorIdentifier($sourceConnectorIdentifier)
    {
        $this->sourceConnectorIdentifier = $sourceConnectorIdentifier;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::getSourceConnectorIdentifier()
     */
    public function getSourceConnectorIdentifier()
    {
        return $this->sourceConnectorIdentifier;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::setSourceGroupTitle()
     */
    public function setSourceGroupTitle($sourceGroupTitle)
    {
        $this->sourceGroupTitle = $sourceGroupTitle;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::getSourceGroupTitle()
     */
    public function getSourceGroupTitle()
    {
        return $this->sourceGroupTitle;
    }


    public function setSourceGroupUrl($sourceGroupUrl)
    {
        $this->sourceGroupUrl = $sourceGroupUrl;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::getSourceGroupUrl()
     */
    public function getSourceGroupUrl()
    {
        return $this->sourceGroupUrl;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::setSourceUrl()
     */
    public function setSourceUrl($sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::getSourceUrl()
     */
    public function getSourceUrl()
    {
        return $this->sourceUrl;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::setSourceTitle()
     */
    public function setSourceTitle($sourceTitle)
    {
        $this->sourceTitle = $sourceTitle;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::getSourceTitle()
     */
    public function getSourceTitle()
    {
        return $this->sourceTitle;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::setSourceDescription()
     */
    public function setSourceDescription($sourceDescription)
    {
        $this->sourceDescription = $sourceDescription;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceProjectInterface::getSourceDescription()
     */
    public function getSourceDescription()
    {
        return $this->sourceDescription;
    }


    /*
     * Implementing \MB\DashboardBundle\Model\Project\CIProjectInterface
     */

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::setCiId()
     */
    public function setCiId($ciId)
    {
        $this->ciId = $ciId;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::getCiId()
     */
    public function getCiId()
    {
        return $this->ciId;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::setCiConnectorIdentifier()
     */
    public function setCiConnectorIdentifier($ciConnectorIdentifier)
    {
        $this->ciConnectorIdentifier = $ciConnectorIdentifier;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::getCiConnectorIdentifier()
     */
    public function getCiConnectorIdentifier()
    {
        return $this->ciConnectorIdentifier;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::setCiUrl()
     */
    public function setCiUrl($ciUrl)
    {
        $this->ciUrl = $ciUrl;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::getCiUrl()
     */
    public function getCiUrl()
    {
        return $this->ciUrl;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::setCiBuildStatus()
     */
    public function setCiBuildStatus($ciBuildStatus)
    {
        $this->ciBuildStatus = $ciBuildStatus;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::getCiBuildStatus()
     */
    public function getCiBuildStatus()
    {
        return $this->ciBuildStatus;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::setCiBuildMessage()
     */
    public function setCiBuildMessage($ciBuildMessage)
    {
        $this->ciBuildMessage = $ciBuildMessage;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::getCiBuildMessage()
     */
    public function getCiBuildMessage()
    {
        return $this->ciBuildMessage;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::setCiDeployStatus()
     */
    public function setCiDeployStatus($ciDeployStatus)
    {
        $this->ciDeployStatus = $ciDeployStatus;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::getCiDeployStatus()
     */
    public function getCiDeployStatus()
    {
        return $this->ciDeployStatus;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::setCiDeployMessage()
     */
    public function setCiDeployMessage($ciDeployMessage)
    {
        $this->ciDeployMessage = $ciDeployMessage;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::getCiDeployMessage()
     */
    public function getCiDeployMessage()
    {
        return $this->ciDeployMessage;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::setCiTitle()
     */
    public function setCiTitle($ciTitle)
    {
        $this->ciTitle = $ciTitle;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::getCiTitle()
     */
    public function getCiTitle()
    {
        return $this->ciTitle;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::setCiDescription()
     */
    public function setCiDescription($ciDescription)
    {
        $this->ciDescription = $ciDescription;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CIProjectInterface::getCiDescription()
     */
    public function getCiDescription()
    {
        return $this->ciDescription;
    }
}
