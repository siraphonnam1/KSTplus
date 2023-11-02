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
                                <input type="text" class="form-control" id="username" name="username" value="meanie" aria-label="Username" aria-describedby="basic-addon1" disabled>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="basic-addon1">Password:</span>
                                <input type="password" class="form-control" id="password" name="password" value="11111111" aria-label="Username" aria-describedby="basic-addon1" disabled>
                            </div>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text" id="basic-addon1">Name:</span>
                                <input type="text" class="form-control" name="name" id="name" value="Meanie" aria-label="Username" aria-describedby="basic-addon1" disabled>
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
                                            @role($user->role)
                                                selected
                                            @endrole
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

                <div class="bg-white rounded-4 mb-2 shadow-sm">
                    <div class="text-center my-3">
                        <div class="my-4">
                            <p class="fs-4 fw-bold">Course</p>
                        </div>
                        <div>
                            <table class="table table-hover" id="course-datatable">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">code</th>
                                        <th scope="col">Course name</th>
                                        <th scope="col">Enroll date</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>ID0003</td>
                                        <td>cn</td>
                                        <td>{{ date('Y-m-d') }}</td>
                                        <td>Learning...</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>ID0002</td>
                                        <td>course</td>
                                        <td>{{ date('Y-m-d') }}</td>
                                        <td class="table-danger">Abandon</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>ID0001</td>
                                        <td>gg</td>
                                        <td>{{ date('Y-m-d') }}</td>
                                        <td class="table-success">Success</td>
                                    </tr>
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
</script>

<style>

</style>
