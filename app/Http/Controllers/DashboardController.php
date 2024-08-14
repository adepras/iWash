<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();

        $todayBookingsCount = Booking::whereDate('created_at', Carbon::today())->count();

        $yearlyIncome = Booking::whereYear('created_at', Carbon::now()->year)->sum('total_price');

        $monthlyIncome = Booking::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        $weeklyIncome = Booking::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('total_price');

        $dailyIncome = Booking::whereDate('created_at', Carbon::today())->sum('total_price');

        $incomeLabels = [];
        $incomeData = [];
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths($i);
            $incomeLabels[] = $month->format('F');
            $incomeData[] = Booking::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_price');
        }

        $satisfactionData = [
            'Kurang Baik' => Booking::where('satisfaction', 'Kurang Baik')->count(),
            'Baik' => Booking::where('satisfaction', 'Baik')->count(),
            'Sangat Baik' => Booking::where('satisfaction', 'Sangat Baik')->count(),
        ];        

        return view('admin.menu.dashboard', [
            'userCount' => $userCount,
            'todayBookingsCount' => $todayBookingsCount,
            'yearlyIncome' => $yearlyIncome,
            'monthlyIncome' => $monthlyIncome,
            'weeklyIncome' => $weeklyIncome,
            'dailyIncome' => $dailyIncome,
            'incomeLabels' => array_reverse($incomeLabels),
            'incomeData' => array_reverse($incomeData),
            'satisfactionData' => array_values($satisfactionData)
        ]);
    }
}
