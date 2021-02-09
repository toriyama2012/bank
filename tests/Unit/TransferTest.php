<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Transfer;
use App\Http\Controllers\TransferController;
use Illuminate\Http\Request;

class TransferTest extends TestCase
{
    private $branch;
    private $customer_from;
    private $customer_to;
    private $transferController;

    // Avoiding call setUp twice
    private $wasSetup = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->branch = new Branch();
        $this->branch->name = 'Testbranch';
        $this->branch->location = 'Nowhere';
        $this->branch->save();

        $this->customer_from = new Customer();
        $this->customer_from->name = 'Customer gives 5 dollars';
        $this->customer_from->email = 'give.customer@example.com';
        $this->customer_from->balance = '10000.00';
        $this->customer_from->branch_id = $this->branch->id;
        $this->customer_from->save();

        $this->customer_to = new Customer();
        $this->customer_to->name = 'Customer gets 5 dollars';
        $this->customer_to->email = 'get.customer@example.com';
        $this->customer_to->balance = '10000.00';
        $this->customer_to->branch_id = $this->branch->id;
        $this->customer_to->save();

        $this->transferController = new TransferController();

        $this->wasSetup = true;
    }

    /*protected function tearDown(): void
    {
        parent::tearDown();

        // This should be in the TearDown method but it was giving me some config issues
        // As far as Branch have "onDelete -> Cascade" we don't need to delete customers and transfers
        $this->branch->delete();
    }*/

    /**
     * Testing we can meke a transfer
     *
     * @test
     *
     * @return void
     */
    public function test_transfer_ok()
    {
        $amount = 5.00;

        $initial_transfers_amount = count(Transfer::all());

        $request = new Request();
        $request->setMethod('POST');
        $request->request->add(['amount' => $amount]);
        $request->request->add(['customer_from_id' => $this->customer_from->id]);
        $request->request->add(['customer_to_id' => $this->customer_to->id]);

        $response = $this->transferController->transfersStore($request);

        $final_transfers_amount = count(Transfer::all());

        $ok = true;

        if ($initial_transfers_amount == $final_transfers_amount) {
            $ok = false;
        }

        $customer_from_new_balance = $this->customer_from->balance - $amount;
        $customer_to_new_balance = $this->customer_to->balance + $amount;

        $customer_from_model = Customer::find($this->customer_from->id);
        $customer_to_model = Customer::find($this->customer_to->id);

        if ($customer_from_model->balance != $customer_from_new_balance) {
            $ok = false;
        }

        if ($customer_to_model->balance != $customer_to_new_balance) {
            $ok = false;
        }

        // This should be in the TearDown method but it was giving me some config issues
        // As far as Branch have "onDelete -> Cascade" we don't need to delete customers and transfers
        $this->branch->delete();

        $this->assertTrue($ok);
    }

    /**
     * Testing we can not make a transfer if we have not enough money
     *
     * @test
     *
     * @return void
     */
    public function test_transfer_wrong()
    {
        $amount = 5000.00;

        // As far as the transfer should haven't been made, the balance
        // should be the same both customers had originally
        $customer_from_new_balance = $this->customer_from->balance;
        $customer_to_new_balance = $this->customer_to->balance;

        $initial_transfers_amount = count(Transfer::all());

        $request = new Request();
        $request->setMethod('POST');
        $request->request->add(['amount' => $amount]);
        $request->request->add(['customer_from_id' => $this->customer_from->id]);
        $request->request->add(['customer_to_id' => $this->customer_to->id]);

        $response = $this->transferController->transfersStore($request);

        $final_transfers_amount = count(Transfer::all());

        $ok = true;

        if ($initial_transfers_amount != $final_transfers_amount) {
            $ok = false;
        }

        $customer_from_model = Customer::find($this->customer_from->id);
        $customer_to_model = Customer::find($this->customer_to->id);

        if ($customer_from_model->balance != $customer_from_new_balance) {
            $ok = false;
        }

        if ($customer_to_model->balance != $customer_to_new_balance) {
            $ok = false;
        }

        // This should be in the TearDown method but it was giving me some config issues
        // As far as Branch have "onDelete -> Cascade" we don't need to delete customers and transfers
        $this->branch->delete();

        $this->assertFalse($ok);
    }

    /**
     * Testing we can not make a transfer if we have not enough money
     *
     * @test
     *
     * @return void
     */
    public function test_transfer_customer_cant_transfer_itself()
    {
        $amount = 5000.00;

        // As far as the transfer should haven't been made, the balance
        // should be the same both customers had originally
        $customer_from_new_balance = $this->customer_from->balance;
        $customer_from_new_balance = $this->customer_from->balance;

        $initial_transfers_amount = count(Transfer::all());

        $request = new Request();
        $request->setMethod('POST');
        $request->request->add(['amount' => $amount]);
        $request->request->add(['customer_from_id' => $this->customer_from->id]);
        $request->request->add(['customer_to_id' => $this->customer_from->id]);

        $response = $this->transferController->transfersStore($request);

        $final_transfers_amount = count(Transfer::all());

        $ok = true;

        if ($initial_transfers_amount != $final_transfers_amount) {
            $ok = false;
        }

        $customer_from_model = Customer::find($this->customer_from->id);

        if ($customer_from_model->balance != $customer_from_new_balance) {
            $ok = false;
        }

        // This should be in the TearDown method but it was giving me some config issues
        // As far as Branch have "onDelete -> Cascade" we don't need to delete customers and transfers
        $this->branch->delete();

        $this->assertFalse($ok);
    }
}
