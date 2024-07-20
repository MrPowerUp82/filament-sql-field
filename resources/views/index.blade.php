<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}'), tables: {{ $getDatabaseTables() }}, isDark: {{ $getDark() }} }" x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('codemirror5-css-cdn', package: 'mrpowerup/filament-sql-field'))]" x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('codemirror5-js-cdn', package: 'mrpowerup/filament-sql-field'))]"
        x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('matchbrackets-js-cdn', package: 'mrpowerup/filament-sql-field'))]" x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('sql-js-cdn', package: 'mrpowerup/filament-sql-field'))]" x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('showhint-css-cdn', package: 'mrpowerup/filament-sql-field'))]"
        x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('showhint-js-cdn', package: 'mrpowerup/filament-sql-field'))]" x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('dracula-theme', package: 'mrpowerup/filament-sql-field'))]" x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('sqlhint-js-cdn', package: 'mrpowerup/filament-sql-field'))]">
        <div style="width: 100%; font-size: 0.875rem; line-height: 1.25rem;" x-init="() => {
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
        }" x-cloak wire:ignore>
            <textarea x-ref="editor" x-bind:value="state"></textarea>
        </div>
    </div>

</x-dynamic-component>
