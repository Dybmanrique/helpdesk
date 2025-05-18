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
            'applicant' => $this->whenLoaded('applicant', function () {
                return [
                    'type' => class_basename($this->applicant_type),
                    'id' => $this->applicant->id,
                    'name' => $this->applicant->name ?? null, // Suponiendo que tiene name
                    'last_name' => $this->applicant->last_name ?? null, // Suponiendo que tiene name
                    'second_last_name' => $this->applicant->second_last_name ?? null, // Suponiendo que tiene name
                    'email' => $this->applicant->email ?? null, // Si aplica
                    'phone' => $this->applicant->phone ?? null, // Si aplica
                    // puedes adaptar según el tipo de modelo
                ];
            }),
            'procedure_files' => $this->procedure_files->map(function ($procedure_file) {
                return [
                    'id' => $procedure_file->file->id,
                    'name' => $procedure_file->file->name,
                    'path' => $procedure_file->file->path,
                    'uuid' => $procedure_file->file->uuid,
                ];
            }),
            'actions' => $this->actions->map(function ($action) {
                return [
                    'id' => $action->id,
                    'comment' => $action->comment,
                    'action' => $action->action,
                    'created_at' => $action->created_at->toDateTimeString(),
                    'files' => $action->action_files->map(function ($action_file) {
                        return [
                            'id' => $action_file->file->id,
                            'name' => $action_file->file->name,
                            'path' => $action_file->file->path, // suponiendo que tienes un campo o método `url`
                            'uuid' => $action_file->file->uuid,
                        ];
                    }),
                ];
            }),
        ];
    }
}
