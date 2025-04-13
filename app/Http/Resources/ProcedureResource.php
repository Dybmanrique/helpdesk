<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcedureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'expedient_number' => $this->expedient_number,
            'ticket' => $this->ticket,
            'reason' => $this->reason,
            'description' => $this->description,
            'state' => $this->state->name,
            'category' => $this->category->name,
            'priority' => $this->priority->name,
            'document_type' => $this->document_type->name,
            'user' => $this->user ? [
                'email' => $this->user->email,
                'name' => optional($this->user->person)->name,
                'last_name' => optional($this->user->person)->last_name,
                'second_last_name' => optional($this->user->person)->second_last_name,
                'identity_number' => optional($this->user->person)->identity_number,
                'address' => optional($this->user->person)->address,
                'phone' => optional($this->user->person)->phone,
            ] : null,
            'files' => $this->files->map(function ($file) {
                return [
                    'id' => $file->id,
                    'name' => $file->name,
                    'path' => $file->path,
                ];
            }),
            'actions' => $this->actions->map(function ($action) {
                return [
                    'id' => $action->id,
                    'comment' => $action->comment,
                    'action' => $action->action,
                    'created_at' => $action->created_at->toDateTimeString(),
                    'files' => $action->action_files->map(function ($file) {
                        return [
                            'id' => $file->id,
                            'name' => $file->name,
                            'path' => $file->path, // suponiendo que tienes un campo o método `url`
                        ];
                    }),
                ];
            }),
        ];
    }
}
