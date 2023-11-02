<x-app-layout>
    <div class="text-center mt-5">
        <p class="fs-1 fw-bold">Request All</p>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg p-4 row">
                <div x-data="{ open: false }" class='mb-3 hover:-translate-y-1 duration-300'>
                    <button @click="open = !open" class = 'shadow-sm rounded-2xl bg-white w-full p-2 text-left text-gray-700'>
                        <div class="flex justify-around">
                            <p>Account creation request:</p>
                            <p>Adison Wonglakhon </p>
                            <p>{{ date('Y-m-d') }} <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">Waiting...</span></p>
                        </div>
                    </button>
                    <div x-show="open" class="accordion-content" class='w-full px-4 py-2 text-left text-gray-700'>
                        <div class="flex justify-center w-full">
                            <div class="bg-white w-4/5 p-2">
                                <div class="grid grid-cols-3 text-sm mb-2 bg-gray-100 rounded-lg p-2">
                                    <p>Username:</p>
                                    <p>Password:</p>
                                    <p>Name:</p>
                                    <p>Agency:</p>
                                    <p>Branch:</p>
                                    <p>Dpm:</p>
                                    <p>Status:</p>
                                </div>
                                <div>
                                    <p>Courses:</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-data="{ open: false }" class='mb-4 hover:-translate-y-1 duration-300'>
                    <button @click="open = !open" class = 'shadow-sm rounded-2xl bg-white w-full p-2 text-left text-gray-700'>
                        <div class="flex justify-around">
                            <p>Account creation request:</p>
                            <p>Adison Wonglakhon </p>
                            <p>{{ date('Y-m-d') }} <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Success</span></p>
                        </div>
                    </button>
                    <div x-show="open" class="accordion-content" class='w-full px-4 py-2 text-left text-gray-700'>
                        <div class="flex justify-center w-full">
                            <div class="bg-white w-4/5 p-2">
                                <div class="grid grid-cols-3 text-sm mb-2 bg-gray-100 rounded-lg p-2">
                                    <p>Username:</p>
                                    <p>Password:</p>
                                    <p>Name:</p>
                                    <p>Agency:</p>
                                    <p>Branch:</p>
                                    <p>Dpm:</p>
                                    <p>Status:</p>
                                </div>
                                <div>
                                    <p>Courses:</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script type="text/javascript">

</script>

<style>

</style>
