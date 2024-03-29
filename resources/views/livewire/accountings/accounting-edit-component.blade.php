<div>
    @section('title', 'Contabilidade')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar contabilidade') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center p-12">
        <div class="mx-auto w-full max-w-[550px]">
            <form>
            @csrf

            {{ $this->form }}

            </form>
        </div>
    </div>
</div>
