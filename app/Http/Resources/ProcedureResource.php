<?php

namespace App\Http\Resources;

use App\Models\LegalRepresentative;
use App\Models\Person;
use App\Models\User;
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
                $procedureApplicant = $this->applicant;
                $applicant = [];
                if ($procedureApplicant instanceof Person) {
                    $person = $procedureApplicant;
                    $applicant['email'] = $person->email;
                } elseif ($procedureApplicant instanceof LegalRepresentative) {
                    $person = $procedureApplicant->person;
                    $applicant['email'] = $person->email;
                } elseif ($procedureApplicant instanceof User) {
                    $person = $procedureApplicant->person;
                    $applicant['email'] = $procedureApplicant->email; // el correo será tomado del usuario
                }
                $applicant['type'] = class_basename($this->applicant_type);
                $applicant['id'] = $this->applicant->id;
                $applicant['name'] = $person->name ?? null;
                $applicant['last_name'] = $person->last_name ?? null;
                $applicant['second_last_name'] = $person->second_last_name ?? null;
                $applicant['phone'] = $person->phone ?? null;
                return $applicant;
            }),
            'procedure_files' => $this->procedure_files->map(function ($procedure_file) {
                return [
                    'id' => $procedure_file->id,
                    'name' => $procedure_file->name,
                    'path' => $procedure_file->path,
                    'uuid' => $procedure_file->uuid,
                ];
            }),
            'procedure_link' => $this->procedure_link->url ?? null,
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
