<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mt-4">
        <form method="POST" action="{{ route('branches.customers.store', $branch->id) }}">
            @csrf
            <div class="mb-3">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control" name="customerName" placeholder="You may write something like: Alfred D. Cage" required>
              </div>
              <div class="mb-3">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" class="form-control" name="customerEmail" placeholder="You may write something like: alfred.cage@chessable.com" required>
              </div>
              <div class="mb-3">
                <label for="inputBlance" class="form-label">Balance</label>
                <input type="number"  min="0" max="99999999" step="0.01" class="form-control currency" name="customerBalance" value="0.00" required>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="container py-4 d-flex justify-content-center">
        <a class="btn btn-info" href="{{ route('branches.customers.index', $branch->id) }}" role="button">BranchCustomersList</a>
    </div>
</x-app-layout>