<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Event;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\Request;
use App\Services\EventService;

class EventsController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $events = $this->eventService->getAllEvents($search);

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
        ];
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'city' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
        ],  $mensagem);

        $this->eventService->createEvent(
            $request->all(),
            $request->file('image'),
            auth()->id()
        );

        return redirect('/')->with('mensagem', 'Evento cadastrado com sucesso!');
    }

    public function show($id)
    {
        $event = $this->eventService->getEventById($id);

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
        $this->eventService->deleteEvent($id);

        return redirect()->route('events.dashboard')->with('msg', 'Deletado com sucesso!');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $event = $this->eventService->getEventById($id);

        if ($user->id != $event->user_id) {
            return redirect('/dashboard');
        }
        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        // Validação
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'city' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        $this->eventService->updateEvent(
            $id, 
            $request->all(), 
            $request->file('image')
        );

        return redirect()
            ->route('events.dashboard')
            ->with('msg', 'Evento atualizado com sucesso!');
    }

    public function joinEvent($id)
    {
        $event = $this->eventService->getEventById($id);
        $this->eventService->joinEvent($id, auth()->user());

        return redirect('/dashboard')->with('msg', 'Você esta participando do evento: ' . $event->title);
    }

    public function leaveEvent($id)
    {
        $event = $this->eventService->getEventById($id);
        $this->eventService->leaveEvent($id, auth()->user());

        return redirect('/dashboard')->with('msg', 'Você saiu do evento: ' . $event->title);
    }
}
