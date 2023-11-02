<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">Agency Data</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row justify-center">
                <div class="p-4 rounded-lg row">
                    <div class="col-6 ">
                        <div class="bg-white p-4 shadow rounded-lg">
                            <div class="flex justify-between mb-3">
                                <p class="text-2xl font-bold"><i class="bi bi-buildings"></i> Agency</p>
                                <button class="btn btn-success" onclick="addAgn()" ><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div class="overflow-auto">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Action</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Contact</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @foreach ($agns as $agn)
                                            <tr>
                                                <td><button class="btn btn-sm btn-danger" id="delBtn" deltype="agn" value="{{ $agn->id }}"><i class="bi bi-trash"></i></button></td>
                                                <td class="text-nowrap">{{$agn->name}}</td>
                                                <td class="text-nowrap">{{$agn->address?? ""}}</td>
                                                <td class="text-nowrap">{{$agn->contact?? ""}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white p-4 shadow rounded-lg">
                            <div class="flex justify-between mb-3">
                                <p class="text-2xl font-bold"><i class="bi bi-building"></i> Branch</p>
                                <button class="btn btn-success" onclick="addBrn()"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div class="overflow-auto">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Action</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Agency</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @foreach ($brns as $brn)
                                            <tr>
                                                <td><button class="btn btn-sm btn-danger" id="delBtn" deltype="brn" value="{{ $brn->id }}"><i class="bi bi-trash"></i></button></td>
                                                <td class="text-nowrap">{{$brn->name}}</td>
                                                <td class="text-nowrap">{{ optional($brn->agencyName)->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg mb-5 shadow">
                    <div class="flex justify-between mb-3">
                        <p class="text-2xl font-bold"><i class="bi bi-house-door"></i> Department</p>
                        <button class="btn btn-success" onclick="addDpm()"><i class="bi bi-plus-lg"></i></button>
                    </div>
                    <div class="overflow-auto">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Action</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Personnel</th>
                                    <th scope="col">Agency</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">OwnCourse</th>
                                </tr>
                            </thead>
                            <tbody >
                                @foreach ($dpms as $dpm)
                                    <tr>
                                        <td><button class="btn btn-sm btn-danger" id="delBtn" deltype="dpm" value="{{ $dpm->id }}"><i class="bi bi-trash"></i></button></td>
                                        <td>{{$dpm->name}}</td>
                                        <td>0</td>
                                        <td>{{optional($dpm->brnName->agencyName)->name}}</td>
                                        <td>{{optional($dpm->brnName)->name}}</td>
                                        <td>0</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="w-4/5 h-0.5 mx-auto border-0 rounded bg-gray-700">

    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">Course Data</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row justify-center gap-4">
                <div class="bg-white p-4 rounded col shadow">
                    <div class="flex justify-between mb-3">
                        <p class="text-2xl font-bold"><i class="bi bi-backpack"></i> Course</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">lecturer</th>
                                    <th scope="col">Dpm</th>
                                    <th scope="col">student</th>
                                </tr>
                            </thead>
                            <tbody >

                                <tr>
                                    <td>1</td>
                                    <td>Meanie</td>
                                    <td>New</td>
                                    <td>IT</td>
                                    <td>12</td>
                                    <td>0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 col">
                    <div class="flex justify-between items-start w-full">
                        <div class="flex-col items-center">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white mr-1"><i class="bi bi-briefcase"></i> All Course</h5>
                        </div>
                    </div>
                    <!-- Line Chart -->
                    <div class="py-6" id="pie-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <hr class="w-4/5 h-0.5 mx-auto border-0 rounded bg-gray-700">

    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">Roles & Permissions</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row justify-center">
                <div class="p-4 rounded-lg row">
                    <div class="col-6 ">
                        <div class="bg-white p-4 shadow rounded-lg">
                            <div class="flex justify-between mb-3">
                                <p class="text-2xl font-bold"><i class="bi bi-person-square"></i> Roles</p>
                                <button class="btn btn-success" onclick="addRole()" ><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div class="overflow-auto">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Action</th>
                                            <th scope="col">Name</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td><button class="btn btn-sm btn-danger" id="delBtn" deltype="role" value="{{ $role->name }}"><i class="bi bi-trash"></i></button></td>
                                                <td class="text-nowrap">{{$role->name}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white p-4 shadow rounded-lg">
                            <div class="flex justify-between mb-3">
                                <p class="text-2xl font-bold"><i class="bi bi-person-fill-gear"></i> Permissions</p>
                                <button class="btn btn-success" onclick="addPerm()"><i class="bi bi-plus-lg"></i></button>
                            </div>
                            <div class="overflow-auto">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Action</th>
                                            <th scope="col">Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td><button class="btn btn-sm btn-danger" id="delBtn" deltype="perm" value="{{ $permission->name }}"><i class="bi bi-trash"></i></button></td>
                                                <td class="text-nowrap">{{$permission->name}}</td>
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
    </div>
</x-app-layout>


<script>
    // ApexCharts options and config
    window.addEventListener("load", function() {
      const getChartOptions = () => {
          return {
            series: [10, 5, 5],
            colors: ["#1C64F2", "#16BDCA", "#9061F9"],
            chart: {
              height: 420,
              width: "100%",
              type: "pie",
            },
            stroke: {
              colors: ["white"],
              lineCap: "",
            },
            plotOptions: {
              pie: {
                labels: {
                  show: true,
                },
                size: "100%",
                dataLabels: {
                  offset: -25
                }
              },
            },
            labels: ["IT", "AD", "SALE"],
            dataLabels: {
              enabled: true,
              style: {
                fontFamily: "Inter, sans-serif",
              },
            },
            legend: {
              position: "bottom",
              fontFamily: "Inter, sans-serif",
            },
            yaxis: {
              labels: {
                formatter: function (value) {
                  return value
                },
              },
            },
            xaxis: {
              labels: {
                formatter: function (value) {
                  return value
                },
              },
              axisTicks: {
                show: false,
              },
              axisBorder: {
                show: false,
              },
            },
          }
        }

        if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
          const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
          chart.render();
        }
    });


    addAgn = () => {
        Swal.fire({
            title: 'Add Agency',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="addr" class="form-label">Address</label>
                    <input type="text" class="form-control" id="addr">
                </div>
                <div class="mb-3">
                    <label for="cont" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="cont">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            preConfirm: () => {
                const agnname = document.getElementById('name').value;
                const addr = document.getElementById('addr').value;
                const cont = document.getElementById('cont').value;

                if (!agnname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addAgency', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: agnname, address:addr, contact:cont })
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
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your department was saved successfully.',
                    'success'
                )
            }
        });
    }

    addBrn = () => {
        Swal.fire({
            title: 'Add Branch',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>

                <label for="agn" class="form-label">Agency</label>
                <select class="form-select" aria-label="Default select example" id="agn">
                    @foreach ($agns as $agn)
                        <option value="{{$agn->id}}">{{$agn->name}}</option>
                    @endforeach
                </select>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            preConfirm: () => {
                const brnname = document.getElementById('name').value;
                const agn = document.getElementById('agn').value;

                if (!brnname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addBranch', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: brnname, agency:agn })
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
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your department was saved successfully.',
                    'success'
                )
            }
        });
    }

    addRole = () => {
        Swal.fire({
            title: 'Add Role',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            preConfirm: () => {
                const rname = document.getElementById('name').value;

                if (!rname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addRole', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: rname })
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
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your department was saved successfully.',
                    'success'
                )
            }
        });
    }

    addPerm = () => {
        Swal.fire({
            title: 'Add Permission',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            preConfirm: () => {
                const pname = document.getElementById('name').value;

                if (!pname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addPerm', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: pname })
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
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(result.value);
                Swal.fire(
                    'Saved!',
                    'Your department was saved successfully.',
                    'success'
                )
            }
        });
    }

    addDpm = () => {
        Swal.fire({
            title: 'Add Department',
            html: `
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>

                <label for="brn" class="form-label">Branch</label>
                <select class="form-select" aria-label="Default select example" id="brn">
                    @foreach ($brns as $brn)
                        <option value="{{$brn->id}}">{{$brn->name}}</option>
                    @endforeach
                </select>
            `,
            showCancelButton: true,
            confirmButtonText: 'Save',
            showLoaderOnConfirm: true,
            preConfirm: (name) => {
                const dpmname = document.getElementById('name').value;
                const brn = document.getElementById('brn').value;

                if (!dpmname) {
                    Swal.showValidationMessage("Name is required");
                    return;
                }

                return fetch('/manage/addDpm', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: dpmname, branch:brn })
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
                    'Saved!',
                    'Your department was saved successfully.',
                    'success'
                )
            }
        })

    }


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
                    const delType = delbtn.getAttribute('deltype');

                    return fetch('/manage/delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ delid: delId, type:delType })
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
