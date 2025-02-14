@extends('layouts.main')

@section('title', 'Tech Elevate')

@section('content')


<div id="search-Container" class="col-md-12">
    <h1 id="search-event">Busque um evento</h1>
    <form action="{{ route('buscar') }}" method="GET">
        <input type="text" name="search" class="form-control-search form-control" placeholder="Procurar...">
        <button type="submit" id="search" class="btn btn-primary btn-lg ">Procurar</button>
    </form>
</div>
<div id="events-container" class="col-md-12">
    <h2>Próximos Eventos</h2>
    <p class="subtitle">Veja os eventos dos próximos dias</p>
    <div id="cards-container" class="row">
        @foreach($events as $event)
        <div class="card col-md-3">
            <img src="/img/events/{{ $event->image }}" alt="{{$event->title}}">
            <p class="card-date">{{ $event->date->format('d/m/Y') }}</p>
            <h4 class="card-title">{{ $event -> title }}</h4>
            <p class="card-description">{{ Str::limit($event->description, 100, '...') }}</p>
            <p class="card-participantes"> {{ count($event->users) }} participantes</p>
            <a href="{{ route('event.show', $event->id) }}" class="btn btn-primary">Saiba mais</a>
        </div>
        @endforeach
        @if(count($events) == 0)
        <p class="evento-none">Não há eventos disponíveis</p>
        @endif
    </div>
</div>

@endsection