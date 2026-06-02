<?php

namespace App\Services\ProjectBilling;

use App\Models\ProyectoPago;
use App\Models\ProyectoPagoDocumento;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectPaymentDocumentService
{
    public function store(ProyectoPago $payment, UploadedFile $file, ?int $userId = null, ?string $description = null): ProyectoPagoDocumento
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $path = $file->storeAs(
            "project-payments/{$payment->id}",
            (string) Str::uuid().($extension ? ".{$extension}" : ''),
            'public',
        );

        return ProyectoPagoDocumento::query()->create([
            'pago_id' => $payment->id,
            'uploaded_by_id' => $userId,
            'nombre_original' => $file->getClientOriginalName(),
            'ruta' => $path,
            'disk' => 'public',
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'descripcion' => $description,
        ]);
    }

    public function delete(ProyectoPagoDocumento $document): void
    {
        Storage::disk($document->disk)->delete($document->ruta);
        $document->delete();
    }
}
