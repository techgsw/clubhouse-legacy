@component('emails.layout')
    @slot ('title')
        Career Service Purchase Notification - theClubhouse®
    @endslot
    @php $date = new DateTime('NOW'); @endphp
    @slot('body')
        <p>Hey <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team,</p>
        @if ($type == 'career-service')
            <p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} ({{ $user->email }}) just purchased a career service.</p>
        @elseif ($type == 'webinar')
            <p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} ({{ $user->email }}) just RSVP'd for a webinar.</p>
        @elseif ($type == 'membership')
            <p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} ({{ $user->email }}) just signed up to be a Clubhouse Pro.</p>
        @elseif ($type == 'premium-job')
            <p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} ({{ $user->email }}) just purchased a premium job.</p>
        @elseif ($type == 'premium-job-upgrade')
            <p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} ({{ $user->email }}) just purchased a premium job upgrade.</p>
        @elseif ($type == 'platinum-job')
            <p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} ({{ $user->email }}) just purchased a platinum job.</p>
        @elseif ($type == 'platinum-job-upgrade')
            <p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} ({{ $user->email }}) just purchased a platinum job upgrade.</p>
        @endif
        <p><strong>Summary:</strong></p>
        <table style="width: 100%; text-align: left; font-size: 14px;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tr>
                <td>{{ $date->format('Y-m-d') }}</td>
                <td>{{ $product_option->product->name }}</td>
                @if (in_array($type, array('career-service', 'premium-job', 'premium-job-upgrade', 'platinum-job', 'platinum-job-upgrade')))
                    <td>{{ money_format('%.2n', $amount) }}</td>
                @else
                    <td>N/A</td>
                @endif
            </tr>
        </table>
        <br />
        <p>Thanks,<br/><span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> App</p>
    @endslot
@endcomponent
