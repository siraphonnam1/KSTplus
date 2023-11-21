<div class="card px-5 py-4">
    <p class="fw-bold text-2xl mb-4">Add Question</p>
    <div class="mb-4 border-b border-gray-200 ">
        <div class="grid grid-cols-8 mb-3">
            <p class="self-center text-lg">Title: </p>
            <input type="text" id="title" class="col-span-5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Question title" required>
        </div>
        <div class="grid grid-cols-8 mb-3">
            <p class="self-center text-lg">Score: </p>
            <input type="number" id="score" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " value="{{1}}">
        </div>
        <div class="grid grid-cols-8 mb-3">
            <p class="self-center text-lg"></p>
            <div class="flex items-center mb-4">
                <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 ">Shuffle choices</label>
            </div>
        </div>
        <hr>
        <div class="mt-4">
            <p class="text-lg">Answers:</p>
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="flex inline-block p-2 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                        <svg class="w-4 h-4 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 1h10M6 5h10M6 9h10M1.49 1h.01m-.01 4h.01m-.01 4h.01"/>
                        </svg>
                        Multiple choice
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="flex inline-block p-2 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 " id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="false">
                        <svg class="w-4 h-4 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 21">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279"/>
                        </svg>
                        Short answer
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div id="default-tab-content">
        <div class="flex hidden p-2 ps-5 rounded-lg bg-gray-50 " id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="grow">
                <ol class="list-decimal" id="choiceList">
                    <li class="mb-2">
                        <div class="flex gap-4">
                            <input type="text" id="choice1" name="choice1" class="block w-50 text-sm text-gray-900 bg-transparent border-t-0 border-s-0 border-e-0 border-b-2 border-gray-400 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Input choice text" />
                            <div class="flex items-center">
                                <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                                <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 ">Answer</label>
                            </div>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="flex gap-4">
                            <input type="text" id="choice2" name="choice2" class="block w-50 text-sm text-gray-900 bg-transparent border-t-0 border-s-0 border-e-0 border-b-2 border-gray-400 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Input choice text" />
                            <div class="flex items-center">
                                <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                                <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 ">Answer</label>
                            </div>
                        </div>
                    </li>
                </ol>
                <input type="hidden" name="choice" id="lastChoice" value="2">
            </div>
            <div class="p-4 flex justify-center">
                <button type="button" id="addAns" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-2 "><i class="bi bi-plus-lg"></i> Add</button>
            </div>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 " id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
            <input type="text" id="choice2" name="writing" class="block w-50 text-sm text-gray-900 bg-transparent border-t-0 border-s-0 border-e-0 border-b-2 border-gray-400 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Input answer" />
        </div>
    </div>
    <div class="mt-20">
        <button type="button" class="transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">
            Save
        </button>
        <button type="button" class="transition ease-in-out hover:-translate-y-1 hover:scale-110 duration-300 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 ">
            Cancel
        </button>
    </div>
</div>
<script>
    $(document).ready(function() {
        var count = $('#choiceList li').length;
        $('#addAns').on('click', function() {
            // Append the new li
            $('#choiceList').append(`
                <li class="mb-2">
                    <div class="flex gap-4">
                        <input type="text" id="choice${count+1}" name="choice${count+1}" class="block w-50 text-sm text-gray-900 bg-transparent border-t-0 border-s-0 border-e-0 border-b-2 border-gray-400 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Input choice text" />
                        <div class="flex items-center">
                            <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500  focus:ring-2 ">
                            <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 ">Answer</label>
                        </div>
                    </div>
                </li>
            `);
            count++;
            // Update the lastChoice value
            updateLastChoice();
        });

        // Function to update the lastChoice value
        function updateLastChoice() {
            $('#lastChoice').val(count);
        }
    });
</script>
