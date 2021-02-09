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
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Balance</th>
              <th scope="col">Show</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($customers as $customer)
                <tr>
                  <th scope="row">{{ $customer->id }}</th>
                  <td>{{ $customer->name }}</td>
                  <td>{{ $customer->email }}</td>
                  <td>{{ $customer->balance }}</td>
                  <td><button type="button" class="btn btn-primary" onclick="showCustomer('{{ route('branches.customers.show', [$branch->id, $customer->id]) }}')">Show Customer</button></td>
                  <td>
                    <form method="POST" action="{{ route('branches.customers.destroy', [$branch->id, $customer->id]) }}" id="deleteCustomerForm{{ $customer->id }}">
                      @csrf
                      @method('delete')
                      <button type="button" class="btn btn-danger" onclick="ensureDeleteCustomer('deleteCustomerForm{{ $customer->id }}')">Delete Customer</button>
                    </form>
                  </td>
                </tr>
            @endforeach
            @if (count($customers) == 0)
                <td colspan="6" class="text-center">No customers found yet</td>
            @endif
          </tbody>
        </table>

        {{ $customers->links() }}

        <div class="container py-4 d-flex justify-content-center">
            <a class="btn btn-success mr-20" href="{{ route('branches.customers.create', $branch->id) }}" role="button">Add Customer</a>
            <a class="btn btn-info" href="{{ route('branches.index') }}" role="button">BranchList</a>
        </div>

    </div>
</x-app-layout>