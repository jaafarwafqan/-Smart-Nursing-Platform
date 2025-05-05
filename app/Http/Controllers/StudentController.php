<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Research;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::query()
            ->when($request->input('study_type'), fn($q, $type) => $q->where('study_type', $type))
            ->when($request->input('search'), fn($q, $s) => $q->where('name', 'like', "%$s%"))
            ->when($request->input('gender'), fn($q, $g) => $q->where('gender', $g))
            ->orderBy('id', 'desc')
            ->paginate(20);

        $stats = [
            'total'    => Student::count(),
            'ug'       => Student::where('study_type', 'أولية')->count(),
            'pg'       => Student::whereIn('study_type', ['ماجستير', 'دكتوراه'])->count(),
            'female'   => Student::where('gender', 'أنثى')->count(),
        ];

        return view('students.index', compact('students', 'stats'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'birthdate' => 'nullable|date',
            'university_number' => 'nullable|string|unique:students',
            'study_type' => 'required',
            'study_year' => 'nullable|integer',
            'program' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'notes' => 'nullable|string',
        ]);
        Student::create($data);
        return redirect()->route('students.index')->with('success', 'تمت إضافة الطالب بنجاح');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'birthdate' => 'nullable|date',
            'university_number' => 'required|unique:students,university_number,' . $student->id,
            'study_type' => 'required',
            'study_year' => 'nullable|integer',
            'program' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'notes' => 'nullable|string',
        ]);
        $student->update($data);
        return redirect()->route('students.index')->with('success', 'تم تحديث بيانات الطالب');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'تم حذف الطالب');
    }

    // استيراد الطلاب من Excel (واجهة رفع الملف)
    public function importForm()
    {
        return view('students.import');
    }

    // تنفيذ الاستيراد
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);
        Excel::import(new StudentsImport, $request->file('file'));
        return redirect()->route('students.index')->with('success', 'تم استيراد الطلاب بنجاح');
    }

    // تصدير الطلاب إلى Excel
    public function export(Request $request)
    {
        // return Excel::download(new StudentsExport, 'students.xlsx');
        return response()->json(['message' => 'تم التصدير (نموذج)']);
    }

    // ربط طالب ببحث
    public function attachResearch(Request $request, Student $student)
    {
        $data = $request->validate([
            'research_id' => 'required|exists:researches,id',
            'supervisor_id' => 'nullable|exists:professors,id',
            'study_type' => 'required',
            'status' => 'required',
        ]);
        $student->researches()->attach($data['research_id'], [
            'supervisor_id' => $data['supervisor_id'] ?? null,
            'study_type' => $data['study_type'],
            'status' => $data['status'],
        ]);
        return redirect()->route('students.show', $student)->with('success', 'تم ربط البحث بالطالب');
    }
} 