<?php

namespace App\Http\Controllers;

use App\Models\Research;
use App\Models\Student;
use App\Models\Professor;
use App\Services\ResearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResearchController extends Controller
{
    public function __construct(private ResearchService $service)
    {
        $this->authorizeResource(Research::class, 'research');
    }

    public function index()
    {
        $researches = Research::with(['students', 'professors'])->latest()->paginate(10);
        return view('researches.index', compact('researches'));
    }

    public function create()
    {
        $students = Student::all();
        $professors = Professor::all();
        return view('researches.create', compact('students', 'professors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string',
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            'student_roles' => 'required|array',
            'professors' => 'required|array',
            'professors.*' => 'exists:professors,id',
            'professor_roles' => 'required|array',
        ]);

        $research = Research::create([
            'title' => $validated['title'],
            'research_title' => $validated['title'],
            'research_type' => 'عام',
            'abstract' => $validated['abstract'],
            'keywords' => $validated['keywords'],
            'notes' => $validated['notes'],
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('research_files');
            $research->update(['file_path' => $path]);
        }

        // ربط الطلاب
        foreach ($validated['students'] as $index => $studentId) {
            $research->students()->attach($studentId, [
                'role' => $validated['student_roles'][$index]
            ]);
        }

        // ربط الأساتذة
        foreach ($validated['professors'] as $index => $professorId) {
            $research->professors()->attach($professorId, [
                'role' => $validated['professor_roles'][$index]
            ]);
        }

        return redirect()->route('researches.index')
            ->with('success', 'تم إنشاء البحث بنجاح');
    }

    public function show(Research $research)
    {
        $research->load(['students', 'professors']);
        return view('researches.show', compact('research'));
    }

    public function edit(Research $research)
    {
        $research->load(['students', 'professors']);
        $students = Student::all();
        $professors = Professor::all();
        return view('researches.edit', compact('research', 'students', 'professors'));
    }

    public function update(Request $request, Research $research)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'notes' => 'nullable|string',
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            'student_roles' => 'required|array',
            'professors' => 'required|array',
            'professors.*' => 'exists:professors,id',
            'professor_roles' => 'required|array',
        ]);

        $research->update([
            'title' => $validated['title'],
            'research_title' => $validated['title'],
            'research_type' => 'عام',
            'abstract' => $validated['abstract'],
            'keywords' => $validated['keywords'],
            'notes' => $validated['notes'],
        ]);

        if ($request->hasFile('file')) {
            if ($research->file_path) {
                Storage::delete($research->file_path);
            }
            $path = $request->file('file')->store('research_files');
            $research->update(['file_path' => $path]);
        }

        // تحديث روابط الطلاب
        $research->students()->detach();
        foreach ($validated['students'] as $index => $studentId) {
            $research->students()->attach($studentId, [
                'role' => $validated['student_roles'][$index]
            ]);
        }

        // تحديث روابط الأساتذة
        $research->professors()->detach();
        foreach ($validated['professors'] as $index => $professorId) {
            $research->professors()->attach($professorId, [
                'role' => $validated['professor_roles'][$index]
            ]);
        }

        return redirect()->route('researches.index')
            ->with('success', 'تم تحديث البحث بنجاح');
    }

    public function destroy(Research $research)
    {
        if ($research->file_path) {
            Storage::delete($research->file_path);
        }
        $research->delete();
        return redirect()->route('researches.index')
            ->with('success', 'تم حذف البحث بنجاح');
    }

    public function download(Research $research)
    {
        if (!$research->file_path) {
            return back()->with('error', 'لا يوجد ملف للبحث');
        }
        return Storage::download($research->file_path);
    }
}
