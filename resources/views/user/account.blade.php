<!-- /resources/views/user/account.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Account')
@section('content')
<div class="container">
    @component('user.header', ['user' => $user])
        @can ('view-contact-notes')
            <button type="button" class="view-contact-notes-btn flat-button black"
                contact-id="{{ $user->contact->id }}"
                contact-name="{{ $user->contact->getName() }}"
                contact-follow-up="{{ $user->contact->follow_up_date ? $user->contact->follow_up_date->format('Y-m-d') : '' }}">
                {{ $user->contact->getNoteCount() }} <i class="fa fa-comments"></i>
            </button>
        @endif
        @if ($user->profile->resume_url)
            <a href="{{ Storage::disk('local')->url($user->profile->resume_url) }}" class="flat-button black"><span class="hide-on-small-only">View </span> Resume</a>
        @else
            <a href="#" class="flat-button black disabled">No Resume</a>
        @endif
        @can ('edit-profile', $user)
            <a href="/user/{{ $user->id }}/edit-profile" class="flat-button black">Edit<span class="hide-on-small-only"> Profile</span></a>
        @endcan
        @can ('view-admin-jobs', $user)
            <button class="view-contact-job-assignment-btn flat-button" contact-id="{{ $user->contact->id }}"><i class="fa fa-id-card"></i> Assign to job</button>
        @elsecan ('create-job', $user)
            <a href="/job-options" class="flat-button"><i class="fa fa-id-card"></i> Create Job Posting</a>
        @endcan
    @endcomponent
    <ul class="nav-tabs" style="margin-bottom: 12px;">
        <li class="tab"><a class="active" href="/user/{{ $user->id }}/account">Account</a></li>
        @can ('view-contact')
            <li class="tab"><a href="/contact/{{ $user->contact->id }}">Contact</a></li>
        @endcan
        @can ('view-mentor')
            @if ($user->contact->mentor)
                <li class="tab"><a href="/contact/{{ $user->contact->id }}/mentor">Mentor</a></li>
            @endif
        @endcan
        <li class="tab"><a href="/user/{{ $user->id }}/profile">Profile</a></li>
        <li class="tab"><a class="" href="/user/{{ $user->id }}/jobs">My Jobs</a></li>
        <!--<li class="tab"><a href="/user/{{ $user->id }}/questions">Q&A</a></li>-->
        @can ('create-job')
            <li class="tab"><a class="" href="/user/{{ $user->id }}/job-postings">Job Postings</a></li>
        @endcan
        @can ('edit-roles')
            <li class="tab"><a href='/admin/{{ $user->id }}/edit-roles'>Roles</a></li>
        @endcan
    </ul>
    <div class="row">
        <div class="col s12 m12 l6">
            {{ csrf_field() }}
            <h4>Subscriptions</h4>
            @if (!is_null($stripe_user) && !is_null($stripe_user->subscriptions) && count($stripe_user->subscriptions->data) > 0)
                <table>
                    <thead>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Next Payment</th>
                        <th>&nbsp;</th>
                    </thead>
                    @foreach ($stripe_user->subscriptions->data as $key => $value)
                        @php $next_bill = date('m/d/Y', $value->current_period_end); @endphp
                        <tr>
                            <td>{{ $value->items->data[0]->plan->nickname }}</td>
                            <td>{{ money_format('%.2n', ($value->items->data[0]->plan->amount / 100)) }} / {{ $value->items->data[0]->plan->amount < 7000 ? 'Month' : 'Year' }}</td>
                            <td>{{ $next_bill }}</td>
                            <td><a class="flat-button black" id="cancel-subscription-button" data-subscription-id="{{ $value->id }}">Cancel</a></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p>No active subscriptions.</p>
            @endif
        </div>
        @php
            $cc = array(
                'Visa' => 'visa',
                'American Express' => 'amex',
                'MasterCard' => 'mastercard',
                'JCB' => 'jcb',
                'Discover' => 'discover',
                'Diners Club' => 'diners-club'
            ); 
        @endphp
        <div class="col s12 m12 l6">
            {{ csrf_field() }}
            <h4 style="display: inline-block;">Cards</h4>
            <a id="add-cc-button" class="btn btn-small sbs-red right" style="margin-top: 15px;"><li class="fa fa-plus"></li> CARD</a>
            @if (!is_null($stripe_user) && !is_null($stripe_user->subscriptions) && count($stripe_user->sources) > 0)
                <table>
                    <thead>
                        <th>Card</th>
                        <th>Expiration</th>
                        <th>&nbsp;</th>
                    </thead>
                    @foreach ($stripe_user->sources->data as $key => $value)
                        @php
                            $card_icon = ((array_key_exists($value->brand, $cc)) ? $cc[$value->brand] : 'credit-card');
                        @endphp
                        <tr>
                            <td><li class="fa fa-cc-{{ $card_icon }}" style="font-size: 32px;"></li> ....{{ $value->last4 }}</td>
                            <td>{{ str_pad($value->exp_month, 2, '0', STR_PAD_LEFT) }} / {{ $value->exp_year }}</td>
                            @if ($stripe_user->default_source == $value->id)
                                <td class="right-align"><a class="flat-button blue" href="javascript: void(0);">Primary</a></td>
                            @else
                                <td class="right-align">
                                    <a class="btn btn-small red text-right remove-card-button" data-card-id="{{ $value->id }}">X</a>
                                    <a class="btn btn-small blue text-right make-primary-button" data-card-id="{{ $value->id }}"><li class="fa fa-credit-card"></li></a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            @else
                <p>No cards on file.</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="cc-form scale-transition scale-out hidden">
                @include('forms.add-card')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Order History</h4>
            @if (isset($transactions['orders']) && count($transactions['orders']) > 0)
                <table>
                    <thead>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Card</th>
                    </thead>
                    @foreach ($transactions['orders'] as $key => $value)
                        @php $created = date('m/d/Y', $value['order']['created']); @endphp
                        @foreach ($value['order']['items'] as $order_key => $item)
                        <tr>
                            <td>{{ $created }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ money_format('%.2n', ($value['order']['total_amount'] / 100)) }}</td>
                            @if (array_key_exists('charge_object', $value['order']))
                                @php
                                    $card_icon = ((array_key_exists($value['order']['charge_object']->source->brand, $cc)) ? $cc[$value['order']['charge_object']->source->brand] : 'credit-card');
                                 @endphp
                                <td><li class="fa fa-cc-{{ $card_icon }}" style="font-size: 32px;"></li> ....{{ $value['order']['charge_object']->source->last4 }}</td>
                            @else
                                <td>N/A</td>
                            @endif
                        </tr>
                        @endforeach
                    @endforeach
                </table>
            @else
                <p>No orders.</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Subscription History</h4>
            @if (isset($transactions['subscriptions']) && count($transactions['subscriptions']) > 0)
                <table>
                    <thead>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Card</th>
                    </thead>
                    @foreach ($transactions['subscriptions'] as $key => $value)
                        @if (array_key_exists('invoice', $value))
                            @php $bill_date = date('m/d/Y', $value['invoice']->date); @endphp
                            @foreach ($value['invoice']->lines->data as $invoice_item_key => $item)
                            <tr>
                                <td>{{ $bill_date }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ money_format('%.2n', ($item->amount / 100)) }}</td>
                                @if (array_key_exists('charge_object', $value))
                                    @php
                                        $card_icon = ((array_key_exists($value['charge_object']->source->brand, $cc)) ? $cc[$value['charge_object']->source->brand] : 'credit-card');
                                     @endphp
                                    <td><li class="fa fa-cc-{{ $card_icon }}" style="font-size: 32px;"></li> ....{{ $value['charge_object']->source->last4 }}</td>
                                @else
                                    <td>N/A</td>
                                @endif
                            </tr>
                            @endforeach
                        @endif
                    @endforeach
                </table>
            @else
                <p>No subscription payments.</p>
            @endif
        </div>
    </div>
</div>
@can ('edit-profile', $user)
@include('components.contact-notes-modal')
@include('components.contact-job-notes-modal')
@include('components.inquiry-notes-modal')
@component('components.job-contact-assign-modal')@endcomponent
@endcan
@endsection
