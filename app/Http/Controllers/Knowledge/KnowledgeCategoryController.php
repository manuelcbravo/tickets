<?php

namespace App\Http\Controllers\Knowledge;

use App\Http\Controllers\Controller;
use App\Http\Requests\Knowledge\StoreKnowledgeCategoryRequest;
use App\Http\Requests\Knowledge\UpdateKnowledgeCategoryRequest;
use App\Models\KnowledgeCategory;
use App\Models\Proyecto;
use App\Services\Knowledge\KnowledgeCategoryService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class KnowledgeCategoryController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('knowledge/categories', [
            'categories' => KnowledgeCategory::query()
                ->with(['parent:id,nombre', 'proyecto:id,nombre'])
                ->withCount('articles')
                ->orderBy('orden')
                ->orderBy('nombre')
                ->get(),
            'projects' => Proyecto::query()->orderBy('nombre')->get(['id', 'nombre']),
        ]);
    }

    public function store(StoreKnowledgeCategoryRequest $request, KnowledgeCategoryService $service): RedirectResponse
    {
        $service->create($request->validated(), $request->user()->id);

        return back()->with('success', 'Categoria creada correctamente.');
    }

    public function update(UpdateKnowledgeCategoryRequest $request, KnowledgeCategory $category, KnowledgeCategoryService $service): RedirectResponse
    {
        $service->update($category, $request->validated(), $request->user()->id);

        return back()->with('success', 'Categoria actualizada correctamente.');
    }

    public function destroy(KnowledgeCategory $category, KnowledgeCategoryService $service): RedirectResponse
    {
        $service->delete($category);

        return back()->with('success', 'Categoria eliminada correctamente.');
    }
}
