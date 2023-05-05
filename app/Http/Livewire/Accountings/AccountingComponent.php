<?php

namespace App\Http\Livewire\Accountings;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Filament\Tables;
use App\Helpers\Consts;
use Livewire\Component;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Wizard;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput\Mask;
use Illuminate\Validation\ValidationException;

class AccountingComponent extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    // form fields
    public string $userId;
    public string $name = '';
    public string $email = '';
    public string $document = '';
    public string $phone = '';
    public string $zipCode = '';
    public string $street = '';
    public string $number = '';
    public string $complement = '';
    public string $neighborhood = '';
    public string $city = '';
    public string $state = '';
    public $data = '';

    protected function getFormSchema(): array
    {
        return [
            Wizard::make(
                [
                    Step::make('Dados contabilidade')
                        ->schema([
                                TextInput::make('name')
                                    ->label('Contabilidade')
                                    ->default($this->name)
                                    ->required()
                                    ->rule('min:3')
                                    ->validationAttribute('Contabilidade')
                                    ->columnSpan(6),

                                TextInput::make('email')
                                    ->label('E-mail')
                                    ->default($this->email)
                                    ->required()
                                    ->rule('email')
                                    ->validationAttribute('E-mail')
                                    ->columnSpan(6),

                                TextInput::make('document')
                                    ->label('CNPJ')
                                    ->unique('users', 'document')
                                    ->required()
                                    ->default($this->document)
                                    ->validationAttribute('CNPJ')
                                    ->columnSpan(3),

                                TextInput::make('phone')
                                    ->label('Telefone')
                                    ->required()
                                    ->default($this->phone)
                                    ->validationAttribute('Telefone')
                                    ->columnSpan(3),

                                TextInput::make('zipCode')
                                    ->label('CEP')
                                    ->required()
                                    ->default($this->zipCode)
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
                                    ->validationAttribute('CEP')
                                    ->columnSpan(4),

                                TextInput::make('state')
                                    ->label('Estado')
                                    ->default($this->state)
                                    ->columnSpan(2),

                                TextInput::make('city')
                                    ->label('Cidade')
                                    ->default($this->city)
                                    ->columnSpan(3),

                                TextInput::make('neighborhood')
                                    ->label('Bairro')
                                    ->default($this->neighborhood)
                                    ->columnSpan(3),

                                TextInput::make('street')
                                    ->label('Logradouro')
                                    ->default($this->street)
                                    ->columnSpan(3),

                                TextInput::make('number')
                                    ->label('Número')
                                    ->default($this->number)
                                    ->columnSpan(3),

                                TextInput::make('complement')
                                    ->label('Complemento')
                                    ->default($this->complement)
                                    ->columnSpan(6),
                            ]
                        )
                ]
            )
            ->columns(6)
            ->extraAttributes(['class' => 'dark:text-white'])
            ->submitAction(new HtmlString(view('livewire.accountings.accounting-register-component-submit')))
        ];
    }

    public function submit()
    {
        $this->data = $this->form->getState();
        ds($this->data)->s('data')->warning();
        $accounting = new User();
        $accounting->name = $this->name;
        $accounting->user_type_id = Consts::USER_TYPE_ACCOUNTING;
        $accounting->belongs = Auth::user()->id;
        $accounting->email = $this->email;
        $accounting->password = bcrypt('password');// password
        $accounting->document = preg_replace("/\D/", "", $this->document);
        $accounting->phone = preg_replace("/\D/", "", $this->phone);
        $accounting->zipCode = $this->zipCode;
        $accounting->street = $this->street;
        $accounting->number = ($this->number) ?? 'S/N';
        $accounting->complement = ($this->complement) ?? 'S/C';
        $accounting->neighborhood = $this->neighborhood;
        $accounting->city = $this->city;
        $accounting->state = $this->state;
        if ($accounting->save()) {
            Notification::make()
                ->title('Contabilidade cadastrada com sucesso!')
                ->success()
                ->duration(5000)
                ->send();
        }
    }

    protected function getTableQuery(): Builder
    {
        return User::query()
            ->where('user_type_id', Consts::USER_TYPE_ACCOUNTING);
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
                    ->url(fn (User $record): string => route('accountings-edit', $record))
                    ->extraAttributes(['class' => 'dark:text-white']),
                Tables\Actions\DeleteAction::make()
                    ->extraAttributes(['class' => 'dark:text-white']),
            ]),

        ];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

    public function render(): View
    {
        return view('livewire.accountings.accounting-component');
    }
}
