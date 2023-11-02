<div x-data="{ open: false }" {{ $attributes->merge(['class' => 'mb-4']) }}>
    <button @click="open = !open" {{ $attributes->merge(['class' => 'block shadow-sm rounded-2xl bg-white w-full p-3 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out']) }}>
        {{ $title }}
    </button>

    <div x-show="open" class="accordion-content" {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out']) }}>
        {{ $slot }}
    </div>
</div>
