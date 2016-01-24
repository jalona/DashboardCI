<?php

namespace MB\DashboardBundle\Model\Group;

interface SourceGroupInterface
{
    /**
     * Set sourceId
     *
     * @param integer $sourceId
     *
     * @return ISourceProject
     */
    public function setSourceId($sourceId);

    /**
     * Get sourceId
     *
     * @return integer
    */
    public function getSourceId();

    /**
     * Set sourceConnectorIdentifier
     *
     * @param string $sourceConnectorIdentifier
     *
     * @return SourceGroupInterface
     */
    public function setSourceConnectorIdentifier($sourceConnectorIdentifier);

    /**
     * Get sourceConnectorIdentifier
     *
     * @return string
     */
    public function getSourceConnectorIdentifier();

    /**
     * Set title
     *
     * @param string $title
     *
     * @return SourceGroupInterface
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set url
     *
     * @param string $url
     *
     * @return SourceGroupInterface
     */
    public function setUrl($url);

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl();

    /**
     * Add project
     *
     * @param \MB\DashboardBundle\Entity\Project $project
     *
     * @return SourceGroupInterface
     */
    public function addProject(\MB\DashboardBundle\Entity\Project $project);

    /**
     * Remove project
     *
     * @param \MB\DashboardBundle\Entity\Project $project
     */
    public function removeProject(\MB\DashboardBundle\Entity\Project $project);

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getprojects();
}
