<div>
    @foreach ($data as $tableName => $columns)
        <div class="mb-4">
            <h2 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">{{ $tableName }}</h2>
            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                @foreach ($columns as $col)
                    <li>{{ $col }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
