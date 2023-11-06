<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">My Classroom</p>
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
                            </div>
                        @endforeach
                    @else
                        <div class="flex justify-center fw-bold"><span class="bg-yellow-100 text-yellow-800 text-xl font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Course not found</span></div>
                    @endif
                </div>
                <div class="col-md-4 col-lg-4 px-4 col-sm-12">
                    <div class="card p-4 border-0 shadow-sm">
                        <form action="{{ route('courses.searchmy') }}" method="GET">
                             @csrf
                            <div class="p-2 text-center fw-bold fs-4"><p>Filters <i class="bi bi-filter-left"></i></p></div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded" id="floatingInput" name="search" value="{{$search ?? ''}}" placeholder="name@example.com">
                                <label for="floatingInput"><i class="bi bi-search"></i> Search</label>
                            </div>

                            <p class="mb-2">Dpartment:</p>
                            <div class="d-flex flex-wrap ps-2">

                                @foreach ($dpms as $dpm)
                                    <div class="w-50">
                                        <div class="form-check">
                                            <input class="form-check-input" name="departments[]" type="checkbox" value="{{ $dpm->id }}" id="flexCheckDefault"
                                                @if (in_array($dpm->id, $departmentIds ?? []))
                                                    checked
                                                @endif
                                            >
                                            <label class="form-check-label" for="flexCheckDefault" >
                                                {{ $dpm->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <button class="btn btn-info w-100 mt-2" type="submit"><i class="bi bi-search"></i> Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>

</script>
<style>
    .course-card {
        border: unset;
    }
    .course-card:hover{
        outline: 4px solid pink;
        cursor: pointer;
    }
</style>
