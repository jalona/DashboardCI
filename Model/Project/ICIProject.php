<?php

namespace MB\DashboardBundle\Model\Project;

interface ICIProject
{
    /**
     * Set ciId
     *
     * @param integer $ciId
     *
     * @return ICIProject
     */
    public function setCiId($ciId);

    /**
     * Get ciId
     *
     * @return integer
     */
    public function getCiId();

    /**
     * Set ciConnectorIdentifier
     *
     * @param string $ciConnectorIdentifier
     *
     * @return ICIProject
     */
    public function setCiConnectorIdentifier($ciConnectorIdentifier);

    /**
     * Get ciConnectorIdentifier
     *
     * @return string
     */
    public function getCiConnectorIdentifier();

    /**
     * Set ciUrl
     *
     * @param string $ciUrl
     *
     * @return ICIProject
     */
    public function setCiUrl($ciUrl);

    /**
     * Get ciUrl
     *
     * @return string
     */
    public function getCiUrl();

    /**
     * Set ciBuildStatus
     *
     * @param boolean $ciBuildStatus
     *
     * @return ICIProject
     */
    public function setCiBuildStatus($ciBuildStatus);

    /**
     * Get ciBuildStatus
     *
     * @return boolean
     */
    public function getCiBuildStatus();

    /**
     * Set ciBuildMessage
     *
     * @param string $ciBuildMessage
     *
     * @return ICIProject
     */
    public function setCiBuildMessage($ciBuildMessage);

    /**
     * Get ciBuildMessage
     *
     * @return string
     */
    public function getCiBuildMessage();

    /**
     * Set ciDeployStatus
     *
     * @param boolean $ciDeployStatus
     *
     * @return ICIProject
     */
    public function setCiDeployStatus($ciDeployStatus);

    /**
     * Get ciDeployStatus
     *
     * @return boolean
     */
    public function getCiDeployStatus();

    /**
     * Set ciDeployMessage
     *
     * @param string $ciDeployMessage
     *
     * @return ICIProject
     */
    public function setCiDeployMessage($ciDeployMessage);

    /**
     * Get ciDeployMessage
     *
     * @return string
     */
    public function getCiDeployMessage();

    /**
     * Set ciTitle
     *
     * @param string $ciTitle
     *
     * @return ICIProject
     */
    public function setCiTitle($ciTitle);

    /**
     * Get ciTitle
     *
     * @return string
     */
    public function getCiTitle();

    /**
     * Set ciDescription
     *
     * @param string $ciDescription
     *
     * @return ICIProject
     */
    public function setCiDescription($ciDescription);

    /**
     * Get ciDescription
     *
     * @return string
     */
    public function getCiDescription();
}
