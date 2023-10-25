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
                <div class="col-8">
                    {{-- course card --}}
                    <a href="{{route('course.detail')}}">
                        <div class="shadow-sm card mb-3 course-card">
                            <div class="row g-0">
                                <div class="col-md-4 d-flex align-items-center">
                                    <img src="/img/logo.png" class="img-fluid rounded-start w-100 h-100 object-fit-contain" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold mb-0 fs-4">Course1</h5>
                                        <p class="card-text fw-bold mb-2">By IT</p>
                                        <p class="card-text text-secondary" style="text-indent: 1em">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{route('course.detail')}}">
                        <div class="shadow-sm card mb-3 course-card">
                            <div class="row g-0">
                                <div class="col-md-4 d-flex align-items-center">
                                    <img src="/img/logo.png" class="img-fluid rounded-start w-100 h-100 object-fit-contain" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold mb-0 fs-4">Course2</h5>
                                        <p class="card-text fw-bold mb-2">By IT</p>
                                        <p class="card-text text-secondary" style="text-indent: 1em">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{route('course.detail')}}">
                        <div class="shadow-sm card mb-3 course-card">
                            <div class="row g-0">
                                <div class="col-md-4 d-flex align-items-center">
                                    <img src="/img/logo.png" class="img-fluid rounded-start w-100 h-100 object-fit-contain" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold mb-0 fs-4">Course3</h5>
                                        <p class="card-text fw-bold mb-2">By IT</p>
                                        <p class="card-text text-secondary" style="text-indent: 1em">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{route('course.detail')}}">
                        <div class="shadow-sm card mb-3 course-card">
                            <div class="row g-0">
                                <div class="col-md-4 d-flex align-items-center">
                                    <img src="/img/logo.png" class="img-fluid rounded-start w-100 h-100 object-fit-contain" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold mb-0 fs-4">Course4</h5>
                                        <p class="card-text fw-bold mb-2">By IT</p>
                                        <p class="card-text text-secondary" style="text-indent: 1em">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-4 px-4">
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

<style>
    .course-card {
        border: unset;
    }
    .course-card:hover{
        outline: 4px solid pink;
        cursor: pointer;
    }
</style>
