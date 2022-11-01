<?php
defined('APP') or exit('Access denied');

class Validator
{
    private $results = [];
    private $errors = [];

    public function validate($rules = [])
    {
        foreach ($rules as $key => $value) {
            foreach ($value as $rule) {
                $result = $rule($key);
                if ($result['success']) {
                    $this->results[$key] = $result['validated'];
                } else {
                    $this->errors[$key] = $result['error'];
                }
            }
        }
    }

    public function fails()
    {
        return sizeof($this->errors) !== 0;
    }

    public function results()
    {
        return $this->results;
    }

    public function errors()
    {
        return $this->errors;
    }
}

function required(string $message = null)
{
    return function ($key) use ($message) {
        if (!isset($_POST[$key]) || $_POST[$key] == '') {
            return [
                'success' => false,
                'validated' => null,
                'error' => ($message) ? $message : 'Field ' . $key . ' is required',
            ];
        }

        return [
            'success' => true,
            'validated' => $_POST[$key],
            'error' => null
        ];
    };
}

function max_char(int $max, string $message = null)
{
    return function ($key) use ($max, $message) {
        if (isset($_POST[$key])) {
            $value = (string) $_POST[$key];
            if (strlen($value) > $max) {
                return [
                    'success' => false,
                    'validated' => null,
                    'error' => ($message) ? $message : $key . ' field can\'t be more than ' . $max . ' characters',
                ];
            }

            return [
                'success' => true,
                'validated' => $_POST[$key],
                'error' => null
            ];
        }
    };
}

function unique(string $table, string $column,  $ignore = null, string $message = null)
{
    return function ($key) use ($table, $column, $ignore, $message) {
        if (isset($_POST[$key])) {
            $value = $_POST[$key];
            $db = Database::getConnection();
            $query = "SELECT * FROM $table WHERE $column=?";
            if ($ignore) {
                $query .= ' AND id != ?';
            }
            $query .= ' LIMIT 1';

            $stmt = $db->prepare($query);
            $stmt->bindValue(1, $value);
            if ($ignore) {
                $stmt->bindValue(2, $ignore);
            }

            $stmt->execute();

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($result) {
                return [
                    'success' => false,
                    'validated' => null,
                    'error' => ($message) ? $message : $key . ': ' . $value . ' already taken',
                ];
            }

            return [
                'success' => true,
                'validated' => $value,
                'error' => null
            ];
        }
    };
}

function in(array $array, $message = null)
{
    return function ($key) use ($array, $message) {
        if (isset($_POST[$key])) {
            $value = $_POST[$key];
            if (!in_array($value, $array)) {
                return [
                    'success' => false,
                    'validated' => null,
                    'error' => ($message) ? $message : $key . ' is invalid',
                ];
            }

            return [
                'success' => true,
                'validated' => $value,
                'error' => null
            ];
        }
    };
}
