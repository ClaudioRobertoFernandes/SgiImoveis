<?php

namespace App\Http\Livewire\Register;

use App\Models\userTypes\User_types;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Filament\Forms;

class RegisterComponent extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $data = null;
    public $full_name;
    public $email;
    public $permissions;

    public function render(): View|Application|Factory
    {
        return view('livewire.register.register-component');
    }
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('full_name')
                ->required()
                ->rule('min:5')
                ->columnSpanFull()
                ->validationAttribute('Nome completo'),

            TextInput::make('email')
                ->email()
                ->unique('users', 'email')
                ->required()
                ->validationAttribute('e-mail'),

            Select::make('permissions')
                ->label('Tipo de usuário')
                ->placeholder('Selecione o tipo de usuário')
                ->options(User_types::all()->pluck('name', 'id'))
                ->required()
                ->validationAttribute('Tipo de usuário'),
        ];
    }
    public function submit(): void
    {
//        Notification::make()
//            ->title('Saved successfully')
//            ->success()
//            ->send();

        $this->data = $this->form->getState();
    }
}
