<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Rechnung - {{ $order->id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .logo { max-width: 150px; }
        .company-info { float: right; text-align: right; }
        .customer-info { margin-bottom: 30px; }
        .order-details { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .order-details th, .order-details td { border: 1px solid #eee; padding: 10px; text-align: left; }
        .order-details th { background-color: #f9f9f9; }
        .total { text-align: right; font-weight: bold; font-size: 14px; }
        .footer { margin-top: 50px; font-size: 10px; text-align: center; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <strong>{{ $company_info->name ?? 'Remorques Industrie' }}</strong><br>
            {{ $company_info->address ?? 'N/A' }}<br>
            {{ $company_info->phone ?? 'N/A' }}<br>
            {{ $company_info->email_contact ?? 'N/A' }}
        </div>
        <div class="logo">
            {{-- Image base64 if possible or just text --}}
            <h1>RECHNUNG</h1>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="customer-info">
        <strong>Rechnung an:</strong><br>
        {{ $order->customer_name }}<br>
        {{ $order->customer_address ?? 'N/A' }}<br>
        {{ $order->customer_email }}<br>
        {{ $order->customer_phone ?? 'N/A' }}
    </div>

    <div>
        <strong>Bestelldatum:</strong> {{ $order->created_at->format('d.m.Y') }}<br>
        <strong>Bestellnummer:</strong> #{{ $order->id }}
    </div>

    <table class="order-details">
        <thead>
            <tr>
                <th>Produkt</th>
                <th>SKU</th>
                <th>Menge</th>
                <th>Einzelpreis</th>
                <th>Gesamt</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @if($order->product_image)
                    <img src="{{ $order->product_image }}" style="max-width: 50px; display: block; margin-bottom: 5px;">
                    @endif
                    {{ $order->product_name }}
                </td>
                <td>{{ $order->sku }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ number_format($order->product_price, 2, ',', '.') }} €</td>
                <td>{{ number_format($order->product_price * $order->quantity, 2, ',', '.') }} €</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold; border: none; padding-top: 20px;">GESAMTSUMME:</td>
                <td style="font-weight: bold; border: none; padding-top: 20px; font-size: 1.2em; color: #d00;">{{ number_format($order->product_price * $order->quantity, 2, ',', '.') }} €</td>
            </tr>
        </tfoot>
    </table>

    {{-- <div class="total">Gesamtbetrag: - €</div> --}}

    @if($order->message)
    <div style="margin-top: 20px;">
        <strong>Anmerkung:</strong><br>
        {{ $order->message }}
    </div>
    @endif

    <div class="footer">
        <p>Vielen Dank für Ihre Bestellung!</p>
        <p>{{ $company_info->name ?? 'Remorques Industrie' }} - {{ $company_info->address ?? '' }}</p>
    </div>
</body>
</html>
