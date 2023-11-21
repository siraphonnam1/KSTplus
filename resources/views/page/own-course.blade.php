<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">Own Course</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row">
                <div class="mb-4 flex justify-end">
                    <button class="btn btn-success" onclick="showAddCourseAlert()">
                        <i class="bi bi-plus-circle-fill"></i> Add Course
                    </button>
                </div>
                <div class="overflow-y-auto mb-4" style="height: 520px">
                    @if (count($courses) > 0)
                        @foreach ($courses as $course)
                            {{-- course card --}}
                            <div class="shadow-sm card mb-3 course-card">
                                <a href="{{route('course.detail', ['id' => $course->id])}}">
                                    <div class="row g-0">
                                        <div class="col-md-4 d-flex align-items-center coursebg" style="background-image: url('{{ $course->img ? '/uploads/course_imgs/'.$course->img : '/img/logo.png' }}')">
                                            {{-- <img src="{{ $course->img ? '/uploads/course_imgs/'.$course->img : '/img/logo.png' }}" class="img-fluid rounded-start object-fit-cover" alt="..."> --}}
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title fw-bold mb-0 fs-4">{{ $course->title }}</h5>
                                                <p class="card-text fw-bold mb-2">ID: {{ $course->code }} &nbsp;&nbsp; By: {{ optional($course->getDpm)->name }}</p>
                                                <p class="card-text text-secondary text-truncate" style="text-indent: 1em">{{ $course->description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="course-menu">
                                    <button class="btn btn-info btn-sm edit-btn text-white" value="{{$course->id}}" ctitle="{{ $course->title }}" cdesc="{{ $course->description}}" allPerm="{{ json_decode($course->permission)->all??'' }}"  dpmPerm="{{ json_decode($course->permission)->dpm??'' }}"><i class="bi bi-gear"></i></button>
                                    <button class="btn btn-danger btn-sm delete-btn" value="{{$course->id}}"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex justify-center fw-bold"><span class="bg-yellow-100 text-yellow-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Course not found</span></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function showAddCourseAlert() {
        Swal.fire({
            title: 'Add Course',
            html: `
                <div class="mb-3">
                    <label for="topic" class="form-label text-start">Topic</label>
                    <input type="text" class="form-control" id="topic">
                </div>
                <div class="mb-3">
                    <label for="desc" class="form-label">Description</label>
                    <textarea class="form-control" id="desc" rows="2"></textarea>
                </div>

                <p class="mb-3">Permission</p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="allPer" value="option1">
                    <label class="form-check-label" for="allPer">All</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="dpmPer" value="option2">
                    <label class="form-check-label" for="dpmPer">DpmOnly</label>
                </div>
                <div class="flex items-center justify-center w-full mt-2">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-30 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-2 pb-2">
                            <p class="mb-2 font-bold">Course image</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">jpeg,png  (MAX 10Mb size)</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" />
                    </label>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const topic = document.getElementById('topic').value;
                const desc = document.getElementById('desc').value;
                const allPer = document.getElementById('allPer').checked;
                const dpmPer = document.getElementById('dpmPer').checked;
                const fileInput = document.getElementById('dropzone-file');

                if (!topic) {
                    Swal.showValidationMessage("Topic is required");
                    return;
                }
                const formData = new FormData();
                formData.append('title', topic);
                formData.append('desc', desc);
                formData.append('allPerm', allPer);
                formData.append('dpmPerm', dpmPer);
                formData.append('cimg', fileInput.files[0]);

                // Add your CSRF token
                formData.append('_token', '{{ csrf_token() }}');

                return fetch('/course/add', {
                    method: 'POST',
                    body: formData
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
            }
        });

    }

    const delBtn = document.querySelectorAll(".delete-btn");
    delBtn.forEach((btn) => {
        const delId = btn.value;
        btn.addEventListener('click', function () {
            Swal.fire({
                title: `Are you sure?`,
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
                        body: JSON.stringify({ delid: delId, deltype:'course'})
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

    const editBtn = document.querySelectorAll(".edit-btn");
    editBtn.forEach((ebtn) => {
        const editId = ebtn.value;
        const etitle = ebtn.getAttribute('ctitle');
        const edesc = ebtn.getAttribute('cdesc');
        const eall = ebtn.getAttribute('allPerm');
        const edpm = ebtn.getAttribute('dpmPerm');
        ebtn.addEventListener('click', function () {
            Swal.fire({
                title: 'Edit Course',
                html: `
                    <div class="mb-3">
                        <label for="topic" class="form-label text-start">Topic</label>
                        <input type="text" class="form-control" id="topic" value="${etitle}">
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Description</label>
                        <textarea class="form-control" id="desc" rows="2">${edesc}</textarea>
                    </div>

                    <p class="mb-3">Permission</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="allPer" value="option1" ${eall ? 'checked' : ''}>
                        <label class="form-check-label" for="allPer">All</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="dpmPer" value="option2" ${edpm ? 'checked' : ''}>
                        <label class="form-check-label" for="dpmPer">DpmOnly</label>
                    </div>
                    <div class="flex items-center justify-center w-full mt-2">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-30 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-2 pb-2">
                                <p class="mb-2 font-bold">Course image</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">jpeg,png  (MAX 10Mb size)</p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" />
                        </label>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: "Save",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const topic = document.getElementById('topic').value;
                    const desc = document.getElementById('desc').value;
                    const allPer = document.getElementById('allPer').checked;
                    const dpmPer = document.getElementById('dpmPer').checked;
                    const fileInput = document.getElementById('dropzone-file');

                    if (!topic) {
                        Swal.showValidationMessage("Topic is required");
                        return;
                    }

                    const formData = new FormData();
                    formData.append('title', topic);
                    formData.append('desc', desc);
                    formData.append('allPerm', allPer);
                    formData.append('dpmPerm', dpmPer);
                    formData.append('courseId', editId);
                    formData.append('cimg', fileInput.files[0]);

                    // Add your CSRF token
                    formData.append('_token', '{{ csrf_token() }}');

                    return fetch('/course/update', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json', // This tells the server you expect JSON in return
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        console.log(error);
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
    });
</script>
<style>
    .course-card {
        border: unset;
    }
    .course-card:hover{
        outline: 4px solid pink;
        cursor: pointer;
    }
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    .course-menu {
        position: absolute;
        top: 0;
        right: 0;
        width: fit-content;
        display: none;
        transition: 1s;
    }
    @keyframes fin {
        0% {
            transform: scale(0.5);

        }
        50% {transform: scale(1);}
        100% {transform: scale(1);}
    }
    .course-card:hover > .course-menu {
        animation: fin 1s;
        display: unset;
    }
    .coursebg {
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
    }
</style>
