<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalProjects = Project::count();
        $totalCategories = Category::count();

        $projectsByStatus = Project::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $projectsByCategory = Category::withCount('projects')
            ->orderByDesc('projects_count')
            ->get();

        $topStudents = Student::withCount('projects')
            ->orderByDesc('projects_count')
            ->limit(5)
            ->get();

        $recentProjects = Project::with(['student', 'category'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $topTechnologies = Project::whereNotNull('technologies')
            ->pluck('technologies')
            ->flatten()
            ->countBy()
            ->sortDesc()
            ->take(10);

        $projectsByUniversity = Student::join('projects', 'students.id', '=', 'projects.student_id')
            ->select('students.university', DB::raw('count(projects.id) as total'))
            ->groupBy('students.university')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => [
                'totalStudents' => $totalStudents,
                'totalProjects' => $totalProjects,
                'totalCategories' => $totalCategories,
            ],
            'projectsByStatus' => $projectsByStatus,
            'projectsByCategory' => $projectsByCategory,
            'topStudents' => $topStudents,
            'recentProjects' => $recentProjects,
            'topTechnologies' => $topTechnologies,
            'projectsByUniversity' => $projectsByUniversity,
        ]);
    }
}
