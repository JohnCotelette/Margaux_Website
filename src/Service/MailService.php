<?php

namespace App\Service;

use App\Entity\User;
use Swift_Mailer;
use Twig\Environment;

final class MailService {
    /**
     * @var Environment
     */
    private $view;

    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var array
     */
    private $templatesLinks;

    /**
     * @param Swift_Mailer $mailer
     * @param Environment $view
     */
    public function __construct(Swift_Mailer $mailer, Environment $view) {
        $this->mailer = $mailer;
        $this->view = $view;
        $this->templatesLinks = [
            "resetPassword" => "mail/resetPassword.html.twig",
        ];
    }

    /**
     * @param User $user
     * @param string $url
     * @param string $type
     * @return void
     */
    public function sendMailToRecipient(User $user, string $url, string $type) :void
    {
        $template = $this->templatesLinks[$type];

        $contactMail = (new \Swift_Message("An important email from MargauxPassot.com"))
            ->setFrom("passotmargaux@gmail.com")
            ->setTo($user->getEmail())
            ->setBody(
                $this->view->render($template, [
                    "url" => $url
                ]), "text/html"
            );

        $this->mailer->send($contactMail);
    }
}