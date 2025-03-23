@extends('layouts.main')

@section('title', 'Tech Elevate')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário-evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-event mt-5 mb-5 col-md-6 offset-md-3 p-5">
        <h2>Adicione um Evento</h2>
        <p class="subtitle-event">Coloque as informações sobre o seu evento</p>
        <div class="container-form">
            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="image" class="form-label">Imagem do Evento:</label>

                    <input type="file" class="form-control" id="image" name="image" required onchange="previewImage(this)">
                    <small class="form-text text-primary fw-bold">Escolha uma imagem para o seu evento (obrigatório).</small>

                    <div class="mt-2" id="imagePreview" style="display: none;">
                        <p class="mb-0 me-2 d-inline-block">Pré-visualização:</p>
                        <img id="preview" src="#" alt="Pré-visualização da imagem" class="img-thumbnail" style="max-height: 100px;">
                    </div>

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
                <div class="mt-2 mb-2">
                    <label for="title" class="form-label">Evento</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Digite o titulo do evento" value="{{ old('title') }}">
                    @error('title')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="date" class="form-label">Data</label>
                    <input type="date" name="date" class="form-control" id="date" value="{{ old('date') }}">
                    @error('date')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" name="city" class="form-control" id="city" placeholder="Digite sua cidade" value="{{ old('city') }}">
                    @error('city')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control" name="description" id="description" placeholder="Digite a descrição">{{ old('description') }}</textarea>
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
                            <input type="checkbox" name="items[]" value="Cadeiras"> Cadeiras
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="items[]" value="Palco"> Palco
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="items[]" value="Cerveja gratis"> Cerveja grátis
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="items[]" value="Open food"> Open Food
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="items[]" value="Brindes"> Brindes
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
                            <input type="checkbox" name="tech_tags[]" value="Cloud"> Cloud
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="tech_tags[]" value="Back-end"> Back-end
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="tech_tags[]" value="Front-end"> Front-end
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="tech_tags[]" value="DevOps"> DevOps
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="tech_tags[]" value="Inteligência Artificial"> Inteligência Artificial
                        </div>
                        @error('tech_tags')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary enviar" value="Criar Evento">Enviar</button>
            </form>
        </div>
    </div>

</body>

</html>

@endsection