<x-layouts.mail.default>
    <p>Hi <strong>{{ $order->user->bussinesses->name ?? '' }}</strong>,</p>
    <p>Thank you for your order. Your order has been successfully created and is currently <strong>awaiting
            payment</strong>.</p>


    <p><strong>Order Details:</strong></p>
    <ul>
        <li><strong>Order Number:</strong> {{ $order->transaction_number ?? '' }}</li>
        <li><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y H:i') ?? '' }}</li>
        <li><strong>Shipping Date:</strong> {{ $order->shipping_date->format('F j, Y') ?? '' }}</li>
        <li><strong>Total Amount:</strong> Rp. {{ number_format($order->total ?? 0, 2, ',', '.') }}</li>
    </ul>


    <p>Please complete your payment using the following link:</p>
    <p><a href=" {{ route('checkout', $order->slug ?? '') }}">Complete Payment</a></p>


    <p>If you need help, contact us at <a href="mailto:csb2b@sevenambakers.com">csb2b@sevenambakers.com</a>.
    </p>
    <p>Thank you for choosing 7AM Bakers Club</p>
</x-layouts.mail.default>
