<?php
namespace Objects;

class MicroTranslate
{
    private $key = 'ENTER KEY HERE';
    private $host = "https://api.cognitive.microsofttranslator.com";
    private $path = "/translate?api-version=3.0";
    private $params = "&to=ru&to=en";

    public function setText($text)
    {
        $this->text = $text;
    }


    public function translateText ()
    {
        $result = $this->Translate ();
        $json = json_encode(json_decode($result), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        print_r($json);
    }


    private function Translate ()
    {
        $requestBody = array (
            array (
                'Text' => $this->text,
            ),
        );
        $content = json_encode($requestBody);
        $long = strlen($content);

        $headers = "Content-type: application/json\r\n" .
            "Content-length:0". $long. "\r\n" .//strlen($content) . "\r\n" .
            "Ocp-Apim-Subscription-Key: $this->key\r\n";// .
        $options = array (
            'http' => array (
                'method' => 'POST',
                'header' => $headers,
                'content' => $content
            )
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->host.$this->path.$this->params);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $options['http']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $err = curl_error($ch);

        $result = curl_exec($ch);
        curl_close ($ch);
        var_dump($result);
        if ($err) {
            echo $err;
        } else {
            return $result;
        }
    }

}
