<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\course;
use App\Models\lesson;
use App\Models\department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\isEmpty;

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
                'code' => ($dpmName->prefix).($courseNum),
            ]);
            return response()->json(['success' => $request->all()]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function update(Request $request) {
        $request->validate([
            'courseId' => ['required', 'max:255'],
            'desc' => ['string', 'max:20000'],
            'title' => ['required', 'string', 'max:5000'],
        ]);
        try {

            $course_perm = [
                'new'=> $request->perm ?? false,
                'employee'=> $request->normPer ?? false,
            ];
            $courses = course::find( $request->courseId);
            $courses->update([
                'permission'=> json_encode($course_perm),
                'title'=> $request->title,
                'description' => $request->desc,
                'dpm'=> $request->user()->dpm,
            ]);
            return response()->json(['success' => $request->all()]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function delete(Request $request) {
        try {
            $status = '';
            if ($request->deltype == 'course') {
                course::find($request->delid)->delete();
            } else if ($request->deltype == 'lesson') {
                lesson::find($request->delid)->delete();
            }
            return response()->json(['success' => $request->all()]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function search(Request $request)
    {
        // Retrieve the search keyword and department filters from the request
        $search = $request->input('search');
        $departmentIds = $request->input('departments');

        // Start building the query
        $query = course::query();

        // If a search keyword was provided, use it to filter the courses
        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%") // assuming the courses table has 'name' and 'description' columns
                  ->orWhere('code', 'LIKE', "%{$search}%");
        }

        // If department filters were provided, use them to filter the courses
        if (!empty($departmentIds)) {
            $query->whereIn('dpm', $departmentIds);
        }

        // Execute the query and get the results
        $courses = $query->get();

        // Load departments for the filters
        $dpms = department::all();
        // Return the search view with the results and departments
        return view('page.allcourse', compact('courses', 'dpms', 'departmentIds', 'search'));
    }

    public function searchMy(Request $request)
    {
        // Retrieve the search keyword and department filters from the request
        $search = $request->input('search');
        $departmentIds = $request->input('departments');
        $userId = $request->user()->id; // Get the current user's ID

        // Start building the query with the initial condition for the current user
        $query = Course::where('studens', 'LIKE', "%\"$userId\"%");

        // Nest the additional search and department conditions
        if ($search || !empty($departmentIds)) {
            $query->where(function ($subquery) use ($search, $departmentIds) {
                // If a search keyword was provided, use it to filter the courses
                if ($search) {
                    $subquery->where('title', 'LIKE', "%{$search}%")
                            ->orWhere('description', 'LIKE', "%{$search}%")
                            ->orWhere('code', 'LIKE', "%{$search}%");
                }

                // If department filters were provided, use them to filter the courses
                if (!empty($departmentIds)) {
                    $subquery->whereIn('department_id', $departmentIds);
                }
            });
        }

        // Execute the query and get the results
        $courses = $query->get();

        // Load departments for the filters
        $dpms = Department::all();

        // Return the search view with the results and departments
        return view('page.myclassroom', compact('courses', 'dpms', 'departmentIds', 'search'));
    }


    public function addLesson(Request $request): RedirectResponse {
        $request->validate([
            'desc' => ['string', 'max:20000'],
            'topic' => ['required', 'string', 'max:5000'],
            'courseid' => ['required', 'string', 'max:255'],
        ]);

        try {
            $lesson = lesson::create([
                'topic'=> $request->topic,
                'desc'=> $request->desc,
                'course'=> $request->courseid,
            ]);
            alert()->success('Success','Lesson has been saved!');
            return back();
        } catch (\Throwable $th) {
            alert()->error('Some thing worng!', $th->getMessage());
            return back();
        }
    }

    public function updateLesson(Request $request): RedirectResponse {
        $request->validate([
            'lessid' => ['string', 'max:255'],
            'topic' => ['required', 'string', 'max:5000'],
            'desc' => ['required', 'string', 'max:10000'],
        ]);

        try {
            $lesson = Lesson::find($request->lessid);
            $lesson->update([
                'topic' => $request->topic,
                'desc' => $request->desc
            ]);
            alert()->success('Success','Lesson has been saved!');
            return back();
        } catch (\Throwable $th) {
            alert()->error('Some thing worng!', $th->getMessage());
            return back();
        }
    }

    public function subLessAdd(Request $request) {
        try {
            if ($request->addType == "file") {
                $request->validate([
                    'label' => 'required|string|max:255',
                    'content' => 'required|file|mimes:jpeg,png,pdf,svg,doc,docx,xls,xlsx,ppt,pptx,txt,mp4,zip,rar|max:10240', // 10MB max size, adjust as needed
                    'lessId' => 'required',
                    'addType' => 'required',
                ]);

                if ($request->hasFile('content')) {
                    $file = $request->file('content');
                    $filename = time(). '_' . $file->getClientOriginalName(); // Unique name

                    // Define the path within the public directory where you want to store the files
                    $destinationPath = public_path('uploads/sublessons');

                    // Check if the directory exists, if not, create it
                    if (!File::isDirectory($destinationPath)) {
                        File::makeDirectory($destinationPath, 0755, true);
                    }

                    // Move the file to the public directory
                    $file->move($destinationPath, $filename);

                    // Generate the URL to the file
                    $url = asset('uploads/sublessons/' . $filename);
                }

                $subless = [
                    'id'=> date('dmYHi'),
                    'type'=> $request->addType,
                    'label'=> $request->label,
                    'content'=> $filename,
                    'date'=> date('Y-m-d'),
                ];
                $lesson = lesson::find($request->lessId);
                if (is_null($lesson->sub_lessons)) {
                    $subContainer = [];
                } else {
                    $subContainer = json_decode($lesson->sub_lessons);
                }
                $subContainer[] = $subless;
                if ($lesson) {
                    $lesson->sub_lessons = $subContainer;
                    $lesson->save();
                }
            } else {
                $request->validate([
                    'content' => ['required','string', 'max:10000'],
                    'label' => ['required', 'string', 'max:500'],
                    'lessId' => 'required',
                    'addType' => 'required',
                ]);
                $subless = [
                    'id'=> date('dmYHi'),
                    'type'=> $request->addType,
                    'label'=> $request->label,
                    'content'=> $request->content,
                    'date'=> date('Y-m-d'),
                ];
                $lesson = lesson::find($request->lessId);
                if (is_null($lesson->sub_lessons)) {
                    $subContainer = [];
                } else {
                    $subContainer = json_decode($lesson->sub_lessons);
                }
                $subContainer[] = $subless;
                if ($lesson) {
                    $lesson->sub_lessons = $subContainer;
                    $lesson->save();
                }
            }
            return response()->json(['success' => $subContainer]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error' => $th->getMessage()]);
        }
    }


    public function subLessDel(Request $request) {
        try {
            $lesson = lesson::find($request->lessId);
            $subContainer = [];
            if ($lesson) {
                if (!is_null($lesson->sub_lessons)) {
                    $oldContainer = json_decode($lesson->sub_lessons);
                    foreach ($oldContainer as $key => $item) {
                        if ($key != $request->delid) {
                            $subContainer[] = $item;
                        }
                    }
                }
            }
            $lesson->sub_lessons = $subContainer;
            $lesson->save();
            return response()->json(['success' => $subContainer]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

}
