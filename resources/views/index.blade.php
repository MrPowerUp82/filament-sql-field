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
    <script src="{{ asset('js/mrpowerup/filament-sql-field/searchcursor-js-cdn.js') }}"></script>
    <script src="{{ asset('js/mrpowerup/filament-sql-field/mark-selection-js-cdn.js') }}"></script>
    <script src="{{ asset('js/mrpowerup/filament-sql-field/sql-formatter-js-cdn.js') }}"></script>
    <script src="{{ asset('js/mrpowerup/filament-sql-field/sql-parser-js-cdn.js') }}"></script>

    <style>
        .cm-sql-error {
            background-color: rgba(255, 0, 0, 0.3);
            border-bottom: 2px solid red;
        }
    </style>

    <div x-data="{
        state: $wire.entangle('{{ $getStatePath() }}'),
        tables: {{ $getTables() }},
        isDark: {{ $getDark() }},
        allowFullscreen: {{ $getFullscreen() }},
        mime: '{{ $getMime() }}'
    }">
        <div style="width: 100%; font-size: 0.875rem; line-height: 1.25rem;" x-init="() => {
            $nextTick(() => {
                if (isDark == null) {
                    isDark = (localStorage.getItem('theme') == 'system' || localStorage.getItem('theme') == null) ? window.matchMedia('(prefers-color-scheme: dark)').matches : localStorage.getItem('theme') == 'dark';
                }
                const options = {
                    mode: mime,
                    indentWithTabs: true,
                    smartIndent: true,
                    lineNumbers: true,
                    matchBrackets: true,
                    styleSelectedText: true,
                    styleActiveLine: true,
                    smartIndent: true,
                    autofocus: true,
                    theme: isDark ? 'dracula' : 'default',
                    gutters: ['CodeMirror-linenumbers', 'CodeMirror-lint-markers'],
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
                    setTimeout(() => {
                        checkSQLSyntaxNoToast()
                    }, 250);
                });
                window.editor.setSize(null, {{ $getEditorHeight() }});
                if (allowFullscreen) {
                    window.editor.options.extraKeys = {
                        ...window.editor.options.extraKeys,
                        'F11': function(cm) {
                            console.log(cm.getOption('fullScreen'));
                            cm.setOption('fullScreen', !cm.getOption('fullScreen'));
                        },
                        'Esc': function(cm) {
                            if (cm.getOption('fullScreen')) cm.setOption('fullScreen', false);
                        }
                    }
                }
            });
        }" x-cloak wire:ignore>
            <textarea x-ref="editor" x-bind:value="state" style="min-height: 30vh;height:{{ $getEditorHeight() }}"></textarea>
        </div>
    </div>

    <script>
        const translations =
        {!! $getTranslations() !!};
    </script>

    @script
        <script>            
            $wire.on('updatePlugin', (event) => {

                let value = event[0];
                switch (event[1]) {
                    case 'tables':
                        try {
                            window.editor.setOption('hintOptions', {
                                tables: value
                            });
                            showToast(translations.notifications.tables.success.title, "green");
                        } catch (error) {
                            showToast(error, "red");
                        }
                        break;
                    case 'theme':
                        localStorage.setItem('theme', value ? 'dark' : 'light');
                        window.editor.setOption('theme', value ? 'dracula' : 'default');
                        break;
                    case 'mime':
                        try {
                            window.editor.setOption('mode', value);
                            showToast(translations.notifications.mime.success.title, "green");
                        } catch (error) {
                            showToast(error, "red");
                        }
                        break;
                    case 'fullscreen':
                        window.editor.setOption('fullScreen', value);
                        break;
                    case 'height':
                        window.editor.setSize(null, value);
                        break;
                    case 'value':
                        window.editor.setValue(value);
                        break;
                    case 'check':
                        checkSQLSyntax();
                        break;
                    case 'format':
                        formatSQL();
                        break;
                    default:
                        break;
                }
            });
        </script>
    @endscript

    <script>
        function checkSQLSyntaxNoToast() {
            window.editor.doc.getAllMarks().forEach(marker => marker.clear());
            let editorCode = window.editor.getValue();
            try {
                let parsed = sqlParser.parse(editorCode);
            } catch (e) {
                window.editor.markText({
                    line: e.hash.loc.first_line - 1,
                    ch: e.hash.loc.first_column
                }, {
                    line: e.hash.loc.last_line,
                    ch: e.hash.loc.last_column
                }, {
                    className: 'cm-sql-error',
                    title: e.message
                });
            }
        }

        function checkSQLSyntax() {
            window.editor.doc.getAllMarks().forEach(marker => marker.clear());
            let editorCode = window.editor.getValue();
            try {
                let parsed = sqlParser.parse(editorCode);
                showToast(translations.notifications.check.success.title, "green");
            } catch (e) {
                window.editor.markText({
                    line: e.hash.loc.first_line - 1,
                    ch: e.hash.loc.first_column
                }, {
                    line: e.hash.loc.last_line,
                    ch: e.hash.loc.last_column
                }, {
                    className: 'cm-sql-error',
                    title: e.message
                });
                showToast(e.message, "red");
            }
        }

        function formatSQL() {
            let value = window.editor.getValue();
            let mode = window.editor.getOption('mode').replace('text/x-', '');
            try {
                value = sqlFormatter.format(value, {
                    language: mode,
                    tabWidth: 2,
                    keywordCase: "upper",
                    linesBetweenQueries: 2
                });
                window.editor.setValue(value);
                showToast(translations.notifications.format.success.title, "green");
            } catch (error) {
                showToast(error, "red");
            }
        }

        function showToast(message, color) {
            console.log(message);
            switch (color) {
                case "green":
                    new FilamentNotification()
                        .title(message)
                        .success()
                        .send();
                    break;
                case "red":
                    new FilamentNotification()
                        .title(message)
                        .danger()
                        .send();
                    break;
                case "yellow":
                    new FilamentNotification()
                        .title(message)
                        .warning()
                        .send();
                    break;
                default:
                    break;
            }
        }
    </script>
</x-dynamic-component>
