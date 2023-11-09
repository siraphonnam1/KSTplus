<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Models\User;
use App\Models\course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
Use Alert;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Exception;

class UserController extends Controller
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
    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'agn' => ['required', 'string', 'max:255'],
            'brn' => ['required', 'string', 'max:255'],
            'dpm' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
        ], [
            'name.required' => 'The name field is mandatory!',
            'username.required' => 'The username field is mandatory!',
            'agn.required' => 'The agency field is mandatory!',
            'brn.required' => 'The branch field is mandatory!',
            'dpm.required' => 'The department field is mandatory!',
            'role.required' => 'The role field is mandatory!',

        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => $request->password,
                'agency' => $request->agn,
                'brn' => $request->brn,
                'dpm' => $request->dpm,
                'role' => $request->role,

                'courses' => $request->courses ?? [],
                'startlt' => ($request->role == 'new' ? date('Y-m-d') : null),
            ]);
            foreach (Role::all() as $role) {
                if ($user->hasRole($role->name)) {
                    $user->removeRole($role->name);
                }
            }
            $user->assignRole($request->role);
            alert()->success('Success','User has been created!');
        } catch (\Throwable $th) {
            alert()->error('Some thing worng!', $th->getMessage());
        }
        return Redirect::route('users.all');
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
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255'],
                'agn' => ['required', 'string', 'max:255'],
                'brn' => ['required', 'string', 'max:255'],
                'dpm' => ['required', 'string', 'max:255'],
                'role' => ['required', 'string', 'max:255'],
            ], [
                'name.required' => 'The name field is mandatory!',
                'username.required' => 'The username field is mandatory!',
                'agn.required' => 'The agency field is mandatory!',
                'brn.required' => 'The branch field is mandatory!',
                'dpm.required' => 'The department field is mandatory!',
                'role.required' => 'The role field is mandatory!',
            ]);

            $user = User::find($request->uid);
            $user->name = $request->name;
            $user->username = $request->username;
            if (strlen($request->password) >= 8) {
                $user->password = $request->password;
            }
            $user->agency = $request->agn;
            $user->brn = $request->brn;
            $user->dpm = $request->dpm;
            $user->role = $request->role;
            $user->startlt = ($request->role == 'new' ? date('Y-m-d') : null);
            foreach (Role::all() as $role) {
                if ($user->hasRole($role->name)) {
                    $user->removeRole($role->name);
                }
            }
            $user->assignRole($request->role);
            $user->save();
            return response()->json(['success' => $request->all()]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            User::find( $request->delid )->delete();
            return response()->json(['success' => $request->all() ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function renew(Request $request)
    {
        try {
            $user = User::find( $request->uid );
            $user->update(['startlt'=> $request->date]);
            return response()->json(['success' => $request->all() ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function addCourse(Request $request) {
        try {
            $user = User::find( $request->uid );
            $courses = course::whereIn('id', $request->courses )->get();
            $courseContainer = [];
            $stdContainer = [];
            $oCourses = $user->courses ?? [];
            if (count($oCourses) > 0) {
                $courseContainer = array_unique(array_merge($oCourses, $request->courses));
            } else {
                $courseContainer = $request->courses;
            }

            foreach ($courses as $course) {
                $oStd = is_array($course->studens) ? $course->studens : json_decode($course->studens, true);
                if (count($oStd ?? []) > 0) {
                    $stdContainer = $oStd;
                }
                if (!($stdContainer[$user->id] ?? false)) {
                    $stdContainer[$user->id] = date('Y-m-d');
                }
                $course->studens = $stdContainer;
                $course->save();
            }
            $user->courses = $courseContainer;
            $user->save();
            return response()->json(['success' => $stdContainer ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function removeCourse(Request $request) {
        try {
            $course = course::find($request->cid);
            $user = User::find($request->uid);

            if (!$course || !$user) {
                return response()->json(['error' => 'Course or User not found.'], 404);
            }

            // remove student from course
            $studentsC = $course->studens;
            if (array_key_exists($request->uid, $studentsC)) {
                unset($studentsC[$request->uid]);
            }

            // remove course from user
            $userCourse = [];
            foreach ($user->courses as $courseId) {
                if ($request->cid != $courseId) {
                    $userCourse[] = $courseId;
                }
            }

            // save to database
            $course->studens = $studentsC;
            $user->courses = $userCourse;
            $user->save();
            $course->save();
            return response()->json(['success' => $request->all() ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
