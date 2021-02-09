<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mt-4">
        <form action="{{ route('branches.customers.update', [$branch->id, $customer->id]) }}" method="POST">
            @csrf
            @method('put')
            <div class="mb-3">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control" id="inputName" name="customerName" value="{{ $customer->name }}" required>
              </div>
              <div class="mb-3">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail" name="customerEmail" value="{{ $customer->email }}" required>
              </div>
              <div class="mb-3">
                <label for="inputBlance" class="form-label">Balance</label>
                <input type="number"  min="0" max="99999999" step="0.01" class="form-control currency" id="inputBalance" name="customerBalance" value="{{ $customer->balance }}" required>
              </div>
              <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <div class="container py-4 d-flex justify-content-center">
        <a class="btn btn-info" href="{{ route('branches.customers.index', $branch->id) }}" role="button">BranchList</a>
    </div>
</x-app-layout>