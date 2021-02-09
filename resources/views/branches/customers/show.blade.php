<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mt-4">
        <div class="mb-3">
            <label for="inputName" class="form-label">Name</label>
            <input type="text" class="form-control" name="customerName" value="{{ $customer->name }}" disabled>
          </div>
          <div class="mb-3">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" name="customerEmail" value="{{ $customer->email }}" disabled>
          </div>
          <div class="mb-3">
            <label for="inputBlance" class="form-label">Balance</label>
            <input type="number"  min="0" step="0.01" class="form-control currency" name="customerBalance" value="{{ $customer->balance }}" disabled>
          </div>
    </div>

    <div class="container py-4 d-flex justify-content-center">
        <a class="btn btn-success mr-20" href="{{ route('branches.customers.edit', [$branch->id, $customer->id]) }}" role="button">Edit</a>
        <a class="btn btn-info" href="{{ route('branches.customers.index', $branch->id) }}" role="button">BranchCustomersList</a>
    </div>
</x-app-layout>