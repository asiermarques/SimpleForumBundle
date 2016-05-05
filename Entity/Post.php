<?php

namespace Simettric\SimpleForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="forum_post")
 * @ORM\Entity(repositoryClass="Simettric\SimpleForumBundle\Repository\PostRepository")
 */
class Post
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="string", length=255)
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="\Simettric\SimpleForumBundle\Interfaces\UserInterface")
     */
    protected $user;


    /**
     * @ORM\ManyToOne(targetEntity="Forum", inversedBy="posts")
     */
    protected $forum;


    /**
     * @ORM\OneToOne(targetEntity="PostReply")
     */
    protected $lastReply;


    /**
     *
     * @ORM\OneToMany(targetEntity="PostReply", mappedBy="post")
     */
    private $replies;

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
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Post
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set user
     *
     * @param \Simettric\SimpleForumBundle\Interfaces\UserInterface $user
     *
     * @return Post
     */
    public function setUser(\Simettric\SimpleForumBundle\Interfaces\UserInterface $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Simettric\SimpleForumBundle\Interfaces\UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->replies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set forum
     *
     * @param \Simettric\SimpleForumBundle\Entity\Forum $forum
     *
     * @return Post
     */
    public function setForum(\Simettric\SimpleForumBundle\Entity\Forum $forum = null)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Get forum
     *
     * @return \Simettric\SimpleForumBundle\Entity\Forum
     */
    public function getForum()
    {
        return $this->forum;
    }

    /**
     * Add reply
     *
     * @param \Simettric\SimpleForumBundle\Entity\PostReply $reply
     *
     * @return Post
     */
    public function addReply(\Simettric\SimpleForumBundle\Entity\PostReply $reply)
    {
        $this->replies[] = $reply;

        return $this;
    }

    /**
     * Remove reply
     *
     * @param \Simettric\SimpleForumBundle\Entity\PostReply $reply
     */
    public function removeReply(\Simettric\SimpleForumBundle\Entity\PostReply $reply)
    {
        $this->replies->removeElement($reply);
    }

    /**
     * Get replies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * Set lastReply
     *
     * @param \Simettric\SimpleForumBundle\Entity\PostReply $lastReply
     *
     * @return Post
     */
    public function setLastReply(\Simettric\SimpleForumBundle\Entity\PostReply $lastReply = null)
    {
        $this->lastReply = $lastReply;

        return $this;
    }

    /**
     * Get lastReply
     *
     * @return \Simettric\SimpleForumBundle\Entity\PostReply
     */
    public function getLastReply()
    {
        return $this->lastReply;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Post
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}