@extends('layouts.main')

@section('title', $event->title)

@section('content')

<div class="col-md-10 offset-md-1 mt-5">
    <div class="row">
        <div id="image-container" class="col-md-6">
            <img src="/img/events/{{ $event->image}}" class="img-fluid" alt="{{ $event->title }}">
        </div>
        <div id="info-container" class="col-md-6">
            <h1>{{ $event->title }}</h1>
            <p class="event-date"><i class="bi bi-calendar-date-fill"></i> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
            <p class="event-city"><i class="bi bi-geo-alt-fill"></i>{{$event->city}}</p>
            <p class=" events-participants"><i class="bi bi-people-fill text-black"></i>{{ count($event->users)}}</p>
            <p class="event-owner"><i class="bi bi-person-fill-gear"></i>{{$event->user->name}}</p>
            @if(!$hasUserJoined)
            <form action="/events/join/{{ $event->id }}" method="POST">
                @csrf
                <a href="/events/join/{{ $event->id }}"
                    class="btn btn-primary"
                    id="event-submit"
                    onclick="event.preventDefault();
            this.closest('form').submit();">
                    Confirmar Presença
                </a>
            </form>
            @else
            <p class="already-joined-msg btn btn-secondary">Você já está participando deste evento</p>
            @endif
            <div class="list-item">
                <h3 class="title-items">O evento conta com:</h3>
                <ul id="items-list">
                    @foreach($event->items as $item)
                    <li><i class="fas fa-box"></i><span>{{$item}}</span></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-12" id="description-container">
        <h3>Sobre o evento:</h3>
        <p class="event-description">{{$event->description}}</p>
    </div>
</div>


@endsection