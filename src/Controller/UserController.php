<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditRoleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class UserController extends AbstractController
{
    /**
     * @Route("/back-office/utilisateurs")
     * @return Response
     */
    public function list(): Response
    {
        // Récupération du Repository
        $repo = $this->getDoctrine()->getRepository(User::class);
        // Récupération des utilisateurs
        $users = $repo->findAll();
        // Renvoi des utilisateurs à la vue
        return $this->render('user/list.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/back-office/utilisateurs/changement-roles/{id}",name="app_user_editrole", requirements={"id"="[0-9]+"})
     * @param int $id
     * @return Response
     */
    public function edit(int $id, Request $request): Response
    {
        // Récupération du Repository
        $repo = $this->getDoctrine()->getRepository(User::class);
        // Récupération de l'utilisateur
        $user = $repo->findOneBy([
            'id' => $id
        ]);

        // Instanciation du formulaire
        $form = $this->createForm(UserEditRoleType::class, $user);

        // Remplir le formulaire avec les variables $_POST
        $form->handleRequest($request);

        // On vérifie que le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération du manager
            $manager = $this->getDoctrine()->getManager();
            // Mis à jour en BDD
            $manager->flush();
            // Ajout du message flash
            $this->addFlash('primary', 'Rôle modifié');
        }

        // Renvoi des utilisateurs à la vue
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'editForm' => $form->createView()
        ]);
    }
}
