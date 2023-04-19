<?php

namespace App\Http\Livewire\Register;

use Filament\Forms;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use App\Models\userTypes\User_types;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Select;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput\Mask;
use Illuminate\Validation\ValidationException;
use Str;

class RegisterComponent extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $data = null;
    public $name;
    public $email;
    public $permissions;
    public $document;
    public $phone;
    public $password;
    public $password_confirmation;
    public $zipCode;
    public $street;
    public $number;
    public $complement;
    public $neighborhood;
    public $city;
    public $state;


    public function render(): View|Application|Factory
    {
        return view('livewire.register.register-component');
    }

    // mount
    public function mount(): void
    {
        //
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make(
                [
                    Step::make('Dados pessoais')
                        ->schema(
                            [
                                TextInput::make('name')
                                    ->label('Nome completo')
                                    ->required()
                                    ->rule('min:3')
                                    ->columnSpanFull()
                                    ->validationAttribute('Nome completo')
                                ->columnSpanFull(),

                                TextInput::make('email')
                                    ->label('E-mail')
                                    ->email()
                                    ->unique('users', 'email')
                                    ->required()
                                    ->validationAttribute('e-mail'),

                                TextInput::make('document')
                                    ->label('CPF/CNPJ')
                                    ->unique('users', 'document')
                                    ->required()
                                    ->validationAttribute('CPF/CNPJ'),

                                TextInput::make('phone')
                                    ->label('Telefone')
                                    ->required()
                                    ->validationAttribute('Telefone'),

                                Select::make('permissions')
                                    ->label('Tipo de usuário')
                                    ->placeholder('Selecione o tipo de usuário')
                                    ->options(
                                        User_types::getPermitionType()
                                    )
                                    ->required()
                                    ->validationAttribute('Tipo de usuário'),
                            ]
                        )
                    ->columns(2),

                    Step::make('Endereço')
                        ->schema(
                            [
                                TextInput::make('zipCode')
                                    ->label('CEP')
                                    ->required()
                                    ->mask(fn(Mask $mask) => $mask->pattern('00000-000'))
                                    ->minLength(8)
                                    ->suffixAction(function ($state, $livewire, $set){
                                        return Action::make('search-action')
                                            ->icon('heroicon-o-search')
                                            ->action(static function () use ($livewire, $state, $set){
                                                $livewire->validateOnly('zipCode');
                                                $request = Http::get("https://viacep.com.br/ws/{$state}/json/")->json();
                                                if (!isset($request['erro'])) {
                                                    $set('street', $request['logradouro']);
                                                    $set('neighborhood', $request['bairro']);
                                                    $set('city', $request['localidade']);
                                                    $set('state', $request['uf']);
                                                }else{
                                                    $set('street', null);
                                                    $set('neighborhood', null);
                                                    $set('city', null);
                                                    $set('state', null);

                                                    throw ValidationException::withMessages([
                                                        'zipCode' => 'CEP inválido',
                                                    ]);
                                                }
                                            });
                                    })
                                    ->columnSpan(2)
                                    ->validationAttribute('CEP'),

                                TextInput::make('city')
                                    ->label('Cidade')
                                    ->required()
                                    ->columnSpan(4)
                                    ->validationAttribute('Cidade'),

                                TextInput::make('neighborhood')
                                    ->label('Bairro')
                                    ->required()
                                    ->columnSpan(4)
                                    ->validationAttribute('Bairro'),

                                TextInput::make('state')
                                    ->label('Estado')
                                    ->required()
                                    ->columnSpan(2)
                                    ->validationAttribute('Estado'),

                                TextInput::make('street')
                                    ->label('Logradouro')
                                    ->required()
                                    ->columnSpan(4)
                                    ->validationAttribute('Rua'),

                                TextInput::make('number')
                                    ->label('Número')
                                    ->numeric()
                                    ->columnSpan(2)
                                    ->validationAttribute('Número'),

                                TextInput::make('complement')
                                    ->label('Complemento')
                                    ->columnSpan(2)
                                    ->validationAttribute('Complemento'),
                            ]
                        ),
                ]
            )->columns(6)
            ->submitAction(new HtmlString(view('livewire.register.register-component-submit')))
            ->extraAttributes(['class'=>'dark:text-white'])
        ];
    }

    public function submit()
    {

        $this->data = $this->form->getState();

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->user_type_id = $this->permissions;
        $user->document = $this->document;
        $user->phone = $this->phone;
        $user->password = bcrypt('password');// password
        $user->zipCode = $this->zipCode;
        $user->street = $this->street;
        $user->number = ($this->number) ?? 'S/N';
        $user->complement = ($this->complement) ?? 'S/C';
        $user->neighborhood = $this->neighborhood;
        $user->city = $this->city;
        $user->state = $this->state;

        if ($user->save()) {

            Notification::make()
                ->title('Salvo com sucesso')
                ->success()
                ->send();
        }

        return redirect()->route('register-participants');
    }
}
