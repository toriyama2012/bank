<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private const TOTAL_CUSTOMERS = 2;
    private const TOTAL_BALANCE = 50000;

    public function reportsIndex() {
        return view('reports.index');
    }

    public function ReportsBranchHighestBalances() {
        // SELECT branches.*, customers.* FROM branches LEFT JOIN customers ON customers.branch_id = branches.id AND customers.balance = (SELECT MAX(balance) FROM customers WHERE customers.branch_id = branches.id)
        $results = DB::table('branches')->selectRaw('branches.id as branch_id, branches.name as branch_name, branches.location, customers.id as customer_id, customers.name as customer_name, customers.email as customer_email, customers.balance as customer_balance')->leftJoin('customers', function($join) { $join->on('customers.branch_id', '=', 'branches.id'); $join->on(DB::raw('customers.balance'), '=', DB::raw('(SELECT MAX(balance) FROM customers WHERE customers.branch_id = branches.id)')); })->orderBy('branches.id', 'desc')->paginate(5);
        
        return view('reports.branch-highest-balances', compact('results'));
    }

    public function ReportsBranchMoreTwoCustomersAndBalanceOver50kReport() {
        // SELECT customers.branch_id, COUNT(customers.id) AS total_customers, SUM(balance) total_balance, branches.name AS branch_name, branches.location, customers.name AS customer_name, customers.email FROM customers JOIN branches ON branches.id = customers.branch_id GROUP BY branch_id HAVING total_customers > 2 AND total_balance > 50000;
        $results = DB::table('customers')->selectRaw('customers.branch_id, COUNT(customers.id) AS total_customers, SUM(balance) total_balance, branches.name AS branch_name, branches.location, customers.name AS customer_name, customers.email')->join('branches', 'branches.id', '=', 'customers.branch_id')->groupBy('branch_id')->having('total_customers', '>', self::TOTAL_CUSTOMERS)->having('total_balance', '>', self::TOTAL_BALANCE)->orderBy('branch_id', 'desc')->paginate(5);// check /config/database.php -> connections.mysql.strict

        return view('reports.branch-more-two-customers-and-balance-over-50k', compact('results'));
    }

    public function ReportsBranchMoreTwoCustomersAndBalanceOver50kReportV2() {
        //SELECT customers.branch_id, COUNT(customers.id) AS total_customers, branches.name AS branch_name, branches.location, customers.name AS customer_name, customers.email FROM customers JOIN branches ON branches.id = customers.branch_id WHERE customers.balance > 50000 GROUP BY customers.branch_id HAVING total_customers > 2;
        $results = DB::table('customers')->selectRaw('customers.branch_id, COUNT(customers.id) AS total_customers, SUM(balance) total_balance, branches.name AS branch_name, branches.location, customers.name AS customer_name, customers.email')->join('branches', 'branches.id', '=', 'customers.branch_id')->where('balance', '>', self::TOTAL_BALANCE)->groupBy('branch_id')->having('total_customers', '>', self::TOTAL_CUSTOMERS)->orderBy('branch_id', 'desc')->paginate(5);// check /config/database.php -> connections.mysql.strict

        return view('reports.branch-more-two-customers-and-balance-over-50k-v2', compact('results'));
    }
}
