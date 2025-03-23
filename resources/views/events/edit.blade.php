@extends('layouts.main')

@section('title', 'Editar Evento')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-event mt-5 mb-5 col-md-6 offset-md-3 p-5">
        <h2>Editar Evento: <span class="text-dark">{{$event->title}}</h2>
        <p class="subtitle-event">Atualize as informações sobre o seu evento</p>
        <div class="container-form">
            <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="image" class="form-label fw-bold">Imagem do Evento:</label>

                    @if($event->image)
                    <div class="d-flex align-items-center mb-2">
                        <p class="mb-0 me-3">Imagem atual:</p>
                        <img src="/img/events/{{ $event->image }}" alt="Imagem do evento {{ $event->title }}" id="currentImage" class="img-thumbnail" style="max-height: 100px;">
                    </div>
                    @endif

                    <div class="mt-2" id="imagePreview" style="display: none;">
                        <p class="mb-0 me-2 d-inline-block">Nova imagem:</p>
                        <img id="preview" src="#" alt="Pré-visualização da nova imagem" class="img-thumbnail" style="max-height: 100px;">
                    </div>

                    <input type="file" class="form-control mt-2" id="image" name="image" onchange="previewImage(this)">
                    <small class="form-text text-primary fw-bold">Selecione uma nova imagem para substituir a atual (opcional).</small>

                    @error('image')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <script>
                    function previewImage(input) {
                        var preview = document.getElementById('preview');
                        var previewDiv = document.getElementById('imagePreview');

                        if (input.files && input.files[0]) {
                            var reader = new FileReader();

                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                previewDiv.style.display = 'block';
                            }

                            reader.readAsDataURL(input.files[0]);
                        } else {
                            previewDiv.style.display = 'none';
                        }
                    }
                </script>

        </div>
        <div class="mt-2 mb-2">
            <label for="title" class="form-label">Evento</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Digite o titulo do evento" value="{{ old('title', $event->title) }}">
            @error('title')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="date" class="form-label">Data</label>
            <input type="date" name="date" class="form-control" id="date" value="{{ old('date', \Carbon\Carbon::parse($event->date)->format('Y-m-d')) }}">
            @error('date')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" name="city" class="form-control" id="city" placeholder="Digite sua cidade" value="{{ old('city', $event->city) }}">
            @error('city')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="description" class="form-label">Descrição</label>
            <textarea class="form-control" name="description" id="description" placeholder="Digite a descrição">{{ old('description', $event->description) }}</textarea>
            @error('description')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <label class="form-label">Adicione itens de infraestrutura:</label>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cadeiras" {{ in_array('Cadeiras', $event->items) ? 'checked' : '' }}> Cadeiras
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Palco" {{ in_array('Palco', $event->items) ? 'checked' : '' }}> Palco
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Cerveja gratis" {{ in_array('Cerveja gratis', $event->items) ? 'checked' : '' }}> Cerveja grátis
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Open food" {{ in_array('Open food', $event->items) ? 'checked' : '' }}> Open Food
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" value="Brindes" {{ in_array('Brindes', $event->items) ? 'checked' : '' }}> Brindes
                </div>
                @error('items')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Tags de Tecnologia:</label>
                <div class="form-group">
                    <input type="checkbox" name="tech_tags[]" value="Cloud" {{ in_array('Cloud', $event->tech_tags) ? 'checked' : '' }}> Cloud
                </div>
                <div class="form-group">
                    <input type="checkbox" name="tech_tags[]" value="Back-end" {{ in_array('Back-end', $event->tech_tags) ? 'checked' : '' }}> Back-end
                </div>
                <div class="form-group">
                    <input type="checkbox" name="tech_tags[]" value="Front-end" {{ in_array('Front-end', $event->tech_tags) ? 'checked' : '' }}> Front-end
                </div>
                <div class="form-group">
                    <input type="checkbox" name="tech_tags[]" value="DevOps" {{ in_array('DevOps', $event->tech_tags) ? 'checked' : '' }}> DevOps
                </div>
                <div class="form-group">
                    <input type="checkbox" name="tech_tags[]" value="Inteligência Artificial" {{ in_array('Inteligência Artificial', $event->tech_tags) ? 'checked' : '' }}> Inteligência Artificial
                </div>
                @error('tech_tags')
                <div class="text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary enviar" value="Atualizar Evento">Atualizar</button>
        </form>
    </div>
    </div>

</body>

</html>

@endsection