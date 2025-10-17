<?php

namespace App\Http\Controllers;

use App\Models\ProgressReport;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanProgressReportController extends Controller
{
    public function index()
    {
        // Optimize query with selective fields and proper pagination
        $reports = ProgressReport::where('karyawan_id', Auth::id())
            ->select(['id', 'assignment_id', 'nama_barang', 'lokasi_pengantaran', 'jumlah_diantar', 'harga_total', 'status_pengantaran', 'tanggal_laporan'])
            ->orderBy('tanggal_laporan', 'desc')
            ->paginate(15); // Increase pagination for better UX

        return view('karyawan.reports.index', compact('reports'));
    }

    public function create()
    {
        $assignments = Assignment::where('karyawan_id', Auth::id())
            ->where('status', '!=', 'completed')
            ->get();

        return view('karyawan.reports.create', compact('assignments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'nullable|exists:assignments,id',
            'nama_barang' => 'required|string|max:255',
            'lokasi_pengantaran' => 'required|string|max:255',
            'jumlah_diantar' => 'required|integer|min:1',
            'harga_total' => 'required|numeric|min:0',
            'status_pengantaran' => 'required|in:belum_dikirim,dalam_perjalanan,selesai',
            'catatan' => 'nullable|string',
            'tanggal_laporan' => 'required|date',
        ]);

        $validated['karyawan_id'] = Auth::id();

        ProgressReport::create($validated);

        return redirect()->route('karyawan.reports.index')
            ->with('success', 'Progress report berhasil dibuat!');
    }

    public function show(ProgressReport $report)
    {
        // Check if report belongs to authenticated karyawan
        if ($report->karyawan_id !== Auth::id()) {
            abort(403);
        }

        $report->load('assignment');
        return view('karyawan.reports.show', compact('report'));
    }

    public function edit(ProgressReport $report)
    {
        // Check if report belongs to authenticated karyawan
        if ($report->karyawan_id !== Auth::id()) {
            abort(403);
        }

        $assignments = Assignment::where('karyawan_id', Auth::id())
            ->get();

        return view('karyawan.reports.edit', compact('report', 'assignments'));
    }

    public function update(Request $request, ProgressReport $report)
    {
        // Check if report belongs to authenticated karyawan
        if ($report->karyawan_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'assignment_id' => 'nullable|exists:assignments,id',
            'nama_barang' => 'required|string|max:255',
            'lokasi_pengantaran' => 'required|string|max:255',
            'jumlah_diantar' => 'required|integer|min:1',
            'harga_total' => 'required|numeric|min:0',
            'status_pengantaran' => 'required|in:belum_dikirim,dalam_perjalanan,selesai',
            'catatan' => 'nullable|string',
            'tanggal_laporan' => 'required|date',
        ]);

        $report->update($validated);

        return redirect()->route('karyawan.reports.index')
            ->with('success', 'Progress report berhasil diupdate!');
    }

    public function destroy(ProgressReport $report)
    {
        // Check if report belongs to authenticated karyawan
        if ($report->karyawan_id !== Auth::id()) {
            abort(403);
        }

        $report->delete();

        return redirect()->route('karyawan.reports.index')
            ->with('success', 'Progress report berhasil dihapus!');
    }
}
