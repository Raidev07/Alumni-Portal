<?php

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// CREATE SPREADSHEET
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// HEADERS
$headers = [
    'School Number',
    'First Name',
    'Middle Name',
    'Surname',
    'Suffix',
    'Email',
    'Phone',
    'Address',
    'Birthdate',
    'Sex',
    'Department',
    'Course Code',
    'Year Graduated'
];

// ADD HEADERS
$column = 'A';

foreach ($headers as $header) {
    $sheet->setCellValue($column . '1', $header);
    $column++;
}

// SAMPLE DATA OPTIONAL
// $sample = [
//     '2020-0001',
//     'Juan',
//     'Santos',
//     'Dela Cruz',
//     '',
//     'juan@example.com',
//     '09123456789',
//     'Quezon City',
//     '2000-01-15',
//     'Male',
//     'College of Computer Studies',
//     'BSIT',
//     '2024'
// ];

$column = 'A';

// foreach ($sample as $value) {
//     $sheet->setCellValue($column . '2', $value);
//     $column++;
// }

// AUTO SIZE
foreach (range('A', 'M') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// DOWNLOAD FILE
$filename = "alumni_import_template.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

exit;
?>