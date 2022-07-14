<?php

namespace Tests\Feature;

use App\Serie;
use App\Services\CriadorDeSerie;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CriadorDeSerieTest extends TestCase
{
    use RefreshDatabase;
    public function testeCriarSerie()
    {
        $criadorDeSerie = new CriadorDeSerie();
        $nomeserie = 'Nome de Teste';
        $serieCriada = $criadorDeSerie->criarSerie($nomeserie,1,1);
        $this->assertInstanceOf(Serie::class,$serieCriada);
        $this->assertDatabaseHas('series',['nome' => $nomeserie]);
        $this->assertDatabaseHas('temporadas',['serie_id' => $serieCriada->id, 'numero' => 1]);
        $this->assertDatabaseHas('episodios',['numero' => 1]);



    }
}
