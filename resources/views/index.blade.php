<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}'), tables: {{ $getDatabaseTables() }}, isDark: {{ $getDark() }} }" style="width: 100%; font-size: 0.875rem; line-height: 1.25rem;" x-init="() => {
        $nextTick(() => {
            const options = {
                mode: 'text/x-mysql',
                indentWithTabs: true,
                smartIndent: true,
                lineNumbers: true,
                matchBrackets: true,
                autofocus: true,
                theme: isDark ? 'dracula' : 'default',
                extraKeys: {
                    'Ctrl-Space': 'autocomplete'
                },
                hintOptions: {
                    tables: tables
                }
            };
            window.editor = CodeMirror.fromTextArea($refs.editor, options);
            window.editor.on('change', (cMirror) => {
                state = cMirror.getValue();
                $refs.editor.value = cMirror.getValue();
            });
        });
    }"
        x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('codemirror', package: 'mrpowerup/filament-sql-field'))]" x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('codemirror', package: 'mrpowerup/filament-sql-field'))]" x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('matchbrackets', package: 'mrpowerup/filament-sql-field'))]"
        x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('sql', package: 'mrpowerup/filament-sql-field'))]" x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('show-hint', package: 'mrpowerup/filament-sql-field'))]" x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('show-hint', package: 'mrpowerup/filament-sql-field'))]"
        x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('dracula.min', package: 'mrpowerup/filament-sql-field'))]" x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('sql-hint', package: 'mrpowerup/filament-sql-field'))]" x-cloak wire:ignore>
        <textarea x-ref="editor" x-bind:value="state"></textarea>
    </div>
</x-dynamic-component>
