<?php
/**
 * Project:     web.framework: the PHP5 MVC framework
 * File:		VerifyEmail.tester.class.php
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * You may contact the authors of web.framework by e-mail at:
 * webframe@staniszczak.pl
 *
 * The latest version of web.framework can be obtained from:
 * http://sourceforge.net/projects/webframework
 *
 * @link http://sourceforge.net/projects/webframework
 * @copyright 2005 Marcin Staniszczak
 * @author Marcin Staniszczak <marcin@staniszczak.pl>
 * @version 1.0.0
 */

/**
 * This tester check mail's propriety
 *
 * @name VerifyEmail
 * @version 1.0.0
 * @package web.framework
 * @subpackage Validators
 *
 * @author Marcin Staniszczak
 * @copyright 2005 Marcin Staniszczak
 */
class VerifyEmail implements ITester {
	/**
	 * This function verifi email.
	 * From http://php.faq.pl/klucz/sprawdz_mail
	 * Author: lemming nine
	 *
	 * @author lemming nine
	 * @param string e-mail to check
	 * @return boolean true - mail is correct, false - mail is incorrect
	 */
	private function verifyEmial($strEmail) {
	    $wholeexp = '/^(.+?)@(([a-z0-9\.-]+?)\.[a-z]{2,5})$/i';
	    $userexp = "/^[a-z0-9\~\!\#\$\%\&\(\)\-\_\+\=\[\]\;\:\'\"\,\.\/]+$/i";
	    if (preg_match($wholeexp, $strEmail, $regs)) {
			$username = $regs[1];
	        $host = $regs[2];
	        if (checkdnsrr($host, MX)) {
	            if (preg_match($userexp, $username)) {
	                return true;
	            } else {
	                return false;
	            }
	        } else {
	            return false;
	        }
	    } else {
	        return false;
	    }
	}

	/**
	 * This is tester's main method
	 *
	 * @param string web form value
	 * @param array tester's setting array - array('name'=>'value')
	 * @return boolean true - mail is correct, false - mail is incorrect
     */
	public function execute($strValue, $arrParameters) {
		return $this->verifyEmial($strValue);
	}
}
?>