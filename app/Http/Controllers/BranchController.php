<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Customer;

class BranchController extends Controller
{
    public function index() {
        // Si queremos evitar el repo, llamamos a la DB con PDO
        // Lo que nos devuelva la query "SELECT * FROM branches ORDER BY id DESC LIMIT 5"
        // lo recorremos con un foreach y lo parseamos así
        /*$users = collect([
            (object)[
                'id' => 2,
                'name' => 'aaa',
                'email' => 'bbb'
            ],
            (object)[
                'id' => 1,
                'name' => 'ccc',
                'email' => 'ddd'
            ]
        ]);*/

        $branches = Branch::orderBy('id', 'desc')->paginate(5);

        return view('branches.index', compact('branches'));
    }

    public function show($id) {
        $branch = Branch::find($id);

        return view('branches.show', compact('branch'));
    }

    public function edit($id) {
        $branch = Branch::find($id);

        return view('branches.edit', compact('branch'));
    }

    public function create() {
        return view('branches.create');
    }

    public function store(Request $request) {
        $branch = new Branch();

        $branch->name = $request->branchName;
        $branch->location = $request->branchLocation;

        $branch->save();

        return redirect()->route('branches.show', $branch);
    }

    public function update(Request $request, $id) {
        $branch = Branch::find($id);

        $branch->name = $request->branchName;
        $branch->location = $request->branchLocation;

        $branch->save();

        return redirect()->route('branches.show', $branch);
    }

    public function destroy($id) {
        $branch = Branch::find($id);

        $branch->delete();

        return redirect()->route('branches.index');
    }
}
