<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mt-4">
        <div class="mb-3">
            <label for="inputName" class="form-label">Name</label>
            <input type="text" class="form-control" id="inputName" name="branchName" value="{{ $branch->name }}" disabled>
        </div>
        <div class="mb-3">
            <label for="inputLocation" class="form-label">Location</label>
            <input type="text" class="form-control" id="inputLocation" name="branchLocation" value="{{ $branch->location }}" disabled>
        </div>
    </div>

    <div class="container py-4 d-flex justify-content-center">
        <a class="btn btn-success mr-20" href="{{ route('branches.edit', $branch->id) }}" role="button">Edit</a>
        <a class="btn btn-secondary mr-20" href="{{ route('branches.customers.index', $branch->id) }}" role="button">Show Branch Users</a>
        <a class="btn btn-info" href="{{ route('branches.index') }}" role="button">BranchList</a>
    </div>
</x-app-layout>