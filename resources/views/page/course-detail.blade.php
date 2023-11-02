<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight d-flex justify-content-between">
            <p>{{ __('Course Title') }}</p>
            <div class="badge btn" style="background-color: var(--primary-color)">Enroll</div>
        </div>
    </x-slot>
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-lg-10 col-sm-12 col-md-8 mb-4">
                <div class="card py-2 px-4 mb-4">
                    <p class="fw-bold fs-5">Description</p>
                    <p class="ps-4" style="text-indent: 1.5em">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dignissimos vel aut sunt non dolores? Voluptatibus pariatur numquam corporis possimus sunt, sed voluptates delectus
                        voluptas aliquid praesentium perspiciatis inventore fugit? Aliquam.</p>
                    <div class="course-menu">
                        <button class="btn btn-sm text-light" style="background-color: var(--primary-color)"><i class="bi bi-gear"></i></i></button>
                        <button class="btn btn-danger btn-sm delete-btn"><i class="bi bi-trash"></i></button>
                    </div>
                </div>

                <div class="card py-2 px-4 mb-4">
                    <p class="fw-bold fs-5">Topic 1</p>
                    <div class="ps-4">
                        <p class="mb-3" style="text-indent: 1.5em">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dignissimos vel aut sunt non dolores? Voluptatibus pariatur numquam corporis possimus sunt, sed voluptates delectus
                            voluptas aliquid praesentium perspiciatis inventore fugit? Aliquam.</p>
                        <div class="mb-3">
                            <i class="bi bi-file-earmark bg-secondary rounded-circle p-1 text-light"></i>
                            <a href="" class="text-primary">Documentation <span class="text-secondary" style="font-size: 12px">Updated October 25, 2566 (PDF)</span></a>
                        </div>
                        <div class="mb-3">
                            <i class="bi bi-play-fill bg-secondary rounded-circle p-1 text-light"></i>
                            <a href="" class="text-primary">Video01 <span class="text-secondary" style="font-size: 12px">Updated October 25, 2566 (MP4)</span></a>
                        </div>
                    </div>
                    <div class="course-menu">
                        <button class="btn btn-sm text-light" style="background-color: var(--primary-color)"><i class="bi bi-gear"></i></i></button>
                        <button class="btn btn-danger btn-sm delete-btn"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
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
                                {{-- <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button> --}}
                            </div>
                            <div class="modal-body bg-light text-dark">
                                <form action="" method="post">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="topic" placeholder="name@example.com">
                                        <label for="topic">Title</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="desc" placeholder="Password">
                                        <label for="desc">Description</label>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="bg-success rounded-pill align-self-center w-100 mx-4" style="height: 5px"></div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-12">
                <div class="card p-4">
                    <p class="text-center fw-bold fs-5 mb-4">About</p>
                    <p>Course ID:</p>
                    <p>Lecturer:</p>
                    <p>Dpm:</p>
                    <p>Lesson:</p>
                    <p>Update:</p>
                    <p>Create:</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    const delBtn = document.querySelectorAll(".delete-btn");
    delBtn.forEach((btn) => {
        btn.addEventListener('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                  Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
                }
            });
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
