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
                                <div class="bg-white p-2 rounded shadow-sm min-w-full">
                                    <div class="flex justify-between mb-3">
                                        <p class="text-2xl font-bold"><i class="bi bi-backpack"></i> Course</p>
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
                    <p class="text-sm text-gray-500 ">This is some placeholder content the <strong class="font-medium text-gray-800 ">Settings tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>

                {{-- history content --}}
                <div class="hidden p-4 rounded-lg bg-gray-50 " id="history" role="tabpanel" aria-labelledby="history-tab">
                    <p class="text-sm text-gray-500 ">This is some placeholder content the <strong class="font-medium text-gray-800 ">Contacts tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
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
        }
    });

    $(document).ready(function() {
        $('#allcourse-datatable').DataTable({
            paging: true,       // Enables pagination
            searching: true,    // Enables the search box
            ordering: true,     // Enables column ordering
            info: true,         // 'Showing x to y of z entries' string
            lengthChange: true, // Allows the user to change number of rows shown
            pageLength: 5,      // Set number of rows per page
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
        });
    });
</script>

<style>

</style>
