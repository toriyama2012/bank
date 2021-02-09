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
              <th scope="col" class="text-start">Branches with highest Balances Report</th>
              <th scope="col" class="text-end">Branches with more than two customers with a balance over 50000$ Report</th>
            </tr>
          </thead>
          <tbody>
                <tr>
                  <td class="text-start"><a class="btn btn-info" href="{{ route('reports.branch-highest-balances') }}" role="button">See Report</a></td>
                  <td class="text-end"><a class="btn btn-info" href="{{ route('reports.branch-more-two-customers-and-balance-over-50k') }}" role="button">See Report</a></td>
                </tr>
          </tbody>
        </table>
    </div>
</x-app-layout>