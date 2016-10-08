<?php

namespace AppBundle\Controller;

use AppBundle\Manager\ArticleManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @RouteResource("Article")
 */
class ArticleController extends Controller
{
    /**
     * Get Articles
     *
     * @ApiDoc(
     *     section="Article services",
     *     description="Get articles",
     *     statusCodes={
     *      "200": "OK"
     *     }
     * )
     */
    public function cgetAction()
    {
        /** @var ArticleManager $articleManager */
        $articleManager = $this->get('article_manager');

        $articles = $articleManager->loadArticles();

        return array('articles' => $articles);
    }

    /**
     * Get article by id
     *
     * @ApiDoc(
     *     section="Article services",
     *     description="Get article by id",
     *     requirements={
     *      {"name"="id", "requirement"="\d+", "dataType"="integer", "required"=true, "description"="Article dd"},
     *     },
     *     statusCodes={
     *      "200": "OK",
     *      "404": "Not Found"
     *     }
     * )
     */
    public function getAction($id)
    {
        /** @var ArticleManager $articleManager */
        $articleManager = $this->get('article_manager');

        $article = $articleManager->loadArticle($id);

        if($article === null){
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        return array('article' => $article);
    }

    /**
     * Create article
     *
     * @ApiDoc(
     *     section="Article services",
     *     description="Post article",
     *    input={
     *      "class"="AppBundle\Entity\Article"
     *     },
     *     statusCodes={
     *      "201": "Created",
     *      "400": "Error parameters"
     *     }
     * )
     */
    public function postAction(Request $request)
    {
        /** @var ArticleManager $articleManager */
        $articleManager = $this->get('article_manager');

        $article = $articleManager->createArticle($request->request->all());

        return array('article' => $article);
    }

    /**
     * Update article
     *
     * @ApiDoc(
     *     section="Article services",
     *     description="Update article",
     *     requirements={
     *      {"name"="id", "requirement"="\d+", "dataType"="integer", "required"=true, "description"="Article dd"},
     *     },
     *    input={
     *      "class"="AppBundle\Entity\Article"
     *     },
     *     statusCodes={
     *      "204": "Updated",
     *      "404": "Not found"
     *     }
     * )
     */
    public function putAction($id, Request $request)
    {
        /** @var ArticleManager $articleManager */
        $articleManager = $this->get('article_manager');

        $article = $articleManager->loadArticle($id);

        if($article === null){
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $articleManager->updateArticle($article, $request->request->all());

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete article
     *
     * @ApiDoc(
     *     section="Article services",
     *     description="Delete article",
     *     requirements={
     *      {"name"="id", "requirement"="\d+", "dataType"="integer", "required"=true, "description"="Article dd"},
     *     },
     *     statusCodes={
     *      "204": "Updated",
     *      "404": "Not found"
     *     }
     * )
     */
    public function deleteAction($id)
    {
        /** @var ArticleManager $articleManager */
        $articleManager = $this->get('article_manager');

        $article = $articleManager->loadArticle($id);

        if($article === null){
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $articleManager->deleteArticle($article);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
