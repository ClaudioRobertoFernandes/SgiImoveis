<div>
    @section('title', 'Contabilidade')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contabilidade') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center p-12">
        <!-- Author: FormBold Team -->
        <!-- Learn More: https://formbold.com -->
        <div class="mx-auto w-full">

            {{ $this->table }}

        </div>
    </div>

</div>
