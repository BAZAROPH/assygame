<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $suiveur;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($suiveur)
    {
        $this->suiveur = $suiveur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Bienvenue sur Assygamé')
            ->markdown('mail.inscription');

        /* return $this->from("service-client@assygame.com") // L'expéditeur
            ->subject("Une commande initiée via ASSYGAME") // Le sujet
            ->view('emails.message-commande'); */
    }
}
