<?php
/**
 * Created by MrPowerUp82.
 */

namespace MrPowerUp\FilamentSqlField\Traits;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

trait ReportProcessing
{
    /**
     * Convert JSON data to an Excel sheet.
     *
     * @param string|array  $json_data The JSON data to convert. 
     * Example: [{"name": "John", "age": 30}, {"name": "Jane", "age": 25}]
     * @param string $filename The name of the Excel file to save.
     * @return string The URL of the generated Excel file.
     */
    public function jsonToSheet(string|array $json_data, string $filename='tabela.xlsx')
    {
        $filename = now()->format('YmdHis') . '_' . $filename;
        $sheetColumns =  range('A', 'Z');

        $data = is_string($json_data) ? json_decode($json_data, true) : $json_data;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set the header
        $i = 0;
        foreach (array_keys($data[0]) as $key) {
            $sheet->setCellValue($sheetColumns[$i] . '1', $key);
            $i++;
        }

        // Set the data
        foreach ($data as $rowIndex => $row) {
            $colIndex = 0;
            foreach ($row as $value) {
                try {
                    $sheet->setCellValue($sheetColumns[$colIndex] . ($rowIndex + 2), is_array($value) ? implode(",", $value) : $value);
                } catch (\Throwable $th) {
                    $sheet->setCellValue($sheetColumns[$colIndex] . ($rowIndex + 2), is_array($value) ? json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $value);
                }
                $colIndex++;
            }
        }

        // Save the file
        $path = storage_path('app/public/temp');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Convert to string interpolation.
        $filePath = "$path/$filename";
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
        // Convert to string interpolation.
        return asset("storage/temp/$filename?v=" . now()->format('YmdHis'));
    }

    /**
     * Convert JSON data to a CSV file.
     *
     * @param string|array  $json_data The JSON data to convert.
     * @param string $filename The name of the CSV file to save.
     * @return string The URL of the generated CSV file.
     */
    public function jsonToCsv(string|array $json_data, string $filename='tabela.csv')
    {
        $filename = now()->format('YmdHis') . '_' . $filename;
        $data = is_string($json_data) ? json_decode($json_data, true) : $json_data;
        $path = storage_path('app/public/temp');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $filePath = "$path/$filename";
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $file = fopen($filePath, 'w');
        fputcsv($file, array_keys($data[0]));
        foreach ($data as $row) {
            $row = array_map(function ($item) {
                return is_array($item) ? implode(",", $item) : $item;
            }, $row);
            fputcsv($file, $row, ";");
        }
        fclose($file);

        return asset("storage/temp/$filename?v=" . now()->format('YmdHis'));
    }

    /**
     * Save JSON data to a file.
     *
     * @param string|array  $json_data The JSON data to save.
     * @param string $filename The name of the JSON file to save.
     * @return string The URL of the generated JSON file.
     */
    public function jsonOnly(string|array $json_data, string $filename='report.json')
    {
        $json_data = is_string($json_data) ? $json_data : json_encode($json_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $filename = now()->format('YmdHis') . '_' . $filename;
        $path = storage_path('app/public/temp');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $filePath = "$path/$filename";
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        file_put_contents($filePath, $json_data);

        return asset("storage/temp/$filename?v=" . now()->format('YmdHis'));
    }

    public function isJson($string) {
        return preg_match('/^(?:\{.*\}|\[.*\])$/', $string);
    }
}
