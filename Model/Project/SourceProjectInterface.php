<?php

namespace MB\DashboardBundle\Model\Project;

use MB\DashboardBundle\Entity\SourceGroup;
interface SourceProjectInterface
{
    /**
     * Set sourceId
     *
     * @param integer $sourceId
     *
     * @return SourceProjectInterface
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
     * @return SourceProjectInterface
     */
    public function setSourceConnectorIdentifier($sourceConnectorIdentifier);

    /**
     * Get sourceConnectorIdentifier
     *
     * @return string
     */
    public function getSourceConnectorIdentifier();

    /**
     * Set sourceGroup
     *
     * @param \MB\DashboardBundle\Entity\SourceGroup $sourceGroup
     *
     * @return SourceProjectInterface
     */
    public function setSourceGroup(\MB\DashboardBundle\Entity\SourceGroup $sourceGroup);

    /**
     * Get sourceGroup
     *
     * @return SourceGroup
     */
    public function getSourceGroup();

    /**
     * Set sourceUrl
     *
     * @param string $sourceUrl
     *
     * @return SourceProjectInterface
     */
    public function setSourceUrl($sourceUrl);

    /**
     * Get sourceUrl
     *
     * @return string
     */
    public function getSourceUrl();

    /**
     * Set sourceTitle
     *
     * @param string $sourceTitle
     *
     * @return SourceProjectInterface
     */
    public function setSourceTitle($sourceTitle);

    /**
     * Get sourceTitle
     *
     * @return string
     */
    public function getSourceTitle();

    /**
     * Set sourcePath
     *
     * @param string $sourcePath
     *
     * @return SourceProjectInterface
     */
    public function setSourcePath($sourcePath);

    /**
     * Get sourcePath
     *
     * @return string
    */
    public function getSourcePath();

    /**
     * Set sourceDescription
     *
     * @param string $sourceDescription
     *
     * @return SourceProjectInterface
     */
    public function setSourceDescription($sourceDescription);

    /**
     * Get sourceDescription
     *
     * @return string
     */
    public function getSourceDescription();
}
