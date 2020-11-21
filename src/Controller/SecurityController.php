<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\MailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class SecurityController extends AbstractController
{
    /**
     * @Route("/adminConnect", name="login", methods={"GET", "POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) :Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute("projects_index");
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logout()
    {
        return $this->redirectToRoute("homepage");
    }

    /**
     * @Route("/forgotPassword", name="forgotPassword", methods={"GET", "POST"})
     * @param Request $request
     * @param UserRepository $userRep
     * @param MailService $mailService
     * @return Response
     */
    public function forgotPassword(Request $request, UserRepository $userRep, MailService $mailService) :Response
    {
        if ($request->getMethod() == "POST") {
            $user = $userRep->findOneBy(["email" => $request->get("email")]);

            if (!$user) {
                $this->addFlash("alert", "User not found.");
                return $this->redirectToRoute("forgotPassword");
            }

            $passwordToken = md5($user->getEmail().uniqid());

            $user->setPasswordToken($passwordToken);

            $em = $this
                ->getDoctrine()
                ->getManager();

            $em->persist($user);
            $em->flush();

            $resetPasswordUrl = $this->generateUrl("resetPassword", [
                "resetPasswordToken" => $user->getPasswordToken(),
            ], false);

            $mailService->sendMailToRecipient($user, $resetPasswordUrl, "resetPassword");

            $this->addFlash("success", "The link to change your password is in your e-mail box.");
        }

        return $this->render("security/forgotPassword.html.twig");
    }

    /**
     * @Route("/resetPassword/{resetPasswordToken}", name="resetPassword", methods={"GET", "POST"})
     * @param Request $request
     * @param UserRepository $userRep
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param string $resetPasswordToken
     * @return Response
     */
    public function resetPassword(Request $request,
                                  UserRepository $userRep,
                                  UserPasswordEncoderInterface $passwordEncoder,
                                  string $resetPasswordToken) :Response
    {
        $user = $userRep->findOneBy(["passwordToken" => $resetPasswordToken]);

        if (!$user || $user->getPasswordToken() === null) {
            return $this->redirectToRoute("homepage");
        }

        $form = $this->createForm(ResetPasswordType::class, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (password_verify($form["password"]->getData(), $user->getPassword())) {
                $this->addFlash("errorResetPassword", "Your old and new passwords must be different.");

                return $this->render("security/changePassword.html.twig", [
                    "form" => $form->createView(),
                ]);
            }

            $user->setPassword($passwordEncoder->encodePassword($user, $form["password"]->getData()));
            $user->setPasswordToken(null);

            $this
                ->getDoctrine()
                ->getManager()
                ->flush();

            $this->addFlash("successResetPassword", "Your password has been changed.");

            return $this->redirectToRoute("login");
        }

        return $this->render("security/changePassword.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
