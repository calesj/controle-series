<?php

namespace App\Listeners;

use App\Events\NovaSerie;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EnviarEmailNovaSerieCadastrada implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NovaSerie  $event
     * @return void
     */
    public function handle(NovaSerie $event)
    {
        $nomeSerie = $event->nomeSerie;
        $qtdTemporada = $event->qtdTemporadas;
        $qtdEpisodio = $event->qtdEpisodios;
        $users = User::all();

        foreach ($users as $indice => $user){

            $multiplicador = $indice +1;
            $email = new \App\Mail\NovaSerie(
                $nomeSerie,
                $qtdTemporada,
                $qtdEpisodio
            );
            $email->subject = 'Nova Serie adicionada';
            $quando = now()->addSecond($multiplicador * 10);
            Mail::to($user)->later(
                $quando,
                $email);
            // sleep(5);
        }
    }
}
