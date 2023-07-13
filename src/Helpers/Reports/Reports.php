<?php

namespace Amazon\SpApi\Helpers\Reports;

use Amazon\SpApi\AseCryptoStream;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Class Reports
 * @package Amazon\SpApi\Helpers\Feeds
 */
class Reports
{
    /**
     * @param $payload
     * @return mixed : Processing Report.
     */
    public function downloadReportProcessingReport($payload)
    {
        // 定义参数
        $key = null;
        $initializationVector = null;

        // check if decryption in required
        if (isset($payload['encryption_details'])) {
            $key = $payload['encryption_details']['key'];
            $initializationVector = $payload['encryption_details']['initialization_vector'];

            // base64 decode before using in encryption
            $initializationVector = base64_decode($initializationVector, true);
            $key = base64_decode($key, true);
        }

        // 获取url
        $url = $payload['url'] ?? '';

        // 是否存在秘钥
        if(is_null($key))
            $feed_processing_report_content = file_get_contents($url);
        else
            $feed_processing_report_content = ASECryptoStream::decrypt(file_get_contents($url), $key, $initializationVector);

        // 是否设置了压缩方式
        if(isset($payload['compressionAlgorithm']) && $payload['compressionAlgorithm'] == 'GZIP')
            $feed_processing_report_content = gzdecode($feed_processing_report_content);

        // 去除换行符
        $lines = explode("\n", $feed_processing_report_content);

        // Get the column headers from the first line
        $headers = explode("\t", $lines[0]);

        // Initialize an empty array to store the parsed data
        $data = [];

        // Process each line (starting from the second line)
        $count = count($lines);
        for ($i = 1; $i < $count; $i++) {
            // Split the line into individual values
            $values = explode("\t", $lines[$i]);
            // Create an associative array by combining the headers and values
            if(count($headers) != count($values))
                continue;
            $row = array_combine($headers, $values);
            // Add the row to the data array
            $data[] = $row;
        }
        return $data;
    }
}
