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

    <!-- Event count com o mesmo estilo para ambas as views -->
    <div class="events-count">
        <p>Temos <strong>{{ count($events) }}</strong> eventos em nossa plataforma</p>
    </div>

    <!-- Desktop View -->
    <div class="d-none d-md-block">
        <div id="cards-container" class="row">
            @foreach($events as $event)
            <div class="card col-md-3">
                <img src="/img/events/{{ $event->image }}" alt="{{$event->title}}">
                <p class="card-date">{{ $event->date->format('d/m/Y') }}</p>
                <h4 class="card-title">{{ $event->title }}</h4>
                <p class="card-description">{{ Str::limit($event->description, 100, '...') }}</p>
                @if($event->tech_tags && count($event->tech_tags) > 0)
                <div class="mt-3">
                    <h3 class="tags">Tags de Tecnologia:</h3>
                    <div class="tech-tags">
                        @foreach($event->tech_tags as $tag)
                        <span class="badge bg-info text-dark me-1">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                <p class="card-participantes">{{ count($event->users) }} participantes</p>
                <a href="{{ route('event.show', $event->id) }}" class="btn btn-primary">Saiba mais</a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Mobile View com Swiper -->
    <div class="d-block d-md-none">
        @if(count($events) > 2)
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach($events as $event)
                <div class="swiper-slide">
                    <div class="card">
                        <img src="/img/events/{{ $event->image }}" alt="{{$event->title}}">
                        <p class="card-date">{{ $event->date->format('d/m/Y') }}</p>
                        <h4 class="card-title">{{ $event->title }}</h4>
                        <p class="card-description">{{ Str::limit($event->description, 100, '...') }}</p>
                        <p class="card-participantes">{{ count($event->users) }} participantes</p>
                        <a href="{{ route('event.show', $event->id) }}" class="btn btn-primary">Saiba mais</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <!-- Script de inicialização do Swiper -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Iniciando Swiper...');
                var swiper = new Swiper(".mySwiper", {
                    slidesPerView: 1.2,
                    centeredSlides: true,
                    spaceBetween: 20,
                    loop: true,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                });
                console.log('Swiper iniciado:', swiper);
            });
        </script>
        @else
        <div class="row">
            @foreach($events as $event)
            <div class="col-6">
                <div class="card">
                    <img src="/img/events/{{ $event->image }}" alt="{{$event->title}}">
                    <p class="card-date">{{ $event->date->format('d/m/Y') }}</p>
                    <h4 class="card-title">{{ $event->title }}</h4>
                    <p class="card-description">{{ Str::limit($event->description, 100, '...') }}</p>
                    <p class="card-participantes">{{ count($event->users) }} participantes</p>
                    <a href="{{ route('event.show', $event->id) }}" class="btn btn-primary">Saiba mais</a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection