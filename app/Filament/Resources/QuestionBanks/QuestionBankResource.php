<?php

namespace App\Filament\Resources\QuestionBanks;

use App\Filament\Resources\QuestionBanks\Pages\CreateQuestionBank;
use App\Filament\Resources\QuestionBanks\Pages\EditQuestionBank;
use App\Filament\Resources\QuestionBanks\Pages\ListQuestionBanks;
use App\Filament\Resources\QuestionBanks\Schemas\QuestionBankForm;
use App\Filament\Resources\QuestionBanks\Tables\QuestionBanksTable;
use App\Models\QuestionBank;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class QuestionBankResource extends Resource
{
    protected static ?string $model = QuestionBank::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // Menggunakan kelas jembatan Schema v5
    public static function form(Schema $schema): Schema
    {
        return QuestionBankForm::configure($schema);
    }

    public static function table(Schema $schema): Schema
    {
        return QuestionBanksTable::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionBanks::route('/'),
            'create' => CreateQuestionBank::route('/create'),
            'edit' => EditQuestionBank::route('/{record}/edit'),
        ];
    }
}
