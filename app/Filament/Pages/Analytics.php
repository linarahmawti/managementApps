<?php

namespace App\Filament\Pages;

use UnitEnum;
use BackedEnum;
use Filament\Pages\Page;
use App\Models\ProgressReport;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Analytics extends Page
{
    protected const REVENUE_COLUMN = 'harga_total';

    protected string $view = 'admin.analytics';

    protected static ?string $navigationLabel = 'Analytics Dashboard';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static string|UnitEnum|null $navigationGroup = 'Dashboard';

    public $todayStats = [];
    public $monthlyStats = [];
    public $chartData = [];
    public $topEmployees;
    public $recentReports;

    public function mount(): void
    {
        $this->loadAnalyticsData();
    }

    protected function loadAnalyticsData(): void
    {
        // Variabel waktu
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfLastSevenDays = Carbon::now()->subDays(6)->startOfDay();

        // 2 & 3. Mendapatkan Laporan Hari Ini & Bulan Ini
        $todayReports = ProgressReport::whereDate('tanggal_laporan', $today)->get();
        $monthlyReports = ProgressReport::whereBetween('tanggal_laporan', [$startOfMonth, $today])->get();

        $this->todayStats = [
            'total_deliveries' => $todayReports->count(),
            // MENGGUNAKAN self::REVENUE_COLUMN
            'total_revenue' => $todayReports->sum(self::REVENUE_COLUMN),
            'delivered_items' => $todayReports->sum('jumlah_diantar'),
            'unique_locations' => $todayReports->pluck('lokasi_pengantaran')->unique()->count(),
        ];

        $this->monthlyStats = [
            'total_deliveries' => $monthlyReports->count(),
            // MENGGUNAKAN self::REVENUE_COLUMN
            'total_revenue' => $monthlyReports->sum(self::REVENUE_COLUMN),
            'delivered_items' => $monthlyReports->sum('jumlah_diantar'),
            'unique_locations' => $monthlyReports->pluck('lokasi_pengantaran')->unique()->count(),
        ];

        // 4. Trend Pendapatan
        $revenueTrend = ProgressReport::select(
                DB::raw('DATE(tanggal_laporan) as date'),
                // MENGGUNAKAN self::REVENUE_COLUMN
                DB::raw('SUM(' . self::REVENUE_COLUMN . ') as revenue')
            )
            ->where('tanggal_laporan', '>=', $startOfLastSevenDays)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $this->chartData = $this->formatChartData($revenueTrend, $startOfLastSevenDays);

        // 5 & 6. Karyawan Terbaik & Laporan Terbaru
        $this->topEmployees = ProgressReport::with('karyawan')
            ->select('karyawan_id',
                     DB::raw('COUNT(*) as total_reports'),
                     // MENGGUNAKAN self::REVENUE_COLUMN
                     DB::raw('SUM(' . self::REVENUE_COLUMN . ') as total_revenue')
            )
            ->where('tanggal_laporan', '>=', $startOfMonth)
            ->groupBy('karyawan_id')
            ->orderBy('total_reports', 'desc')
            ->limit(5)
            ->get();

        $this->recentReports = ProgressReport::with('karyawan')
            ->orderBy('tanggal_laporan', 'desc')
            ->limit(10)
            ->get();
    }

    protected function formatChartData($revenueTrend, $startDate): array
    {
        $dataMap = $revenueTrend->keyBy(fn($item) => Carbon::parse($item->date)->format('D'))
                                ->map(fn($item) => $item->revenue)->toArray();
        $chartData = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dayName = $date->format('D');
            $chartData[] = ['date' => $dayName, 'revenue' => $dataMap[$dayName] ?? 0];
        }
        return $chartData;
    }
}
