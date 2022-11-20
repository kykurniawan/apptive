<?php

namespace Apptive\Core\Brains;

class Request
{
    public static function input()
    {
        $input = file_get_contents('php://input');
        $type = Request::header('Content-Type');
        if ($type == 'application/json') {
            return json_decode($input, true);
        }

        if (
            $type == 'text/plain'
            || $type == 'text/html'
            || $type == 'application/xml'
            || $type == 'application/javascript'
        ) {
            return $input;
        }

        if (strpos('multipart/form-data', $type) == 0) {
            return Request::post();
        }

        if ($type = 'application/x-www-form-urlencoded') {
            parse_str($input, $output);
            return $output;
        }
    }

    public static function file($key = null)
    {
        if (is_null($key)) {
            $files = [];
            foreach ($_FILES as $key => $value) {
                $files[$key] = static::file($key);
            }

            return $files;
        }

        return new class($key)
        {
            protected
                $originalName,
                $tmpName,
                $ext,
                $type,
                $size;

            public function __construct($key)
            {
                if (!isset($_FILES[$key])) {
                    return null;
                }

                $file = $_FILES[$key];

                $this->originalName = $file['name'];
                $this->tmpName = $file['tmp_name'];
                $this->ext = pathinfo($this->originalName, PATHINFO_EXTENSION);
                $this->type = $file['type'];
                $this->size = $file['size'];
            }

            public function originalName()
            {
                return $this->originalName();
            }

            public function tmpName()
            {
                return $this->tmpName;
            }

            public function name()
            {
                return uniqid('', true) . '.' . $this->ext;
            }

            public function ext()
            {
                return $this->ext;
            }

            public function type()
            {
                return $this->type;
            }

            public function size()
            {
                return $this->size;
            }

            public function move(string $path, $name = null)
            {
                if (!file_exists($path)) {
                    throw new \Exception('File path is not exists');
                }

                if (!is_dir($path)) {
                    throw new \Exception('File path is not a directory');
                }

                if (!is_writeable($path)) {
                    throw new \Exception('File path is not writeable, please check the permission');
                }

                $fileName = $this->name();

                if ($name) {
                    $fileName = $name;
                }

                $to = preg_replace('#/+#', '/', $path . '/' . $fileName);

                if (move_uploaded_file($this->tmpName(), $to)) {
                    return $fileName;
                }

                return null;
            }
        };
    }

    public static function header($key = null)
    {
        $headers = [];
        foreach (getallheaders() as $k => $v) {
            $headers[strtolower($k)] = $v;
        }

        if ($key) {
            if (isset($headers[strtolower($key)])) {
                return $headers[strtolower($key)];
            }
            return null;
        }

        return $headers;
    }

    public static function method($method = null)
    {
        if ($method) {
            if (strtolower($method) === strtolower($_SERVER['REQUEST_METHOD'])) {
                return true;
            }
            return false;
        }
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public static function query($key = null)
    {
        if ($key) {
            if (isset($_GET[$key])) {
                return $_GET[$key];
            }
            return null;
        }
        return $_GET;
    }

    public static function post($key = null)
    {
        if ($key) {
            if (isset($_POST[$key])) {
                return $_POST[$key];
            }
            return null;
        }

        return $_POST;
    }
}
