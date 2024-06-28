<?php

    namespace Wixnit\Archive;

    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\GuzzleException;

    class Archive
    {
        private string $URI = "";
        public string $Key = "";


        public function __construct(string $URI, string $key = "")
        {
            $this->URI = $URI;
            $this->Key = $key;
        }

        public function Create(string $name): bool
        {
            $ret = false;

            $client = new Client();

            try{
                $response = $client->request('POST', $this->URI."/v1/archive", [
                    'form_params' => [
                        'name' => $name,
                    ],
                    'http_errors'=> false,
                ]);

                if($response->getStatusCode() == 200)
                {
                    $content = json_decode($response->getBody()->getContents());
                    $this->Key = $content->data;
                    $ret = true;
                }
            }
            catch (\Exception|GuzzleException $e){}

            return $ret;
        }

        public function Search(string $term): array
        {
            $ret = [];

            return $ret;
        }
        public function CreateIntent(string $fileName, bool $isPrivate = false, string $content = null, string $expiry_date = null, string $life_span = null): ?UploadIntent
        {
            $client = new Client();

            try{
                $response = $client->request("GET", $this->URI."/v1/upload/init", [
                    "query" => [
                        "key"=> $this->Key,
                        "file_name" => $fileName,
                        "is_private" => $isPrivate,
                        "content"=> $content,
                        "expiry_date"=> $expiry_date,
                        "life_span"=> $life_span,
                    ],
                    'http_errors'=> false,
                ]);

                if($response->getStatusCode() == 200)
                {
                    $content = json_decode($response->getBody()->getContents());

                    if($content->status == "success")
                    {
                        $intent = new UploadIntent();
                        $intent->FileName = $content->data->file_name;
                        $intent->Token = $content->data->token;

                        return $intent;
                    }
                }
            }
            catch (\Exception|GuzzleException $e){}

            return null;
        }
    }