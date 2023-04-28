<?php 

namespace App\Service;

use App\Entity\Commentaire;
use App\Entity\Conducteur;

use Swift_Mailer;
use Swift_Message;
use Doctrine\Persistence\ManagerRegistry;

class CommentMailer
{
    private $mailer;
    private $doctrine;

    public function __construct(Swift_Mailer $mailer, ManagerRegistry $doctrine)
    {
        $this->mailer = $mailer;
        $this->doctrine = $doctrine;
    }

    public function sendCommentNotification(Commentaire $comment)
    {
        $entityManager = $this->doctrine->getManager();
        $conducteur = $entityManager->getRepository(Conducteur::class)->find($comment->getIdConducteur());
        $conducteurEmail = $conducteur->getEmailConducteur();
        
        $email = (new Swift_Message('You have a new comment'))
            ->setFrom('autoxpresstn@gmail.com')
            ->setTo($conducteurEmail)
            ->setBody(
                "<p>Dear {$conducteur->getPrenomConducteur()},</p>".
                "<p>We would like to inform you that you have received a new comment from Balkiss Hmidi:</p>".
                "<div style='border:1px solid #ccc;color :red; padding:10px;margin-top:10px;'><p>{$comment->getContenu()}</p></div>".
                "<p>Thank you for using our platform.</p>".
                "<p>Best regards,</p>".
                "<p>AutoXpress Team.</p>",
                'text/html'
            );
        $this->mailer->send($email);
    }
}