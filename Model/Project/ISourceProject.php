<?php

namespace MB\DashboardBundle\Model\Project;

interface ISourceProject
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
     * @return ISourceProject
     */
    public function setSourceConnectorIdentifier($sourceConnectorIdentifier);

    /**
     * Get sourceConnectorIdentifier
     *
     * @return string
     */
    public function getSourceConnectorIdentifier();

    /**
     * Set sourceUrl
     *
     * @param string $sourceUrl
     *
     * @return ISourceProject
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
     * @return ISourceProject
     */
    public function setSourceTitle($sourceTitle);

    /**
     * Get sourceTitle
     *
     * @return string
     */
    public function getSourceTitle();

    /**
     * Set sourceDescription
     *
     * @param string $sourceDescription
     *
     * @return ISourceProject
     */
    public function setSourceDescription($sourceDescription);

    /**
     * Get sourceDescription
     *
     * @return string
     */
    public function getSourceDescription();
}
