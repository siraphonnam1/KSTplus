<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight d-flex justify-content-between">
            <p>{{ $course->title }}</p>
            @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                <button class="badge btn btn-secondary" disabled>Own</button>
            @elseif ($course->studens[Auth::user()->id] ?? false)
                <button class="badge btn btn-success" disabled>Enrolled</button>
            @else
            <a href="{{ route('enroll', ['cid' => $course->id]) }}"><button class="badge btn" style="background-color: var(--primary-color)" >Enroll</button></a>
            @endif
        </div>
    </x-slot>
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-lg-10 col-sm-12 col-md-8 mb-4">
                <div class="card py-2 px-4 mb-4">
                    <p class="fw-bold fs-5">Description</p>
                    <p class="ps-4" style="text-indent: 1.5em">{{ $course->description }}</p>
                </div>

                @if ($course->studens[Auth::user()->id] ?? false)
                    @foreach ($lessons as $lesson)
                        <div class="card p-4 mb-4">
                            <p class="fw-bold fs-5">{{ $lesson->topic }}</p>
                            <div class="ps-4">
                                <p class="mb-3" style="text-indent: 1.5em">{{ $lesson->desc }}</p>
                                @php
                                    $strSubless = $lesson->sub_lessons;
                                    $sublesson = json_decode($strSubless);
                                @endphp
                                @if (!is_null($sublesson))
                                    @foreach ($sublesson as $index => $sls)
                                        @if ($sls->type == 'text')
                                            <div class="mb-3 flex justify-between">
                                                <div>
                                                    <p class="fw-bold">{{ $sls->label }}</p>
                                                    <p style="text-indent: 1.5em">{{ $sls->content }}</p>
                                                </div>
                                                <div>
                                                    @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                                                        <button class="btn text-danger btn-sm deleteSubBtn" value="{{ $index }}" lessIdVal="{{ $lesson->id }}"><i class="bi bi-trash"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif ($sls->type == 'file')
                                            <div class="mb-3 flex justify-between">
                                                <div>
                                                    <i class="bi bi-file-earmark bg-secondary rounded-circle p-1 text-light"></i>
                                                    <a
                                                        class="text-primary viewFilebtn cursor-pointer"
                                                        data-file-path="{{ asset('uploads/sublessons/' . $sls->content) }}"
                                                        value="{{$sls->content}}"
                                                    >
                                                        {{ $sls->label }}
                                                        <span class="text-secondary" style="font-size: 12px">Updated {{ $sls->date }} ({{ $sls->type }})</span>
                                                    </a>
                                                </div>
                                                <div>
                                                    @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                                                        <button class="btn text-danger btn-sm deleteSubBtn" value="{{ $index }}" lessIdVal="{{ $lesson->id }}"><i class="bi bi-trash"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="mb-3 flex justify-between">
                                                <div>
                                                    @if ($sls->type == 'link')
                                                        <i class="bi bi-link bg-secondary rounded-circle p-1 text-light"></i>
                                                    @elseif ($sls->type == 'video')
                                                        <i class="bi bi-play-fill bg-secondary rounded-circle p-1 text-light"></i>
                                                    @endif
                                                    <a href="{{ $sls->content }}" target="_BLANK" class="text-primary">{{ $sls->label }} <span class="text-secondary" style="font-size: 12px">Updated {{ $sls->date }} ({{ $sls->type }})</span></a>
                                                </div>
                                                <div>
                                                    @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                                                        <button class="btn text-danger btn-sm deleteSubBtn" value="{{ $index }}" lessIdVal="{{ $lesson->id }}"><i class="bi bi-trash"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                            @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                                <div class="course-menu">
                                    <button id="dropdownMenuIconButton{{ $lesson->id }}" data-dropdown-toggle="dropdownDots{{ $lesson->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600" type="button">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                        </svg>
                                    </button>
                                    <!-- Dropdown menu -->
                                    <div id="dropdownDots{{ $lesson->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton{{ $lesson->id }}">
                                            <li>
                                                <button class="w-100 text-start px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white addSubText"  addType="text" lessId="{{ $lesson->id }}"><i class="bi bi-plus"></i> Text</button>
                                            </li>
                                            <li>
                                                <button class="w-100 text-start px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white addSubLink" addType="link" lessId="{{ $lesson->id }}"><i class="bi bi-plus"></i> Link</button>
                                            </li>
                                            <li>
                                                <button class="w-100 text-start px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white addSubLink" addType="video" lessId="{{ $lesson->id }}"><i class="bi bi-plus"></i> Video</button>
                                            </li>
                                            <li>
                                                <button class="w-100 text-start px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white addSubFile" addType="file" lessId="{{ $lesson->id }}"><i class="bi bi-plus"></i> File</button>
                                            </li>
                                        </ul>
                                        <div class="py-2">
                                            <button class="w-100 text-start px-4 py-2 text-sm text-gray-700 hover:bg-sky-300 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white editLessBtn" data-bs-toggle="modal" data-bs-target="#editless{{$lesson->id}}"><i class="bi bi-gear"></i> Edit</button>
                                            <button class="w-100 text-start px-4 py-2 text-sm text-gray-700 hover:bg-red-300 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white delete-btn" value="{{$lesson->id}}" delType="lesson"><i class="bi bi-trash3"></i> Delete</button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- edit lesson modal --}}
                        <div class="modal fade" id="editless{{$lesson->id}}" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addTopicLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-dark">
                                    <div class="modal-header">
                                        <h1 class="modal-title text-light fs-5" id="addTopicLabel">Edit lesson</h1>
                                    </div>
                                    <form method="POST" action="{{ route('lesson.update') }}">
                                        @csrf
                                        <input type="hidden" value="{{$lesson->id}}" name="lessid">
                                        <div class="modal-body bg-light text-dark">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="topic" value="{{ $lesson->topic }}" id="topic" required>
                                                    <label for="topic">Topic</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="desc" value="{{ $lesson->desc }}" id="desc">
                                                    <label for="desc">Description</label>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                        <p>Please Enroll </p>
                @endif


                @if (($course->teacher == Auth::user()->id) || (auth()->user()->hasRole('admin')))
                    <div class="d-flex justify-content-center text-success ">
                        <div class="bg-success rounded-pill align-self-center w-100 mx-4" style="height: 5px"></div>

                        <!-- Modal -->
                        <div class="d-flex btn btn-success rounded-pill addtopic-btn" data-bs-toggle="modal" data-bs-target="#addTopic">
                            <i class="bi bi-plus-circle fs-5"></i>
                            <p class="text-nowrap align-self-center ms-2 ">Add Section</p>
                        </div>

                        <div class="modal fade" id="addTopic" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addTopicLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content bg-dark">
                                    <div class="modal-header">
                                        <h1 class="modal-title text-light fs-5" id="addTopicLabel">Add section</h1>
                                    </div>
                                    <form method="POST" action="{{ route('lesson.add') }}">
                                        @csrf
                                        <input type="hidden" value="{{$id}}" name="courseid">
                                        <div class="modal-body bg-light text-dark">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="topic" id="topic" placeholder="name@example.com" required>
                                                    <label for="topic">Topic</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="desc" id="desc">
                                                    <label for="desc">Description</label>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="bg-success rounded-pill align-self-center w-100 mx-4" style="height: 5px"></div>
                    </div>
                @endif
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="card p-4">
                    <p class="text-center fw-bold fs-5 mb-4">About</p>
                    <p><b>Course ID: </b> {{ $course->code }}</p>
                    <p><b>Lecturer: </b> {{ $course->getTeacher->name }}</p>
                    <p><b>Dpm: </b> {{ $course->getDpm->name }}</p>
                    <p><b>Lesson: </b> {{ $lessons->count() }}</p>
                    @php
                        $updatetime = new DateTime($course->updated_at);
                        $update = $updatetime->format('Y-m-d');

                        $createtime = new DateTime($course->updated_at);
                        $create = $createtime->format('Y-m-d');
                    @endphp
                    <p><b>Update: </b> {{ $update }}</p>
                    <p><b>Create: </b> {{ $create }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    const delBtn = document.querySelectorAll(".delete-btn");
    delBtn.forEach((btn) => {
        const delId = btn.value;
        const delType = btn.getAttribute('delType');
        btn.addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch('/course/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ delid: delId, deltype: delType})
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
                    'Your file has been deleted.',
                    'success'
                    )
                }
            })
        });
    });


    const delSubBtn = document.querySelectorAll(".deleteSubBtn");
    delSubBtn.forEach((subbtn) => {
        const delId = subbtn.value;
        const dellessid = subbtn.getAttribute('lessIdVal');
        subbtn.addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch('/lesson/sublesson/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ delid: delId, lessId: dellessid })
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
                    'Your file has been deleted.',
                    'success'
                    )
                }
            })
        });
    });

    const addText = document.querySelectorAll(".addSubText");
    addText.forEach((btn) => {
        const lessid = btn.getAttribute('lessId');
        const addType = btn.getAttribute('addType')
        btn.addEventListener('click', function () {
            Swal.fire({
                title: 'Add text',
                html:
                    '<input id="swal-input1" class="swal2-input" placeholder="Enter label">' +
                    '<textarea id="content" class="w-100" rows="5" placeholder="Enter text content"></textarea>',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const label = document.getElementById('swal-input1').value;
                    const content = document.getElementById('content').value;

                    if (!label) {
                        Swal.showValidationMessage("Label is required!");
                        return;
                    } else if (!content) {
                        Swal.showValidationMessage("Content is required!");
                        return;
                    } else {
                        return fetch('/lesson/sublesson/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ label: label, content: content, lessId: lessid, addType: addType})
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
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    Swal.fire(
                        'Success!',
                        'Your sublesson has been saved.',
                        'success'
                    )
                }
            })
        });
    });

    const addLink = document.querySelectorAll(".addSubLink");
    addLink.forEach((btn) => {
        const lessid = btn.getAttribute('lessId')
        const addType = btn.getAttribute('addType')
        btn.addEventListener('click', function () {
            Swal.fire({
                title: `Add ${addType}`,
                html:
                    '<input id="swal-input1" class="swal2-input" placeholder="Enter label">' +
                    '<input id="content" class="swal2-input" placeholder="Enter link">',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const label = document.getElementById('swal-input1').value;
                    const content = document.getElementById('content').value;

                    if (!label) {
                        Swal.showValidationMessage("Label is required!");
                        return;
                    } else if (!content) {
                        Swal.showValidationMessage("Content is required!");
                        return;
                    } else {
                        return fetch('/lesson/sublesson/add', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ label: label, content: content, lessId: lessid, addType: addType})
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
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    Swal.fire(
                        'Success!',
                        'Your sublesson has been saved.',
                        'success'
                    )
                }
            })
        });
    });


    const addFile = document.querySelectorAll(".addSubFile");
    addFile.forEach((btnf) => {
        const lessId = btnf.getAttribute('lessId')
        const addType = btnf.getAttribute('addType')
        btnf.addEventListener('click', function () {
            Swal.fire({
                title: 'Add File',
                html:`  <input id="labelInput" class="swal2-input" placeholder="Enter label">
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">jpeg,png,pdf,svg,doc,docx,xls,xlsx,ppt,pptx,txt,mp4,zip,rar <br> (MAX 10Mb size)</p>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" />
                            </label>
                        </div>
                     `,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Save',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const label = document.getElementById('labelInput').value;
                    const fileInput = document.getElementById('dropzone-file');

                    // Ensure a file was selected
                    if (!label) {
                        Swal.showValidationMessage("Label is required!");
                        return;
                    } else if (!fileInput.files || fileInput.files.length === 0) {
                        Swal.showValidationMessage("File is required!");
                        return;
                    } else {
                        const formData = new FormData();
                        formData.append('label', label);
                        formData.append('content', fileInput.files[0]);
                        formData.append('lessId', lessId);
                        formData.append('addType', addType);

                        // Add your CSRF token
                        formData.append('_token', '{{ csrf_token() }}');

                        return fetch('/lesson/sublesson/add', {
                            method: 'POST',
                            body: formData // Send formData without setting Content-Type header
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            Swal.showValidationMessage(`Request failed: ${error}`)
                        });
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result.value);
                    Swal.fire(
                        'Success!',
                        'Your sublesson has been saved.',
                        'success'
                    )
                }
            })
        });
    });

    const pdfButtons = document.querySelectorAll('.viewFilebtn');
        pdfButtons.forEach((pdfbtn) => {
            const fileNameValue = pdfbtn.value;
            pdfbtn.addEventListener('click', function () {
                const pdfUrl = this.getAttribute('data-file-path');
                Swal.fire({
                    width: '50%',
                    html: `<div style="height: 500px;">
                                <iframe src="${pdfUrl}" style="width: 100%; height: 100%;object-fit:cover" frameborder="0"></iframe>
                            </div>
                        `,
                })
            });
        });
</script>
<style>
    .course-menu {
        position: absolute;
        top: 0;
        right: 0;
        width: fit-content;
        /* display: none; */
        transition: 1s;
    }
    .addtopic-btn > p {
        display: none;
    }
    .addtopic-btn:hover > p {
        display: unset;
    }
</style>
