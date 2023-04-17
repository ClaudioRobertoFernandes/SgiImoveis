<?php

namespace App\Http\Livewire\Register;

use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class RegisterUnitComponent extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $name;
    public $description;
    public $owner_id;
    public $zip_code;
    public $street;
    public $number;
    public $complement;
    public $neighborhood;
    public $city;
    public $state;
    public $active;
    public $empty;

    public function render(): View|Application|Factory
    {
        return view('livewire.register.register-unit-component');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Wizard::make(
                [
                    Step::make('Unidade')
                        ->schema(
                            [
                                TextInput::make('name')
                                    ->label('Unidade')
                                    ->columnSpanFull(),

                                TextInput::make('description')
                                    ->label('Descrição')
                                    ->columnSpanFull(),

                                Select::make('owner_id')
                                    ->label('Proprietário')
                                    ->options([
                                        Auth::User()->id => Auth::User()->name,
                                    ])
                                    ->default(Auth::User()->id)
                                    ->disablePlaceholderSelection()
                                    ->disabled()
                                    ->columnSpanFull(),
                            ]
                        ),
                    Step::make('Localização')
                        ->schema(
                            [
                                TextInput::make('zip_code')
                                    ->label('CEP')
                                    ->required()
                                    ->mask(fn(Mask $mask) => $mask->pattern('00000-000'))
                                    ->minLength(8)
                                    ->suffixAction(function ($state, $livewire, $set) {
                                        return Action::make('search-action')
                                            ->icon('heroicon-o-search')
                                            ->action(static function () use ($livewire, $state, $set) {
                                                $livewire->validateOnly('zipCode');
                                                $request = Http::get("https://viacep.com.br/ws/{$state}/json/")->json();
                                                if (!isset($request['erro'])) {
                                                    $set('street', $request['logradouro']);
                                                    $set('neighborhood', $request['bairro']);
                                                    $set('city', $request['localidade']);
                                                    $set('state', $request['uf']);
                                                } else {
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
                                    ->validationAttribute('CEP'),

                                TextInput::make('state')
                                    ->label('Estado'),

                                TextInput::make('city')
                                    ->label('Cidade'),

                                TextInput::make('neighborhood')
                                    ->label('Bairro'),

                                TextInput::make('street')
                                    ->label('Logradouro'),

                                TextInput::make('number')
                                    ->label('Número')
                                    ->numeric(),

                                TextInput::make('complement')
                                    ->label('Complemento'),

                                Toggle::make('active')
                                    ->label('Ativo')
                                    ->default(true),

                                Toggle::make('empty')
                                    ->label('Vazio')
                                    ->default(true),
                            ]
                        )
                ])
                ->extraAttributes(['class'=>'dark:text-white'])
        ];
    }

    public function submit()
    {

        $this->data = $this->form->getState();
    }
}
