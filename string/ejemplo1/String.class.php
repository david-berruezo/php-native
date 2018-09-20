<?php
/**
 * The String class represents character strings.
 * @author Azeem Michael
 */
class String implements Comparable {

    /** @var string primitive string type
     */
    private $str;

    /**
     * The class Constructor
     * @param string $s premitive string to objectify
     */
    public function __construct($s) {
        $this->str = $s;
    }

    /**
     * Destructor to prevent memory leaks.
     */
    public function __destruct() {
        unset($this);
    }

    /**
     * Returns string representation of the object
     * @return string string representation of the object
     */
    public function __toString() {
        return strval($this->str);
    }

    /**
     * Tests if this string begins with the specified suffix.
     * @param String|string $suffix the character sequence to search for
     * @return boolean true if the character sequence represented by the argument is
     * a character
     */
    public function beginsWith($suffix) {
        return (substr($this->str, 0, strlen($suffix)) == $suffix);
    }

    /**
     * Tests if this string begins with the specified suffix (case insensitive).
     * @param String|string $suffix the character sequence to search for
     * @return boolean true if the character sequence represented by the argument is
     * a character
     */
    public function beginsWithIgnoreCase($suffix) {
        $pos = stripos($this->str, strval($suffix));
        if ($pos === false) {
            return false;
        }
        return ($pos === 0);
    }

    /**
     * Returns the character at the specified index
     * @param int $index the index of the char value.
     * @return string the char value at the specified index of this string.
     * The first char value is at index 0.
     * @throws RuntimeException if 0 > $index > strlength
     */
    public function charAt($index) {
        if ($index < 0 || $index > $this->length()) {
            throw new RuntimeException('Index out of bound.');
        }
        return $this->str[$index];
        //return substr($this->str,$index,1);  //this also works
    }

    /**
     * Compares this object with the specified object for order. Returns a negative
     * integer, zero, or a positive integer as this object is less than, equal to,
     * or greater than the specified object
     *
     * @uses Compares this object with the specified string|String for order
     * @param mixed $s - the string to be compared
     * @return int a negative integer, zero, or a positive integer as this object is
     * less than, equal to, or greater than the specified object
     */
    public function compareTo($s) {
        return strnatcmp($this->str, $s);
    }

    /**
     * Case Insensitive Comparator
     * @param mixed $s - the string to be compared
     * @return int a negative integer, zero, or a positive integer as this string is
     * less than, equal to, or greater than the specified string
     */
    public function compareToIgnoreCase($s) {
        return strnatcasecmp($this->str, $s);
    }

    /**
     * Concatenates the specified String to the end of this string.
     * @param String|string $s - the string that is concatenated to the end of this string.
     * @return String a String that represents the concatenation of this object's
     * characters followed by the String argument's characters.
     * @example
     * <code>
     * Examples:
     * $str1 = new String('cares');
     * $str1->concat('s') returns 'caress'
     * $str2 = new String('to');
     * $str2->concat('get')->concat('her') returns 'together'
     * </code>
     */
    public function concat($s) {
        return new String($this->str . $s);
    }

    /**
     * Returns true if and only if this string represents the same sequence of
     * characters as the specified sequence.
     * @param String|string $s the sequence to search for. If needle is not a string|String,
     * it is converted to an integer and applied as the ordinal value of a character.
     * @return boolean true if this string contains the specified sequence of char values.
     */
    public function contains($s) {
        return (strpos($this->str, $s) !== false);
    }

    /**
     * Returns true if and only if this string represents the same sequence of
     * characters as the specified case-insensitive sequence.
     * @param String|string $s the sequence to search for. If needle is not a string|String,
     * it is converted to an integer and applied as the ordinal value of a character.
     * @return boolean true if this string contains the specified case-insensitive sequence of char values.
     */
    public function containsIgnoreCase($s) {
        return (stripos($this->str, $s) !== false);
    }

    /**
     * Tests if this string ends with the specified suffix.
     * @param String|string $suffix the character sequence to search for
     * @return boolean true if the character sequence represented by the argument is
     * a character
     */
    public function endsWith($suffix) {
        $beginIndex = strrpos($this->str, strval($suffix));
        $temp = $this->substring($beginIndex);
        return ($temp->equals($suffix));
    }

    /**
     * Tests if this string ends with the specified suffix (case insensitive).
     * @param String|string $suffix the character sequence to search for
     * @return boolean true if the character sequence represented by the argument is
     * a character
     */
    public function endsWithIgnoreCase($suffix) {
        $beginIndex = strripos($this->str, strval($suffix));
        $temp = $this->substring($beginIndex);
        return ($temp->equalsIgnoreCase($suffix));
    }

    /**
     * Compares this string to the specified String. The result is true if and only
     * if the argument is not null and is a String object that represents the same
     * sequence of characters as this object.
     * of characters as this object.
     * @param String|string $s the String to compare this String against.
     * @return boolean true if the Strings are equal; false otherwise.
     */
    public function equals($s) {
        return ($this->compareTo($s) == 0);
    }

    /**
     * Compares this String to another String, ignoring case considerations.
     * @param String|string $s the String to compare this String against.
     * @return boolean true if the argument is not null and the Strings are equal,
     * ignoring case; false otherwise.
     */
    public function equalsIgnoreCase($s) {
        return ($this->compareToIgnoreCase($s) == 0);
    }

    /**
     * Returns the integer value of this String, using the specified base
     * for the conversion (the default is base 10).
     * @param int $base the base for the conversion
     * @return int|boolean  the integer value of this String on success, or false
     * on failure. If this string is empty returns false, otherwise returns true.
     *
     */
    public function intVal($base=10) {
        return ($base == 10) ? intval($this->str) : intval($this->str, $base);
    }

    /**
     * Finds whether this String is empty. ("") is considered an empty string.
     * @return bool returns true if this object is blank (""), false otherwise.
     */
    public function isEmpty() {
        return empty($this->str);
    }

    /**
     * Finds whether this String is numeric. Numeric strings consist of optional
     * sign, any number of digits, optional decimal part and optional exponential
     * part. Thus +0123.45e6 is a valid numeric value. Hexadecimal notation (0xFF)
     * is allowed too but only without sign, decimal and exponential part.
     * @return bool returns true if this object is a number of a numeric string,
     * false otherwise.
     */
    public function isNumber() {
        return is_numeric($this->str);
    }

    /**
     * Strip whitespace (or other characters) from the beginning of a string
     * @param String|string $s the characters you want to strip
     * @return String returns a String with whitespace (or other characters) stripped
     */
    public function leftTrim($s=' ') {
        return ($s == ' ') ? new String(ltrim($this->str)) : new String(ltrim($this->str, $s));
    }

    /**
     * Strip whitespace (or specified characaters) from the end of a string
     * @param String|string $s the characters you want to strip
     * @return String returns a String with whitespace (or specified characters) stripped
     */
    public function rightTrim($s=' ') {
        return ($s == ' ') ? new String(rtrim($this->str)) : new String(rtrim($this->str, $s));
    }

    /**
     * Tests if this string starts with the specified prefix beginning at specified index.
     * @param String|string $prefix characters to search
     * @param int $toffset default to zero
     * @return boolean true if this string starts with specified prefix, false otherwise.
     */
    public function startsWith($prefix, $toffset=0) {
        $temp = substr($this->str, 0, ($this->length() - 1) * -1);
        if (!($prefix instanceof String)) {
            $prefix = new String($prefix);
        }
        $endIndex = $prefix->length();
        $substr = $this->substring(0, $endIndex);
        return $substr->equalsIgnoreCase($prefix);
    }

    /**
     * Returns a hash code for this string.
     * Note: The hash code for a string object is computed as sha1
     * @return String a sha1 hash code value for this object.
     */
    public function hashCode() {
        return new String(hash('sha1', $this->str));
    }

    /**
     * Returns the index within this string of the first occurrence of a
     * case-insensitive string.
     * @param string $chars Characters to search for within this string. Note that
     * the characters may be a string of one or more characters.
     * @param int $offset The optional offset parameter allows you to specify which
     * character in this string to start searching. The position returned is still
     * relative to the beginning of this string.
     * @return int|boolean Index of the first occurrence of the specified character.
     * If string is not found, boolean false will be returned.
     */
    public function indexOf($chars, $offset=0) {
        return stripos($this->str, $chars, $offset);
    }

    /**
     * Returns the length of this string.
     * @return int the length of the sequence of characters represented by this object.
     */
    public function length() {
        return strlen($this->str);
    }

    /**
     * Tells whether this string matches the given regular
     * <a href="http://www.php.net/manual/en/intro.pcre.php">expression</a>.
     * @param String|string $regex the pattern to search for, as a String.
     * @return boolean true if, and only if, this string matches the given regular expression
     */
    public function matches($regex) {
        return preg_match($regex, $this->str);
    }

    /**
     * Replace all occurrences of the target string with the replacement string
     * @param mixed $target The value being searched for, otherwise known as the
     * needle. An array may be used to designate multiple needles.
     * @param mixed $replacement The replacement value that replaces found target
     * values. An array may be used to designate multiple replacements.
     * @return String the resulting String
     */
    public function replace($target, $replacement) {
        return new String(str_replace($target, $replacement, $this->str));
    }

    /**
     * Perform a regular expression search and replace
     * @param string|array $regx the regular expression to search for. It can be either a
     * string or an array of strings.
     * @param string|array $replacement The replacement value that replaces found target
     * values. An array may be used to designate multiple replacements.
     * @return String If matches are found, the new String will be found, otherwise String
     * will be returned unchanged or NULL if an error occurred
     */
    public function pregReplace($regx, $replacement) {
        return new String(preg_replace($regx, $replacement, $this->str));
    }

    /**
     * Replace all occurrences of the target string with the replacement string (ignoring case)
     * @param mixed $target The value being searched for, otherwise known as the
     * needle. An array may be used to designate multiple needles.
     * @param mixed $replacement The replacement value that replaces found target
     * values. An array may be used to designate multiple replacements.
     * @return String the resulting String
     */
    public function replaceIgnoreCase($target, $replacement) {
        return new String(str_ireplace($target, $replacement, $this->str));
    }

    /**
     * Returns a new String that is a substring of this string. The substring beings
     * at the specified beginIndex and extends to the character at index endIndex - 1.
     * Thus the length of the substring is endIndex-beginIndex.
     * @example Examples:
     * 'hamburger'->substring(4, 8) returns 'urge'
     * 'smiles'->substring(1,5) returns 'mile'
     * @param int $beginIndex - the begining index, inclusive.
     * @param int $endIndex - the ending index, exclusive.
     * @return String the specified substring.
     */
    public function substring($beginIndex, $endIndex=null) {
        if (is_null($endIndex)) {
            $endIndex = $this->length();
        }
        return new String(substr($this->str, $beginIndex, $endIndex));
    }

    /**
     * Converts all of the characters in this string to upper case using the rules
     * of the default local.
     * @return String Returns String with all alphabetic characters converted to uppercase.
     */
    public function toUpperCase() {
        return new String(strtoupper($this->str));
    }

    /**
     * Converts all of the characters in this string to lower case using the rules
     * of the default local.
     * @return String Returns String with all alphabetic characters converted to lowercase.
     */
    public function toLowerCase() {
        return new String(strtolower($this->str));
    }

    /**
     * Strip whitespace (or other characters) from the beginning and end of a string
     * @param mixed $s the character list to search for.
     * @return String returns the new String object
     */
    public function trim($s=null) {
        if (is_null($s)) {
            return new String(trim($this->str));
        }
        return new String(trim($this->str, $s));
    }

    /**
     * Counts the number of words inside string. If the optional format is not
     * specified, then the return value will be an integer representing the number
     * of words found.
     * @param int $format specify the return value of this function. The current
     * values are:<br/>
     * <ul>
     * <li>0 - returns the number of words found</li>
     * <li>1 - returns an array containing all the words found inside the string</li>
     * <li>2 - returns an associative array, where the key is the number position of
     * the word inside the string and the value is the actual word itself</li>
     * </ul>
     * @return int|array returns an array or an integer, depending on the format chosen.
     */
    public function numOfWords($format=0) {
        return str_word_count($this->str, $format);
    }

    /**
     * Returns a string with the first character of str capitalized, if that character is alphabetic.
     * Note that 'alphabetic' is determined by the current locale. For instance,
     * in the default "C" locale characters such as umlaut-a (ä) will not be converted.
     * @return String the resulting String object
     */
    public function ucfirst() {
        return new String(ucfirst($this->str));
    }

}

?>
