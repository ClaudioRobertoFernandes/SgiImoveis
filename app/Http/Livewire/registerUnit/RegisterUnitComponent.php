<?php

namespace App\Http\Livewire\registerUnit;

use App\Models\Building\Buildings;
use App\Models\Units\Units;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class RegisterUnitComponent extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $name;
    public $block;
    public $building_id;
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
    public $search_tenant;
    private array $data;

    public function render(): View|Application|Factory
    {
        return view('livewire.register-unit.register-unit-component');
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make(
                [
                    Step::make('Unidade')
                        ->schema(
                            [
                                Select::make('owner_id')
                                    ->label('Proprietário')
                                    ->options([
                                        Auth::User()->id => Auth::User()->name,
                                    ])
                                    ->columnSpanFull(),

                                Select::make('building_id')
                                    ->label('Edifício')
                                    ->options([
                                        Buildings::getBuildings(Auth::User()->id),
                                    ])
                                    ->columnSpanFull()
                                    ->helperText('Em caso de apartamento cadastre o edifício.'),

                                TextInput::make('name')
                                    ->label('Imóvel')
                                    ->required()
                                    ->columns(2),

                                TextInput::make('block')
                                    ->label('Bloco')
                                    ->columns(2),

                                Textarea::make('description')
                                    ->label('Descrição')
                                    ->rows(3)
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
                                    ->label('Complemento')
                                    ->columnSpanFull(),

                                Toggle::make('active')
                                    ->label('Ativo')
                                    ->onColor('success')
                                    ->columns(2),

                                Toggle::make('empty')
                                    ->label('Vazio')
                                    ->onColor('success')
                                    ->columns(2),
                            ]
                        )
                ])
                ->columns(2)
                ->extraAttributes(['class' => 'dark:text-white'])
                ->submitAction(new HtmlString(view('livewire.register-unit.register-unit-component-submit')))
        ];
    }


    public function submit()
    {

        $this->data = $this->form->getState();

        $unit = new Units();
        $unit->building_id = $this->building_id;
        $unit->name = $this->name;
        $unit->block = $this->block;
        $unit->description = $this->description;
        $unit->owner_id = $this->owner_id;
        $unit->zip_code = $this->zip_code;
        $unit->street = $this->street;
        $unit->number = $this->number ?? 'S/N';
        $unit->complement = $this->complement ?? 'S/C';
        $unit->neighborhood = $this->neighborhood;
        $unit->city = $this->city;
        $unit->state = $this->state;
        $unit->active = $this->active ?? false;
        $unit->empty = $this->empty ?? false;

        if ($unit->save()) {

            Notification::make()
                ->title('Salvo com sucesso')
                ->success()
                ->duration(5000)
                ->send();
        }

        return redirect()->route('register-units');
    }
}
