<?php

namespace App\Http\Controllers\ProjectBilling;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectBilling\StoreProjectPaymentDocumentRequest;
use App\Models\ProyectoPago;
use App\Models\ProyectoPagoDocumento;
use App\Services\ProjectBilling\ProjectPaymentDocumentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProjectPaymentDocumentController extends Controller
{
    public function store(StoreProjectPaymentDocumentRequest $request, ProyectoPago $payment, ProjectPaymentDocumentService $service): RedirectResponse
    {
        $service->store($payment, $request->file('archivo'), $request->user()->id, $request->input('descripcion'));

        return back()->with('success', 'Comprobante cargado correctamente.');
    }

    public function destroy(ProyectoPago $payment, ProyectoPagoDocumento $document, ProjectPaymentDocumentService $service): RedirectResponse
    {
        abort_unless($document->pago_id === $payment->id, 404);
        $service->delete($document);

        return back()->with('success', 'Comprobante eliminado.');
    }

    public function download(ProyectoPago $payment, ProyectoPagoDocumento $document): StreamedResponse
    {
        abort_unless($document->pago_id === $payment->id, 404);

        return Storage::disk($document->disk)->download($document->ruta, $document->nombre_original);
    }
}
