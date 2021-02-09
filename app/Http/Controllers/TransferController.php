<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\Customer;

class TransferController extends Controller
{
    public function transfersIndex() {
        $transfers = Transfer::paginate(5);//DB::table('transfers')->orderBy('id', 'desc')->paginate(5);
        $customers = Customer::all();

        return view('transfers.index', compact('transfers', 'customers'));
    }

    public function transfersStore(Request $request) {
        $transfer = new Transfer();

        $message = 'Transfer made successfully';

        $transfer_validation = $this->validateTransfer($request);

        if (!$transfer_validation['ok']) {
            $message = $transfer_validation['message'];
            return redirect()->route('transfers.index', compact('message'));
        }

        if (!$this->processTransfer($request)) {
            $message = 'Error during the transfer processing';
            return redirect()->route('transfers.index', compact('message'));
        }

        $transfer->customer_from_id = $request->customer_from_id;
        $transfer->customer_to_id = $request->customer_to_id;
        $transfer->amount = $request->amount;

        $saved = $transfer->save();

        $transfer->save();

        return redirect()->route('transfers.index', compact('message'));
    }

    public function transfersAjaxValidate(Request $request) {
        $transfer_validation = $this->validateTransfer($request);

        return response()->json(['success' => $transfer_validation]);
    }

    private function validateTransfer(Request $request) {
        $transfer_validation = [
            'ok' => true,
            'message' => 'Transfer made successfully'
        ];

        $customer_1 = Customer::find($request->customer_from_id);
        $customer_2 = Customer::find($request->customer_to_id);

        if (!$customer_1) {
            $transfer_validation['ok'] = false;
            $transfer_validation['message'] = 'Origin customer was not found';
            return $transfer_validation;  
        }

        if (!$customer_2) {
            $transfer_validation['ok'] = false;
            $transfer_validation['message'] = 'Destinatary customer was not found';
            return $transfer_validation;  
        }

        if ($request->amount > $customer_1->balance) {
            $transfer_validation['ok'] = false;
            $transfer_validation['message'] = 'Origin customer has not enough money in his balance to make the tranfer';
            return $transfer_validation;  
        }

        if ($request->amount < 1) {
            $transfer_validation['ok'] = false;
            $transfer_validation['message'] = 'The minimun amount allowed to transfer is 1 dollar';
            return $transfer_validation;  
        }

        if ($request->amount >= 1000000) {
            $transfer_validation['ok'] = false;
            $transfer_validation['message'] = 'The transfer amount is equal or higher than 1000000';
            return $transfer_validation;  
        }

        $resulting_amount = $request->amount + $customer_2->balance;

        if ($resulting_amount >= 100000000) {
            $transfer_validation['ok'] = false;
            $transfer_validation['message'] = 'The transfer will make the destinatary customer to exceed the balance limit which is equal or higher than 100000000';
            return $transfer_validation;  
        }

        return $transfer_validation;
    }

    private function processTransfer(Request $request) {
        $customer_1 = Customer::find($request->customer_from_id);
        $customer_2 = Customer::find($request->customer_to_id);

        $customer_1->balance -= $request->amount;
        $customer_2->balance += $request->amount;

        $done = $customer_1->save();

        if (!$done) {
            return false;
        }

        $done = $customer_2->save();
    
        if (!$done) {
            return false;
        }

        return true;
    }
}
