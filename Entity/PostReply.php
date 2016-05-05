<?php

namespace Simettric\SimpleForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PostReply
 *
 * @ORM\Table(name="forum_post_reply")
 * @ORM\Entity(repositoryClass="Simettric\SimpleForumBundle\Repository\PostReplyRepository")
 */
class PostReply
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
     * @ORM\ManyToOne(targetEntity="\Simettric\SimpleForumBundle\Interfaces\UserInterface")
     */
    protected $user;


    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="replies")
     */
    protected $post;


    /**
     * @ORM\ManyToOne(targetEntity="PostReply", inversedBy="replies")
     */
    protected $reply;


    /**
     *
     * @ORM\OneToMany(targetEntity="PostReply", mappedBy="reply")
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
     * Set body
     *
     * @param string $body
     *
     * @return PostReply
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
     * @return PostReply
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
     * @return PostReply
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
     * Set post
     *
     * @param \Simettric\SimpleForumBundle\Entity\Post $post
     *
     * @return PostReply
     */
    public function setPost(\Simettric\SimpleForumBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Simettric\SimpleForumBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set reply
     *
     * @param \Simettric\SimpleForumBundle\Entity\PostReply $reply
     *
     * @return PostReply
     */
    public function setReply(\Simettric\SimpleForumBundle\Entity\PostReply $reply = null)
    {
        $this->reply = $reply;

        return $this;
    }

    /**
     * Get reply
     *
     * @return \Simettric\SimpleForumBundle\Entity\PostReply
     */
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * Add reply
     *
     * @param \Simettric\SimpleForumBundle\Entity\PostReply $reply
     *
     * @return PostReply
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
}