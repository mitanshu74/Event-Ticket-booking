<?php

namespace App\Domain\Api\Request;

use App\Http\Requests\ApiRequest;

class DeleteEventRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * You can add admin authorization logic here if needed.
     */
    public function authorize(): bool
    {
        return true; // Set to true if already protected by middleware
    }

    /**
     * Validation rules for deleting an event
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:events,id'
        ];
    }

    /**
     * Perform the deletion of the event.
     */
    public function handleDeletion(): array
    {
        $event = Event::find($this->id);

        if (!$event) {
            return [
                'success' => false,
                'message' => 'Event not found.'
            ];
        }

        // Delete image if exists
        if ($event->image && \Storage::exists($event->image)) {
            \Storage::delete($event->image);
        }

        $event->delete();

        return [
            'success' => true,
            'message' => 'Event deleted successfully.'
        ];
    }
}
