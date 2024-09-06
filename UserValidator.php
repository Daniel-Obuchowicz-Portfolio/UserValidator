<?php

class UserValidator
{
    private const EMAIL_PATTERN = '/^[a-zA-Z]+[a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    private const PASSWORD_MIN_LENGTH = 8;
    private const UPPERCASE_PATTERN = '/[A-Z]/';
    private const LOWERCASE_PATTERN = '/[a-z]/';
    private const DIGIT_PATTERN = '/[0-9]/';
    private const SPECIAL_CHAR_PATTERN = '/[\W_]/';

    // Metoda do walidacji adresu e-mail
    public function validateEmail(string $email): bool
    {
        return $this->matchesPattern($email, self::EMAIL_PATTERN);
    }

    // Metoda do walidacji hasła
    public function validatePassword(string $password): bool
    {
        if (strlen($password) < self::PASSWORD_MIN_LENGTH) {
            return false;
        }

        // Sprawdzenie poszczególnych warunków
        $hasUppercase = preg_match(self::UPPERCASE_PATTERN, $password);
        $hasLowercase = preg_match(self::LOWERCASE_PATTERN, $password);
        $hasDigit = preg_match(self::DIGIT_PATTERN, $password);
        $hasSpecialChar = preg_match(self::SPECIAL_CHAR_PATTERN, $password);

        // Zwracamy true tylko wtedy, gdy wszystkie warunki są spełnione
        return $hasUppercase && $hasLowercase && $hasDigit && $hasSpecialChar;
    }

    // Metoda pomocnicza do sprawdzania wyrażenia regularnego
    private function matchesPattern(string $subject, string $pattern): bool
    {
        return preg_match($pattern, $subject) === 1;
    }
}

// Przykład użycia:
$validator = new UserValidator();

$email = "test@example.com";
$password = "StrongPass1!";

// Walidacja e-mail
if ($validator->validateEmail($email)) {
    echo "Email is valid.\n";
} else {
    echo "Email is invalid.\n";
}

// Walidacja hasła
if ($validator->validatePassword($password)) {
    echo "Password is valid.\n";
} else {
    echo "Password is invalid.\n";
}

