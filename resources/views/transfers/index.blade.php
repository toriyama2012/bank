<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container py-4">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">OriginalUser</th>
              <th scope="col">DestinationUser</th>
              <th scope="col">Amount</th>
              <th scope="col">When</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($transfers as $transfer)
                <tr>
                  <th scope="row">{{ $transfer->id }}</th>
                  <td>{{ $transfer->customer1->name}} [{{ $transfer->customer1->branch->name}} -- {{ $transfer->customer1->branch->location}}]</td>
                  <td>{{ $transfer->customer2->name}} [{{ $transfer->customer2->branch->name}} -- {{ $transfer->customer2->branch->location}}]</td>
                  <td>$ {{ $transfer->amount }}</td>
                  <td>{{ $transfer->created_at }}</td>
                </tr>
            @endforeach
            @if (count($transfers) == 0)
                <td colspan="5" class="text-center">No transfers found yet</td>
            @endif
          </tbody>
        </table>

        {{ $transfers->links() }}

    </div>

    <div class="container py-4">
        <div class="row">
            <div class="col-sm">
                <b>Amount</b>
            </div>
            <div class="col-sm">
                Origin User:
            </div>
            <div class="col-sm">
                Destinatary User:
            </div>
        </div>
        <form method="POST" action="{{ route('transfers.store') }}" id="transferForm">
            @csrf
            <div class="row mb-4">
                <div class="col-sm">
                    <input type="number" min="1.00" max="99999999" step="0.01" class="form-control currency" id="amount" name="amount" value="1.00" required title="The minimun amount allowed to transfer is 1 dollar">
                </div>
                <div class="col-sm">
                    <select name="customer_from_id" id="customer_from_id">
                    @foreach ($customers as $key => $customer)
                       <option value="{{ $customer->id }}"{{ ($key == 0) ? ' selected' : ' ' }}>{{ $customer->name }} [{{ $customer->branch->name }} -- {{ $customer->branch->location }}]</option>
                    @endforeach
                    </select>
                </div>
                <div class="col-sm">
                    <select name="customer_to_id" id="customer_to_id">
                    @foreach ($customers as $key => $customer)
                       <option value="{{ $customer->id }}"{{ ($key == 1) ? ' selected' : ' ' }}>{{ $customer->name }} [{{ $customer->branch->name }} -- {{ $customer->branch->location }}]</option>
                    @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-primary" onclick="validateTransferUsers('transferForm', '{{ route('transfers.validation') }}')">Submit</button>
                </div>
            </div>
        <form>
    </div>

    @isset($message)
        <div class="alert alert-warning" role="alert">
            Waring: <i>{{ $message }}</i>
        </div>
    @endisset
</x-app-layout>