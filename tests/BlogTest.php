<?php

use Lesstif\NaverBlogApi\HttpClient;

class BlogTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {

    }

    public function testSearchCategory()
    {
        //$token = env("YOUR_ACCESS_TOKEN"); // 네이버 로그인 API호출로 받은 접근 토큰값
        /*
        $header = "Bearer ".$token; // Bearer 다음에 공백 추가
        $url = "https://openapi.naver.com/blog/listCategory.json";
        $is_post = false;
        */

        //HttpClient
        $h = new HttpClient();

        $ret = $h->getCategory();

        var_dump($ret);

            /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $headers[] = "Authorization: ".$header;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo "status_code:".$status_code."";
        curl_close ($ch);

        if($status_code == 200) {
            echo $response;
        } else {
            echo "Error 내용:".$response;
        }
            */
    }
}
