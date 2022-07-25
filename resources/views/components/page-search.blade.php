<!-- Search -->
<div class="col s12 m6 l6">
    <form action="{{ $base_url }}" method="get" style="display: flex; flex-flow: row;">
        <div class="input-field" style="flex: 1 0 auto;">
            <input id="search" type="text" name="search" value="{{ request('search') }}">
            <label for="search">Search</label>
        </div>
        <div class="input-field" style="flex: 0 0 auto;">
            <button type="submit" name="submit" class="btn sbs-red btn-xs">Go</button>
        </div>
    </form>
</div>
