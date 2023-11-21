<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\agency;
use App\Models\branch;
use App\Models\lesson;
use App\Models\department;
use App\Models\progress;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\course;
use App\Models\quiz;
use App\Notifications\MessageNotification;
use App\Models\Test;


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
    public function courseDetail(Request $request, $id) {
        $lessons = lesson::where("course", $id)->get();
        $course = course::find($id);
        if ($request->user()->hasAnyRole(['admin','staff'])) {
            $quizzes = quiz::all();
        } else {
            $quizzes = quiz::where('create_by', $request->user()->id)->get();
        }
        $tested = Test::where('tester', $request->user()->id)->orderBy('id', 'desc')->get();
        return view("page.course-detail", compact("id", "lessons", "course", "quizzes", 'tested'));
    }

    public function allCourse(Request $request) {
        $courses = course::where('permission->all', "true")->paginate(12);
        return view("page.allcourse", compact("courses"));
    }

    public function main(Request $request) {
        $courses = course::latest()->take(6)->get();
        $dpms = department::all();
        if ($request->user()->role == "new") {
            return redirect()->route('home');
        } else {
            $allcourses = course::where('permission->all', "true")->take(8)->get();
            $dpmcourses = course::where('permission->dpm', "true")
                 ->where(function ($query) use ($request) {
                     $query->Where('dpm', $request->user()->dpm);
                 })->orWhere("studens", 'LIKE' , '%"'.$request->user()->id.'"%')->take(8)->get();
            return view("page.main", compact("allcourses", "dpms", "dpmcourses"));
        }
    }

    public function home(Request $request) {
        $courses = course::latest()->take(6)->where("studens", 'LIKE' , '%"'.$request->user()->id.'"%')->get();
        $user = $request->user();
        return view("page.home", compact("courses", 'user'));
    }

    public function allUsers(Request $request) {
        $users = User::all();
        $agns = agency::all();
        $dpms = department::all();
        $brns = branch::all();
        $roles = Role::all();
        $permissions = Permission::all();
        $courses = course::all();
        return view("page.allusers", compact("users","dpms","agns","brns", "roles", "permissions", "courses"));
    }

    public function userDetail(Request $request, $id) {
        $user = User::find($id);
        $agns = agency::all();
        $dpms = department::all();
        $brns = branch::all();
        $roles = Role::all();
        $permissions = Permission::all();
        $courses = course::all();
        $ucourse = course::whereIn("id", $user->courses ?? [])->get();
        return view("page.userDetail", compact("id","user", "roles", "permissions","dpms","agns","brns", "courses", 'ucourse'));
    }

    public function requestAll(Request $request) {
        return view("page.requestAll");
    }
    public function ownCourse(Request $request) {
        $courses = course::where("teacher", $request->user()->id)->get();

        return view("page.own-course", compact("courses"));
    }

    public function classroom(Request $request) {
        $courses = course::where('permission->dpm', "true")
                 ->where(function ($query) use ($request) {
                     $query->where("studens", 'LIKE' , '%"'.$request->user()->id.'"%')
                            ->orWhere('dpm', $request->user()->dpm);
                 })->paginate(12);
        // $courses = course::where("studens", 'LIKE' , '%"'.$request->user()->id.'"%')->orWhere('dpm', $request->user()->dpm)->get();
        $dpms = department::all();
        return view("page.myclassroom", compact("courses","dpms"));
    }

    public function sendMessage(Request $request)
    {
        date_default_timezone_set('Asia/Bangkok');

        try {
            $text = $request->input('text');
            $noticText = [
                'user' => $request->user()->id,
                'content' => $text,
                'date'=> date('Y-m-d H:i:s'),
                'status'=> 'wait',
            ];
            // Validation and logic for the message

            // Find staff to notify
            $staffUsers = User::whereIn('role', ['admin','staff'])->get();
            // Send notification to each staff user
            foreach ($staffUsers as $staffUser) {
                $staffUser->notify(new MessageNotification($noticText));
            }
            return response()->json(['success' => $request->all()]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->unreadNotifications->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'error'], 404);
    }

    public function noticSuccess($id)
    {
        $notification = auth()->user()->notifications->find($id);

        if ($notification) {
            // Decode the data field into an array, modify it, and re-encode it as JSON
            $data = $notification->data;
            $data['status'] = 'success';
            $notification->data = $data;

            // Save the modified notification back to the database
            $notification->save();

            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'error'], 404);
    }

}
