<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Article;
use Doctrine\ORM\EntityManager;

class ArticleManager{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em){
        $this->em = $em;
        $this->repository = $em->getRepository(Article::class);
    }

    /**
     * @return array
     */
    public function loadArticles(){
        return $this->repository->findAll();
    }

    /**
     * @param $id
     * @return null|Article
     */
    public function loadArticle($id){
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return Article
     */
    public function createArticle(array $data){
        $article = new Article();
        $article
            ->setTitle($data['title'])
            ->setAuthor($data['author'])
            ->setAuthorLink($data['author_link'])
            ->setIntroduction($data['introduction'])
            ->setContent($data['content']);

        return $this->saveArticle($article);
    }

    /**
     * @param Article $article
     * @param array $data
     * @return Article
     */
    public function updateArticle(Article $article, array $data){
        $article
            ->setTitle($data['title'])
            ->setIntroduction($data['introduction'])
            ->setContent($data['content']);

        return $this->saveArticle($article);
    }

    /**
     * @param Article $article
     * @return Article
     */
    public function saveArticle(Article $article){
        $this->em->persist($article);
        $this->em->flush();
        return $article;
    }

    /**
     * @param Article $article
     */
    public function deleteArticle(Article $article){
        $this->em->remove($article);
        $this->em->flush();
    }
}