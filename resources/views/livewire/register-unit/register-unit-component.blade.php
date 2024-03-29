<div>
    @section('title', 'Unidades')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cadastrar unidades') }}
        </h2>
    </x-slot>
    <!-- component -->
    <div class="flex items-center justify-center p-12">
        <!-- Author: FormBold Team -->
        <!-- Learn More: https://formbold.com -->
        <div class="mx-auto w-full max-w-[550px]">
            <form>
                @csrf

                {{ $this->form }}

            </form>
        </div>
    </div>
</div>
