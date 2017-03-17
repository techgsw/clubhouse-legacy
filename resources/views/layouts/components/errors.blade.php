@if (count($errors) > 0)
    <div class="alert card-panel red lighten-4 red-text text-darken-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
