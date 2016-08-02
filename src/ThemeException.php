<?php

namespace MauroMoreno\LaravelTheme;

/**
 * Define a custom exception class
 */
class ThemeException extends \Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $message = "$message, current Theme: [".\Theme::get()."]";

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
