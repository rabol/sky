<?php

namespace LaraZeus\Sky\Filament\Resources\FaqResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\LocaleSwitcher;
use Filament\Resources\Pages\ListRecords;
use LaraZeus\Sky\Filament\Resources\FaqResource;
use LaraZeus\Sky\SkyPlugin;

class ListFaqs extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = FaqResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('Open')
                ->color('warning')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->label(__('Open'))
                ->visible(! config('zeus-sky.headless'))
                ->url(fn (): string => route(SkyPlugin::get()->getRouteNamePrefix() . 'faq'))
                ->openUrlInNewTab(),
            LocaleSwitcher::make(),
        ];
    }
}
