<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
// use App\Security\EmailVerifier;
use App\Repository\CategoryRepository;
// use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
// use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;


/**
 * @Route("/recipe")
 */
class RegistrationController extends AbstractController
{
    private $categories;

    function __construct(CategoryRepository $repo)
    {
        $this->categories = $repo->findAll();
    }
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        if ($this->getUser()) {
            $this->addFlash('error', 'Vous êtes déjà connecté');
            return $this->redirectToRoute('app_home');
        }
        
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                    )
                );
               

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'categories'=> $this->categories

        ]);
    }
      
}