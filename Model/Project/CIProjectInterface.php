<?php

namespace MB\DashboardBundle\Model\Project;

interface CIProjectInterface
{
    /**
     * Set ciId
     *
     * @param integer $ciId
     *
     * @return CIProjectInterface
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
     * @return CIProjectInterface
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
     * @return CIProjectInterface
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
     * @return CIProjectInterface
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
     * @return CIProjectInterface
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
     * @return CIProjectInterface
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
     * @return CIProjectInterface
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
     * @return CIProjectInterface
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
     * @return CIProjectInterface
     */
    public function setCiDescription($ciDescription);

    /**
     * Get ciDescription
     *
     * @return string
     */
    public function getCiDescription();
}
