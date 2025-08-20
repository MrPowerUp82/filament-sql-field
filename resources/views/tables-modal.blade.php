<style>
.table-container {
    margin-bottom: 1rem;
}
.table-title {
    margin-bottom: 0.5rem;
    font-size: 1.25rem;
    font-weight: 600;
}
.table-list {
    max-width: 28rem;
    margin: 0;
    padding-left: 1.25rem;
    list-style-type: disc;
}
.table-list li {
    margin-bottom: 0.25rem;
}
</style>

<div>
    @foreach ($data as $tableName => $columns)
        <div class="table-container">
            <h2 class="table-title">{{ $tableName }}</h2>
            <ul class="table-list">
                @foreach ($columns as $col)
                    <li>{{ $col }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
