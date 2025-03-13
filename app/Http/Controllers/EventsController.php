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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],  $mensagem);

        $event = new Event;
        $event->fill($request->only(['title', 'city', 'description', 'date']));
        $event->items = $request->items ?? [];

        $event->tech_tags = $request->tech_tags ?? [];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->file('image');
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            // Salva a imagem diretamente na pasta public
            $requestImage->move(public_path('img/events'), $imageName);

            $event->image = $imageName;
        }

        $event->user_id = auth()->id();
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

        if ($user->id != $event->user_id) {
            return redirect('/dashboard');
        }
        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Validação
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'city' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event->tech_tags = $request->tech_tags ?? [];
        // Atualiza os dados básicos
        $event->fill($request->only(['title', 'city', 'description', 'date']));
        $event->items = $request->items ?? [];

        // Verifica se uma nova imagem foi enviada
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                // Remove a imagem antiga se existir
                if ($event->image && file_exists(public_path('img/events/' . $event->image))) {
                    unlink(public_path('img/events/' . $event->image));
                }

                $requestImage = $request->file('image');
                $extension = $requestImage->extension();
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

                $requestImage->move(public_path('img/events'), $imageName);
                $event->image = $imageName;
            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Erro ao fazer upload da imagem: ' . $e->getMessage());
            }
        }

        $event->save();

        return redirect()
            ->route('events.dashboard')
            ->with('msg', 'Evento atualizado com sucesso!');
    }

    public function joinEvent($id)
    {

        $user = auth()->user();

        $user->eventsParticipant()->attach($id);

        $event = Event::findOrFail($id);


        return redirect('/dashboard')->with('msg', 'Você esta participando do evento: ' . $event->title);
    }

    public function leaveEvent($id)
    {
        $user = auth()->user();

        $user->eventsParticipant()->detach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu do evento: ' . $event->title);
    }
}
