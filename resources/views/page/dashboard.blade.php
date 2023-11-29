<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="text-center mt-5 px-2">
            <p class="fs-1 fw-bold">Dashboard</p>
            @php
                $seriesList = [];
                $dpmList= [];
                foreach ($dpms as $key => $dpm) {
                    $seriesList[] = App\Models\course::where('dpm', $dpm->id)->count();
                    $dpmList[] = $dpm->name;
                };

                $totaltest = count($tests ?? []);
                $passtest = 0;
                foreach ($tests as $key => $test) {
                    $passScore = ($test->totalScore) * (optional($test->getQuiz)->pass_score) / 100;
                    if ($test->score >= $passScore) {
                        $passtest++;
                    }
                }
                $testData = [$passtest, $totaltest - $passtest]

            @endphp

            {{-- Tabs Bar --}}
            <div class="border-b border-gray-200 mb-4">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2">
                        <a href="#" id="course-tab" data-tabs-target="#course" type="button" role="tab" aria-controls="course" aria-selected="false" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300  group">
                            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                <path d="M16 14V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 0 0 0-2h-1v-2a2 2 0 0 0 2-2ZM4 2h2v12H4V2Zm8 16H3a1 1 0 0 1 0-2h9v2Z"/>
                            </svg>
                            Course
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="#" id="test-tab" data-tabs-target="#test" type="button" role="tab" aria-controls="test" aria-selected="false" class="inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active group" aria-current="page">
                            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM5 12a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-3a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm0-3a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm10 6H9a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2Zm0-3H9a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Zm0-3H9a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z"/>
                            </svg>
                            Test
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="#" id="log-tab" data-tabs-target="#log" type="button" role="tab" aria-controls="log" aria-selected="false" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300  group">
                            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 15">
                                <path d="M1 13a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H1v7Zm5.293-3.707a1 1 0 0 1 1.414 0L8 9.586V8a1 1 0 0 1 2 0v1.586l.293-.293a1 1 0 0 1 1.414 1.414l-2 2a1 1 0 0 1-1.416 0l-2-2a1 1 0 0 1 .002-1.414ZM17 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1Z"/>
                            </svg>
                            Log
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="#" id="history-tab" data-tabs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="false" class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300  group">
                            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                            </svg>
                            History
                        </a>
                    </li>
                </ul>
            </div>
            {{-- End Tabs Bar --}}

            {{-- Tabs Contents --}}
            <div id="default-tab-content">

                {{-- course Content --}}
                <div class="hidden p-2 rounded-lg bg-gray-50" id="course" role="tabpanel" aria-labelledby="course-tab">
                    <div class="py-2">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="sm:rounded-lg p-2">
                                <div class="mb-4">
                                    <div class="flex justify-between mb-3">
                                        <p class="text-2xl font-bold"><i class="bi bi-journal-bookmark"></i> All Course</p>
                                    </div>
                                    <canvas id="myChart"></canvas>
                                </div>
                                <div class="bg-white p-4 rounded shadow-sm min-w-full">
                                    <div class="flex flex-wrap justify-between mb-3">
                                        <p class="text-2xl font-bold"><i class="bi bi-backpack"></i> Course</p>
                                        <a href="{{ route('export.pdf', ['type' => 'course']) }}" target="_BLANK">
                                            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">PDF</button>
                                        </a>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="table table-hover w-80 sm:w-full table-fixed" id="allcourse-datatable">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">Code</th>
                                                    <th scope="col" >Name</th>
                                                    <th scope="col">Lecturer</th>
                                                    <th scope="col">Dpm</th>
                                                    <th scope="col">student</th>
                                                </tr>
                                            </thead>
                                            <tbody class="scrollable-tbody">
                                                @foreach ($courses as $course)
                                                    <tr>
                                                        <td>{{ $course->code }}</td>
                                                        <td class="text-wrap" data-toggle="tooltip" data-placement="top" title="{{ $course->title }}">{{ Str::limit($course->title, 20) }}</td>
                                                        <td>{{ $course->getTeacher->name }}</td>
                                                        <td>{{ $course->getDpm->name }}</td>
                                                        <td>{{ count($course->studens ?? []) }}</td>
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

                {{-- test content --}}
                <div class="hidden p-4 rounded-lg bg-gray-50" id="test" role="tabpanel" aria-labelledby="test-tab">
                    <div class="py-2">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="sm:rounded-lg p-2">
                                <div class="mb-4">
                                    <div class="flex justify-between mb-3">
                                        <p class="text-2xl font-bold"><i class="bi bi-file-earmark-check"></i> Test Summary</p>
                                    </div>
                                    <div  class="flex justify-center items-center flex-wrap">
                                        <div class=" md:h-80 w-1/2">
                                            <canvas id="testChart"></canvas>
                                        </div>
                                        <div>
                                            <p class="text-xl">Average</p>
                                            <p class="text-5xl sm:text-7xl md:text-9xl">{{ intval($passtest * 100 /  $totaltest) }}%</p>
                                            <p class="text-xl">Pass from</p>
                                            <p class="text-xl">Total : <b>{{$totaltest}}</b> times</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white p-2 rounded shadow-sm min-w-full">
                                    <div class="flex justify-between mb-3">
                                        <p class="text-2xl font-bold"><i class="bi bi-list-check"></i> All Test</p>
                                    </div>
                                    <div class="overflow-x-auto">
                                        <table class="table text-start table-hover w-80 sm:w-full table-fixed" id="test-datatable">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Quiz</th>
                                                    <th scope="col">User</th>
                                                    <th scope="col">Score</th>
                                                    <th scope="col">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody class="scrollable-tbody">
                                                @foreach ($tests as $index => $test)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td class="text-wrap" data-toggle="tooltip" data-placement="top" title="{{ optional($test->getQuiz)->title }}">{{ Str::limit(optional($test->getQuiz)->title, 10) }}</td>
                                                        <td>{{ optional($test->getTester)->name }}</td>
                                                        <td>{{ $test->score }} / {{ $test->totalScore }}</td>
                                                        <td>{{ Carbon\Carbon::parse($test->start)->format('d-m-Y') }}</td>
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

                {{-- log content --}}
                <div class="hidden p-4 rounded-lg bg-gray-50 " id="log" role="tabpanel" aria-labelledby="log-tab">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="log-table">
                            <thead class="text-xs text-white uppercase bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Module
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Note
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activitys as $index => $log)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{$index + 1}}
                                        </th>
                                        <td class="px-6 py-2">
                                            {{ optional($log->getUser)->name }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $log->module }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $log->note }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $log->content }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- history content --}}
                <div class="hidden p-4 rounded-lg " id="history" role="tabpanel" aria-labelledby="history-tab">
                    {{-- Course Deleted --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-20 bg-gray-50">
                        <p class="font-bold text-2xl my-2">Course Deleted</p>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="courseDel-table">
                            <thead class="text-xs text-white uppercase bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-4 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Title
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        Teacher
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        Dpm
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        Delete_at
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($courseDel as $index => $course)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{$index + 1}}
                                        </th>
                                        <td class="px-6 py-2 text-nowrap" data-toggle="tooltip" data-placement="top" title="{{ $course->title }}">
                                            {{ $course->code }} : {{ Str::limit($course->title, 20) }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ optional($course->getTeacher)->name }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ optional($course->getDpm)->name }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ Carbon\Carbon::parse($course->deleted_at)->format('d-m-Y') }}
                                        </td>
                                        <td class="">
                                            <button type="button" data-res-id="{{$course->id}}" data-res-type="course" class="restoreBtn text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 me-2 my-2 focus:outline-none">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Quiz Deleted --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-gray-50">
                        <p class="font-bold text-2xl my-2">Quiz Deleted</p>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="quizDel-table">
                            <thead class="text-xs text-white uppercase bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-4 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Title
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        Create_By
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        Pass Score
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        Delete_at
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quizDel as $index => $quiz)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                            {{$index + 1}}
                                        </th>
                                        <td class="px-6 py-2 text-nowrap" data-toggle="tooltip" data-placement="top" title="{{ $quiz->title }}">
                                            {{ Str::limit($quiz->title, 20) }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ optional($quiz->getCreated)->name }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ $quiz->pass_score }}
                                        </td>
                                        <td class="px-6 py-2">
                                            {{ Carbon\Carbon::parse($quiz->deleted_at)->format('d-m-Y') }}
                                        </td>
                                        <td class="">
                                            <button type="button" data-res-id="{{$quiz->id}}" data-res-type="quiz" class="restoreBtn text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 me-2 my-2 focus:outline-none">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- End Tabs Contents --}}
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myChart');
    const testch = document.getElementById('testChart');
    const seriesList = @json($seriesList); // Converts the PHP array to a JSON string that JavaScript can read
    const dpmList = @json($dpmList);

    const testData = @json($testData);

    new Chart(testch, {
        type: 'doughnut',
        data: {
            labels: [
                'PASS',
                'FAIL'
            ],
            datasets: [{
                label: 'Amount',
                data: testData,
                backgroundColor: [
                    '#4ade80',
                    'rgb(255, 99, 132)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
            }
        },
    });

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dpmList,
            datasets: [{
                label: 'course amount',
                data: seriesList,
                borderWidth: 1,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
            }
        }
    });

    $(document).ready(function() {
        $('#allcourse-datatable').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 10,      // Set number of rows per page
            dom: 'Blfrtip',
            buttons: [
                'excel',
            ]
        });
    });

    $(document).ready(function() {
        $('#test-datatable').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 5,      // Set number of rows per page
            dom: 'Blfrtip',
            buttons: ['excel', 'pdf']
        });
    });

    $(document).ready(function() {
        $('#log-table').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 10,      // Set number of rows per page
            dom: 'Blfrtip',
            buttons: [
                'excel',
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    orientation: 'landscape', // Landscape orientation to fit wider tables
                    pageSize: 'A4', // You can choose 'A3' if 'A4' is too small
                    title: '',
                    customize: function(doc) {
                        // Modify the default style
                        doc.styles.tableBodyEven.alignment = 'center';
                        doc.styles.tableBodyOdd.alignment = 'center';
                        doc.styles.title.alignment = 'center'; // Centering the title if you have one
                        doc.styles.tableHeader.alignment = 'center'; // Centering the header text

                        // Add a title with a larger font size
                        doc.content.splice(0, 0, {
                            text: 'Knowledge Service Training',
                            fontSize: 16,
                            alignment: 'center',
                            margin: [0, 0, 0, 10] // Adjust the bottom margin to create space for the subtitle
                        });

                        // Add a subtitle directly under the title
                        doc.content.splice(1, 0, {
                            text: 'User activity log',
                            fontSize: 12,
                            alignment: 'center',
                            margin: [0, 0, 0, 20] // Additional space below the subtitle before the table starts
                        });

                        // Ensure that there is a content array and that it contains at least one item
                        if (doc.content && doc.content.length > 0) {
                            // Find the table in the content array
                            var table = doc.content.find(function (item) {
                                return item.table !== undefined;
                            });

                            // If a table is found, set its widths property
                            if (table) {
                                var widths = new Array(table.table.body[0].length).fill('*'); // Fill the array with '*' to distribute space evenly
                                table.table.widths = widths;
                            }
                        }

                        // Optionally set the page margins
                        var cm = 28.35;
                        doc.pageMargins = [1.5 * cm, 1.5 * cm, 1.5 * cm, 1.5 * cm]; // Or any other margin you prefer

                        // Ensure that your table headers repeat on each page if the table is long
                        doc.styles.tableHeader = {
                            fillColor: '#e3e3e3', // Color for the table header
                            color: 'black', // Text color for the table header
                            alignment: 'center' // Center alignment for the header text
                        };
                    }
                }
            ]
        });
    });

    $(document).ready(function() {
        $('#courseDel-table').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 10,      // Set number of rows per page
        });
    });

    $(document).ready(function() {
        $('#quizDel-table').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 10,      // Set number of rows per page
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
        $(document).ready(function() {
            $('.restoreBtn').click(function() {
                // Get the notification ID from the data attribute
                const resId = $(this).data('res-id');
                const resType = $(this).data('res-type');
                Swal.fire({
                    title: `Are you sure?`,
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, restore it!',
                    showLoaderOnConfirm: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/restore/${resType}/${resId}`, // You need to define this route in your web.php
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                // You can add some code here to handle a successful response
                                if (response.success) {
                                    Swal.fire(
                                        'Success!',
                                        `${response.success} has been restore.`,
                                        'success'
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload()
                                        }
                                    });
                                    console.log("success: ",response.success);
                                } else {
                                    Swal.fire(
                                        'Sorry!',
                                        `${response.success} has not restore.`,
                                        'error'
                                    );
                                    console.log("error: ",response.error);
                                };
                                // window.location.reload()
                            },
                            error: function(error) {
                                // You can add some error handling here
                                Swal.fire(
                                    'Sorry!',
                                    'Data has not restore.',
                                    'error'
                                )
                                console.log("error: ",error);
                            }
                        });
                    }
                })

            });
        });
    });
</script>

<style>

</style>
