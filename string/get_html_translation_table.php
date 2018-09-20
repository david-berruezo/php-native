<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 01/07/2016
 * Time: 13:11
 */

/*
 * Devuelve una tabla de traducción
 * HTML_ENTITIES o HTML_SPECIALCHARS
 * ENT_COMPAT	La tabla contendrá entidades para comillas dobles, pero no para comillas simples.
 * ENT_QUOTES	La tabla contendrá entidades para comillas dobles y simples.
 * ENT_NOQUOTES	La tabla no contendrá entidades para comillas simples ni para comillas dobles.
 * ENT_HTML401	Tabla para HTML 4.01.
 * ENT_XML1	Tabla para XML 1.
 * ENT_XHTML	Tabla para XHTML.
 * ENT_HTML5	Tabla para HTML 5.
 */
print_r (get_html_translation_table()); // HTML_SPECIALCHARS is default.
?>