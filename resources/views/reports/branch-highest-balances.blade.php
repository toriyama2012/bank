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
              <th scope="col">Branch Name & Location</th>
              <th scope="col">Customer Name & Email</th>
              <th scope="col">Balance</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($results as $result)
                <tr>
                  <th scope="row">{{ $result->branch_id }}</th>
                  <td>{{ $result->branch_name }} -- {{ $result->location }}</td>
                  <td>{{ $result->customer_name ?? '  --> No customers found <--  ' }} {{ $result->customer_emaile ?? '' }}</td>
                  <td>$ {{ $result->customer_balance ?? '0' }}</td>
                </tr>
            @endforeach
            @if (count($results) == 0)
                <td colspan="4" class="text-center">No records found yet for this report</td>
            @endif
          </tbody>
        </table>

        {{ $results->links() }}

        <div class="container py-4 d-flex justify-content-center">
            <a class="btn btn-info" href="{{ route('reports.index') }}" role="button">ReportsList</a>
        </div>
    </div>
</x-app-layout>