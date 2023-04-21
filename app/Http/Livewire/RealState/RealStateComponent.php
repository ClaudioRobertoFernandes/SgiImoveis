<?php

namespace App\Http\Livewire\RealState;

use App\Helpers\Consts;
use App\Models\RealStates\RealStates;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class RealStateComponent extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $belongs;
    public $real_state;
    public $realState;
    public $value_base;
    public $user_id;
    public $first_release;
    public $recurrent_release;
    public $entrance_fees;
    public $exit_fees;
    public $daily_interest;
    public $monthly_interest;

    public function mount(): void
    {
        $this->belongs = User::getBelongsToUser();
        $this->realState = User::where('user_type_id', Consts::USER_TYPE_REAL_STATE)
            ->where('belongs', $this->belongs)
            ?->get();
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.real-state.real-state-component');
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make(
                [
                    Step::make('Imobiliarias')
                        ->schema(
                            [
                                Select::make('real_state')
                                    ->label('Imobiliaria')
                                    ->options($this->realState->pluck('name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->columnSpanFull(),

                                TextInput::make('value_base')
                                    ->prefix('R$')
                                    ->label('Valor base')
                                    ->placeholder('Valor base')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required()
                                    ->columnSpanFull(),

                                TextInput::make('first_release')
                                    ->suffix('%')
                                    ->label('Primeiro aluguel')
                                    ->placeholder('Primeiro aluguel')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0),

                                TextInput::make('recurrent_release')
                                    ->suffix('%')
                                    ->label('Aluguel recorrente')
                                    ->placeholder('Aluguel recorrente')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('entrance_fees')
                                    ->suffix('%')
                                    ->label('Taxa de entrada')
                                    ->placeholder('Taxa de entrada')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('exit_fees')
                                    ->suffix('%')
                                    ->label('Taxa de saida')
                                    ->placeholder('Taxa de saida')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('daily_interest')
                                    ->suffix('%')
                                    ->label('Juros diario')
                                    ->placeholder('Juros diario')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),

                                TextInput::make('monthly_interest')
                                    ->suffix('%')
                                    ->label('Juros mensal')
                                    ->placeholder('Juros mensal')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),
                            ]
                        )
                ]
            )->columns(2)
                ->submitAction(new HtmlString(view('livewire.register.register-component-submit')))
                ->extraAttributes(['class' => 'dark:text-white'])
        ];
    }

    public function submit()
    {

        $this->data = $this->form->getState();
        $realState = new RealStates();
        $realState->user_id = $this->data['real_state'];
        $realState->value_base = $this->data['value_base'];
        $realState->first_release = $this->data['first_release'];
        $realState->recurrent_release = $this->data['recurrent_release'];
        $realState->entrance_fees = $this->data['entrance_fees'];
        $realState->exit_fees = $this->data['exit_fees'];
        $realState->daily_interest = $this->data['daily_interest'];
        $realState->monthly_interest = $this->data['monthly_interest'];
        if ($realState->save()) {

            Notification::make()
                ->title('Salvo com sucesso')
                ->success()
                ->send();
        }

        return redirect()->route('Imobiliarias');
    }
}
