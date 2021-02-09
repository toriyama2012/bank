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
              <th scope="col">Location</th>
              <th scope="col">Show</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($branches as $branch)
                <tr>
                  <th scope="row">{{ $branch->id }}</th>
                  <td>{{ $branch->name }}</td>
                  <td>{{ $branch->location }}</td>
                  <td><button type="button" class="btn btn-primary" onclick="showBranch('{{ route('branches.show', $branch->id) }}')">Show Branch</button></td>
                  <td>
                    <form method="POST" action="{{ route('branches.destroy', $branch->id) }}" id="deleteBranchForm{{ $branch->id }}">
                      @csrf
                      @method('delete')
                      <button type="button" class="btn btn-danger" onclick="ensureDeleteBranch('deleteBranchForm{{ $branch->id }}')">Delete Branch</button>
                    </form>
                  </td>
                </tr>
            @endforeach
            @if (count($branches) == 0)
                <td colspan="6" class="text-center">No branches found yet</td>
            @endif
          </tbody>
        </table>

        {{ $branches->links() }}

        <button type="button" class="btn btn-success mt-2" onclick="addBranch('{{ route('branches.create') }}')">Add Branch</button>
    </div>
</x-app-layout>