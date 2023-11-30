<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">USER</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row gap-2 justify-content-center">
                <div class="bg-white rounded-4 mb-5 shadow-sm">
                    <div class="text-center my-3">
                        <p class="fs-4 fw-bold">About</p>
                    </div>
                    <div class="d-flex justify-content-evenly">
                        <div class="d-flex justify-content-center align-items-center my-3 w-100">
                            <img src="/img/icons/{{$user->icon}}" style="object-fit: cover; width: 200px; height:200px" class="rounded-circle" width="200" alt="">
                        </div>
                        <div class="my-3 w-100 px-4">
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="basic-addon1">Username:</span>
                                <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" aria-label="Username" aria-describedby="basic-addon1" disabled>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="basic-addon1">Password:</span>
                                <input type="password" class="form-control" id="password" name="password" value="" aria-label="Username" aria-describedby="basic-addon1" disabled>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="basic-addon1">Name:</span>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" aria-label="Username" aria-describedby="basic-addon1" disabled>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="basic-addon1">Agency:</span>
                                <select class="form-select form-select-sm" id="agn" name="agn" disabled>
                                    @foreach ($agns as $agn)
                                        <option value="{{ $agn->id }}"
                                            @if ($user->dpm == $agn->id)
                                                selected
                                            @endif
                                        >{{ $agn->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="basic-addon1">Branch:</span>
                                <select class="form-select form-select-sm" id="brn" name="brn" disabled>
                                    @foreach ($brns as $brn)
                                        <option value="{{ $brn->id }}"
                                            @if ($user->brn == $brn->id)
                                                selected
                                            @endif
                                        >{{ $brn->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="basic-addon1">Dpm:</span>
                                <select class="form-select form-select-sm" name="dpm" id="dpm"  disabled>
                                    @foreach ($dpms as $dpm)
                                        <option value="{{ $dpm->id }}"
                                            @if ($user->dpm == $dpm->id)
                                                selected
                                            @endif
                                        >{{ $dpm->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="basic-addon1">Role:</span>
                                <select class="form-select form-select-sm" name="role" id="role" disabled>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            @if ($user->role == $role->name)
                                                selected
                                            @endif
                                        >{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mb-3 gap-2">
                        <button class="btn btn-success" id="editBtn">Edit</button>
                        <button class="btn btn-danger" id="cancelBtn" style="display: none;">Cancel</button>
                    </div>
                </div>

                <div class="bg-white rounded-4 mb-4 shadow-sm">
                    <div class="text-center my-3">
                        <div class="my-4 flex justify-between px-4">
                            <p class="fs-4 fw-bold">Course</p>
                            <button class="btn btn-success" id="addC2User"><i class="bi bi-plus-lg"></i></button>
                        </div>
                        <div>
                            <table class="table table-hover" id="course-datatable">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Action</th>
                                        <th scope="col">code</th>
                                        <th scope="col" >Course name</th>
                                        <th scope="col">Progress</th>
                                        <th scope="col">Enroll date</th>
                                    </tr>
                                </thead>
                                <tbody class="text-start">
                                    @foreach ($ucourse as $course)
                                        @php
                                            $prog_finish = App\Models\progress::where('user_id', $id)->where('course_id', $course->id)->count();
                                            $less_all = App\Models\lesson::where('course', $course->id)->count();
                                            if ($less_all != 0) {
                                                $prog_avg = $prog_finish * 100 / $less_all;
                                            } else {
                                                $prog_avg = 0;
                                            }
                                        @endphp
                                        <tr>
                                            <th scope="row"><button class="text-danger delete-btn" value="{{ $course->id }}" userId="{{ $user->id }}"><i class="bi bi-trash"></i></button></th>
                                            <td>{{ $course->code }}</td>
                                            <td data-toggle="tooltip" data-placement="top" title="{{ $course->title }}">{{ Str::limit($course->title, 60) }}</td>
                                            <td>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-success" style="width: {{$prog_avg}}%">{{$prog_avg}}%</div>
                                                </div>
                                                {{-- {{$prog_avg}}%
                                                <div class="w-full bg-gray-200 rounded-full h-2.5 ">
                                                    <div class="bg-green-600 h-2.5 rounded-full " style="width: {{$prog_avg}}%"></div>
                                                </div> --}}
                                            </td>
                                            <td>
                                                {{ $course->studens[$user->id] ?? '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-4 mb-4 shadow-sm">
                    <div class="text-center my-3">
                        <div class="my-4 flex justify-between px-4">
                            <p class="fs-4 fw-bold">Own Course</p>
                        </div>
                        <div>
                            <table class="table table-hover" id="owncourse-datatable">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">code</th>
                                        <th scope="col" colspan="3" >Course name</th>
                                        <th scope="col">Progress</th>
                                        <th scope="col">Enroll date</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @foreach ($ownCourse as $index => $ocourse)
                                        @php
                                            $prog_finish = App\Models\progress::where('user_id', $id)->where('course_id', $ocourse->id)->count();
                                            $less_all = App\Models\lesson::where('course', $ocourse->id)->count();
                                            if ($less_all != 0) {
                                                $prog_avg = $prog_finish * 100 / $less_all;
                                            } else {
                                                $prog_avg = 0;
                                            }
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $ocourse->code }}</td>
                                            <td colspan="3" data-toggle="tooltip" data-placement="top" title="{{ $ocourse->title }}">{{ Str::limit($ocourse->title, 60) }}</td>
                                            <td>
                                                <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar bg-success" style="width: {{$prog_avg}}%">{{$prog_avg}}%</div>
                                                </div>
                                                {{-- {{$prog_avg}}%
                                                <div class="w-full bg-gray-200 rounded-full h-2.5 ">
                                                    <div class="bg-green-600 h-2.5 rounded-full " style="width: {{$prog_avg}}%"></div>
                                                </div> --}}
                                            </td>
                                            <td>
                                                {{ $ocourse->studens[$user->id] ?? '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-4 mb-4 shadow-sm">
                    <div class="text-center my-3">
                        <div class="my-4 flex justify-between px-4">
                            <p class="fs-4 fw-bold">Test History</p>
                        </div>
                        <div>
                            <table class="table table-hover " id="test-datatable">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Quiz</th>
                                        <th scope="col">Score</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="text-start">
                                    @foreach ($tests as $index => $test)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-nowrap" data-toggle="tooltip" data-placement="top" title="{{ optional($test->getQuiz)->title }}">{{ optional($test->getQuiz)->title }}</td>
                                            {{-- <td>{{ optional($test->getTester)->name }}</td> --}}
                                            <td>{{ $test->score }} / {{ $test->totalScore }}</td>
                                            <td>{{ Carbon\Carbon::parse($test->start)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script >
    $(document).ready(function() {
        $('#test-datatable').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 5,      // Set number of rows per page
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'KST_Test_{{$user->name}}_export',
                },
                {
                    extend: 'pdf',
                    title: '{{ auth()->user()->agnName->name ?? "Knowledge Service Training"}}',
                    header: "Header",
                    filename: "kst_test_export",
                    customize: function (doc) {
                        // Set table layout to full width
                        doc.content[1].table.widths =
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');

                        // Add a subtitle (this example adds it on the second line)
                        doc.content.splice(1, 0, {
                            text: '{{$user->name}} Test history',
                            fontSize: 12,
                            alignment: 'center',
                            margin: [0, 0, 0, 10]
                        });

                        // Set margins to ensure table uses full page width
                        var cm = 28.35;
                        doc.pageMargins = [2*cm, cm, 2*cm, cm]; // Or any other margin settings
                    }
                }
            ]
        });
    });

    $(document).ready(function() {
        $('#course-datatable').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 5,      // Set number of rows per page
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'KST_Test_export',
                },
                {
                    extend: 'pdf',
                    title: '{{ auth()->user()->agnName->name ?? "Knowledge Service Training"}}',
                    header: "Header",
                    filename: "kst_course_export",
                    customize: function (doc) {
                        // Set table layout to full width
                        doc.content[1].table.widths =
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');

                        // Add a subtitle (this example adds it on the second line)
                        doc.content.splice(1, 0, {
                            text: '{{$user->name}} Enroll Course',
                            fontSize: 12,
                            alignment: 'center',
                            margin: [0, 0, 0, 10]
                        });

                        // Set margins to ensure table uses full page width
                        var cm = 28.35;
                        doc.pageMargins = [2*cm, cm, 2*cm, cm]; // Or any other margin settings
                    }
                }
            ]
        });
    });

    $(document).ready(function() {
        $('#owncourse-datatable').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 5,      // Set number of rows per page
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'KST_Course_export',
                },
                {
                    extend: 'pdf',
                    title: '{{ auth()->user()->agnName->name ?? "Knowledge Service Training"}}',
                    header: "Header",
                    filename: "kst_test_export",
                    customize: function (doc) {
                        // Set table layout to full width
                        doc.content[1].table.widths =
                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');

                        // Add a subtitle (this example adds it on the second line)
                        doc.content.splice(1, 0, {
                            text: '{{$user->name}} Course',
                            fontSize: 12,
                            alignment: 'center',
                            margin: [0, 0, 0, 10]
                        });

                        // Set margins to ensure table uses full page width
                        var cm = 28.35;
                        doc.pageMargins = [2*cm, cm, 2*cm, cm]; // Or any other margin settings
                    }
                }
            ]
        });
    });




    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const fullname = document.getElementById('name');
    const agn = document.getElementById('agn');
    const brn = document.getElementById('brn');
    const dpm = document.getElementById('dpm');
    const role = document.getElementById('role');

    const editBtn = document.getElementById('editBtn');
    const cancelBtn = document.getElementById('cancelBtn');

    editBtn.addEventListener('click', () => {
        if (editBtn.innerText === 'Edit') {

            username.disabled = false;
            password.disabled = false;
            fullname.disabled = false;
            agn.disabled = false;
            brn.disabled = false;
            dpm.disabled = false;
            role.disabled = false;

            cancelBtn.style.display = 'block';
            editBtn.innerText = 'Save';
        } else if (editBtn.innerText === 'Save') {
            username.disabled = true;
            password.disabled = true;
            fullname.disabled = true;
            agn.disabled = true;
            brn.disabled = true;
            dpm.disabled = true;
            role.disabled = true;

            fetch('/user/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: fullname.value,
                        username: username.value,
                        password: password.value,
                        agn: agn.value,
                        brn: brn.value,
                        dpm: dpm.value,
                        role: role.value,
                        uid: {{$id}}
                    })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                    return response.json();
                }
                else {
                    return response.json();  // This line is crucial. Return the result of response.json().
                }
            })
            .then(data => {
                console.log(data);  // This is where you get and log the actual JSON data.
                if (data.error) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: false,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    Toast.fire({
                        icon: 'error',
                        title: 'Something went wrong!'
                    });
                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: false,
                        didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: 'Saved successfully'
                    });
                }
            })
            .catch(error => {
                console.error('There was an error:', error);
            });

            cancelBtn.style.display = 'none';
            editBtn.innerText = 'Edit';
        }
    });

    cancelBtn.addEventListener('click' , () => {
        username.disabled = true;
        username.value = "meanie";

        password.disabled = true;
        password.value = "11111111";

        fullname.disabled = true;
        fullname.value = "Meanie";

        agn.disabled = true;
        agn.value = "1";

        brn.disabled = true;
        brn.value = "1";

        dpm.disabled = true;
        dpm.value = "1";

        role.disabled = true;
        role.value = "1";

        cancelBtn.style.display = 'none';
        editBtn.innerText = 'Edit';
    });


    const addCBtn = document.getElementById('addC2User');
    addCBtn.addEventListener('click', () => {
        Swal.fire({
            title: 'Add Course',
            html: `
                <select id="select-course" class="select2" multiple="multiple" style="width: 100%">
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->code }}</option>
                    @endforeach
                </select>
            `,
            didOpen: () => {
                // Initialize Select2 on the #select-course element
                $('#select-course').select2({
                    dropdownParent: $(".swal2-container"),
                    placeholder: "Select courses",
                    allowClear: true
                });
            },
            showCancelButton: true,
            confirmButtonText: "Save",
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const courseSel = $('#select-course').select2('data').map(option => option.id);

                if (courseSel.length < 1) {
                    Swal.showValidationMessage("Please select a course!");
                    return;
                }

                return fetch('/user/add/course', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ courses: courseSel, uid: {{$user->id}}})
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.json()
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed`
                    )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Success!',
                    'Your change has been saved.',
                    'success'
                )
            }
        });
    });

    const delBtn = document.querySelectorAll(".delete-btn");
    delBtn.forEach((btn) => {
        const courseId = btn.value;
        const userId = btn.getAttribute('userId');
        btn.addEventListener('click', function () {
            Swal.fire({
                title: `Are you sure?`,
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch('/user/remove/course', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ cid: courseId, uid: userId})
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed`
                        )
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    Swal.fire(
                        'Deleted!',
                        'course has been removed.',
                        'success'
                    )
                }
            })
        });
    });
</script>

<style>

</style>
