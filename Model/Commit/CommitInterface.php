<?php

namespace MB\DashboardBundle\Model\Commit;

use MB\DashboardBundle\Model\Project\SourceProjectInterface;
interface CommitInterface
{
    /**
     * Set authorName
     *
     * @param string $authorName
     *
     * @return CommitInterface
     */
    public function setAuthorName($authorName);

    /**
     * Get authorName
     *
     * @return string
     */
    public function getAuthorName();

    /**
     * Set authorEmail
     *
     * @param string $authorEmail
     *
     * @return CommitInterface
     */
    public function setAuthorEmail($authorEmail);

    /**
     * Get authorEmail
     *
     * @return string
     */
    public function getAuthorEmail();

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return CommitInterface
     */
    public function setHash($hash);

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash();

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return CommitInterface
     */
    public function setComment($comment);

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment();

    /**
     * Set url
     *
     * @param string $url
     *
     * @return CommitInterface
     */
    public function setUrl($url);

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl();

    /**
     * Set project
     *
     * @param \MB\DashboardBundle\Entity\Project $project
     *
     * @return CommitInterface
     */
    public function setProject(\MB\DashboardBundle\Entity\Project $project);

    /**
     * Get project
     *
     * @return SourceProjectInterface
    */
    public function getProject();
}
