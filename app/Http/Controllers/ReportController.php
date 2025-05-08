<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Tampilkan daftar report.
     */
    public function index()
    {
        $reports = Report::paginate(10);
        return view('report.index', compact('reports'));
    }

    /**
     * Tampilkan form pembuatan report baru.
     */
    public function create()
    {
        return view('report.create');
    }

    /**
     * Simpan report baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|string|max:255',
            'date_range'  => 'required|string',
        ]);

        Report::create($validated);

        return redirect()
            ->route('report.index')
            ->with('success', 'Report berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu report.
     */
    public function show(Report $report)
    {
        return view('report.show', compact('report'));
    }

    /**
     * Tampilkan form edit report.
     */
    public function edit(Report $report)
    {
        return view('report.edit', compact('report'));
    }

    /**
     * Update data report.
     */
    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'report_type' => 'required|string|max:255',
            'date_range'  => 'required|string',
        ]);

        $report->update($validated);

        return redirect()
            ->route('report.index')
            ->with('success', 'Report berhasil diupdate.');
    }

    /**
     * Hapus report.
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()
            ->route('report.index')
            ->with('success', 'Report berhasil dihapus.');
    }
}
