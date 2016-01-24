<?php

namespace MB\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MB\DashboardBundle\Model\Commit\CommitInterface;

/**
 * Commit
 *
 * @ORM\Table(name="commit")
 * @ORM\Entity(repositoryClass="MB\DashboardBundle\Repository\CommitRepository")
 */
class Commit implements CommitInterface
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
     * @var string
     *
     * @ORM\Column(name="source_id", type="string", length=255)
     */
    private $sourceId;

    /**
     * @var string
     *
     * @ORM\Column(name="authorName", type="string", length=255)
     */
    private $authorName;

    /**
     * @var string
     *
     * @ORM\Column(name="authorEmail", type="string", length=255)
     */
    private $authorEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=255)
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="MB\DashboardBundle\Entity\Project", inversedBy="commits")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $project;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::setSourceId()
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::getSourceId()
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::setAuthorName()
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::getAuthorName()
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::setAuthorEmail()
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::getAuthorEmail()
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::setHash()
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::getHash()
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::setComment()
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::getComment()
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::setUrl()
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Commit\CommitInterface::getUrl()
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CommitInterface::setProject()
     */
    public function setProject(\MB\DashboardBundle\Entity\Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \MB\DashboardBundle\Model\Project\CommitInterface::getProject()
     */
    public function getProject()
    {
        return $this->project;
    }
}

