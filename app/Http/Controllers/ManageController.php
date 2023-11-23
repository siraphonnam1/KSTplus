<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function Laravel\Prompts\alert;
use App\Models\agency;
use App\Models\branch;
use App\Models\course;
use App\Models\department;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;


class ManageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agns = agency::all();
        $brns = branch::all();
        $dpms = department::all();
        $roles = Role::all();
        $courses = course::all();
        $permissions = Permission::all();
        return view("page.manages.manage", compact("agns","brns","dpms", "roles", "permissions", "courses"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createAgency(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'address' => 'max:255',
            'contact' => 'max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            $validatedData = $validator->validated();
            $agn = new agency;
            $agn->name = $validatedData['name'];
            $agn->address = $validatedData['address'];
            $agn->contact = $validatedData['contact'];
            $agn->save();
            return response()->json(['success' => $agn]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ee '.$th->getMessage()]);
        }
    }

    public function createBranch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'agency' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            $validatedData = $validator->validated();
            $name = $validatedData['name'];
            $agency = $validatedData['agency'];
            $brn = new branch;
            $brn->name = $name;
            $brn->agency = $agency;
            $brn->save();
            return response()->json(['success' => $name]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ee '.$th->getMessage()]);
        }
    }

    public function createRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            $role = Role::create(['name' => $request->name]);
            return response()->json(['success' => $role]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ee '.$th->getMessage()]);
        }
    }

    public function createPerm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            $permission = Permission::create(['name' => $request->name]);
            return response()->json(['success' => $permission]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ee '.$th->getMessage()]);
        }
    }

    public function createDpm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'prefix' => 'required|max:255',
            'branch' => 'max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            $validatedData = $validator->validated();
            $name = $validatedData['name'];
            $prefix = $validatedData['prefix'];
            $branch = $validatedData['branch'];
            $dpm = new department;
            $brn = branch::find( $branch );
            $dpm->name = $name;
            $dpm->prefix = Str::upper($prefix);
            $dpm->branch = $branch;
            $dpm->agency = $brn->agency;
            $dpm->save();
            return response()->json(['success' => $name.' '.$branch]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ee '.$th->getMessage()]);
        }
    }

    public function deleteData(Request $request) {
        try {
            if ($request->type == 'agn') {
                agency::find( $request->delid )->delete();
            } elseif ($request->type == 'brn') {
                branch::find( $request->delid )->delete();
            } elseif ($request->type == 'dpm') {
                department::find( $request->delid )->delete();
            } elseif ($request->type == 'role') {
                Role::findByName($request->delid)->delete();
            } elseif ($request->type == 'perm') {
                Permission::findByName($request->delid)->delete();
            };
            return response()->json(['success' => $request->all() ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'ee '.$th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            if ($request->editType == 'agn') {
                $agn = agency::find( $request->agnid );
                $agn->name = $request->name;
                $agn->address = $request->address;
                $agn->contact = $request->contact;
                $agn->save();
            } elseif ($request->editType == 'brn') {
                $brn = branch::find( $request->brnid );
                $brn->name = $request->name;
                $brn->agency = $request->agency;
                $brn->save();
            } elseif ($request->editType == 'dpm') {
                $dpm = department::find( $request->dpmid );
                $brn = branch::find( $request->branch );
                $dpm->name = $request->name;
                $dpm->branch = $request->branch;
                $dpm->prefix = Str::upper($request->prefix);
                $dpm->agency = $brn->agency;
                $dpm->save();
            }
            return response()->json(['success' => $request->all() ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
