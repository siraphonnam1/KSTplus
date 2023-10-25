<x-app-layout>
    <header class="position-relative">
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
        <div class="position-absolute top-100 start-50 translate-middle badge bg-light shadow " style="width: 700px">
            <div class="d-flex flex-wrap gap-4 justify-content-center p-4" style="color:black">
                <div class="d-flex flex-column justify-content-center align-items-center gap-1 dpm-hover p-2 rounded">
                    <img src="/img/icondpm/admin.png" class="dpmicon" width="60" alt="">
                    <p class="fw-bold fs-6">Administrative</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center gap-1 dpm-hover p-2 rounded">
                    <img src="/img/icondpm/audit.png" class="dpmicon" width="60" alt="">
                    <p class="fw-bold fs-6">Audit</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center gap-1 dpm-hover p-2 rounded">
                    <img src="/img/icondpm/finance.png" class="dpmicon" width="60" alt="">
                    <p class="fw-bold fs-6">Finance</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center gap-1 dpm-hover p-2 rounded">
                    <img src="/img/icondpm/hr.png" class="dpmicon" width="60" alt="">
                    <p class="fw-bold fs-6">HR</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center gap-1 dpm-hover p-2 rounded">
                    <img src="/img/icondpm/it.png" class="dpmicon" width="60" alt="">
                    <p class="fw-bold fs-6">ITI</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center gap-1 dpm-hover p-2 rounded">
                    <img src="/img/icondpm/law.png" class="dpmicon" width="60" alt="">
                    <p class="fw-bold fs-6">Law</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center gap-1 dpm-hover p-2 rounded">
                    <img src="/img/icondpm/management.png" class="dpmicon" width="60" alt="">
                    <p class="fw-bold fs-6">Management</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center gap-1 dpm-hover p-2 rounded">
                    <img src="/img/icondpm/marketing.png" class="dpmicon" width="60" alt="">
                    <p class="fw-bold fs-6">Marketing</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center gap-1 dpm-hover p-2 rounded">
                    <img src="/img/icondpm/purchase.png" class="dpmicon" width="60" alt="">
                    <p class="fw-bold fs-6">Purchase</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center gap-1 dpm-hover p-2 rounded">
                    <img src="/img/icondpm/sale.png" class="dpmicon" width="60" alt="">
                    <p class="fw-bold fs-6">Sale</p>
                </div>
            </div>
        </div>
    </header>
    <div class="text-center">
        <p class="fs-1 fw-bold">Courses</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 ">
                <div class="d-flex flex-wrap gap-4 justify-content-center mb-4">
                    @for ($i = 0; $i < 2; $i++)
                        <div class="card" style="width: 18rem;">
                            <div class="card-header" >
                                <img class="bg-light rounded" src="/img/logo.png" alt="" width="80">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Card title</h5>
                                <p class="card-text fs-6 mb-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="{{route('course.detail')}}" class="btn btn-primary">Detail <i class="bi bi-chevron-double-right"></i></a>
                            </div>
                        </div>
                    @endfor
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
    .search-container {
        width: 400px;
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
</style>
