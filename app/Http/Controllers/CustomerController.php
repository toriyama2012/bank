<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function customersIndex($id) {
        $branch = Branch::find($id);

        $customers = Customer::where('branch_id', '=', $id)->orderBy('id', 'desc')->paginate(5);

        return view('branches.customers.index', compact('customers', 'branch'));
    }

    public function customersCreate($id) {
        $branch = Branch::find($id);

        return view('branches.customers.create', compact('branch'));
    }

    public function customersShow($id, $customer_id) {
        $branch = Branch::find($id);

        $customer = Customer::find($customer_id);

        return view('branches.customers.show', compact('customer', 'branch'));
    }

    public function customersEdit($id, $customer_id) {
        $branch = Branch::find($id);

        $customer = Customer::find($customer_id);

        return view('branches.customers.edit', compact('customer', 'branch'));
    }

    public function customersStore($id, Request $request) {
        $branch = Branch::find($id);

        $customer = new Customer();

        $customer->name = $request->customerName;
        $customer->email = $request->customerEmail;
        $customer->balance = $request->customerBalance;
        $customer->branch_id = $id;

        $customer->save();

        return view('branches.customers.show', compact('customer', 'branch'));
    }

    public function customersUpdate(Request $request, $id, $customer_id) {
        $branch = Branch::find($id);

        $customer = Customer::find($customer_id);

        $customer->name = $request->customerName;
        $customer->email = $request->customerEmail;
        $customer->balance = (float)$request->customerBalance;

        $customer->save();

        return redirect()->route('branches.customers.show', [$branch, $customer]);
    }

    public function customersDestroy($id, $customer_id) {
        $customer = Customer::find($customer_id);

        $customer->delete();

        return redirect()->route('branches.customers.index', $id);
    }
}
