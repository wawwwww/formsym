<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    /**
     * @Route("/form", name="article_list")
     */
    public function index()
    {
        $Repository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $Repository->findAll();

        return $this->render('form/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route ("creation")
     * @return Response
     */
    public function create(): Response
    {

        $article = new article();
        $form = $this->createForm(ArticleType::class, $article);

        return $this->render('form/create.html.twig', [
            'createForm' => $form->createView()
        ]);

    }

    /**
     * @Route ("show/{id}", name="article_show")
     */
    public function show($id)
    {
        $Repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $Repository->findOneBy(['id'=> $id]);
        return $this->render('form/show.html.twig', [
            'article' => $article
        ]);
    }

}
