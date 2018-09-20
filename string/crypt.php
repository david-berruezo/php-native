<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/06/2016
 * Time: 21:11
 */


/*
 * The crypt() function returns a hashed string using DES, Blowfish, or MD5 algorithms.
 * This function behaves different on different operating systems. PHP checks what algorithms are available and
 * what algorithms to use when it is installed.
 * The salt parameter is optional. However, crypt() creates a weak password without the salt.
 * Make sure to specify a strong enough salt for better security.
 * There are some constants that are used together with the crypt() function. The value of these constants are set
 * by PHP when it is installed.
 */


/*
 * [CRYPT_STD_DES] - Standard DES-based hash with two character salt from the alphabet "./0-9A-Za-z".
 * Using invalid characters in the salt will cause this function to fail.
 * [CRYPT_EXT_DES] - Extended DES-based hash with a nine character salt consisting of an underscore followed
 * by 4 bytes of iteration count and 4 bytes of salt. These are encoded as printable characters, 6 bits per character, least significant character first. The values 0 to 63 are encoded as "./0-9A-Za-z". Using invalid characters in the salt will cause the function to fail.
 * [CRYPT_MD5] - MD5 hashing with a 12 character salt starting with $1$
 * [CRYPT_BLOWFISH] - Blowfish hashing with a salt starting with $2a$,  $2x$, or $2y$, a two digit cost parameters
 * "$", and 22 characters from the alphabet "./0-9A-Za-z". Using characters outside of the alphabet will cause
 * this function to return a zero-length string. The "$" parameter is the base-2 logarithm of the iteration
 * count for the underlying Blowfish-bashed hashing algorithmeter and must be in range 04-31. Values outside
 * this range will cause the function to fail.
 * [CRYPT_SHA_256] - SHA-256 hash with a 16 character salt starting with  $5$. If the salt string
 * starts with "rounds=<N>$", the numeric value of N is used to indicate how many times
 * the hashing loop should be executed, much like the cost parameter on Blowfish. The default
 * number of rounds is 5000, there is a minimum of 1000 and a maximum of 999,999,999. Any selection
 * of N outside this range will be truncated to the nearest limit.
 * [CRYPT_SHA_512] - SHA-512 hash with a 16 character salt starting with $6$. If the salt string
 * starts with "rounds=<N>$", the numeric value of N is used to indicate how many times
 * the hashing loop should be executed, much like the cost parameter on Blowfish. The default
 * number of rounds is 5000, there is a minimum of 1000 and a maximum of 999,999,999.
 * Any selection of N outside this range will be truncated to the nearest limit.
 */


// 2 character salt
if (CRYPT_STD_DES == 1)
{
    echo "Standard DES: ".crypt('something','st')."\n<br>";
}
else
{
    echo "Standard DES not supported.\n<br>";
}

// 4 character salt
if (CRYPT_EXT_DES == 1)
{
    echo "Extended DES: ".crypt('something','_S4..some')."\n<br>";
}
else
{
    echo "Extended DES not supported.\n<br>";
}

// 12 character salt starting with $1$
if (CRYPT_MD5 == 1)
{
    echo "MD5: ".crypt('something','$1$somethin$')."\n<br>";
}
else
{
    echo "MD5 not supported.\n<br>";
}

// Salt starting with $2a$. The two digit cost parameter: 09. 22 characters
if (CRYPT_BLOWFISH == 1)
{
    echo "Blowfish: ".crypt('something','$2a$09$anexamplestringforsalt$')."\n<br>";
}
else
{
    echo "Blowfish DES not supported.\n<br>";
}

// 16 character salt starting with $5$. The default number of rounds is 5000.
if (CRYPT_SHA256 == 1)
{
    echo "SHA-256: ".crypt('something','$5$rounds=5000$anexamplestringforsalt$')."\n<br>"; }
else
{
    echo "SHA-256 not supported.\n<br>";
}

// 16 character salt starting with $5$. The default number of rounds is 5000.
if (CRYPT_SHA512 == 1)
{
    echo "SHA-512: ".crypt('something','$6$rounds=5000$anexamplestringforsalt$');
}
else
{
    echo "SHA-512 not supported.";
}




