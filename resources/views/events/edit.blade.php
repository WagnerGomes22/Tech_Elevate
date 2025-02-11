@extends('layouts.main')

@section('title', 'Editando ' . $event->title)

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário-Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-event mt-5 col-md-6 offset-md-3 p-5">
        <h2>Editando o evento: <span class=" text-muted">{{$event->title}}</h2>
        <p class="text-center lead"></p>
        <p class="subtitle-event">Gerencie os detalhes do evento abaixo</p>
        <div class="container-form">
            <form action="{{ route('events.update', ['id' => $event->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="image" class="form-label">Imagem do Evento:</label>
                    <input type="file" name="image" id="image" class="form-control-file" onchange="previewImage(event)">
                    <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" id="img-preview" class="img-preview">

                </div>
                <div class="mb-2">
                    <label for="title" class="form-label">Evento</label>
                    <input type="text" name="title" class="form-control" id="title"
                        placeholder="Digite o titulo do evento" value="{{$event->title}}">
                </div>

                <div class="mb-2">
                    <label for="date" class="form-label">Data</label>
                    <input type="date" name="date" class="form-control" id="date" value="{{date('Y-m-d', strtotime($event->date));}}">
                </div>

                <div class="mb-2">
                    <label for="title" class="form-label">Cidade</label>
                    <input type="text" name="city" class="form-control" id="city" placeholder="Digite sua cidade" value="{{$event->city}}">
                </div>

                <div class="mb-2">
                    <label for="title" class="form-label">Descrição</label>
                    <textarea class="form-control" name="description" id="description" placeholder="Digite a descrição">{{$event->description}}</textarea>
                </div>

                <div class="mb-2">
                    <label for="title" class="form-label">Evento privado?</label>
                    <select name="private" id="private" class="form-control">
                        <option value="1" {{ $event->private == 1 ? 'selected' : '' }}>Sim</option>
                        <option value="0" {{ $event->private == 0 ? 'selected' : '' }}>Não</option>

                    </select>
                </div>
                <div class="mb-2">
                    <label for="title" class="form-label">Adicione itens de infraestrutura:</label>

                    <div class="form-group">
                        <input type="checkbox" name="items[]" value="Cadeiras"
                            {{ in_array('Cadeiras', $event->items) ? 'checked' : '' }}> Cadeiras
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="items[]" value="Palco"
                            {{ in_array('Palco', $event->items) ? 'checked' : '' }}> Palco
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="items[]" value="Cerveja gratis"
                            {{ in_array('Cerveja gratis', $event->items) ? 'checked' : '' }}> Cerveja grátis
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="items[]" value="Open food"
                            {{ in_array('Open food', $event->items) ? 'checked' : '' }}> Open Food
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="items[]" value="Brindes"
                            {{ in_array('Brindes', $event->items) ? 'checked' : '' }}> Brindes
                    </div>
                </div>

                <button type="submit" class="btn btn-primary enviar" value="Criar Evento">Enviar</button>
            </form>
        </div>
    </div>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('img-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>
@endsection