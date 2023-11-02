<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\course;
use App\Models\department;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    public function store(Request $request) {
        $request->validate([
            'desc' => ['string', 'max:20000'],
            'title' => ['required', 'string', 'max:5000'],
        ]);
        try {
            $dpmName = department::find($request->user()->dpm);
            $courses = course::where('dpm', $request->user()->dpm)->count();
            $courseNum = sprintf('%03d', $courses);
            $course_perm = [
                'new'=> $request->perm ?? '',
                'employee'=> $request->normPer ?? '',
            ];
            $course = course::create([
                'title'=> $request->title,
                'description' => $request->desc,
                'permission' => json_encode($course_perm),
                'teacher' => $request->user()->id,
                'dpm' => $request->user()->dpm,
                'code' => ($dpmName->name).($courseNum),
            ]);
            return response()->json(['success' => $request->all()]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function delete(Request $request) {
        try {
            course::find($request->delid)->delete();
            return response()->json(['success' => $request->all()]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

}
