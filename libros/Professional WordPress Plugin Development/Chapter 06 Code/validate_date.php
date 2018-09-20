<?php

// Validate future dates like mm/dd/yyyy.
// Returns true or an error message
function boj_validate_date( $date ) {
    // first test: pattern matching
    if( !preg_match( '!\d{2}/\d{2}/\d{4}!', $date ) )
        return 'wrong pattern';
    
    // second test: is date valid?
    $timestamp = strtotime( $date );
    if( !$ timestamp )
        return 'date invalid';
    
    // third test: is the date from the past?
    if( $timestamp <= time() )
        return 'past date';

    // So far, so good
    return true;
}

// Test it:

var_dump( boj_validate_date( '12/12/99' ) );
// string(12) "wrong pattern"

var_dump( boj_validate_date( '35/30/1980' ) );
// string(12) "date invalid"

var_dump( boj_validate_date( '03/30/1980' ) );
// string(9) "past date"

var_dump( boj_validate_date( '03/30/2020' ) );
// bool(true)

