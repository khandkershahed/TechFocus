<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountsReceivable;
use App\Models\AccountsPayable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccountComparisonController extends Controller
{
    public function comparison()
    {
        // Accounts Receivable Data
        $totalReceivables = AccountsReceivable::sum('client_amount');
        $totalReceived = AccountsReceivable::sum('client_payment_value');
        $pendingReceivables = $totalReceivables - $totalReceived;
        
        $receivablesByStatus = AccountsReceivable::select('client_payment_status', DB::raw('COUNT(*) as count'), DB::raw('SUM(client_amount) as amount'))
            ->groupBy('client_payment_status')
            ->get();
            
        $overdueReceivables = AccountsReceivable::where('due_date', '<', Carbon::now())
            ->where('client_payment_status', '!=', 'paid')
            ->get();
            
        $recentReceivables = AccountsReceivable::with('rfq')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Accounts Payable Data
        $totalPayables = AccountsPayable::sum('principal_amount');
        $totalPaid = AccountsPayable::sum('principal_payment_value');
        $pendingPayables = $totalPayables - $totalPaid;
        
        $payablesByStatus = AccountsPayable::select('principal_payment_status', DB::raw('COUNT(*) as count'), DB::raw('SUM(principal_amount) as amount'))
            ->groupBy('principal_payment_status')
            ->get();
            
        $overduePayables = AccountsPayable::where('due_date', '<', Carbon::now())
            ->where('principal_payment_status', '!=', 'paid')
            ->get();
            
        $recentPayables = AccountsPayable::with('rfq')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Comparison Metrics
        $netCashFlow = $totalReceived - $totalPaid;
        $receivableToPayableRatio = $totalPayables > 0 ? ($totalReceivables / $totalPayables) : 0;
        $collectionEfficiency = $totalReceivables > 0 ? ($totalReceived / $totalReceivables) * 100 : 0;
        $paymentEfficiency = $totalPayables > 0 ? ($totalPaid / $totalPayables) * 100 : 0;

        return view('admin.account.comparison', compact(
            'totalReceivables',
            'totalReceived',
            'pendingReceivables',
            'receivablesByStatus',
            'overdueReceivables',
            'recentReceivables',
            'totalPayables',
            'totalPaid',
            'pendingPayables',
            'payablesByStatus',
            'overduePayables',
            'recentPayables',
            'netCashFlow',
            'receivableToPayableRatio',
            'collectionEfficiency',
            'paymentEfficiency'
        ));
    }
}