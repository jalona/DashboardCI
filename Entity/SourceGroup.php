<?php

namespace MB\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MB\DashboardBundle\Model\Group\SourceGroupInterface;

/**
 * SGroup
 *
 * @ORM\Table(name="source_group")
 * @ORM\Entity(repositoryClass="MB\DashboardBundle\Repository\SourceGroupRepository")
 */
class SourceGroup implements SourceGroupInterface
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
     * @var string
     *
     * @ORM\Column(name="sourceConnectorIdentifier", type="string", length=255)
     */
    private $sourceConnectorIdentifier;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="MB\DashboardBundle\Entity\Project", mappedBy="sourceGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projects;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /*
     * Implementing \MB\DashboardBundle\Model\Group\SourceGroupInterface
     */

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceGroupInterface::setSourceId()
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceGroupInterface::getSourceId()
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceGroupInterface::setSourceConnectorIdentifier()
     */
    public function setSourceConnectorIdentifier($sourceConnectorIdentifier)
    {
        $this->sourceConnectorIdentifier = $sourceConnectorIdentifier;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceGroupInterface::getSourceConnectorIdentifier()
     */
    public function getSourceConnectorIdentifier()
    {
        return $this->sourceConnectorIdentifier;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceGroupInterface::setTitle()
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceGroupInterface::getTitle()
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceGroupInterface::setUrl()
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceGroupInterface::getUrl()
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceGroupInterface::addProject()
     */
    public function addProject(\MB\DashboardBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceGroupInterface::removeProject()
     */
    public function removeProject(\MB\DashboardBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\SourceGroupInterface::getprojects()
     */
    public function getprojects()
    {
        return $this->projects;
    }
}

