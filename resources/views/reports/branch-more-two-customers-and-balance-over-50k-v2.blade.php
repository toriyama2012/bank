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
            </tr>
          </thead>
          <tbody>
            @foreach ($results as $result)
                <tr>
                  <th scope="row">{{ $result->branch_id }}</th>
                  <td>{{ $result->branch_name }} -- {{ $result->location }}</td>
                </tr>
            @endforeach
            @if (count($results) == 0)
                <td colspan="2" class="text-center">No records found yet for this report</td>
            @endif
          </tbody>
        </table>

        {{ $results->links() }}

        <div class="container py-4 d-flex justify-content-center">
            <a class="btn btn-info mr-20" href="{{ route('reports.branch-more-two-customers-and-balance-over-50k') }}" role="button">See Report Original Version</a>
            <a class="btn btn-info" href="{{ route('reports.index') }}" role="button">ReportsList</a>
        </div>
    </div>
</x-app-layout>