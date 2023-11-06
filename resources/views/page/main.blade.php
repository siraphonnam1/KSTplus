<x-app-layout>
    <header class="position-relative">
        <div class="container h-100 pt-5">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h2 class="text-xl text-light fw-bold mb-3">
                    {{ __('Search Course') }}
                </h2>
                <div class="search-container">
                    <form action="" method="post">
                        @csrf
                        <div class="input-group input-group-sm mb-3 ">
                            <input type="text" class="form-control search-input" placeholder="Search" aria-label="Recipient's username" >
                            <button class="btn btn-info bg-info search-btn" type="button">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="position-absolute top-100 start-50 translate-middle badge bg-light shadow dpmList">
            <div class="d-flex flex-wrap gap-4 justify-content-center p-4" style="color:black">
                @foreach ($dpms as $dpm)
                    <form id="department-form-{{ $dpm->id }}" action="{{ route('courses.search') }}" method="GET">
                        @csrf
                        <input type="hidden" name="departments[]" value="{{ $dpm->id }}">
                        <a href="javascript:void(0);" onclick="document.getElementById('department-form-{{ $dpm->id }}').submit();">
                            <div class="d-flex flex-column justify-content-center align-items-center gap-1 dpm-hover p-2 rounded">
                                <img src="/img/icondpm/dpm2.png" class="dpmicon" width="60" alt="">
                                <p class="fw-bold fs-6">{{ $dpm->name }}</p>
                            </div>
                        </a>
                    </form>
                @endforeach
            </div>
        </div>
    </header>
    <div class="text-center">
        <p class="fs-1 fw-bold">Lastest Courses</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="d-flex flex-wrap gap-5 justify-content-center mb-4">
                    @foreach ($courses as $course)
                        <div class="card shadow-xl shadow-orange-500/50 border-0" style="width: 18rem;">
                            <div class="card-header" style="background-color: var(--primary-color)">
                                <img class="bg-light py-1 rounded" src="/img/logo.png" alt="" width="80">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ Str::limit($course->title, 60) }}</h5>
                                <p class="card-title fw-bold" style="color: var(--primary-color)">By: {{ optional($course->getDpm)->name }}</p>
                                <p class="card-text text-gray-500 fs-6 mb-2">{{ Str::limit($course->description, 75) }}</p>
                            </div>
                            <div class="card-footer d-flex justify-content-end" style="background-color: var(--primary-color)">
                                <a href="{{ route('course.detail', ['id' => $course->id]) }}" class="btn btn-primary">See more <i class="bi bi-chevron-double-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{route('course.all')}}" class="btn btn-success">See more <i class="bi bi-chevron-double-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    header {
        background-color: var(--primary-color);
        height: 350px;
        margin-bottom: 250px;

    }
    .search-input {
        border: unset;
        border-radius: 100px 0px 0px 100px !important;
    }
    .search-btn {
        border-radius: 0px 100px 100px 0px !important;
    }

    .dpmicon {
        color: var(--primary-color);
    }
    .dpm-hover {
        transition: all .4s;
    }
    .dpm-hover:hover{
        box-shadow: 0px 0px 5px .4px rgba(126, 126, 126, 0.5);
        transform: scale(1.1);
        cursor: pointer;
    }
    .search-container {
        width: 400px;
    }
    @media screen and (max-width: 500px) {
        .search-container {
            width: 200px;
        }
    }


</style>
