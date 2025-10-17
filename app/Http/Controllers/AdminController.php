<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressReport;
use App\Models\Assignment;
use App\Models\Barang;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function analytics()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Analytics for today
        $todayStats = [
            'total_deliveries' => ProgressReport::whereDate('tanggal_laporan', $today)->count(),
            'total_revenue' => ProgressReport::whereDate('tanggal_laporan', $today)->sum('harga_total'),
            'delivered_items' => ProgressReport::whereDate('tanggal_laporan', $today)->sum('jumlah_diantar'),
            'unique_locations' => ProgressReport::whereDate('tanggal_laporan', $today)->distinct('lokasi_pengantaran')->count(),
        ];

        // Analytics for this month
        $monthlyStats = [
            'total_deliveries' => ProgressReport::whereBetween('tanggal_laporan', [$startOfMonth, $endOfMonth])->count(),
            'total_revenue' => ProgressReport::whereBetween('tanggal_laporan', [$startOfMonth, $endOfMonth])->sum('harga_total'),
            'delivered_items' => ProgressReport::whereBetween('tanggal_laporan', [$startOfMonth, $endOfMonth])->sum('jumlah_diantar'),
            'unique_locations' => ProgressReport::whereBetween('tanggal_laporan', [$startOfMonth, $endOfMonth])->distinct('lokasi_pengantaran')->count(),
        ];

        // Top performing employees
        $topEmployees = ProgressReport::select('karyawan_id', DB::raw('COUNT(*) as total_reports'), DB::raw('SUM(harga_total) as total_revenue'))
            ->whereBetween('tanggal_laporan', [$startOfMonth, $endOfMonth])
            ->groupBy('karyawan_id')
            ->with('karyawan')
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        // Recent progress reports
        $recentReports = ProgressReport::with(['karyawan', 'assignment.barang'])
            ->orderBy('tanggal_laporan', 'desc')
            ->take(10)
            ->get();

        // Daily revenue chart data (last 7 days)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenue = ProgressReport::whereDate('tanggal_laporan', $date)->sum('harga_total');
            $chartData[] = [
                'date' => $date->format('M d'),
                'revenue' => $revenue
            ];
        }

        return view('admin.analytics', compact(
            'todayStats',
            'monthlyStats',
            'topEmployees',
            'recentReports',
            'chartData'
        ));
    }
}
