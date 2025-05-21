<?php
include 'includes/session.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Voting Results');

// Set column headings
$sheet->setCellValue('A1', 'Position');
$sheet->setCellValue('B1', 'Candidate');
$sheet->setCellValue('C1', 'Votes');

// Load data from database
$data = array();
$sql = "SELECT * FROM positions ORDER BY priority ASC";
$query = $conn->query($sql);
$rowIndex = 2;
while ($row = $query->fetch_assoc()) {
    $position = $row['description'];
    $sql = "SELECT * FROM candidates WHERE position_id = '" . $row['id'] . "'";
    $cquery = $conn->query($sql);
    while ($crow = $cquery->fetch_assoc()) {
        $candidate = $crow['fullname'];
        $sql = "SELECT * FROM votes WHERE candidate_id = '" . $crow['id'] . "'";
        $vquery = $conn->query($sql);
        $votes = $vquery->num_rows;
        $sheet->setCellValue('A' . $rowIndex, $position);
        $sheet->setCellValue('B' . $rowIndex, $candidate);
        $sheet->setCellValue('C' . $rowIndex, $votes);
        $data[] = array($position, $candidate, $votes);
        $rowIndex++;
    }
}

// Create a new worksheet for the detailed votes data
$spreadsheet->createSheet();
$spreadsheet->setActiveSheetIndex(1);
$detailSheet = $spreadsheet->getActiveSheet();
$detailSheet->setTitle('Detailed Votes');

// Set column headings for the detailed votes data
$detailSheet->setCellValue('A1', 'Position');
$detailSheet->setCellValue('B1', 'Candidate');
$detailSheet->setCellValue('C1', 'Voter');
$detailSheet->setCellValue('D1', 'NIM');

// Load detailed votes data from database
$sql = "SELECT positions.description AS position, candidates.fullname AS candidate, voters.fullname AS voter_fullname, voters.nim AS voter_nim 
        FROM votes 
        LEFT JOIN positions ON positions.id = votes.position_id 
        LEFT JOIN candidates ON candidates.id = votes.candidate_id 
        LEFT JOIN voters ON voters.id = votes.voters_id 
        ORDER BY positions.priority ASC, candidates.fullname ASC";
$query = $conn->query($sql);
$rowIndex = 2;
while ($row = $query->fetch_assoc()) {
    $position = $row['position'];
    $candidate = $row['candidate'];
    $voter = $row['voter_fullname'];
    $nim = $row['voter_nim'];
    $detailSheet->setCellValue('A' . $rowIndex, $position);
    $detailSheet->setCellValue('B' . $rowIndex, $candidate);
    $detailSheet->setCellValue('C' . $rowIndex, $voter);
    $detailSheet->setCellValue('D' . $rowIndex, $nim);
    $rowIndex++;
}

// Set the active sheet back to the first sheet
$spreadsheet->setActiveSheetIndex(0);

// Save the spreadsheet
$writer = new Xlsx($spreadsheet);
$filename = 'Voting_Results.xlsx';

// Output the file to the browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>