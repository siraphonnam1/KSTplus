<x-app-layout>
    {{-- <header class="position-relative">
        <div class="container h-100 pt-5">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h2 class="text-xl text-light fw-bold mb-3">
                    {{ __('Search Course') }}
                </h2>
                <div class="search-container">
                    <form action="" method="post">
                        <div class="input-group input-group-sm mb-3 ">
                            <input type="text" class="form-control search-input" placeholder="Search" aria-label="Recipient's username" >
                            <button class="btn btn-info bg-info search-btn" type="button">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header> --}}
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">All Course</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row">
                <div class="col-lg-8 col-md-8 col-sm-12 overflow-y-auto">

                    @foreach ($courses as $course)
                        {{-- course card --}}
                        <div class="shadow-sm card mb-3 course-card">
                            <a href="{{route('course.detail')}}">
                                <div class="row g-0">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <img src="/img/logo.png" class="img-fluid rounded-start w-100 h-100 object-fit-contain" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold mb-0 fs-4">{{ $course->title }}</h5>
                                            <p class="card-text fw-bold mb-2">By {{ $course->getDpm->name }}</p>
                                            <p class="card-text text-secondary text-truncate" style="text-indent: 1em">{{ $course->description}}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="course-menu">
                                <button class="btn btn-danger btn-sm delete-btn" value="{{$course->id}}"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="col-md-4 col-lg-4 px-4 col-sm-12">
                    <div class="mb-4">
                        <button class="btn btn-success w-100" onclick="showAddCourseAlert()">
                            <i class="bi bi-plus-circle-fill"></i> Add Course
                        </button>
                    </div>
                    <div class="card p-4 sticky-top top-4 border-0 shadow-sm">
                        <div class="p-2 text-center fw-bold fs-4"><p>Filters <i class="bi bi-filter-left"></i></p></div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput"><i class="bi bi-search"></i> Search</label>
                        </div>

                        <p class="mb-2">Dpartment:</p>
                        <div class="d-flex flex-wrap ps-2">
                            <div class="w-50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        ITI
                                    </label>
                                </div>
                            </div>

                            <div class="w-50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        CS
                                    </label>
                                </div>
                            </div>

                            <div class="w-50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        HR
                                    </label>
                                </div>
                            </div>

                            <div class="w-50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        AD
                                    </label>
                                </div>
                            </div>

                        </div>
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
                        body: JSON.stringify({ delid: delId})
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
