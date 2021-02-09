<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mt-4">
        <form method="POST" action="{{ route('branches.store') }}">
            @csrf
            <div class="mb-3">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control" id="inputName" aria-describedby="nameHelp" name="branchName" placeholder="You may write something like: OpenBank #123" required>
                <div id="nameHelp" class="form-text">It's recommended to set the branch name and the office number for this city. I.e "ING #2" which will be the second office of ING in the selected location, assuming there is already another existing ING office in the same location</div>
              </div>
              <div class="mb-3">
                <label for="inputLocation" class="form-label">Location</label>
                <input type="text" class="form-control" name="branchLocation" id="inputLocation" placeholder="You may write something like: Alicante" required>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="container py-4 d-flex justify-content-center">
        <a class="btn btn-info" href="{{ route('branches.index') }}" role="button">BranchList</a>
    </div>
</x-app-layout>