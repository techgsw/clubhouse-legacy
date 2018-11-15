@component('emails.layout')
    @slot ('title')
        Payment Receipt - theClubhouse
    @endslot
    @php $date = new DateTime('NOW'); @endphp
    @slot('body')
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>Thank you for your purchase.</p>
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
                <td>{{ money_format('%.2n', $product_option->price) }}</td>
            </tr>
        </table>
        <br />
        <p>If you have any questions, please contact us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a></p>
        <p>Thanks,<br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent
