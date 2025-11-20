<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Banking;
use App\Models\AccountsReceivable;
use App\Models\AccountsPayable;
use App\Models\AccountProfitLoss;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function dashboard()
    {
        // Total Income Calculations
        $totalIncome = Income::sum('amount');
        $totalReceived = Income::sum('received_value');
        $pendingIncome = $totalIncome - $totalReceived;
        
        // Income by type
        $corporateIncome = Income::where('type', 'corporate')->sum('amount');
        $onlineIncome = Income::where('type', 'online')->sum('amount');
        
        // Monthly Income (last 6 months) - FIXED QUERY
        $monthlyIncome = Income::select(
            DB::raw('YEAR(date) as year'),
            DB::raw('MONTH(date) as month'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('SUM(received_value) as total_received')
        )
        ->where('date', '>=', Carbon::now()->subMonths(6))
        ->groupBy(DB::raw('YEAR(date)'), DB::raw('MONTH(date)'))
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
        
        // Alternative method for monthly income (if above doesn't work)
        // $monthlyIncome = DB::table('incomes')
        //     ->select(
        //         DB::raw('YEAR(date) as year'),
        //         DB::raw('MONTH(date) as month'),
        //         DB::raw('SUM(amount) as total_amount'),
        //         DB::raw('SUM(received_value) as total_received')
        //     )
        //     ->where('date', '>=', Carbon::now()->subMonths(6))
        //     ->groupBy(DB::raw('YEAR(date)'), DB::raw('MONTH(date)'))
        //     ->orderBy('year', 'desc')
        //     ->orderBy('month', 'desc')
        //     ->get();
        
        // Recent Incomes (last 10 records)
        $recentIncomes = Income::with(['rfq'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Other Financial Metrics
        $totalExpenses = Expense::sum('amount');
        $totalBankDeposits = Banking::sum('deposit');
        $totalBankWithdrawals = Banking::sum('withdraw');
        $totalReceivables = AccountsReceivable::sum('client_amount');
        $totalPayables = AccountsPayable::sum('principal_amount');
        
        // Profit/Loss Summary
        $totalProfit = AccountProfitLoss::sum('profit');
        $totalLoss = AccountProfitLoss::sum('loss');
        $netProfitLoss = $totalProfit - $totalLoss;

        // Additional calculations for better insights
        $currentMonthIncome = Income::whereYear('date', Carbon::now()->year)
            ->whereMonth('date', Carbon::now()->month)
            ->sum('amount');

        $previousMonthIncome = Income::whereYear('date', Carbon::now()->subMonth()->year)
            ->whereMonth('date', Carbon::now()->subMonth()->month)
            ->sum('amount');

        $incomeGrowth = $previousMonthIncome > 0 
            ? (($currentMonthIncome - $previousMonthIncome) / $previousMonthIncome) * 100 
            : 0;
        
        return view('admin.account.dashboard', compact(
            'totalIncome',
            'totalReceived',
            'pendingIncome',
            'corporateIncome',
            'onlineIncome',
            'monthlyIncome',
            'recentIncomes',
            'totalExpenses',
            'totalBankDeposits',
            'totalBankWithdrawals',
            'totalReceivables',
            'totalPayables',
            'totalProfit',
            'totalLoss',
            'netProfitLoss',
            'currentMonthIncome',
            'previousMonthIncome',
            'incomeGrowth'
        ));
    }
}