<?php

namespace App\Http\Livewire\RealState;

use Exception;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Helpers\Consts;
use Livewire\Component;
use Illuminate\View\Factory;
use Tables\Actions\DeleteAction;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
use App\Models\RealStates\RealStates;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Illuminate\Foundation\Application;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Columns\CheckboxColumn;
use Leandrocfe\FilamentPtbrFormFields\PtbrMoney;
class RealStateComponent extends Component implements Tables\Contracts\HasTable
{

    use Tables\Concerns\InteractsWithTable;

    public $data;
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

                                PtbrMoney::make('value_base')
                                    ->label('Valor base')
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
                ->extraAttributes(['class' => Consts::DARKTEXTWHITE])
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

    protected function getTableQuery(): Builder
    {
        return User::query()
            ->where('user_type_id', Consts::USER_TYPE_REAL_STATE)
            ->leftjoin('real_states', 'real_states.user_id', '=', 'users.id');
    }

    protected function getTableColumns(): array
    {
        return [
            CheckboxColumn::make('user_id')
                ->label('Id')
                ->sortable(['id']),
            TextColumn::make('name')
                ->label('Nome')
                ->sortable(['name'])
                ->tooltip('Nome'),
            TextColumn::make('email')->label('E-mail'),
            TextColumn::make('document')->label('CPF/CNPJ'),
            TextColumn::make('phone')->label('Telefone'),
            TextColumn::make('zipCode')->label('CEP'),
            TextColumn::make('created_at')
                ->label('Cadastro')
                ->date('d/m/Y')
                ->color('danger'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [

        ];
    }

    /**
     * @throws Exception
     */
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\ActionGroup::make([
                // Tables\Actions\ViewAction::make()
                //     ->extraAttributes(['class' => 'dark:text-white']),
                Tables\Actions\EditAction::make()
                    ->url(fn (User $record): string => route('real-states-edit', $record))
                    ->extraAttributes(['class' => 'dark:text-white']),
                Tables\Actions\DeleteAction::make()
                    ->extraAttributes(['class' => 'dark:text-white']),
            ]),

        ];
    }


    public function render(): View|Application|Factory
    {
        return view('livewire.real-state.real-state-component');
    }
}
