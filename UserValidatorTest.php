<?php

use PHPUnit\Framework\TestCase;

require_once 'UserValidator.php'; // Ścieżka do klasy UserValidator

class UserValidatorTest extends TestCase
{
    private UserValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new UserValidator();
    }

    /**
     * Testy poprawnych adresów e-mail
     */
    public function testValidateEmail_ValidEmails()
    {
        $this->assertTrue($this->validator->validateEmail('test@example.com'), 'Failed: test@example.com');
        $this->assertTrue($this->validator->validateEmail('user.name+tag+sorting@example.com'), 'Failed: user.name+tag+sorting@example.com');
        $this->assertTrue($this->validator->validateEmail('x@example.com'), 'Failed: x@example.com');
        $this->assertTrue($this->validator->validateEmail('user@sub.example.co.uk'), 'Failed: user@sub.example.co.uk');
    }

    /**
     * Testy niepoprawnych adresów e-mail
     */
    public function testValidateEmail_InvalidEmails()
    {
        $this->assertFalse($this->validator->validateEmail('plainaddress'), 'Failed: plainaddress');
        $this->assertFalse($this->validator->validateEmail('missingatsign.com'), 'Failed: missingatsign.com');
        $this->assertFalse($this->validator->validateEmail('user@.com'), 'Failed: user@.com');
        $this->assertFalse($this->validator->validateEmail('username@com.'), 'Failed: username@com.');
        $this->assertFalse($this->validator->validateEmail('username@com@com.com'), 'Failed: username@com@com.com');
    }

    /**
     * Testy poprawnych haseł
     */
    public function testValidatePassword_ValidPasswords()
    {
        $this->assertTrue($this->validator->validatePassword('StrongPass1!'), 'Failed: StrongPass1!');
        $this->assertTrue($this->validator->validatePassword('Password123#'), 'Failed: Password123#');
        $this->assertTrue($this->validator->validatePassword('Valid1#Pass'), 'Failed: Valid1#Pass');
        $this->assertTrue($this->validator->validatePassword('S3Cur3!Pass'), 'Failed: S3Cur3!Pass'); // Poprawione z S3cur3! na S3Cur3!Pass
    }

    /**
     * Testy niepoprawnych haseł
     */
    public function testValidatePassword_InvalidPasswords()
    {
        $this->assertFalse($this->validator->validatePassword('short1!'), 'Failed: short1!'); // Zbyt krótkie
        $this->assertFalse($this->validator->validatePassword('alllowercase1!'), 'Failed: alllowercase1!'); // Brak wielkich liter
        $this->assertFalse($this->validator->validatePassword('ALLUPPERCASE1!'), 'Failed: ALLUPPERCASE1!'); // Brak małych liter
        $this->assertFalse($this->validator->validatePassword('NoDigitsOrSpecials'), 'Failed: NoDigitsOrSpecials'); // Brak cyfr i znaków specjalnych
        $this->assertFalse($this->validator->validatePassword('12345678!'), 'Failed: 12345678!'); // Brak liter
    }

    /**
     * Testy przypadków granicznych dla hasła
     */
    public function testValidatePassword_BorderCases()
    {
        // Hasło na minimalną długość 8 znaków spełniające wszystkie kryteria
        $this->assertTrue($this->validator->validatePassword('Ab1!abcD'), 'Failed: Ab1!abcD');
        
        // Zbyt krótkie hasło
        $this->assertFalse($this->validator->validatePassword('Ab1!abc'), 'Failed: Ab1!abc');
    }
}

