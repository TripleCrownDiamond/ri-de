<?php

namespace App\Services;

use App\Models\Order;
use App\Models\CompanyInfo;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;

class InvoiceService
{
    public function generateInvoice(Order $order)
    {
        $company_info = CompanyInfo::first();
        
        $html = View::make('pdf.invoice', [
            'order' => $order,
            'company_info' => $company_info
        ])->render();

        $mpdf = new Mpdf([
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'format' => 'A4',
            'tempDir' => storage_path('app/mpdf'),
        ]);

        // Ensure temp directory exists
        if (!file_exists(storage_path('app/mpdf'))) {
            mkdir(storage_path('app/mpdf'), 0777, true);
        }

        $mpdf->WriteHTML($html);
        
        $fileName = 'Rechnung-' . $order->id . '.pdf';
        
        return [
            'content' => $mpdf->Output('', 'S'),
            'file_name' => $fileName
        ];
    }
}
