<?php

namespace App\Http\Livewire\Accountings;

use App\Helpers\Consts;
use App\Models\User;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class AccountingComponent extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return User::query()
            ->where('user_type_id', Consts::USER_TYPE_ACCOUNTING);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nome')
                ->sortable(['name'])
                ->tooltip('Nome'),
            TextColumn::make('email')->label('E-mail'),
            TextColumn::make('document')->label('CPF/CNPJ'),
            TextColumn::make('phone')->label('Telefone'),
            TextColumn::make('zipCode')->label('CEP'),
//            TextColumn::make('state')->label('UF'),
//            TextColumn::make('city')->label('Cidade'),
//            TextColumn::make('neighborhood')->label('Bairro'),
            TextColumn::make('created_at')
                ->label('Cadastro')
                ->date(Carbon::now()->format('d/m/Y'))
                ->color('danger'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [];
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
