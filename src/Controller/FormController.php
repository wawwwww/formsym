<?php
namespace App\Controller;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class
FormController extends AbstractController
{
    /**
     * @Route("/", name="article_list")
     */
    public function index()
    {
        // Récupération du Repository
        $repository = $this->getDoctrine()->getRepository(Article::class);
        // Récupération des articles
        $articles = $repository->findAll();
        return $this->render('form/index.html.twig', [
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/article/creation", name="article_create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        // Récupération du formulaire
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        // On "remplit" le formulaire avec les données postées
        $form->handleRequest($request);
        // On vérifie que le formulaire est soumis et ses valeurs sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération du manager
            $manager = $this->getDoctrine()->getManager();
            // Insertion de l'article en BDD
            $manager->persist($article); // Préparation du SQL
            $manager->flush(); // Exécution du SQL
            // Ajout d'un message flash
            $this->addFlash('success', 'Votre article bien été ajouté');
            // Redirection vers le détail de l'article
            return $this->redirectToRoute('article_show', [
                'id' => $article->getId()
            ]);
        }
        // Envoi du formulaire à la vue
        return $this->render('form/create.html.twig', [
            'createForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show($id)
    {
        // Récupération du Repository
        $repository = $this->getDoctrine()->getRepository(Article::class);
        // Récupération de l'article lié à l'id
        $article = $repository->findOneBy([
            'id' => $id
        ]);
        return $this->render('form/show.html.twig', [
            'article' => $article
        ]);
    }
    /**
     * @Route("/article/{id}/modification", name="article_update")
     * @param Article $article
     * @param Request $request
     * @return Response
     */
    public function edit(Article $article, Request $request): Response
    {
        // Récupération du formulaire
        $form = $this->createForm(ArticleType::class, $article);
        // Remplir le formulaire avec les variables $_POST
        $form->handleRequest($request);
        // On vérifie que le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération du manager
            $manager = $this->getDoctrine()->getManager();
            // Mis à jour en BDD
            $manager->flush();
            // Ajout du message flash
            $this->addFlash('primary', 'Votre article a bien été modifié');
            // Redirection vers le détail de l'article
            return $this->redirectToRoute('article_show', [
                'id' => $article->getId()
            ]);
        }
        return $this->render('form/update.html.twig', [
            'editForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/article/{id}/suppression", name="article_delete")
     * @param Article $article
     * @return Response
     */
    public function delete(Article $article): Response
    {
        // Récupération du manager
        $manager = $this->getDoctrine()->getManager();
        // Suppression de l'article
        $manager->remove($article);
        $manager->flush();
        // Ajout d'un message flash
        $this->addFlash('danger', 'Votre article a bien été supprimé');
        // Redirection vers la liste des articles
        return $this->redirectToRoute('article_list');
    }
}
