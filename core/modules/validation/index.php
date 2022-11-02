<?php

class ValidationResult
{
    public $success,
        $errorMessage,
        $original,
        $validated;

    public function __construct($success, $errorMessage, $original, $validated)
    {
        $this->success = $success;
        $this->errorMessage = $errorMessage;
        $this->original = $original;
        $this->validated = $validated;
    }
}

function validation_result(bool $success, ?string $errorMessage = null, $original = null, $validated = null)
{
    return new ValidationResult($success, $errorMessage, $original, $validated);
}

function validate(array $rules = [])
{
    return new class($rules)
    {
        private $results = [];
        private $errors = [];

        public function __construct(array $rules = [])
        {
            foreach ($rules as $key => $value) {
                foreach ($value as $rule) {
                    $result = $rule($key);
                    if ($result instanceof ValidationResult === false) {
                        throw new Exception('Validation rule must return object with type ' . ValidationResult::class);
                    }
                    if ($result->success) {
                        $this->results[$key] = $result->validated;
                    } else {
                        $this->errors[$key] = $result->errorMessage;
                    }
                    set_flash('old__' . $key, $result->original);
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
    };
}

function required(string $message = null)
{
    return function ($key) use ($message) {
        if (!isset($_POST[$key]) || $_POST[$key] == '') {
            return validation_result(
                false,
                ($message) ? $message : 'Field ' . $key . ' is required',
                $_POST[$key],
                null
            );
        }

        return validation_result(
            true,
            null,
            $_POST[$key],
            $_POST[$key],
        );
    };
}

function max_char(int $max, string $message = null)
{
    return function ($key) use ($max, $message) {
        if (isset($_POST[$key])) {
            $value = (string) $_POST[$key];
            if (strlen($value) > $max) {
                return validation_result(
                    false,
                    ($message) ? $message : 'Field ' . $key . ' can\'t be more than ' . $max . ' characters',
                    $_POST[$key],
                    null,
                );
            }

            return validation_result(
                true,
                null,
                $_POST[$key],
                $_POST[$key],
            );
        }
    };
}

function unique(string $table, string $column,  $ignore = null, string $message = null)
{
    return function ($key) use ($table, $column, $ignore, $message) {
        if (isset($_POST[$key])) {
            $value = $_POST[$key];
            $db = database();
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
                return validation_result(
                    false,
                    ($message) ? $message : ucwords($key) . ' ' . $value . ' already taken',
                    $_POST[$key],
                    null
                );
            }

            return validation_result(
                true,
                null,
                $_POST[$key],
                $_POST[$key],
            );
        }
    };
}

function in(array $array, $message = null)
{
    return function ($key) use ($array, $message) {
        if (isset($_POST[$key])) {
            $value = $_POST[$key];
            if (!in_array($value, $array)) {
                return validation_result(
                    false,
                    ($message) ? $message : 'Field ' . $key . ' is invalid',
                    $_POST[$key],
                    null,
                );
            }

            return validation_result(
                true,
                null,
                $_POST[$key],
                $_POST[$key],
            );
        }
    };
}
