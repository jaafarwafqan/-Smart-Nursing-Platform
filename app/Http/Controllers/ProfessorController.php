<?php

namespace App\Http\Controllers;

use App\Imports\ProfessorsImport;
use App\Models\Professor;
use App\Models\Research;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ProfessorController extends Controller
{
    public function index(Request $request)
    {
        $professors = Professor::query()
            ->when($request->input('search'), fn($q, $s) => $q->where('name', 'like', "%$s%"))
            ->orderBy('id', 'desc')
            ->paginate(20);

        $stats = [
            'total'      => Professor::count(),
            'professors' => Professor::where('academic_rank', 'أستاذ')->count(),
            'assistants' => Professor::where('academic_rank', 'أستاذ مساعد')->count(),
            'female'     => Professor::where('gender', 'أنثى')->count(),
        ];

        return view('professors.index', compact('professors', 'stats'));
    }

    public function create()
    {
        return view('professors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'academic_rank' => 'nullable|string',
            'college' => 'nullable|string',
            'department' => 'nullable|string',
            'research_interests' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'notes' => 'nullable|string',
        ]);
        Professor::create($data);
        return redirect()->route('professors.index')->with('success', 'تمت إضافة الأستاذ بنجاح');
    }

    public function edit(Professor $professor)
    {
        return view('professors.edit', compact('professor'));
    }

    public function update(Request $request, Professor $professor)
    {
        $data = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'academic_rank' => 'nullable|string',
            'college' => 'nullable|string',
            'department' => 'nullable|string',
            'research_interests' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'notes' => 'nullable|string',
        ]);
        $professor->update($data);
        return redirect()->route('professors.index')->with('success', 'تم تحديث بيانات الأستاذ');
    }

    public function destroy(Professor $professor)
    {
        $professor->delete();
        return redirect()->route('professors.index')->with('success', 'تم حذف الأستاذ');
    }

    // استيراد الأساتذة من Excel (واجهة رفع الملف)
    public function importForm()
    {
        return view('professors.import');
    }

    // تنفيذ الاستيراد
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new ProfessorsImport, $request->file('file'));
            return back()->withSuccess('تم الاستيراد بنجاح.');
        } catch (ValidationException $e) {
            $errors = collect($e->failures())->map(function($f){
                return "الصف {$f->row()}: " . implode('، ', $f->errors());
            });
            return back()->withErrors($errors->all());
        }
    }

    // تصدير الأساتذة إلى Excel
    public function export(Request $request)
    {
        // return Excel::download(new ProfessorsExport, 'professors.xlsx');
        return response()->json(['message' => 'تم التصدير (نموذج)']);
    }

    // ربط أستاذ ببحث
    public function attachResearch(Request $request, Professor $professor)
    {
        $data = $request->validate([
            'research_id' => 'required|exists:researches,id',
            'role' => 'nullable|string',
        ]);
        $professor->researches()->attach($data['research_id'], [
            'role' => $data['role'] ?? null,
        ]);
        return redirect()->route('professors.show', $professor)->with('success', 'تم ربط البحث بالأستاذ');
    }
}
