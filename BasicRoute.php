<?php

namespace Main;
/**
 *  Author : Furkan DURA
 *  Github : https://github.com/furkandura
 */

class BasicRoute
{

    public $url;
    public $method;
    public $error = [];
    public $config;

    private const POST_ERROR = "POST methodu haricinde bir istek geldiği için istek geçersiz oldu.";
    private const GET_ERROR = "GET methodu haricinde bir istek geldiği için istek geçersiz oldu.";
    private const FILE_EXIT_ERROR = "Dosya yolu bulunamadı.";

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->url = $this->urlPrepare();
        $this->method = $_SERVER["REQUEST_METHOD"] ?? "GET";
    }

    /**
     * Get Method
     *
     * @param string $url
     * @param string $path
     * @return void
     */
    public function get(string $url, string $path)
    {
        if ($this->url == $url) {
            if ($this->method == "GET") {
                if (file_exists($this->filePathPrepare($path))) {
                    include $this->filePathPrepare($path);
                } else {
                    array_push($this->error, self::FILE_EXIT_ERROR);

                }
            } else {
                array_push($this->error, self::GET_ERROR);
            }
        }
    }

    /**
     * POST Method
     *
     * @param string $url
     * @param string $path
     * @return void
     */
    public function post(string $url, string $path)
    {
        if ($this->url == $url) {
            if ($this->method == "POST") {
                if (file_exists($this->filePathPrepare($path))) {
                    include $this->filePathPrepare($path);
                } else {
                    array_push($this->error, self::FILE_EXIT_ERROR);
                }
            } else {
                array_push($this->error, self::POST_ERROR);
            }
        }
    }

    /**
     * Deletes slash in url.
     *
     * @param string $url
     * @return string
     */
    public function slashClear(string $url): string
    {
        return substr($url, 1);
    }

    /**
     * Prepares the file path.
     *
     * @param string $path
     * @return string
     */
    public function filePathPrepare(string $path): string
    {
        return __DIR__ . "/" . str_replace(".", "/", $path) . ".php";
    }

    /**
     * Prepares the url.
     *
     * @return string
     */
    public function urlPrepare(): string
    {
        $_url = ($_SERVER["REQUEST_URI"] != "/") ? $_SERVER["REQUEST_URI"] : "";

        if (isset($this->config["SUB_FOLDER"])) {
            $_url = str_replace($this->config["SUB_FOLDER"] . "/", "", $_url);
        }

        return $this->slashClear($_url);
    }

    /**
     * @return array
     */
    public function getErrorMessage(): array
    {
        return (count($this->error) > 0) ? $this->error : [];
    }
}
