<x-app-layout>
    <header class="position-relative">

    </header>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-10">
                <p class="text-xl ms-4 sm:text-3xl font-bold">{{ __('messages.kst_name') }}</p>
            </div>

            {{-- all course carousel --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-5">
                <div class="mb-3 flex justify-between">
                    <p class="text-md sm:text-xl fw-bold">{{ __('messages.all_course') }}</p>
                    <a href="{{route('course.all')}}" class="btn btn-sm text-xs sm:text-md btn-primary">{{ __('messages.seemore') }} <i class="bi bi-chevron-double-right"></i></a>
                </div>
                <div class="owl-carousel">
                    @foreach ($allcourses as $course)
                    <div class="item">
                        <div class="card w-100" style="height: 200px">
                            <a href="{{ route('course.detail', ['id' => $course->id]) }}" class="hoverbg flex justify-center items-center"><p>{{ __('messages.view_course') }}</p></a>
                            <div class="card-header" style="background-image: url('{{ $course->img ? '/uploads/course_imgs/'.$course->img : '/img/logo.png' }}')">
                                {{-- course Img --}}
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded ">ฝ่าย: {{ optional($course->getDpm)->name }}</span>
                            </div>
                            <div class="card-body text-white" style="border-radius: 0px 0px 5px 5px">
                                <h5 class="card-title fw-bold mb-2">{{ Str::limit($course->title, 30) }}</h5>
                                {{-- <p class="card-title fw-bold mb-0 text-xs" style="color: var(--primary-color)">By: {{ optional($course->getDpm)->name }}</p> --}}
                                <p class="card-text text-gray-200 text-sm">{{ Str::limit($course->description, 35) }}</p>
                            </div>
                            {{-- <div class="card-footer d-flex justify-content-end" style="background-color: var(--primary-color)">
                                <a href="" class="btn btn-primary btn-sm">view course <i class="bi bi-chevron-double-right"></i></a>
                            </div> --}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Dpm course carousel --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="mb-3 flex justify-between">
                    <p class="text-md sm:text-xl fw-bold">{{ __('messages.classroom') }}</p>
                    <a href="{{route('classroom')}}" class="btn btn-sm text-xs sm:text-md btn-primary">{{ __('messages.seemore') }} <i class="bi bi-chevron-double-right"></i></a>
                </div>
                <div class="owl-carousel">
                    @foreach ($dpmcourses as $course)
                    <div class="item">
                        <div class="card w-100" style="height: 200px">
                            <a href="{{ route('course.detail', ['id' => $course->id]) }}" class="hoverbg flex justify-center items-center"><p>{{ __('messages.view_course') }}</p></a>
                            <div class="card-header" style="background-image: url('{{ $course->img ? '/uploads/course_imgs/'.$course->img : '/img/logo.png' }}')">
                                {{-- course Img --}}
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded  ">ฝ่าย: {{ optional($course->getDpm)->name }}</span>
                            </div>
                            <div class="card-body text-white" style="border-radius: 0px 0px 5px 5px">
                                <h5 class="card-title fw-bold mb-2">{{ Str::limit($course->title, 30) }}</h5>
                                {{-- <p class="card-title fw-bold mb-0 text-xs" style="color: var(--primary-color)">By: {{ optional($course->getDpm)->name }}</p> --}}
                                <p class="card-text text-gray-200 text-sm">{{ Str::limit($course->description, 35) }}</p>
                            </div>
                            {{-- <div class="card-footer d-flex justify-content-end" style="background-color: var(--primary-color)">
                                <a href="{{ route('course.detail', ['id' => $course->id]) }}" class="btn btn-primary btn-sm">view course <i class="bi bi-chevron-double-right"></i></a>
                            </div> --}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout:4000,
            autoplaySpeed: 2000,
            autoplayHoverPause: true,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });
    });

    // Array of colors
    const colors = ['#004e92', '#C70039', '#009473', '#5A189A', '#36454F', '#008080', '#4B0082', '#228B22', '#800000', '#4169E1'];

    // Select all card-body elements
    const cards = document.querySelectorAll('.card-body');

    // Assign colors to each card in a loop
    cards.forEach((card, index) => {
        card.style.backgroundColor = colors[index % colors.length];
    });

</script>
<style>
.hoverbg {
    display: none;
    border-radius: 5px;
    transition: 1s;
}
.card:hover >.hoverbg {
    display: flex;
    position: absolute;
    background-color: rgba(0, 0, 0, 0.6);
    color: white;
    font-weight: 800;
    width: 100%;
    height: 100%;
    -webkit-animation-name: fadeIn;
    animation-name: fadeIn;
    -webkit-animation-duration: .5s;
    animation-duration: .5s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}
@-webkit-keyframes fadeIn {
  0% {opacity: 0;}
  100% {opacity: 1;}
}
@keyframes fadeIn {
    0% {opacity: 0;}
    100% {opacity: 1;}
}
.card-header {
    height: 100px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: contain;
}
</style>
