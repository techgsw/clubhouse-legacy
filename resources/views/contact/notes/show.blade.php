@if (count($notes) == 0)
    <div class="row">
        <div class="col s12">
            <p style="font-style: italic;">No notes</p>
        </div>
    </div>
@else
    <div class="row">
        <div class="col s12">
            @foreach ($notes as $note)
                @include('components.note')
            @endforeach
        </div>
    </div>
@endif
