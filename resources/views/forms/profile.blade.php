<form method="post" action="/user/{{ $user->id }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="input-field col s12 m6 {{ $errors->has('name') ? 'invalid' : '' }}">
            <input id="first-name" type="text" name="first_name" value="{{ old('first_name') ?: $user->first_name ?: null }}" required>
            <label for="first-name">First name</label>
        </div>
        <div class="input-field col s12 m6 {{ $errors->has('name') ? 'invalid' : '' }}">
            <input id="last-name" type="text" name="last_name" value="{{ old('last_name') ?: $user->last_name ?: null }}" required>
            <label for="last-name">Last name</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 {{ $errors->has('email') ? 'invalid' : '' }}">
            <input id="email" type="email" name="email" value="{{ old('email') ?: $user->email ?: null }}" required>
            <label for="email">Email Address</label>
        </div>
    </div>
    <div class="row">
        <div class="switch col s12">
            <p>Are you currently a sports sales professional?</p>
            <label>
                No
                <input type="checkbox" name="is_sales_professional" {{ old('is_sales_professional') ? "checked" : $user->is_sales_professional ? "checked" : "" }}>
                <span class="lever"></span>
                Yes
            </label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 {{ $errors->has('name') ? 'invalid' : '' }}">
            <input id="organization" type="text" name="organization" value="{{ old('organization') ?: $user->organization ?: null }}">
            <label for="organization">Which organization do you work for?</label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 {{ $errors->has('name') ? 'invalid' : '' }}">
            <input id="title" type="text" name="title" value="{{ old('title') ?: $user->title ?: null }}">
            <label for="title">What is your title?</label>
        </div>
    </div>
    <div class="row">
        <div class="switch col s12">
            <p>Would you like to be considered for jobs in sports sales, business development, or sales leadership?</p>
            <label>
                No
                <input type="checkbox" name="is_interested_in_jobs" {{ old('is_interested_in_jobs') ? "checked" : $user->is_interested_in_jobs ? "checked" : "" }}>
                <span class="lever"></span>
                Yes
            </label>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <button type="submit" class="btn sbs-red">Save</button>
        </div>
    </div>
</form>
