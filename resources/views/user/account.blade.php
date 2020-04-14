<!-- /resources/views/user/account.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Account')
@section('content')
<div class="container">
    @component('user.header', ['user' => $user])
        @include('user.components.actions')
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
                        <th></th>
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
                            @if (array_key_exists($value['order']['id'], $paid_jobs) && !is_null($paid_jobs[$value['order']['id']]['job_url']))
                                <td><a href="{{ $paid_jobs[$value['order']['id']]['job_url'] }}">View Job</a></td>
                            @else
                                <td><a href="/job/create">Available</a></td>
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
    <div class="row">
        <div class="col s12">
            <h4 style="display:inline-block;">Linked Accounts</h4>&nbsp;&nbsp;
            @can('link-accounts')
                <a id='link-account' class="btn btn-small sbs-red" data-user-id="{{ $user->id }}" style="margin-left: 20px; margin-top: -10px;"><li class="fa fa-plus"></li> Link Account</a>
                @include('user.components.link-account-modal')
            @endcan
            @if (isset($linked_users) && count($linked_users) > 0)
                <div class="row">
                @foreach ($linked_users as $linked_user)
                    <div class="col s8 m10">
                        <a class="no-underline" href="/user/{{$linked_user->id}}">
                            <div class="card linked-account">
                                <div class="card-content">
                                    <h5>{{$linked_user->email}}</h5>
                                    <p>Created On: {{$linked_user->created_at->format('m/d/Y')}}</p>
                                    <p>Last Login On: {{$linked_user->last_login_at->format('m/d/Y')}}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @can('link-accounts')
                        <div class="col s4 m2">
                            <a href="/admin/user/unlink-account/{{$linked_user->id}}" id="unlink-account" class="btn btn-small sbs-red" data-user-email="{{$linked_user->email}}" style="margin-top:50px;height:50px;line-height: 49px;"><i class="fa fa-times"></i> Unlink</a>
                        </div>
                    @endcan
                @endforeach
                </div>
            @else
                <p>No accounts are linked.</p>
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
