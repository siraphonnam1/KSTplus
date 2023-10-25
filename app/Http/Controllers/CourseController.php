<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    public function courseDetail(Request $request) {
        return view("page.course-detail");
    }

    public function allCourse(Request $request) {
        return view("page.allcourse");
    }

}
