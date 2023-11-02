<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\agency;
use App\Models\branch;
use App\Models\department;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\course;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function courseDetail(Request $request) {
        return view("page.course-detail");
    }

    public function allCourse(Request $request) {
        $courses = course::all();
        return view("page.allcourse", compact("courses"));
    }

    public function allUsers(Request $request) {
        $users = User::all();
        $agns = agency::all();
        $dpms = department::all();
        $brns = branch::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view("page.allusers", compact("users","dpms","agns","brns", "roles", "permissions"));
    }

    public function userDetail(Request $request, $id) {
        $user = User::find($id);
        $agns = agency::all();
        $dpms = department::all();
        $brns = branch::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view("page.userDetail", compact("id","user", "roles", "permissions","dpms","agns","brns"));
    }

    public function requestAll(Request $request) {
        return view("page.requestAll");
    }
}
