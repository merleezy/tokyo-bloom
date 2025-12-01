<?php
declare(strict_types=1);

namespace App\Services;

class Validator
{
  private array $errors = [];

  public function validate(array $data, array $rules): bool
  {
    $this->errors = [];

    foreach ($rules as $field => $ruleSet) {
      $value = $data[$field] ?? null;
      $ruleList = is_string($ruleSet) ? explode('|', $ruleSet) : $ruleSet;

      foreach ($ruleList as $rule) {
        $this->applyRule($field, $value, $rule);
      }
    }

    return empty($this->errors);
  }

  private function applyRule(string $field, mixed $value, string $rule): void
  {
    [$ruleName, $param] = array_pad(explode(':', $rule, 2), 2, null);

    match ($ruleName) {
      'required' => $this->validateRequired($field, $value),
      'email' => $this->validateEmail($field, $value),
      'min' => $this->validateMin($field, $value, (int) $param),
      'max' => $this->validateMax($field, $value, (int) $param),
      'numeric' => $this->validateNumeric($field, $value),
      'integer' => $this->validateInteger($field, $value),
      'phone' => $this->validatePhone($field, $value),
      'date' => $this->validateDate($field, $value),
      'time' => $this->validateTime($field, $value),
      'url' => $this->validateUrl($field, $value),
      default => null,
    };
  }

  private function validateRequired(string $field, mixed $value): void
  {
    if ($value === null || $value === '' || (is_array($value) && empty($value))) {
      $this->errors[$field][] = "{$field} is required.";
    }
  }

  private function validateEmail(string $field, mixed $value): void
  {
    if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
      $this->errors[$field][] = "{$field} must be a valid email address.";
    }
  }

  private function validateMin(string $field, mixed $value, int $min): void
  {
    if (is_string($value) && strlen($value) < $min) {
      $this->errors[$field][] = "{$field} must be at least {$min} characters.";
    } elseif (is_numeric($value) && $value < $min) {
      $this->errors[$field][] = "{$field} must be at least {$min}.";
    }
  }

  private function validateMax(string $field, mixed $value, int $max): void
  {
    if (is_string($value) && strlen($value) > $max) {
      $this->errors[$field][] = "{$field} must not exceed {$max} characters.";
    } elseif (is_numeric($value) && $value > $max) {
      $this->errors[$field][] = "{$field} must not exceed {$max}.";
    }
  }

  private function validateNumeric(string $field, mixed $value): void
  {
    if ($value !== null && $value !== '' && !is_numeric($value)) {
      $this->errors[$field][] = "{$field} must be numeric.";
    }
  }

  private function validateInteger(string $field, mixed $value): void
  {
    if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_INT)) {
      $this->errors[$field][] = "{$field} must be an integer.";
    }
  }

  private function validatePhone(string $field, mixed $value): void
  {
    if ($value !== null && $value !== '' && !preg_match('/^[\d\s\-\(\)\+]+$/', (string) $value)) {
      $this->errors[$field][] = "{$field} must be a valid phone number.";
    }
  }

  private function validateDate(string $field, mixed $value): void
  {
    if ($value !== null && $value !== '' && !strtotime((string) $value)) {
      $this->errors[$field][] = "{$field} must be a valid date.";
    }
  }

  private function validateTime(string $field, mixed $value): void
  {
    if ($value !== null && $value !== '' && !preg_match('/^([01]?\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', (string) $value)) {
      $this->errors[$field][] = "{$field} must be a valid time (HH:MM or HH:MM:SS).";
    }
  }

  private function validateUrl(string $field, mixed $value): void
  {
    if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_URL)) {
      $this->errors[$field][] = "{$field} must be a valid URL.";
    }
  }

  public function errors(): array
  {
    return $this->errors;
  }

  public function firstError(string $field): ?string
  {
    return $this->errors[$field][0] ?? null;
  }

  public function hasErrors(): bool
  {
    return !empty($this->errors);
  }
}
