<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index(Request $request)


    {
        $search = $request->input('search');

        if ($search) {

            $events = Event::where('title', 'like', '%' . $search . '%')->get();
        } else {
            $events = Event::all();
        }


        return view(
            'welcome',
            ['events' => $events, 'search' => $search]
        );
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(ImageUploadRequest $request)
    {
        $mensagem = [
            'title.required' => 'O campo título é obrigatório',
            'title.string' => 'O campo título deve ser uma string',
            'title.max' => 'O campo título deve ter no máximo 255 caracteres',
            'date.required' => 'O campo data é obrigatório',
            'date.date' => 'O campo data deve ser uma data',
            'city.required' => 'O campo cidade é obrigatório',
            'city.string' => 'O campo cidade deve ser uma string',
            'city.max' => 'O campo cidade deve ter no máximo 255 caracteres',
            'description.required' => 'O campo descrição é obrigatório',
            'description.string' => 'O campo descrição deve ser uma string',
            'image.required' => 'O campo imagem é obrigatório',
            'image.image' => 'O campo imagem deve ser uma imagem',
            'image.max' => 'O campo imagem deve ter no máximo 2MB',
        ];
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'city' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
        ],  $mensagem);

        $event = new Event;

        $event->title = $request->title;
        $event->city = $request->city;
        $event->description = $request->description;
        $event->items = $request->items ?? [];
        $event->date = $request->date;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Obter o arquivo de imagem
            $requestImage = $request->file('image');
    
            // Obter a extensão do arquivo
            $extension = $requestImage->extension();
    
            // Gerar um nome único para o arquivo
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
    
            // Mover a imagem para o diretório 'img/events'
            $requestImage->storeAs('public/img/events', $imageName); // Usando Storage::storeAs
    
            // Salvar o nome da imagem no banco
            $event->image = $imageName;
        }

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/')->with('mensagem', 'Evento cadastrado com sucesso!');
    }

   


    public function show($id)
    {

        $event = Event::findOrFail($id);
      
        $event->items = $event->items ?? [];

        $user = auth()->user();
        $hasUserJoined = false;
        if (auth()->check()) {
            $user = auth()->user();
            $hasUserJoined = $user->eventsParticipant()->where('events.id', $id)->exists();

        }

        return view('events.show', [
            'event' => $event,
            'hasUserJoined' => $hasUserJoined,
        ]);
    }

    

    public function dashboard()
    {
        $user = auth()->user();

        $events = $user->events;

        $eventsParticipant = $user->eventsParticipant;

        return view('events.dashboard', ['events' => $events, 'eventsParticipant' => $eventsParticipant]);
    }

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();

        return redirect()->route('events.dashboard')->with('msg', 'Deletado com sucesso!');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $event = Event::findOrFail($id);

        if($user->id != $event->user_id) {
            return redirect('/dashboard');
        }
        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token', '_method'); // Remove _token do array

        $event = Event::findOrFail($id);
        $event->update($data);
       
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'city' => 'required|string|max:255',
            'description' => 'required|string',
            // Não adicione validação para 'items'
        ]);
        $event->title = $request->title;
        $event->city = $request->city;
        $event->description = $request->description;
        $event->items = $request->items;
        $event->date = $request->date;

        if ($event->image && file_exists(public_path('img/events/' . $event->image))) {
            unlink(public_path('img/events/' . $event->image));
        }
        

            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $event->image = $imageName;
        

        $event->save();

        return redirect()->route('events.dashboard')->with('success', 'Evento atualizado!');
    }

    public function joinEvent($id) {

        $user = auth()->user();

        $user->eventsParticipant()->attach($id);

        $event = Event::findOrFail($id);
        
        
        return redirect('/dashboard')->with('msg', 'Você esta participando do evento: ' . $event->title);

    }   

   public function leaveEvent($id) {
        $user = auth()->user();

        $user->eventsParticipant()->detach($id);

        $event = Event::findOrFail($id);
        
        return redirect('/dashboard')->with('msg', 'Você saiu do evento: ' . $event->title);
    }
    
}
