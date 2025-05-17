<?php

namespace App\Services;

use App\Mail\ProcedureCreatedMail;
use App\Models\AdministrativeUser;
use App\Models\Derivation;
use App\Models\File;
use App\Models\Office;
use App\Models\Procedure;
use App\Models\ProcedureFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ProcedureService
{
    use WithFileUploads;

    public function generateUniqueProcedureTicket()
    {
        do {
            $procedureTicket = Str::uuid(); // uuid
        } while (Procedure::where('ticket', $procedureTicket)->exists());
        return $procedureTicket;
    }

    public function saveProcedureFiles($file, $applicantId, Procedure $procedure)
    {
        $extension = $file->extension();
        $folder = $extension === 'pdf' ? 'pdfs' : 'images';
        $file = File::create([
            'name' => $file->getClientOriginalName(),
            'path' => $file->store('helpdesk/procedure_files/' . (Auth::check() ? 'auth' : 'guest') . '/' . $applicantId . '/' . $folder),
        ]);
        ProcedureFile::create([
            'procedure_id' => $procedure->id,
            'file_id' => $file->id,
        ]);
    }

    public function saveFirstProcedureDerivation(Procedure $procedure)
    {
        $office = Office::where('name', 'Mesa de partes')->first();
        if ($office) {
            $administrativeUser = AdministrativeUser::where('office_id', $office->id)->where('is_default', true)->first();
            if ($administrativeUser) {
                Derivation::create([
                    'procedure_id' => $procedure->id,
                    'user_id' => $administrativeUser->user_id,
                    'office_id' => $office->id,
                ]);
            }
        }
    }

    public function sendProcedureCreatedEmail($email, Procedure $procedure)
    {
        try {
            Mail::to($email)->send(new ProcedureCreatedMail($procedure));
            $emailStatusMessage = '<span><b>Nota: </b>La información adicional fue enviada a su correo: <b>' . $email . '</b></span>';
        } catch (\Exception $e) {;
            $emailStatusMessage = '<span style="color: #d33"><b>Nota: </b>Ocurrió un problema al enviar la información adicional a su correo: <b>' . $email . '</b></span>';
        }
        return $emailStatusMessage;
    }
}
