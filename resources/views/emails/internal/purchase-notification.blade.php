@component('emails.layout')
    @slot ('title')
        Purchase/RSVP Notification - theClubhouse
    @endslot
    @php $date = new DateTime('NOW'); @endphp
    @slot('body')
        <p>Hey <span style="color: #EB2935;">the</span>Clubhouse Team,</p>
        <p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} ({{ $user->email }}) just purchased or RSVP'd for a product.</p>
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
                <td>{{ money_format('%.2n', $amount) }}</td>
            </tr>
        </table>
        <br />
        <p>Thanks,<br/><span style="color: #EB2935;">the</span>Clubhouse App</p>
    @endslot
@endcomponent
