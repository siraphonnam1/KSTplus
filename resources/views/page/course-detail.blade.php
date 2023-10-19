<x-app-layout>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight d-flex justify-content-between">
            <p>{{ __('Course Title') }}</p>
            <div class="badge" style="background-color: var(--primary-color)">Enroll</div>
        </div>
    </x-slot>
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-10">
                <div class="card py-2 px-4 mb-4">
                    <p class="fw-bold fs-5">Description</p>
                    <p class="ps-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dignissimos vel aut sunt non dolores? Voluptatibus pariatur numquam corporis possimus sunt, sed voluptates delectus
                        voluptas aliquid praesentium perspiciatis inventore fugit? Aliquam.</p>
                </div>

                <div class="card py-2 px-4 mb-4">
                    <p class="fw-bold fs-5">Topic 1</p>
                    <p class="ps-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dignissimos vel aut sunt non dolores? Voluptatibus pariatur numquam corporis possimus sunt, sed voluptates delectus
                        voluptas aliquid praesentium perspiciatis inventore fugit? Aliquam.</p>
                </div>
            </div>
            <div class="col-2">
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
