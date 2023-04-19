<?php

namespace App\Http\Livewire\Unit;

use App\Models\Units\Units;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class UnitComponent extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $name;

    public function render()
    {
        return view('livewire.unit.unit-component');
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make(
                [
                    Step::make('Dados pessoais')
                        ->schema(
                            [
                                Forms\Components\TextInput::make('name')
                                    ->label('Nome')
                                    ->placeholder('Nome da unidade')
                                    ->required()
                            ]
                        )
                ])
                ->submitAction(new HtmlString(view('livewire.register.register-component-submit')))
        ];
    }

    public function submit()
    {
        $this->data = $this->form->getState();
        $unit = new Units();
        $unit->name = $this->name;
        $unit->save();
    }
}
