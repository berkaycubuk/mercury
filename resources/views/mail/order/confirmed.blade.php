@component('mail::message')
Your order is confirmed!

Order details:
@component('mail::table')
| Product | Amount | Price |
|:------- |:------:| -----:|
@foreach($order->meta['items'] as $item)
| {{ $item['title'] }} | {{ $item['amount'] }} | {{ format_money($item['price'] * $item['amount']) }} |
@endforeach
| Shipping | | {{ format_money($order->meta['shipping_cost']) }} |
| Total | | {{ format_money($order->meta['total_price']) }} |
@endcomponent

Thanks,<br/>
{{ config('app.name') }}
@endcomponent
