<?php
namespace App\Service;
use App\Entity\User;
use Twig\Environment;
/**
 * Class MailService
 * @package App\Service
 */
class MailService {
    /**
     * @var Environment
     */
    private $view;

    /**
     * @var \Swift_Mailer
     */

    private $mailer;
    /**
     * MailService constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $view
     */

    private $templatesLinks;

    public function __construct(\Swift_Mailer $mailer, Environment $view) {
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
     */
    public function sendMailToRecipient(User $user, string $url, string $type)
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