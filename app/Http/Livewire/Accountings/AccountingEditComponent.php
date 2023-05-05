<?php

namespace App\Http\Livewire\Accountings;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

/**
 *
 */
class AccountingEditComponent extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    /**
     * @var
     */
    public $userId;
    /**
     * @var
     */
    public $data;
    // form fields
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string
     */
    public string $email;
    /**
     * @var string
     */
    public string $document;
    /**
     * @var string
     */
    public string $phone;
    /**
     * @var string
     */
    public string $zipCode;
    /**
     * @var string
     */
    public string $street;
    /**
     * @var string
     */
    public string $number;
    /**
     * @var string
     */
    public string $complement;
    /**
     * @var string
     */
    public string $neighborhood;
    /**
     * @var string
     */
    public string $city;
    /**
     * @var string
     */
    public string $state;
    /**
     * @var
     */
    public $statements;

    /**
     * @var string[]
     */
    protected $listeners = ['refreshComponent' => 'submitAccounting'];

    /**
     * @param $userId
     * @return void
     */
    public function mount($userId): void
    {
        $user = User::find($userId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->document = $user->document;
        $this->phone = $user->phone;
        $this->zipCode = $user->zipCode;
        $this->street = $user->street;
        $this->number = $user->number;
        $this->complement = $user->complement;
        $this->neighborhood = $user->neighborhood;
        $this->city = $user->city;
        $this->state = $user->state;
    }

    /**
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Wizard::make(
                [
                    Step::make('Dados contabilidade')
                    ->description('Preencha os dados da contabilidade')
                    ->icon('heroicon-o-pencil')
                        ->schema(
                            [
                                TextInput::make('name')
                                    ->label('Contabilidade')
                                    ->default($this->name)
                                    ->required()
                                    ->rule('min:3')
                                    ->columnSpanFull()
                                    ->validationAttribute('Contabilidade')
                                    ->columnSpanFull(),

                                TextInput::make('email')
                                    ->label('E-mail')
                                    ->default($this->email)
                                    ->required()
                                    ->rule('email')
                                    ->columnSpanFull()
                                    ->validationAttribute('E-mail')
                                    ->columnSpanFull(),

                                TextInput::make('document')
                                    ->label('CPF/CNPJ')
                                    ->unique('users', 'document')
                                    ->required()
                                    ->default($this->document)
                                    ->validationAttribute('CPF/CNPJ')
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
                                    ->columnSpanFull(),
                            ]
                        )
                ]
            )
                ->columns(6)
                ->extraAttributes(['class' => 'dark:text-white'])
                ->cancelAction(new HtmlString(view('livewire.accountings.accounting-edit-component-back')))
                ->submitAction(new HtmlString(view('livewire.accountings.accounting-edit-component-submit')))
        ];
    }

    /**
     * @return void
     */
    public function back()
    {
        return redirect()->route('Contabilidades');
    }

    public function submitAccounting()
    {
        $this->data = $this->form->getState();

        $user = User::find($this->userId);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->document = preg_replace("/\D/", "", $this->document);
        $user->phone = preg_replace("/\D/", "", $this->phone);
        $user->zipCode = $this->zipCode;
        $user->street = $this->street;
        $user->number = $this->number;
        $user->complement = $this->complement;
        $user->neighborhood = $this->neighborhood;
        $user->city = $this->city;
        $user->state = $this->state;
        if ($user->save()) {
            Notification::make()
                ->title('Alterado com sucesso')
                ->success()
                ->duration(5000)
                ->send();
        }

    }


    /**
     * @return View|Application|Factory
     */
    public function render(): View|Application|Factory
    {
        return view('livewire.accountings.accounting-edit-component');
    }
}
