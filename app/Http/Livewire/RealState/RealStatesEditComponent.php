<?php

namespace App\Http\Livewire\RealState;

use App\Helpers\Consts;
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

    public $realStates;
    public $user;
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
    public  $value_base = 0;
    public int $first_release;
    public int $recurrent_release;
    public int $entrance_fees;
    public int $exit_fees;
    public int $daily_interest;
    public int $monthly_interest;


    public function mount($userId): void
    {
        $this->user = User::where('users.belongs', $userId)
            ->where('user_type_id', '=', Consts::USER_TYPE_REAL_STATE)
            ->leftJoin('real_states', 'users.id', '=', 'real_states.user_id')
            ?->first();

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->city = $this->user->city;
        $this->state = $this->user->state;
        $this->zipCode = $this->user->zipCode;
        $this->neighborhood = $this->user->neighborhood;
        $this->street = $this->user->street;
        $this->number = $this->user->number;
        $this->complement = $this->user->complement;
        $this->document = $this->user->document;
        $this->value_base = $this->user->value_base;
        $this->first_release = $this->user->first_release;
        $this->recurrent_release = $this->user->recurrent_release;
        $this->entrance_fees = $this->user->entrance_fees;
        $this->exit_fees = $this->user->exit_fees;
        $this->daily_interest = $this->user->daily_interest;
        $this->monthly_interest = $this->user->monthly_interest;

    }

    public function getFormSchema()
    {
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

                                TextInput::make('value_base')
                                    ->prefix('R$')
                                    ->label('Valor base'),

                                TextInput::make('first_release')
                                    ->label('Primeiro aluguel')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->first_release),
                                        ])
                                        ->pattern('% value')
                                    )
                                    ->required()
                                    ->helperText(Consts::TEXTHELPVALUEPORCENTAGE)
                                    ->minValue(0),

                                TextInput::make('recurrent_release')
                                    ->label('Aluguel recorrente')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->recurrent_release),

                                        ])
                                        ->pattern('% value')
                                    )
                                    ->helperText(Consts::TEXTHELPVALUEPORCENTAGE)
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('entrance_fees')
                                    ->label('Taxa de entrada')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->entrance_fees),

                                        ])
                                        ->pattern('% value')
                                    )
                                    ->helperText(Consts::TEXTHELPVALUEPORCENTAGE)
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('exit_fees')
                                    ->label('Taxa de saida')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->exit_fees),

                                        ])
                                        ->pattern('% value')
                                    )
                                    ->helperText(Consts::TEXTHELPVALUEPORCENTAGE)
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('daily_interest')
                                    ->label('Juros diario')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->daily_interest),

                                        ])
                                        ->pattern('% value')
                                    )
                                    ->helperText(Consts::TEXTHELPVALUEPORCENTAGE)
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('monthly_interest')
                                    ->label('Juros mensal')
                                    ->mask(fn(TextInput\Mask $mask) => $mask
                                        ->patternBlocks([
                                            'value' => fn(Mask $mask) => $mask->numeric()
                                                ->to($this->monthly_interest),

                                        ])
                                        ->pattern('% value')
                                    )
                                    ->default($this->monthly_interest)
                                    ->helperText(Consts::TEXTHELPVALUEPORCENTAGE)
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
    }

    public function render()
    {
        return view('livewire.real-state.real-states-edit-component');
    }
}
