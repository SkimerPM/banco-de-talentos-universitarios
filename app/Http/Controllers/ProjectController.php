<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['student', 'category']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('student', fn ($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('technology')) {
            $tech = $request->input('technology');
            $query->whereJsonContains('technologies', $tech);
        }

        $projects = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = Category::all();

        $allTechnologies = Project::whereNotNull('technologies')
            ->pluck('technologies')
            ->flatten()
            ->unique()
            ->values();

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'categories' => $categories,
            'allTechnologies' => $allTechnologies,
            'filters' => $request->only('search', 'category', 'status', 'technology'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Projects/Create', [
            'students' => Student::all(),
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'student_id' => 'required|exists:students,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'repository_url' => 'nullable|url|max:255',
            'demo_url' => 'nullable|url|max:255',
            'status' => 'required|in:in_progress,completed,published',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:50',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Proyecto creado exitosamente.');
    }

    public function show(Project $project)
    {
        $project->load(['student', 'category']);

        $related = Project::where('category_id', $project->category_id)
            ->where('id', '!=', $project->id)
            ->with('student')
            ->limit(4)
            ->get();

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'relatedProjects' => $related,
        ]);
    }

    public function edit(Project $project)
    {
        return Inertia::render('Projects/Edit', [
            'project' => $project,
            'students' => Student::all(),
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'student_id' => 'required|exists:students,id',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'repository_url' => 'nullable|url|max:255',
            'demo_url' => 'nullable|url|max:255',
            'status' => 'required|in:in_progress,completed,published',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:50',
        ]);

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Proyecto actualizado exitosamente.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado exitosamente.');
    }
}
