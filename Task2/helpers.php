<?php
function get_exception_message(string $err_code,string $field_name){
   
    $error_messages = [
        '23000' => 'The entry in the field "%s" already exists in the database. Please check your input.',
        '42000' => 'There was an error with the SQL syntax.',
        '42S02' => 'The requested table was not found.',
        '42S22' => 'The specified column "%s" does not exist in the database.',
        '28000' => 'Database access denied. Check your permissions.',
        'HYT00' => 'The database operation timed out. Try again later.',
    ];

    // Retrieve the message template based on the error code
    $message_template = $error_messages[$err_code] ?? 'An unexpected error occurred. Please try again later.';

    // If a field name is provided, format the message
    return $field_name ? sprintf($message_template, $field_name) : $message_template;
}

?>