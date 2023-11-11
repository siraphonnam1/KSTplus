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
use App\Models\User;

use function PHPUnit\Framework\isEmpty;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    public function searchDpm(Request $request)
    {
        $search = $request->get('search');

        // search in title
        $courses1 = course::where('permission->dpm', "true")
                        ->where(function ($query) use ($request) {
                            $query->where("studens", 'LIKE' , '%"'.$request->user()->id.'"%')
                                ->orWhere('dpm', $request->user()->dpm);
                        })
                        // Add your search condition here before paginate
                        ->when($search, function ($query) use ($search) {
                            return $query->where('title', 'like', '%'.$search.'%');
                        });

        // search in course code
        $courses2 = course::where('permission->dpm', "true")
                        ->where(function ($query) use ($request) {
                            $query->where("studens", 'LIKE' , '%"'.$request->user()->id.'"%')
                                ->orWhere('dpm', $request->user()->dpm);
                        })
                        // Add your search condition here before paginate
                        ->when($search, function ($query) use ($search) {
                            return $query->where('code', 'like', '%'.$search.'%');
                        })->union($courses1);

        // query
        $courses = $courses2->paginate(12);

        return view('partials.courses', compact('courses'));
    }


    public function store(Request $request) {
        $request->validate([
            'desc' => ['string', 'max:20000'],
            'title' => ['required', 'string', 'max:5000'],
        ]);
        if ($request->hasFile('cimg')) {
            $request->validate([
                'cimg' => ['file','mimes:jpeg,png,jpg','max:10240'], // 10MB max size, adjust as needed
            ]);
        }

        try {
            if ($request->hasFile('cimg')) {
                $file = $request->file('cimg');
                $filename = time(). '_' . $file->getClientOriginalName(); // Unique name

                // Define the path within the public directory where you want to store the files
                $destinationPath = public_path('uploads/course_imgs');

                // Check if the directory exists, if not, create it
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Move the file to the public directory
                $file->move($destinationPath, $filename);
            }


            $dpmName = department::find($request->user()->dpm);
            $courses = course::where('dpm', $request->user()->dpm)->count();
            $courseNum = sprintf('%03d', $courses);
            $course_perm = [
                'all'=> $request->allPerm ?? '',
                'dpm'=> $request->dpmPerm ?? '',
            ];
            $course = course::create([
                'title'=> $request->title,
                'description' => $request->desc,
                'permission' => json_encode($course_perm),
                'teacher' => $request->user()->id,
                'dpm' => $request->user()->dpm,
                'code' => ($dpmName->prefix).($courseNum),
                'img' => $filename ?? null,
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
            'cimg' => ['required','file','mimes:jpeg,png,jpg','max:10240'],
        ]);
        try {
            if ($request->hasFile('cimg')) {
                $file = $request->file('cimg');
                $filename = time(). '_' . $file->getClientOriginalName(); // Unique name

                // Define the path within the public directory where you want to store the files
                $destinationPath = public_path('uploads/course_imgs');

                // Check if the directory exists, if not, create it
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Move the file to the public directory
                $file->move($destinationPath, $filename);
            }

            $course_perm = [
                'all'=> $request->allPerm ?? false,
                'dpm'=> $request->dpmPerm ?? false,
            ];
            $courses = course::find( $request->courseId);
            $updateData = [
                'permission' => json_encode($course_perm),
                'title' => $request->title,
                'description' => $request->desc,
                'dpm' => $request->user()->dpm,
            ];

            if ($request->hasFile('cimg')) {
                $updateData['img'] = $filename;
                $filePath = public_path('uploads/course_imgs/' . $courses->img);
                // Check if the file exists before attempting to delete
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            $courses->update($updateData);
            return response()->json(['success' => $request->all()]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function delete(Request $request) {
        try {
            $status = '';
            if ($request->deltype == 'course') {
                $courses = course::find($request->delid);
                $filePath = public_path('uploads/course_imgs/' . $courses->img);
                // Check if the file exists before attempting to delete
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
                $courses->delete();
            } else if ($request->deltype == 'lesson') {
                lesson::find($request->delid)->delete();
            }
            return response()->json(['success' => $request->all()]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function enroll(Request $request, $cid) {
        try {
            $course = course::find($cid);
            $user = User::find( $request->user()->id );
            $courseContainer = [];
            $stdContainer = [];
            $oCourses = $user->courses ?? [];

            // ins user table -> course
            if (count($oCourses) > 0) {
                $courseContainer = array_unique(array_merge($oCourses, [(string) $course->id]));
            } else {
                $courseContainer[] = (string) $course->id;
            }
            // ins course table -> studens
            $oStd = is_array($course->studens ?? []) ? $course->studens ?? [] : json_decode($course->studens, true);
            if (count($oStd) > 0) {
                $stdContainer = $oStd;
            }
            if (!($stdContainer[$user->id] ?? false)) {
                $stdContainer[$user->id] = date('Y-m-d');
            }
            $course->studens = $stdContainer;
            $course->save();

            $user->courses = $courseContainer;
            $user->save();
            return redirect()->route('course.detail', ['id' => $cid]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('course.detail', ['id' => $cid]);
        }

    }

    public function search(Request $request)
    {
        // Retrieve the search keyword and department filters from the request
        $search = $request->input('search');
        $departmentIds = $request->input('departments');

        // Start building the query
        $query = Course::where('permission->all', true);

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
        if (!($request->input('departments'))) {
            $departmentIds = [];
        } else {
            $departmentIds = $request->input('departments');
        }
        $userId = $request->user()->id; // Get the current user's ID

        // Start building the query with the initial condition for the current user
        if ($request->user()->hasAnyRole(['admin', 'staff'])) {
            $query = Course::where('permission->dpm', true);
        } else {
            $query = Course::where('permission->dpm', true)
                        ->where(function ($query) use ($request) {
                            $query->where("studens", 'LIKE' , '%"'.$request->user()->id.'"%')
                                ->orWhere('dpm', $request->user()->dpm);
                        });
        }

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
                    $subquery->whereIn('dpm', $departmentIds);
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
                        } else {
                            if ($item->type == 'file') {
                                $filePath = public_path('uploads/sublessons/' . $item->content);
                                // Check if the file exists before attempting to delete
                                if (File::exists($filePath)) {
                                    File::delete($filePath);
                                }
                            }
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
