@php
    $pd = new Parsedown();
@endphp
<div class="product-option row" index="{{ $i ?: ""}}">
    <input type="hidden" class="option-id" id="option-{{ $i ?: "" }}-id" name="option[{{ $i ?: "" }}][id]" value="{{ $option ? $option->id : '' }}">
    <div class="col s2 l1 center-align">
        <div class="product-option-button">
            <div class="product-option-index">{{ $i ?: ""}}</div>
            <div class="product-option-delete"><i class="fa fa-times"></i></div>
        </div>
    </div>
    <div class="col s10 l11">
        <div class="row">
            <div class="input-field col s12 m6">
                <input class="option-name" id="option-{{ $i ?: "" }}-name" name="option[{{ $i ?: "" }}][name]" type="text" value="{{ $option ? $option->name : '' }}" required>
                <label>Name</label>
            </div>
            <div class="input-field col s6 m3">
                <input class="option-price" {{ !is_null($option) && !is_null($option->stripe_plan_id) ? 'disabled' : '' }} id="option-{{ $i ?: "" }}-price" name="option[{{ $i ?: "" }}][price]" type="number" step="0.01" min="0" value="{{ $option ? $option->price : '' }}" required>
                <label>Price ($)</label>
            </div>
            <div class="input-field col s6 m3">
                <input class="option-quantity" {{ !is_null($option) && !is_null($option->stripe_plan_id) ? 'disabled' : '' }} id="option-{{ $i ?: "" }}-quantity" name="option[{{ $i ?: "" }}][quantity]" type="number" step="1" min="0" value="{{ $option ? $option->quantity : '' }}">
                <label>Quantity</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input class="option-description" id="option-{{ $i ?: "" }}-description" type="text" name="option[{{ $i ?: "" }}][description]"  value="{{ !is_null($option) ? $option->description : "" }}" required>
                <label>Description</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6 m4" style="margin-top: 0">
                <p class="checkbox">
                    <input type="checkbox" name="option[{{ $i ?: ""}}][clubhouse]" id="option-{{ $i ?: ""}}-clubhouse" class="option-clubhouse" value="1" {{ $option && $option->hasRole('clubhouse') ? "checked" : "" }} />
                    <label for="option-{{ $i ?: ""}}-clubhouse" class="clubhouse-label">Clubhouse</label>
                </p>
            </div>
            <div class="input-field col s6 m4" style="margin-top: 0">
                <p class="checkbox">
                    <input type="checkbox" name="option[{{ $i ?: ""}}][user]" id="option-{{ $i ?: ""}}-user" class="option-user" value="1" {{ $option && $option->hasRole('user') ? "checked" : "" }} />
                    <label for="option-{{ $i ?: ""}}-user" class="user-label">User</label>
                </p>
            </div>
        </div>
    </div>
</div>
