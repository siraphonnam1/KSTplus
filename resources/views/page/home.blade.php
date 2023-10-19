<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 d-flex flex-wrap gap-4 justify-content-center">
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
        </div>
    </div>
</x-app-layout>
