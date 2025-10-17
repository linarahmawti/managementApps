<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\ProgressReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KaryawanController extends Controller
{
    public function dashboard()
    {
        // Optimize queries with eager loading and caching
        $userId = Auth::id();

        $assignments = Assignment::where('karyawan_id', $userId)
            ->whereIn('status', ['pending', 'in_progress'])
            ->with(['barang:id,nama_barang,kode_barang']) // Only load needed fields
            ->orderBy('tanggal_assignment', 'desc')
            ->get(['id', 'barang_id', 'jumlah', 'lokasi_tujuan', 'status', 'tanggal_assignment', 'catatan']);

        $recentReports = ProgressReport::where('karyawan_id', $userId)
            ->with('assignment:id,status') // Load assignment untuk cek status
            ->orderBy('tanggal_laporan', 'desc')
            ->limit(5) // Reduce number of reports shown
            ->get(['id', 'assignment_id', 'nama_barang', 'lokasi_pengantaran', 'jumlah_diantar', 'status_pengantaran', 'tanggal_laporan']);

        // Cache statistics for better performance
        $stats = cache()->remember("user_stats_{$userId}", now()->addMinutes(15), function () use ($userId) {
            return [
                'total_reports' => ProgressReport::where('karyawan_id', $userId)->count(),
                'today_reports' => ProgressReport::where('karyawan_id', $userId)
                    ->whereDate('tanggal_laporan', today())->count(),
                'delivered_reports' => ProgressReport::where('karyawan_id', $userId)
                    ->where('status_pengantaran', 'delivered')->count(),
            ];
        });

        return view('karyawan.dashboard', compact('assignments', 'recentReports', 'stats'));
    }

    public function inputProgress()
    {
        // Get assignments for the authenticated karyawan
        $assignments = Assignment::where('karyawan_id', Auth::id())
            ->whereIn('status', ['pending', 'in_progress'])
            ->with(['barang:id,nama_barang,harga_barang'])
            ->get();

        return view('karyawan.input-progress', compact('assignments'));
    }

    public function storeProgress(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'nama_barang' => 'required|string|max:255',
            'lokasi_pengantaran' => 'required|string|max:255',
            'jumlah_diantar' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'harga_total' => 'required|numeric|min:0',
            'status_pengantaran' => 'required|in:on_delivery,delivered,failed',
            'catatan' => 'nullable|string',
        ]);

        // Verify assignment belongs to authenticated karyawan
        $assignment = Assignment::where('id', $request->assignment_id)
            ->where('karyawan_id', Auth::id())
            ->firstOrFail();

        // Validate jumlah_diantar doesn't exceed assignment jumlah
        if ($request->jumlah_diantar > $assignment->jumlah) {
            return redirect()->back()
                ->withErrors(['jumlah_diantar' => 'Jumlah diantar tidak boleh lebih dari jumlah assignment.'])
                ->withInput();
        }

        // Create progress report (status akan otomatis update melalui observer)
        $progressReport = ProgressReport::create([
            'assignment_id' => $request->assignment_id,
            'karyawan_id' => Auth::id(),
            'nama_barang' => $request->nama_barang,
            'lokasi_pengantaran' => $request->lokasi_pengantaran,
            'jumlah_diantar' => $request->jumlah_diantar,
            'harga_total' => $request->harga_total,
            'status_pengantaran' => $request->status_pengantaran,
            'catatan' => $request->catatan,
            'tanggal_laporan' => now(),
        ]);

        return redirect()->back()->with('success', 'Laporan pengantaran berhasil dikirim!');
    }

    public function showAssignment($id)
    {
        $assignment = Assignment::where('id', $id)
            ->where('karyawan_id', Auth::id())
            ->with('barang', 'progressReports')
            ->firstOrFail();

        return view('karyawan.assignment-detail', compact('assignment'));
    }
}
