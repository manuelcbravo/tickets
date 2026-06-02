<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenameFileRequest;
use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use App\Support\Filesystem\MediaDisk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'related_table' => ['required', 'string', 'max:80'],
            'related_uuid' => ['required', 'uuid'],
        ]);

        $this->authorizeContext($request, $validated['related_table'], 'view');

        return response()->json([
            'files' => File::query()
                ->where('related_table', $validated['related_table'])
                ->where('related_uuid', $validated['related_uuid'])
                ->latest()
                ->get(),
        ]);
    }

    public function store(StoreFileRequest $request): RedirectResponse
    {
        $this->authorizeContext($request, $request->string('related_table')->toString(), 'manage');

        $uploadedFile = $request->file('file');
        $disk = MediaDisk::name();
        $path = $uploadedFile->store($request->string('related_table')->toString(). '/' . $request->string('related_uuid')->toString(), $disk);

        File::query()->create([
            'disk' => $disk,
            'path' => $path,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'mime_type' => $uploadedFile->getClientMimeType(),
            'size' => $uploadedFile->getSize(),
            'table_id' => $request->string('related_table')->toString(),
            'related_id' => 0,
            'related_table' => $request->string('related_table')->toString(),
            'related_uuid' => $request->string('related_uuid')->toString(),
        ]);

        return back()->with('success', 'Archivo subido correctamente.');
    }

    public function rename(RenameFileRequest $request, File $file): RedirectResponse
    {
        $validated = $request->validated();

        $this->authorizeContext($request, $validated['related_table'], 'manage');

        abort_unless(
            $file->related_table === $validated['related_table'] && $file->related_uuid === $validated['related_uuid'],
            403,
            'No autorizado para renombrar este archivo.',
        );

        $file->update([
            'original_name' => $validated['original_name'],
        ]);

        return back()->with('success', 'Archivo renombrado correctamente.');
    }

    public function destroy(Request $request, File $file): RedirectResponse
    {
        $validated = $request->validate([
            'related_table' => ['required', 'string', 'max:80'],
            'related_uuid' => ['required', 'uuid'],
        ]);

        $this->authorizeContext($request, $validated['related_table'], 'manage');

        abort_unless(
            $file->related_table === $validated['related_table'] && $file->related_uuid === $validated['related_uuid'],
            403,
            'No autorizado para eliminar este archivo.',
        );

        Storage::disk($file->disk)->delete($file->path);
        $file->delete();

        return back()->with('success', 'Archivo eliminado correctamente.');
    }

    private function authorizeContext(Request $request, string $relatedTable, string $action): void
    {
        $permissions = match ($relatedTable) {
            'projects' => $action === 'view'
                ? ['project-planning.documents.view', 'project-planning.documents.manage']
                : ['project-planning.documents.manage'],
            'proyecto_actividades' => $action === 'view'
                ? ['project-planning.activities.view', 'project-planning.activities.manage']
                : ['project-planning.activities.manage'],
            default => [],
        };

        if ($permissions === []) {
            return;
        }

        abort_unless(
            collect($permissions)->contains(fn (string $permission) => $request->user()?->can($permission)),
            403,
            'No autorizado para gestionar archivos en este contexto.',
        );
    }
}
