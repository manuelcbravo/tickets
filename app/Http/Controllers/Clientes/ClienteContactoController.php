<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clientes\StoreClienteContactoRequest;
use App\Http\Requests\Clientes\UpdateClienteContactoRequest;
use App\Models\Client;
use App\Models\ClienteContacto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ClienteContactoController extends Controller
{
    public function store(StoreClienteContactoRequest $request, Client $client): RedirectResponse
    {
        $this->saveContacto($client, new ClienteContacto(), $request->validated());

        return back()->with('success', 'Contacto creado correctamente.');
    }

    public function update(
        UpdateClienteContactoRequest $request,
        Client $client,
        ClienteContacto $contacto,
    ): RedirectResponse {
        abort_unless($contacto->client_id === $client->id, 404);

        $this->saveContacto($client, $contacto, $request->validated());

        return back()->with('success', 'Contacto actualizado correctamente.');
    }

    public function destroy(Client $client, ClienteContacto $contacto): RedirectResponse
    {
        abort_unless($contacto->client_id === $client->id, 404);

        $contacto->delete();

        return back()->with('success', 'Contacto eliminado correctamente.');
    }

    private function saveContacto(Client $client, ClienteContacto $contacto, array $data): void
    {
        DB::transaction(function () use ($client, $contacto, $data): void {
            if ($data['es_principal']) {
                $client->contactos()->update(['es_principal' => false]);
            }

            $contacto->fill([
                ...$data,
                'client_id' => $client->id,
            ]);
            $contacto->save();
        });
    }
}
