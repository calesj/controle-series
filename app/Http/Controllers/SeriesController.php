<?php


namespace App\Http\Controllers;


use App\Episodio;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\NovaSerie;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use App\Temporada;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{

    public function index(Request $request)
    {
        $series = Serie::query()->orderBy('nome')->get();

        $mensagem = $request->session()->get('mensagem');
        $request->session()->remove('mensagem');

        return view("series/index", compact('series', 'mensagem'));

    }

    public function create()
    {
        return view('series/create');
    }

    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie)
    {
        $serie = $criadorDeSerie->criarSerie(
            $request->nome,
            $request->temporadas,
            $request->episodios
        );
        $eventoNovaSerie = new \App\Events\NovaSerie($request->nome,
        $request->temporadas,
        $request->episodios);
        event($eventoNovaSerie);
        $users = User::all();

        foreach ($users as $indice => $user){

            $multiplicador = $indice +1;
            $email = new \App\Mail\NovaSerie(
                $request->nome,
                $request->temporadas,
                $request->episodios
            );
            $email->subject = 'Nova Serie adicionada';
            $quando = now()->addSecond($multiplicador * 5);
            Mail::to($user)->later(
                $quando,
                $email);
           // sleep(5);
        }



        $request->session()->put('mensagem', "Série {$serie->id}  {$serie->nome} criada com sucesso");

        return redirect('../series');
    }

    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {
       $nomeSerie = $removedorDeSerie->removerSerie($request->id);
        $request->session()
            ->flash(
                'mensagem',
                "Série $nomeSerie removida com sucesso"
            );
        return redirect('../series');
    }

    public function editaNome(int $id, Request $request)
    {
        $serie = Serie::find($id);
        $novoNome = $request->nome;
        $serie->nome = $novoNome;
        $serie->save();
    }
}
