<?php

namespace Simettric\SimpleForumBundle\Repository;
use Simettric\SimpleForumBundle\Entity\Post;
use Simettric\SimpleForumBundle\Entity\PostReply;
use Simettric\SimpleForumBundle\Traits\PaginationTrait;

/**
 * PostReplyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostReplyRepository extends \Doctrine\ORM\EntityRepository
{

    use PaginationTrait;

    const DEFAULT_LIST_LIMIT = 10;


    function getBaseQB(Post $post){

        return $this->createQueryBuilder("pr")
            ->innerJoin("pr.post", "p")
            ->where("p.id = :post_id")
            ->setParameter("post_id", $post->getId());

    }

    function getRepliesQB(PostReply $reply){

        return $this->createQueryBuilder("rr")
            ->innerJoin("rr.reply", "r")
            ->where("r.id = :reply_id")
            ->setParameter("reply_id", $reply->getId());

    }




}
