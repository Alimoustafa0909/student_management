<?php

class Validator
{
    public static function validateStudent($name, $email, $gender, $phone)
    {
        if (!$name || !$email || !$gender || !$phone) {
            return "All fields are required.";
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            return "Name must contain only letters.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        }

        if (!in_array($gender, ['Male', 'Female'])) {
            return "Please select a gender.";
        }

        if (!preg_match('/^[0-9]{1,12}$/', $phone)) {
            return "Phone must be Number and up to 12 number.";
        }

        return null;
    }
}
