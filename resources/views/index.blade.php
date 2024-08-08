<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <link rel="stylesheet" href="{{ asset('css/mrpowerup/filament-sql-field/codemirror5-css-cdn.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/mrpowerup/filament-sql-field/showhint-css-cdn.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/mrpowerup/filament-sql-field/dracula-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/mrpowerup/filament-sql-field/fullscreen-css-mode.css') }}" />
    <script src="{{ asset('js/mrpowerup/filament-sql-field/codemirror5-js-cdn.js') }}"></script>
    <script src="{{ asset('js/mrpowerup/filament-sql-field/matchbrackets-js-cdn.js') }}"></script>
    <script src="{{ asset('js/mrpowerup/filament-sql-field/sql-js-cdn.js') }}"></script>
    <script src="{{ asset('js/mrpowerup/filament-sql-field/showhint-js-cdn.js') }}"></script>
    <script src="{{ asset('js/mrpowerup/filament-sql-field/fullscreen-js-mode.js') }}"></script>
    <script src="{{ asset('js/mrpowerup/filament-sql-field/sqlhint-js-cdn.js') }}"></script>

    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}'), tables: {{ $getTables() }}, isDark: {{ $getDark() }}, 
    allowFullscreen: {{$getFullscreen()}},
    mime: '{{ $getMime() }}'
    }">
        <div style="width: 100%; font-size: 0.875rem; line-height: 1.25rem;" x-init="() => {
            $nextTick(() => {
                const options = {
                    mode: mime,
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
                window.editor.setSize(null, {{ $getEditorHeight() }});
                if (allowFullscreen) {
                    window.editor.options.extraKeys = {...window.editor.options.extraKeys, 
                    'F11': function (cm) {
                    console.log(cm.getOption('fullScreen'));
                    cm.setOption('fullScreen', !cm.getOption('fullScreen'));
                },
                'Esc': function (cm) {
                    if (cm.getOption('fullScreen')) cm.setOption('fullScreen', false);
                }
                    }
                }
            });
        }" x-cloak wire:ignore>
            <textarea x-ref="editor" x-bind:value="state"
            style="min-height: 30vh;height:{{ $getEditorHeight() }}"
            ></textarea>
        </div>
    </div>

</x-dynamic-component>
