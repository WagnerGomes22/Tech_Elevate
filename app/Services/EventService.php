<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Http\UploadedFile;

class EventService
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    /**
     * Get all events or search by title
     */
    public function getAllEvents(?string $search)
    {
        if ($search) {
            return Event::where('title', 'like', '%' . $search . '%')->get();
        }

        return Event::all();
    }

    /**
     * Create a new event
     */
    public function createEvent(array $data, ?UploadedFile $imageFile, int $userId): Event
    {
        $event = new Event;
        $event->fill([
            'title' => $data['title'] ?? null,
            'city' => $data['city'] ?? null,
            'description' => $data['description'] ?? null,
            'date' => $data['date'] ?? null
        ]);
        
        $event->items = $data['items'] ?? [];
        $event->tech_tags = $data['tech_tags'] ?? [];

        if ($imageFile && $imageFile->isValid()) {
            $event->image = $this->imageUploadService->upload($imageFile);
        }

        $event->user_id = $userId;
        $event->save();

        return $event;
    }

    /**
     * Find an event by ID
     */
    public function getEventById(int $id): Event
    {
        $event = Event::findOrFail($id);
        $event->items = $event->items ?? [];
        
        return $event;
    }

    /**
     * Update an existing event
     */
    public function updateEvent(int $id, array $data, ?UploadedFile $imageFile): Event
    {
        $event = Event::findOrFail($id);
        $event->fill([
            'title' => $data['title'] ?? $event->title,
            'city' => $data['city'] ?? $event->city,
            'description' => $data['description'] ?? $event->description,
            'date' => $data['date'] ?? $event->date
        ]);
        
        $event->items = $data['items'] ?? [];
        $event->tech_tags = $data['tech_tags'] ?? [];

        if ($imageFile && $imageFile->isValid()) {
            // Remove a imagem antiga se existir
            $this->imageUploadService->delete($event->image);
            
            // Faz o upload da nova
            $event->image = $this->imageUploadService->upload($imageFile);
        }

        $event->save();

        return $event;
    }

    /**
     * Delete an event
     */
    public function deleteEvent(int $id): void
    {
        $event = Event::findOrFail($id);
        
        // (Opcional) Poderíamos remover a imagem aqui também se fosse regra de negócio:
        // $this->imageUploadService->delete($event->image);

        $event->delete();
    }

    /**
     * Join an event
     */
    public function joinEvent(int $eventId, $user): void
    {
        $user->eventsParticipant()->attach($eventId);
    }

    /**
     * Leave an event
     */
    public function leaveEvent(int $eventId, $user): void
    {
        $user->eventsParticipant()->detach($eventId);
    }
}
