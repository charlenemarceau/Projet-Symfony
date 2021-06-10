<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Category;
use App\Form\RecipeType;
use App\Repository\UserRepository;
use App\Repository\RecipeRepository;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/recipe")
 */
class RecipeController extends AbstractController
{
    
    public function __toString() {
        return $this->name;
    }
    /**
     * @Route("/", name="app_home", methods={"GET"})
     */
    public function index(RecipeRepository $recipeRepository): Response
    {
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="recipe_new", methods={"GET","POST"})
     * 
     * @Security("is_granted('ROLE_USER') && user.isVerified()")
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('recipe/new.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="recipe_show", methods={"GET"})
     */
    public function show(Recipe $recipe): Response
    {
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="recipe_edit", methods={"GET","POST"})
     * @Security("is_granted('RECIPE_EDIT', recipe)")
     */
    public function edit(Request $request, Recipe $recipe) : Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La recette a bien été modifiée!');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('recipe/edit.html.twig', [
            'recipe' => $recipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="recipe_delete", methods={"POST"})
     * @Security("is_granted('RECIPE_DELETE', recipe)")
     */
    public function delete(Request $request, Recipe $recipe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recipe->getId(), $request->request->get('csrf_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recipe);
            $entityManager->flush();
        }
        $this->addFlash('info', 'La recette a bien été supprimé !');
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/category/{id}", name="app_recipe_category")
     *
     * @param Category $cat
     * @return void
     */
    public function recipesByCategory(Category $cat) : Response 
    {
        return $this->render('/recipe/index.html.twig', [
            'recipes' => $cat->getRecipes(),
            'categories' => $this->categories
        ]);
    }
}
