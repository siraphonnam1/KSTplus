<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">Own Course</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row">
                <div class="col-lg-8 col-md-8 col-sm-12 overflow-y-auto mb-4" style="height: 520px">
                    @if (count($courses) > 0)
                        @foreach ($courses as $course)
                            {{-- course card --}}
                            <div class="shadow-sm card mb-3 course-card p-2">
                                <a href="{{route('course.detail', ['id' => $course->id])}}">
                                    <div class="row g-0">
                                        <div class="col-md-4 d-flex align-items-center">
                                            <img src="/img/logo.png" class="img-fluid rounded-start w-100 h-100 object-fit-contain" alt="...">
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
                                    <button class="btn btn-info btn-sm edit-btn text-white" value="{{$course->id}}" ctitle="{{ $course->title }}" cdesc="{{ $course->description}}" newPerm="{{ json_decode($course->permission)->new }}"  empPerm="{{ json_decode($course->permission)->employee }}"><i class="bi bi-gear"></i></button>
                                    <button class="btn btn-danger btn-sm delete-btn" value="{{$course->id}}"><i class="bi bi-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex justify-center fw-bold"><span class="bg-yellow-100 text-yellow-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Course not found</span></div>
                    @endif
                </div>
                <div class="col-md-4 col-lg-4 px-4 col-sm-12">
                    <div class="mb-4">
                        <button class="btn btn-success w-100" onclick="showAddCourseAlert()">
                            <i class="bi bi-plus-circle-fill"></i> Add Course
                        </button>
                    </div>
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
                    <input class="form-check-input" type="checkbox" id="newPer" value="option1">
                    <label class="form-check-label" for="newPer">New</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="normalPer" value="option2">
                    <label class="form-check-label" for="normalPer">Employee</label>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const topic = document.getElementById('topic').value;
                const desc = document.getElementById('desc').value;
                const newPer = document.getElementById('newPer').checked;
                const normalPer = document.getElementById('normalPer').checked;

                if (!topic) {
                    Swal.showValidationMessage("Topic is required");
                    return;
                }

                return fetch('/course/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ title: topic, desc: desc, perm: newPer, normPer: normalPer})
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
        const enew = ebtn.getAttribute('newPerm');
        const eemp = ebtn.getAttribute('empPerm');
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
                        <input class="form-check-input" type="checkbox" id="newPer" value="option1" ${enew ? 'checked' : ''}>
                        <label class="form-check-label" for="newPer">New</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="normalPer" value="option2" ${eemp ? 'checked' : ''}>
                        <label class="form-check-label" for="normalPer">Employee</label>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: "Save",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    const topic = document.getElementById('topic').value;
                    const desc = document.getElementById('desc').value;
                    const newPer = document.getElementById('newPer').checked;
                    const normalPer = document.getElementById('normalPer').checked;

                    if (!topic) {
                        Swal.showValidationMessage("Topic is required");
                        return;
                    }

                    return fetch('/course/update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ title: topic, desc: desc, perm: newPer, normPer: normalPer, courseId:editId})
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
</style>
