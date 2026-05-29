<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seguimientos\StoreSeguimientoRequest;
use App\Http\Requests\Seguimientos\UpdateSeguimientoRequest;
use App\Models\CatSeguimientoTipo;
use App\Models\Seguimiento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    public function tipos(): JsonResponse
    {
        $tipos = CatSeguimientoTipo::query()
            ->select(['id', 'nombre', 'descripcion'])
            ->orderBy('nombre')
            ->get();

        return response()->json([
            'data' => $tipos,
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_relacion' => ['required', 'uuid'],
            'tabla_relacion' => ['required', 'string'],
        ]);

        $seguimientos = Seguimiento::query()
            ->select([
                'id',
                'id_relacion',
                'tabla_relacion',
                'titulo',
                'seguimiento',
                'tipo_id',
                'estado',
                'prioridad',
                'fecha_seguimiento',
                'fecha_proxima_accion',
                'resultado',
                'observaciones',
                'created_by_user_id',
                'updated_by_user_id',
                'created_at',
                'updated_at',
            ])
            ->where('id_relacion', $validated['id_relacion'])
            ->where('tabla_relacion', $validated['tabla_relacion'])
            ->with([
                'tipo:id,nombre',
                'createdBy:id,name',
                'updatedBy:id,name',
            ])
            ->latest('fecha_seguimiento')
            ->latest('created_at')
            ->get();

        return response()->json([
            'data' => $seguimientos,
        ]);
    }

    public function store(StoreSeguimientoRequest $request): JsonResponse
    {
        $data = $request->validated();

        $seguimiento = Seguimiento::query()->create([
            'id_relacion' => $data['id_relacion'],
            'tabla_relacion' => $data['tabla_relacion'],
            'titulo' => $data['titulo'],
            'seguimiento' => $data['seguimiento'],
            'tipo_id' => $data['tipo_id'],
            'estado' => $data['estado'] ?? null,
            'prioridad' => $data['prioridad'] ?? null,
            'fecha_seguimiento' => $data['fecha_seguimiento'] ?? null,
            'fecha_proxima_accion' => $data['fecha_proxima_accion'] ?? null,
            'resultado' => $data['resultado'] ?? null,
            'observaciones' => $data['observaciones'] ?? null,
            'created_by_user_id' => $request->user()->id,
            'updated_by_user_id' => $request->user()->id,
        ]);

        $seguimiento->load([
            'tipo:id,nombre',
            'createdBy:id,name',
            'updatedBy:id,name',
        ]);

        return response()->json([
            'message' => 'Seguimiento creado correctamente.',
            'data' => $seguimiento,
        ], 201);
    }

    public function update(UpdateSeguimientoRequest $request, Seguimiento $seguimiento): JsonResponse
    {
        $data = $request->validated();

        if (
            $seguimiento->id_relacion !== $data['id_relacion'] ||
            $seguimiento->tabla_relacion !== $data['tabla_relacion']
        ) {
            abort(404);
        }

        $seguimiento->update([
            'titulo' => $data['titulo'],
            'seguimiento' => $data['seguimiento'],
            'tipo_id' => $data['tipo_id'],
            'estado' => $data['estado'] ?? null,
            'prioridad' => $data['prioridad'] ?? null,
            'fecha_seguimiento' => $data['fecha_seguimiento'] ?? null,
            'fecha_proxima_accion' => $data['fecha_proxima_accion'] ?? null,
            'resultado' => $data['resultado'] ?? null,
            'observaciones' => $data['observaciones'] ?? null,
            'updated_by_user_id' => $request->user()->id,
        ]);

        $seguimiento->load([
            'tipo:id,nombre',
            'createdBy:id,name',
            'updatedBy:id,name',
        ]);

        return response()->json([
            'message' => 'Seguimiento actualizado correctamente.',
            'data' => $seguimiento,
        ]);
    }

    public function destroy(Request $request, Seguimiento $seguimiento): JsonResponse
    {
        $validated = $request->validate([
            'id_relacion' => ['required', 'uuid'],
            'tabla_relacion' => ['required', 'string'],
        ]);

        if (
            $seguimiento->id_relacion !== $validated['id_relacion'] ||
            $seguimiento->tabla_relacion !== $validated['tabla_relacion']
        ) {
            abort(404);
        }

        $seguimiento->delete();

        return response()->json([
            'message' => 'Seguimiento eliminado correctamente.',
        ]);
    }
}
