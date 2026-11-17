<?php
namespace App\Support;

use \GuzzleHttp\Client;

class Esms
{
    const API_KEY = '';
    const SECRET_KEY = '';
    const BASE_URL = '';
    const BRANDNAME = '';

    private $apiKey;
    private $secretKey;
    private $baseUrl = '';
    private $brandName = '';

    public function __construct()
    {
        $this->apiKey = env('ESMS_API_KEY');
        $this->secretKey = env('ESMS_SECRET_KEY');
        $this->brandName = env('ESMS_BRANDNAME', '');
    }

    /**
     * Gửi tin SMS quảng cáo (SmsType = 1) tới danh sách số điện thoại.
     * eSMS yêu cầu tối thiểu 30 số và tối đa 5000 số mỗi request, brandname phải đã đăng ký.
     *
     * @return array ['ok' => bool, 'message' => string]
     */
    public function sendAdvertising(array $phones, string $content): array
    {
        $phones = array_values(array_unique(array_filter($phones)));
        if (count($phones) < 30) {
            return ['ok' => false, 'message' => 'eSMS yêu cầu tối thiểu 30 số cho tin quảng cáo, hiện chỉ có ' . count($phones) . ' số.'];
        }

        $httpClient = new Client();
        $response = $httpClient->post('https://rest.esms.vn/MainService.svc/json/SendMultipleSMSBrandname_json/', [
            'json' => [
                'ApiKey' => $this->apiKey,
                'SecretKey' => $this->secretKey,
                'Phones' => array_slice($phones, 0, 5000),
                'Content' => $content,
                'SmsType' => '1',
                'Brandname' => $this->brandName,
            ],
            'http_errors' => false,
        ]);
        $results = json_decode((string) $response->getBody(), true);
        $code = $results['CodeResult'] ?? null;

        if ((string) $code === '100') {
            return ['ok' => true, 'message' => 'Đã gửi SMS tới ' . count($phones) . ' số.'];
        }
        return ['ok' => false, 'message' => 'eSMS trả về mã lỗi ' . $code . ': ' . ($results['ErrorMessage'] ?? 'không rõ')];
    }

    public function getBalance()
    {
        $httpClient = new Client();
        $response = $httpClient->get($this->baseUrl . 'GetBalance/' . $this->apiKey . '/' . $this->secretKey);
        echo $response->getStatusCode();
    }

    public function sendOtp($phone_number, $content)
    {
        $content = "Ma xac thuc cua ban la: $content";
        $httpClient = new Client();
        $response = $httpClient->get($this->baseUrl . 'SendMultipleMessage_V4_get?Phone=' . $phone_number . '&Content=' . $content . '&ApiKey=' . $this->apiKey . '&SecretKey=' . $this->secretKey . '&SmsType=2&Brandname=' . $this->brandName);
        $results = json_decode((string) $response->getBody(), true);
        if ($results['CodeResult'] == 100) {
            return true;
        }
        return false;
    }
}