<?php

namespace App\Http\Livewire\RealState;

use App\Models\RealStates\RealStates;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class RealStatesEditComponent extends Component implements Forms\Contracts\HasForms
{

    use Forms\Concerns\InteractsWithForms;

    public $realState;
    public $data;
    public string $name;
    public string $email;
    public string $phone;
    public string $city;
    public string $state;
    public string $zipCode;
    public string $neighborhood;
    public string $street;
    public string $number;
    public string $complement;
    public string $document;
    public int $value_base = 0;
    public int $first_release;
    public int $recurrent_release;
    public int $entrance_fees;
    public int $exit_fees;
    public int $daily_interest;
    public int $monthly_interest;


    public function mount($userId): void
    {
        $this->realState = User::where('users.id', $userId)
            ->leftJoin('real_states', 'users.id', '=', 'real_states.user_id')
            ?->first();

        $this->name = $this->realState->name;
        $this->email = $this->realState->email;
        $this->phone = $this->realState->phone;
        $this->city = $this->realState->city;
        $this->state = $this->realState->state;
        $this->zipCode = $this->realState->zipCode;
        $this->neighborhood = $this->realState->neighborhood;
        $this->street = $this->realState->street;
        $this->number = $this->realState->number;
        $this->complement = $this->realState->complement;
        $this->document = $this->realState->document;
        $this->value_base = $this->realState->value_base;
        $this->first_release = $this->realState->first_release;
        $this->recurrent_release = $this->realState->recurrent_release;
        $this->entrance_fees = $this->realState->entrance_fees;
        $this->exit_fees = $this->realState->exit_fees;
        $this->daily_interest = $this->realState->daily_interest;
        $this->monthly_interest = $this->realState->monthly_interest;
    }

    public function getFormSchema()
    {
        ds($this->value_base)->warning()->s('value base mutators');
        return [
            Wizard::make(
                [
                    Step::make('Dados imobiliarias')
                        ->schema(
                            [
                                TextInput::make('name')
                                    ->default($this->name),
                                TextInput::make('email')
                                    ->default($this->email),
                                TextInput::make('document')
                                    ->default($this->document),
                                TextInput::make('phone')
                                    ->default($this->phone),
                                TextInput::make('city')
                                    ->default($this->city),
                                TextInput::make('state')
                                    ->default($this->state),
                                TextInput::make('zipCode')
                                    ->default($this->zipCode),
                                TextInput::make('neighborhood')
                                    ->default($this->neighborhood),
                                TextInput::make('street')
                                    ->default($this->street),
                                TextInput::make('number')
                                    ->default($this->number),
                                TextInput::make('complement')
                                    ->default($this->complement),
                            ]
                        ),
                    Step::make('Dados monetarios')
                        ->schema(
                            [
//                                Select::make('real_state')
//                                    ->label('Imobiliaria')
//                                    ->options($this->realState->pluck('name', 'id'))
////                                    ->searchable()
//                                    ->required()
//                                    ->columnSpanFull(),

                                TextInput::make('value_base')
                                    ->prefix('R$')
                                    ->label('Valor base')
                                    ->placeholder('Valor base')
////                                    ->regex('/^(\d{1,3}(\.\d{3})*|\d+)(\,\d{2})?$/gm')
////                                    ->mask(fn (TextInput\Mask $mask) => $mask->pattern('\d+(?:\.\d{3})*?,\d{2}'))
////                                    ->mask(fn (
////                                        TextInput\Mask $mask) => $mask->money(prefix: 'R$ ', thousandsSeparator: '.')
////                                        ->decimalSeparator(',')
////                                    )
                                    ->default($this->value_base)
//                                    ->mask(fn(TextInput\Mask $mask) => $mask
//                                        ->patternBlocks([
//                                            'money' => fn(Mask $mask) => $mask->decimalPlaces(2)
//                                                ->numeric()
//                                                ->to($this->value_base)
//                                                ->decimalSeparator(',')
////                                                ->thousandsSeparator('.')
//                                            ,
//
//                                        ])
//                                        ->pattern('R$ money')
//                                    )
//                                    ->mask(fn (TextInput\Mask $mask) => $mask
//                                        ->decimalPlaces(2) // Set the number of digits after the decimal point.
//                                        ->decimalSeparator(',') // Add a separator for decimal numbers.
//                                        ->mapToDecimalSeparator([',']) // Map additional characters to the decimal separator.
//                                        ->thousandsSeparator('.')
//                                        ->numeric() // Add a separator for thousands.
//                                    )
                                    ->numeric()
                                    ->minValue(0)
                                    ->required()
                                    ->columnSpanFull(),

                                TextInput::make('first_release')
                                    ->label('Primeiro aluguel')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->first_release),

                                        ])
                                        ->pattern('value %')
                                    )
                                    ->required()
                                    ->helperText('Valor em porcentagem')
                                    ->minValue(0),

                                TextInput::make('recurrent_release')
                                    ->label('Aluguel recorrente')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->recurrent_release),

                                        ])
                                        ->pattern('value %')
                                    )
                                    ->helperText('Valor em porcentagem')
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('entrance_fees')
                                    ->label('Taxa de entrada')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->entrance_fees),

                                        ])
                                        ->pattern('value %')
                                    )
                                    ->helperText('Valor em porcentagem')
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('exit_fees')
                                    ->label('Taxa de saida')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->exit_fees),

                                        ])
                                        ->pattern('value %')
                                    )
                                    ->helperText('Valor em porcentagem')
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('daily_interest')
                                    ->label('Juros diario')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->daily_interest),

                                        ])
                                        ->pattern('value %')
                                    )
                                    ->helperText('Valor em porcentagem')
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('monthly_interest')
                                    ->label('Juros mensal')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->monthly_interest),

                                        ])
                                        ->pattern('value %')
                                    )
                                    ->helperText('Valor em porcentagem')
                                    ->minValue(0)
                                    ->required(),
                            ]
                        ),
                ],
            )->columns(2)
                ->submitAction(new HtmlString(view('livewire.real-state.real-state-edit-component-submit')))
                ->extraAttributes(['class' => 'dark:text-white'])
                ->startOnStep(2)
            ,
        ];

    }

    public function update()
    {
        $this->data = $this->form->getState();

        ds($this->data)->warning()->die();
    }

    public function render()
    {
        return view('livewire.real-state.real-states-edit-component');
    }
}
