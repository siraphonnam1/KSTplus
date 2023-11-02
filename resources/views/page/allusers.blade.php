<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">All Users</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row">
                <div class="col-lg-9 bg-light col-md-9 col-sm-12 p-4 rounded ">
                    <table class="table table-sm table-hover" id="users-datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Dpm</th>
                                <th scope="col">Course</th>
                                <th scope="col">OwnCourse</th>
                                <th scope="col">Lifetime</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($users as $user)
                                <tr>
                                    <td>1</td>
                                    <td>{{ $user->name }}</td>
                                    <td>New</td>
                                    <td>{{ $user->dpmName->name }}</td>
                                    <td>12</td>
                                    <td>0</td>
                                    <td>Forever</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail" href="{{ url('/users/detail/'. $user->id ) }}"><i class="bi bi-file-person-fill"></i></a>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete this user." id="delBtn" value="{{ $user->id }}"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3 col-lg-3 px-3 col-sm-12">

                    <div class="mb-2">
                        <button
                            class="btn btn-success w-100"
                            id="addBtn"
                            data-bs-toggle="modal"
                            data-bs-target="#addUserModal"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-title="Add user"><i class="bi bi-person-plus-fill"></i></button>

                        <!-- Modal -->
                        <div class="modal fade" id="addUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header ">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add User</h1>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('user.register') }}" method="post">
                                            @csrf
                                            <div class="d-flex gap-2 mb-2">
                                                <p>Name</p>
                                                <input type="text" class="form-control form-control-sm" value="{{ old('name') }}" name="name" required>
                                            </div>
                                            <div class="d-flex gap-2 mb-2">
                                                <p>Username</p>
                                                <input type="text" class="form-control form-control-sm" value="{{ old('username') }}" name="username" required>
                                            </div>
                                            <div class="d-flex gap-2 mb-2">
                                                <p>Password</p>
                                                <input type="password" class="form-control form-control-sm" name="password" required>
                                            </div>
                                            <div class="d-flex gap-2 mb-2">
                                                <select class="form-select form-select-sm" aria-label="Small select example" value="{{ old('agn') }}" name="agn" required>
                                                    <option selected disabled>Agency</option>
                                                    @foreach ($agns as $agn)
                                                        <option value="{{ $agn->id }}">{{ $agn->name }}</option>
                                                    @endforeach
                                                </select>
                                                <select class="form-select form-select-sm" aria-label="Small select example" value="{{ old('brn') }}" name="brn" required>
                                                    <option selected disabled>Branch</option>
                                                    @foreach ($brns as $brn)
                                                        <option value="{{ $brn->id }}">{{ $brn->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="d-flex gap-2 mb-2">
                                                <select class="form-select form-select-sm" aria-label="Small select example" value="{{ old('dpm') }}" name="dpm" required>
                                                    <option selected disabled>Department</option>
                                                    @foreach ($dpms as $dpm)
                                                        <option value="{{ $dpm->id }}">{{ $dpm->name }}</option>
                                                    @endforeach
                                                </select>
                                                <select class="form-select form-select-sm" aria-label="Small select example" value="{{ old('role') }}" name="role" required>
                                                    <option selected disabled>Role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="my-4">
                                                <p>Course</p>
                                                <select class="form-select" id="small-select2-options-multiple-field" aria-label="Small select example" multiple name="courses[]">
                                                    <option>Christmas Island</option>
                                                    <option>South Sudan</option>
                                                    <option>Jamaica</option>
                                                    <option>Kenya</option>
                                                </select>
                                            </div>
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-outline-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card p-4 sticky-top top-4 border-0 shadow-sm">
                        <p class="mb-2">Dpartment:</p>
                        <div class="d-flex flex-wrap ps-2 mb-3">
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

                        <p class="mb-2">Status:</p>
                        <div class="d-flex flex-wrap ps-2 mb-3">
                            <div class="w-50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        New
                                    </label>
                                </div>
                            </div>

                            <div class="w-50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Normal
                                    </label>
                                </div>
                            </div>

                            <div class="w-50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Special
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#users-datatable').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: false,     // Enables column ordering
            info: false,         // 'Showing x to y of z entries' string
            lengthChange: false, // Allows the user to change number of rows shown
            pageLength: 10,      // Set number of rows per page
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    $( '#small-select2-options-multiple-field' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        closeOnSelect: false,
        selectionCssClass: 'select2--small',
        dropdownCssClass: 'select2--small',
    } );

    const delBtns = document.querySelectorAll('#delBtn');
    delBtns.forEach((delbtn) => {
        delbtn.addEventListener('click', () => {
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
                    const delId = delbtn.value;

                    return fetch('/user/delete', {
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
        })
    })
</script>

<style>

</style>
