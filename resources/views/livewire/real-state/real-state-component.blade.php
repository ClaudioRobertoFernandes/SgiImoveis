<div>
    @section('title', 'Imobiliarias')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cadastrar imobiliarias') }}
        </h2>
    </x-slot>
    <!-- component -->
    <!-- component -->
    <div class="flex items-center justify-center p-12">
        <!-- Author: FormBold Team -->
        <!-- Learn More: https://formbold.com -->
        <div class="mx-auto w-full max-w-[550px]">
            <form wire:submit.prevent="submit">
                @csrf

                {{ $this->form }}

            </form>
        </div>
    </div>
</div>
