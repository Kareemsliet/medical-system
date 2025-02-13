<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DrugsController extends Controller
{
    public function fetchDrugs()
    {
        $url = "https://raw.githubusercontent.com/mohmedn424/Egypt-drugs-database/main/%28JSON%29%20New%20prices%20up%20to%2003-08-2024.json";
        $client = new Client();
        $response = $client->get($url);

        if ($response->getStatusCode() == 200) {
            $drugsData = $response->getBody()->getContents();
            Storage::put('drugs_prices.json', $drugsData);
            return "تم حفظ الملف بنجاح!";
        } else {
            return "حدث خطأ أثناء تحميل الملف.";
        }
    }
}
