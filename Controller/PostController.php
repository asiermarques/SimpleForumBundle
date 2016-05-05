<?php
/**
 * Created by Asier Marqués <asiermarques@gmail.com>
 * Date: 4/5/16
 * Time: 17:49
 */

namespace Simettric\SimpleForumBundle\Controller;


use Simettric\SimpleForumBundle\Entity\Post;
use Simettric\SimpleForumBundle\Entity\PostReply;
use Simettric\SimpleForumBundle\Form\PostReplyType;
use Simettric\SimpleForumBundle\Form\PostType;
use Simettric\SimpleForumBundle\Repository\ForumRepository;
use Simettric\SimpleForumBundle\Repository\PostReplyRepository;
use Simettric\SimpleForumBundle\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/discussion")
 */
class PostController extends Controller{

    /**
     * @Route("/create-in-{forum_id}", name="sim_forum_post_create")
     */
    public function createAction($forum_id, Request $request)
    {

        if(!$forum = $this->getForumRepository()->find($forum_id)){
            throw $this->createNotFoundException();
        }

        $item = new Post();
        $item->setForum($forum);
        $item->setUser($this->getUser());

        $form = $this->createForm(PostType::class, $item);



        if($request->getMethod() == Request::METHOD_POST){

            $form->handleRequest($request);
            if($form->isValid()){

                $item->setCreated(new \DateTime());

                $this->getDoctrine()->getManager()->persist($item);
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash("success", $this->get("translator")->trans("post_created"));

                return $this->redirect(
                            $this->generateUrl("sim_forum_post",
                                               ["slug"=>$item->getSlug(), "id"=>$item->getId()])
                );

            }

        }

        return $this->render('SimettricSimpleForumBundle:Post:create.html.twig', array(
            "forum" => $forum,
            "item" => $item,
            "form"  => $form->createView()
        ));

    }


    /**
     * @Route("/{slug}-{id}", requirements={"slug": "[^/\\]+", "id": "\d+" }, name="sim_forum_post", methods="GET")
     * @Route("/{slug}-{id}/reply", name="sim_forum_post_reply", methods="POST", requirements={"slug": "[^/\\]+", "id": "\d+" })
     * @Route("/{slug}-{id}/{reply_id}/reply", name="sim_forum_post_reply_to_reply", methods="POST", requirements={"slug": "[^/\\]+", "id": "\d+" })
     *
     */
    public function detailAction($id, $slug, Request $request)
    {

        /**
         * @var $item Post
         */
        if(!$item = $this->getRepository()->find($id)){
            throw $this->createNotFoundException();
        }

        $reply = new PostReply();
        $reply->setUser($this->getUser());
        $reply->setPost($item);

        $form = $this->createForm(PostReplyType::class, $reply);

        if($request->getMethod() == Request::METHOD_POST){

            $form->handleRequest($request);
            if($form->isValid()){

                if($request->get("reply_id") &&
                    $parent_reply = $this->getReplyRepository()->find($request->get("reply_id"))){
                    //two response levels only
                    if($parent_reply->getReply()){
                        $parent_reply = $parent_reply->getReply();
                    }
                    $reply->setReply($parent_reply);

                }

                $reply->setCreated(new \DateTime());
                $this->getDoctrine()->getManager()->persist($reply);

                $item->setLastReply($reply);
                $item->setUpdated(new \DateTime());
                $this->getDoctrine()->getManager()->persist($item);

                $item->getForum()->setUpdated(new \DateTime());
                $this->getDoctrine()->getManager()->persist($item->getForum());

                $this->getDoctrine()->getManager()->flush();

                $this->addFlash("success", $this->get("translator")->trans("reply_created"));

                return $this->redirect($request->headers->get("referer"));

            }

        }



        $pagination = $this->getReplyRepository()->createPagination(
            $this->getReplyRepository()->getBaseQB($item)->getQuery(),
            $this->get('knp_paginator'),
            $request->get("page", 1)
        );



        return $this->render('SimettricSimpleForumBundle:Post:detail.html.twig', array(
            "pagination" => $pagination,
            "item"       => $item,
            "form"       => $form->createView()
        ));

    }


    /**
     * @return PostRepository
     */
    private function getRepository(){
        return $this->getDoctrine()->getManager()->getRepository("SimettricSimpleForumBundle:Post");
    }

    /**
     * @return ForumRepository
     */
    private function getForumRepository(){
        return $this->getDoctrine()->getManager()->getRepository("SimettricSimpleForumBundle:Forum");
    }

    /**
     * @return PostReplyRepository
     */
    private function getReplyRepository(){
        return $this->getDoctrine()->getManager()->getRepository("SimettricSimpleForumBundle:PostReply");
    }

} 