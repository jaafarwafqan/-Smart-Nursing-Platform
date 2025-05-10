<?php

namespace App\Http\Controllers;

use App\Contracts\JournalServiceInterface;
use App\Models\Journal;
use Illuminate\Http\Request;
use App\Exports\JournalsExport;
use Maatwebsite\Excel\Facades\Excel;

class JournalController extends Controller
{
    public function __construct(private JournalServiceInterface $service)
    {
        $this->authorizeResource(Journal::class, 'journal');
    }

    public function index(Request $request)
    {
        $query = Journal::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('is_scopus_indexed')) {
            $query->where('is_scopus_indexed', $request->is_scopus_indexed);
        }

        if ($request->filled('is_clarivate_indexed')) {
            $query->where('is_clarivate_indexed', $request->is_clarivate_indexed);
        }

        $journals = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total' => Journal::count(),
            'local' => Journal::where('type', 'local')->count(),
            'international' => Journal::where('type', 'international')->count(),
            'scopus' => Journal::where('is_scopus_indexed', true)->count(),
            'clarivate' => Journal::where('is_clarivate_indexed', true)->count(),
        ];

        return view('journals.index', compact('journals', 'stats'));
    }

    public function create()
    {
        return view('journals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:local,international',
            'is_scopus_indexed' => 'boolean',
            'is_clarivate_indexed' => 'boolean',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $journal = $this->service->create($validated);

        return redirect()->route('journals.index')
            ->with('success', 'تم إضافة المجلة بنجاح');
    }

    public function show(Journal $journal)
    {
        $journal->load(['professorResearches']);
        return view('journals.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        return view('journals.edit', compact('journal'));
    }

    public function update(Request $request, Journal $journal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:local,international',
            'is_scopus_indexed' => 'boolean',
            'is_clarivate_indexed' => 'boolean',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $this->service->update($journal, $validated);

        return redirect()->route('journals.index')
            ->with('success', 'تم تحديث المجلة بنجاح');
    }

    public function destroy(Journal $journal)
    {
        $this->service->delete($journal);

        return redirect()->route('journals.index')
            ->with('success', 'تم حذف المجلة بنجاح');
    }

    public function export()
    {
        return Excel::download(new JournalsExport, 'journals.xlsx');
    }
} 