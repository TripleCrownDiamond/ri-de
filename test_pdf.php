<?php

require 'vendor/autoload.php';

use Mpdf\Mpdf;

try {
    $mpdf = new Mpdf([
        'tempDir' => __DIR__ . '/storage/app/mpdf',
    ]);
    if (!file_exists(__DIR__ . '/storage/app/mpdf')) {
        mkdir(__DIR__ . '/storage/app/mpdf', 0777, true);
    }
    $mpdf->WriteHTML('<h1>Test PDF</h1>');
    $mpdf->Output('test.pdf', 'F');
    echo "PDF generated successfully\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
