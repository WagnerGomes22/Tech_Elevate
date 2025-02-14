@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Meus Eventos</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if(session('msg'))
    <div class="alert alert-success">
        {{ session('msg') }}
    </div>
    @endif

    @if(isset($events) && $events->count() > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Participantes</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td scope="row">{{ $loop->index + 1 }}</td>
                <td><a href="/event/{{ $event->id }}">{{ $event->title }}</a></td>
                <td>{{ $event->users ? $event->users->count() : 0 }}</td>
                <td class="d-flex">
                    <a href="{{ route('events.edit', ['id' => $event->id]) }}" class="btn btn-editar"><i class="bi bi-pencil-square"></i> Editar</a>
                    <form action="/delete/{{ $event->id }}" method="POST" style="margin-left: 10px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete"><i class="bi bi-trash3"></i> Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Você ainda não tem eventos, <a href="/events/create">criar evento</a></p>
    @endif
</div>

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Eventos que você está participando</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if(isset($eventsParticipant) && $eventsParticipant->count() > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Participantes</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eventsParticipant as $event)
            <tr>
                <td scope="row">{{ $loop->index + 1 }}</td>
                <td><a href="/event/{{ $event->id }}">{{ $event->title }}</a></td>
                <td>{{ $event->users ? $event->users->count() : 0 }}</td>
                <td class="d-flex">
                    <form action="/events/leave/{{ $event->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete"><i class="bi bi-trash3"></i> Sair do evento</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Você ainda não está participando de nenhum evento, <a href="/">ver eventos</a></p>
    @endif
</div>

<div class="img-preview">
    @if($event->image)
        <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}">
    @endif
</div>

@endsection
