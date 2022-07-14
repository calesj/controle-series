@extends('layout')
@section('cabecalho')
    Cadastrar Serie
@endsection
@section('conteudo')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post">@csrf
        <label for="exampleFormControlInput1" class="form-label">Série</label>
        <div class="row">
            <div class="col col-8">
                <input type="text" class="form-control" id="exampleFormControlInput1" name="nome"
                       placeholder="Digite o nome da Série">
            </div>
            <div class="col col-2">
                <input type="number" class="form-control" id="exampleFormControlInput1" name="temporadas"
                       placeholder="nºTemporadas">
            </div>
            <div class="col col-2">
                <input type="number" class="form-control" id="exampleFormControlInput1" name="episodios"
                       placeholder="Epº por Temporadas">
            </div>
        </div>
                <button class="btn btn-dark mt-2">Cadastrar Serie</button>
                <a href="../series" class="btn btn-light mt-2">Cancelar</a>
    </form>
@endsection
