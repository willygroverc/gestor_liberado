<?php
/* **********************************************************************
 *
 * Copyright (C) 2003 - 2004 Alejandro Garcia Gonzalez.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 *
 * **********************************************************************
 *
 *	Class:			Nexus MIME Mail ('nxs_mimemail.inc.php')
 *	Version:			1.2
 *	Author:			Alejandro Garcia Gonzalez <nexus@nuestroweb.com>
 *	Site:				http://nexus.nuestroweb.com
 *
 * Description:
 * A class for sending MIME based e-mail messages.
 *
 * + Plain Text
 * + HTML
 * + Plain Text with Attachments
 * + HTML with Attachments
 * + HTML with Embedded Images
 * + HTML with Embedded Images and Attachments
 *
 * ********************************************************************** */


class nxs_mimemail {

	/**
 	 * Vars
	 */
	var $debug_status = "yes";			// "yes" | "no" | "halt"
	var $charset = "ISO-8859-1";
	var $mail_subject = "No subject";
	var $mail_from = "Anonymous <fake@mail.com>";
	var $mail_to;
	var $mail_cc;
	var $mail_bcc;
	var $mail_text;
	var $mail_html;
	var $mail_type;
	var $mail_header;
	var $mail_body;
	var $attachments = array();
	var $attachments_index;
	var $attachments_img;
	var $boundary_mix;
	var $boundary_rel;
	var $boundary_alt;

	var $error_msg = array(
			1	=>	'No existe un correo destino',
			2	=>	'',
			3	=>	''
	);

	var $mime_types = array(
			'gif'  => 'image/gif',
			'jpg'  => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpe'  => 'image/jpeg',
			'bmp'  => 'image/bmp',
			'png'  => 'image/png',
			'tif'  => 'image/tiff',
			'tiff' => 'image/tiff',
			'swf'  => 'application/x-shockwave-flash',
			'doc'  => 'application/msword',
			'xls'  => 'application/vnd.ms-excel',
			'ppt'  => 'application/vnd.ms-powerpoint',
			'pdf'  => 'application/pdf',
			'ps'   => 'application/postscript',
			'eps'  => 'application/postscript',
			'rtf'  => 'application/rtf',
			'bz2'  => 'application/x-bzip2',
			'gz'   => 'application/x-gzip',
			'tgz'  => 'application/x-gzip',
			'tar'  => 'application/x-tar',
			'zip'  => 'application/zip',
			'html' => 'text/html',
			'htm'  => 'text/html',
			'txt'  => 'text/plain',
			'css'  => 'text/css'
	);


	/**
	 * Constructor
	 * void nxs_mimemail()
	 */
	function nxs_mimemail(){
		$this->boundary_mix = "=-nxs_mix_" . md5(uniqid(rand()));
		$this->boundary_rel = "=-nxs_rel_" . md5(uniqid(rand()));
		$this->boundary_alt = "=-nxs_alt_" . md5(uniqid(rand()));
		$this->attachments_index = 0;
		if(!defined('BR')){
			define('BR', "\n", TRUE);
		}
	}


	/**
	 * void set_from(string mail_from, [string name])
	 */
	function set_from($mail_from, $name = ""){
		if ($this->validate_mail($mail_from)){
			if (!empty($name)){
				$this->mail_from = "$name <$mail_from>";
			}
			else {
				$this->mail_from = $mail_from;
			}
		}
		else {
			$this->mail_from = "Anonymous <fake@mail.com>";
		}
	}


	/**
	 * bool set_to(string mail_to, [string name])
	 */
	function set_to($mail_to, $name = ""){
		if ($this->validate_mail($mail_to)){
			if (!empty($name)){
				$mail_to = "$name <$mail_to>";
				//return true;
			}
			$this->mail_to = $mail_to;
			return true;
		}
		return false;
	}


	/**
	 * bool set_cc(string mail_cc, [string name])
	 */
	function set_cc($mail_to, $name = ""){
		if ($this->validate_mail($mail_cc)){
			if (!empty($name)){
				$mail_cc = "$name <$mail_cc>";
				//return true;
			}
			$this->mail_cc = $mail_cc;
			return true;
		}
		return false;
	}


	/**
	 * bool set_bcc(string mail_bcc, [string name])
	 */
	function set_bcc($mail_bcc, $name = ""){
		if ($this->validate_mail($mail_bcc)){
			if (!empty($name)){
				$mail_bcc = "$name <$mail_bcc>";
				return true;
			}
			$this->mail_bcc = $mail_bcc;
			return true;
		}
		return false;
	}


	/**
	 * bool add_to(string mail_to, [string name])
	 */
	function add_to($mail_to, $name = ""){
		if ($this->validate_mail($mail_to)){
			if (!empty($name)){
				$mail_to = "$name <$mail_to>";
			}
			if (empty($this->mail_to)){
				$this->mail_to = $mail_to;
				return true;
			}
			else {
				$this->mail_to .= ", " . $mail_to;
				return true;
			}
		}
		return false;
	}


	/**
	 * bool add_cc(string mail_cc, [string name])
	 */
	function add_cc($mail_cc, $name = ""){
		if ($this->validate_mail($mail_cc)){
			if (!empty($name)){
				$mail_cc = "$name <$mail_cc>";
			}
			if (empty($this->mail_cc)){
				$this->mail_cc = $mail_cc;
				return true;
			}
			else {
				$this->mail_cc .= ", " . $mail_cc;
				return true;
			}
		}
		return false;
	}


	/**
	 * bool add_bcc(string mail_bcc, [string name])
	 */
	function add_bcc($mail_bcc, $name = ""){
		if ($this->validate_mail($mail_bcc)){
			if (!empty($name)){
				$mail_bcc = "$name <$mail_bcc>";
			}
			if (empty($this->mail_bcc)){
				$this->mail_bcc = $mail_bcc;
				return true;
			}
			else {
				$this->mail_bcc .= ", " . $mail_bcc;
				return true;
			}
		}
		return false;
	}


	/**
	 * bool set_subject(string subject)
	 */
	function set_subject($subject){
		if (!empty($subject)){
			$this->mail_subject = $subject;
		}
	}


	/**
	 * void set_text(string text)
	 */
	function set_text($text){
		if (!empty($text)){
			$this->mail_text = $text;
		}
	}


	/**
	 * void set_html(string html)
	 */
	function set_html($html){
		if (!empty($html)){
			$this->mail_html = $html;
		}
	}


	/**
	 * void new_mail([string from], [string to], [string subject], [string text], [string html])
	 */
	function new_mail($from = "", $to = "", $subject = "", $text = "", $html = ""){

		// First, clear all vars
		// TNX to Pawel Tomicki
		$this->mail_subject = "";
		$this->mail_from = "";
		$this->mail_to = "";
		$this->mail_cc = "";
		$this->mail_bcc = "";
		$this->mail_text = "";
		$this->mail_html = "";
		$this->mail_header = "";
		$this->attachments_index = 0;

		//TODO: clear array vars

		// Asign vars
		$this->set_from($from);
		$this->set_to($to);
		$this->set_subject($subject);
		$this->set_text($text);
		$this->set_html($html);
	}


	/**
	 * void add_attachment(mixed file, string name, [string type])
	 */
	function add_attachment($file, $name, $type = ""){
		if ($content = $this->open_file($file)){
			if (empty($type)){$type = $this->get_mimetype($name);}
			$this->attachments[$this->attachments_index][content] = chunk_split(base64_encode($content));
			$this->attachments[$this->attachments_index][name] = $name;
			$this->attachments[$this->attachments_index][type] = $type;
			$this->attachments[$this->attachments_index][embedded] = false;
			$this->attachments_index++;
		}
	}


	/**
	 * bool send()
	 */
	function send(){
		switch ($this->parse_elements()){
			case 1:
				$this->build_header("Content-Type: text/plain");
				$this->mail_body = $this->mail_text;
				break;
			case 3:
				$this->build_header("Content-Type: multipart/alternative; boundary=\"$this->boundary_alt\"");
				$this->mail_body .= "--" . $this->boundary_alt . BR;
				$this->mail_body .= "Content-Type: text/plain" . BR;
				$this->mail_body .= "Content-Transfer-Encoding: 7bit" . BR . BR;
				$this->mail_body .= $this->mail_text . BR . BR;
				$this->mail_body .= "--" . $this->boundary_alt . BR;
				$this->mail_body .= "Content-Type: text/html; charset=\"$this->charset\"" . BR;
				$this->mail_body .= "Content-Transfer-Encoding: 7bit" . BR . BR;
				$this->mail_body .= $this->mail_html . BR . BR;
				$this->mail_body .= "--" . $this->boundary_alt . "--" . BR;
				break;
			case 5:
				$this->build_header("Content-Type: multipart/mixed; boundary=\"$this->boundary_mix\"");
				$this->mail_body .= "--" . $this->boundary_mix . BR;
				$this->mail_body .= "Content-Type: text/plain" . BR;
				$this->mail_body .= "Content-Transfer-Encoding: 7bit" . BR . BR;
				$this->mail_body .= $this->mail_text . BR . BR;
				foreach($this->attachments as $key => $value){
					$this->mail_body .= "--" . $this->boundary_mix . BR;
					$this->mail_body .= "Content-Type: " . $this->attachments[$key][type] . "; name=\"" . $this->attachments[$key][name] . "\"" . BR;
					$this->mail_body .= "Content-Disposition: attachment; filename=\"" . $this->attachments[$key][name] . "\"" . BR;
					$this->mail_body .= "Content-Transfer-Encoding: base64" . BR . BR;
					$this->mail_body .= $this->attachments[$key][content] . BR . BR;
				}
				$this->mail_body .= "--" . $this->boundary_mix . "--" . BR;
				break;
			case 7:
				$this->build_header("Content-Type: multipart/mixed; boundary=\"$this->boundary_mix\"");
				$this->mail_body .= "--" . $this->boundary_mix . BR;
				$this->mail_body .= "Content-Type: multipart/alternative; boundary=\"$this->boundary_alt\"" . BR . BR;
				$this->mail_body .= "--" . $this->boundary_alt . BR;
				$this->mail_body .= "Content-Type: text/plain" . BR;
				$this->mail_body .= "Content-Transfer-Encoding: 7bit" . BR . BR;
				$this->mail_body .= $this->mail_text . BR . BR;
				$this->mail_body .= "--" . $this->boundary_alt . BR;
				$this->mail_body .= "Content-Type: text/html; charset=\"$this->charset\"" . BR;
				$this->mail_body .= "Content-Transfer-Encoding: 7bit" . BR . BR;
				$this->mail_body .= $this->mail_html . BR . BR;
				$this->mail_body .= "--" . $this->boundary_alt . "--" . BR . BR;
				foreach($this->attachments as $key => $value){
					$this->mail_body .= "--" . $this->boundary_mix . BR;
					$this->mail_body .= "Content-Type: " . $this->attachments[$key][type] . "; name=\"" . $this->attachments[$key][name] . "\"" . BR;
					$this->mail_body .= "Content-Disposition: attachment; filename=\"" . $this->attachments[$key][name] . "\"" . BR;
					$this->mail_body .= "Content-Transfer-Encoding: base64" . BR . BR;
					$this->mail_body .= $this->attachments[$key][content] . BR . BR;
				}
				$this->mail_body .= "--" . $this->boundary_mix . "--" . BR;
				break;
			case 11:
				$this->build_header("Content-Type: multipart/related; type=\"multipart/alternative\"; boundary=\"$this->boundary_rel\"");
				$this->mail_body .= "--" . $this->boundary_rel . BR;
				$this->mail_body .= "Content-Type: multipart/alternative; boundary=\"$this->boundary_alt\"" . BR . BR;
				$this->mail_body .= "--" . $this->boundary_alt . BR;
				$this->mail_body .= "Content-Type: text/plain" . BR;
				$this->mail_body .= "Content-Transfer-Encoding: 7bit" . BR . BR;
				$this->mail_body .= $this->mail_text . BR . BR;
				$this->mail_body .= "--" . $this->boundary_alt . BR;
				$this->mail_body .= "Content-Type: text/html; charset=\"$this->charset\"" . BR;
				$this->mail_body .= "Content-Transfer-Encoding: 7bit" . BR . BR;
				$this->mail_body .= $this->mail_html . BR . BR;
				$this->mail_body .= "--" . $this->boundary_alt . "--" . BR . BR;
				foreach($this->attachments as $key => $value){
					if ($this->attachments[$key][embedded]){
						$this->mail_body .= "--" . $this->boundary_rel . BR;
						$this->mail_body .= "Content-ID: <" . $this->attachments[$key][embedded] . ">" . BR;
						$this->mail_body .= "Content-Type: " . $this->attachments[$key][type] . "; name=\"" . $this->attachments[$key][name] . "\"" . BR;
						$this->mail_body .= "Content-Disposition: attachment; filename=\"" . $this->attachments[$key][name] . "\"" . BR;
						$this->mail_body .= "Content-Transfer-Encoding: base64" . BR . BR;
						$this->mail_body .= $this->attachments[$key][content] . BR . BR;
					}
				}
				$this->mail_body .= "--" . $this->boundary_rel . "--" . BR;
				break;
			case 15:
				$this->build_header("Content-Type: multipart/mixed; boundary=\"$this->boundary_mix\"");
				$this->mail_body .= "--" . $this->boundary_mix . BR;
				$this->mail_body .= "Content-Type: multipart/related; type=\"multipart/alternative\"; boundary=\"$this->boundary_rel\"" . BR . BR;
				$this->mail_body .= "--" . $this->boundary_rel . BR;
				$this->mail_body .= "Content-Type: multipart/alternative; boundary=\"$this->boundary_alt\"" . BR . BR;
				$this->mail_body .= "--" . $this->boundary_alt . BR;
				$this->mail_body .= "Content-Type: text/plain" . BR;
				$this->mail_body .= "Content-Transfer-Encoding: 7bit" . BR . BR;
				$this->mail_body .= $this->mail_text . BR . BR;
				$this->mail_body .= "--" . $this->boundary_alt . BR;
				$this->mail_body .= "Content-Type: text/html; charset=\"$this->charset\"" . BR;
				$this->mail_body .= "Content-Transfer-Encoding: 7bit" . BR . BR;
				$this->mail_body .= $this->mail_html . BR . BR;
				$this->mail_body .= "--" . $this->boundary_alt . "--" . BR . BR;
				foreach($this->attachments as $key => $valor){
					if ($this->attachments[$key][embedded]){
						$this->mail_body .= "--" . $this->boundary_rel . BR;
						$this->mail_body .= "Content-ID: <" . $this->attachments[$key][embedded] . ">" . BR;
						$this->mail_body .= "Content-Type: " . $this->attachments[$key][type] . "; name=\"" . $this->attachments[$key][name] . "\"" . BR;
						$this->mail_body .= "Content-Disposition: attachment; filename=\"" . $this->attachments[$key][name] . "\"" . BR;
						$this->mail_body .= "Content-Transfer-Encoding: base64" . BR . BR;
						$this->mail_body .= $this->attachments[$key][content] . BR . BR;
					}
				}
				$this->mail_body .= "--" . $this->boundary_rel . "--" . BR . BR;
				foreach($this->attachments as $key => $value){
					if (!$this->attachments[$key][embedded]){
						$this->mail_body .= "--" . $this->boundary_mix . BR;
						$this->mail_body .= "Content-Type: " . $this->attachments[$key][type] . "; name=\"" . $this->attachments[$key][name] . "\"" . BR;
						$this->mail_body .= "Content-Disposition: attachment; filename=\"" . $this->attachments[$key][name] . "\"" . BR;
						$this->mail_body .= "Content-Transfer-Encoding: base64" . BR . BR;
						$this->mail_body .= $this->attachments[$key][content] . BR . BR;
					}
				}
				$this->mail_body .= "--" . $this->boundary_mix . "--" . BR;
				break;
			default:
				return false;
		}
		if (mail($this->mail_to, $this->mail_subject, $this->mail_body,$this->mail_header)){
			return true;
		}
		return false;
	}


	/**
	 * Private
	 * void build_header()
	 */
	function build_header($content_type){
		$this->mail_header = "MIME-Version: 1.0" . BR;
		if (!empty($this->mail_from)){
			$this->mail_header .= "From: " . $this->mail_from . BR;
			$this->mail_header .= "Reply-To: " . $this->mail_from . BR;
		}
		if (!empty($this->mail_cc)){
			$this->mail_header .= "Cc: " . $this->mail_cc . BR;
		}
		if (!empty($this->mail_bcc)){
			$this->mail_header .= "Bcc: " . $this->mail_bcc . BR;
		}
		$this->mail_header .= "X-Mailer: neXus MIME Mail - PHP/". phpversion() . BR;
		$this->mail_header .= $content_type;
	}


	/**
	 * Private
	 * mixed parse_elements()
	 */
	function parse_elements(){
		if (empty($this->mail_to)){
			$this->debug(1);
			return false;
		}
		$this->mail_type = 0;
		$this->search_images();
		if (!empty($this->mail_text)){
			$this->mail_type = $this->mail_type + 1;
		}
		if (!empty($this->mail_html)){
			$this->mail_type = $this->mail_type + 2;
			if (empty($this->mail_text)){
				$this->mail_text = strip_tags(eregi_replace("<br>", BR, $this->mail_html));
				$this->mail_type = $this->mail_type + 1;
			}
		}
		if ($this->attachments_index != 0){
			if (count($this->attachments_img) != 0){
				$this->mail_type = $this->mail_type + 8;
			}
			if ((count($this->attachments) - count($this->attachments_img)) >= 1){
				$this->mail_type = $this->mail_type + 4;
			}
		}
		return $this->mail_type;
	}


	/**
	 * Private
	 * void search_images()
	 */
	function search_images(){
		if ($this->attachments_index != 0){
			foreach($this->attachments as $key => $value){

				//TNX to Pawel Tomicki
				if (eregi('image', $this->attachments[$key][type]) && (eregi('<img.*src=[\"|\'](' . $this->attachments[$key][name] . ')[\"|\'].*>', $this->mail_html) || eregi('.*background=[\"|\'](' . $this->attachments[$key][name] . ')[\"|\'].*', $this->mail_html))){
					$img_id = md5($this->attachments[$key][name]) . ".nxs@mimemail";

					// TNX to Pawel Tomicki
					$this->mail_html = str_replace($this->attachments[$key][name], 'cid:' . $img_id, $this->mail_html);
					//$this->mail_html = eregi_replace('(<img [^<]*src=[\"|\'])(' . $this->attachments[$key][name] . ')([\"|\'][^>]*>[^<]*)', '\\1cid:' . $img_id . '\\3', $this->mail_html);
					$this->attachments[$key][embedded] = $img_id;
					$this->attachments_img[] = $this->attachments[$key][name];
				}
			}
		}
	}


	/**
	 * Private
	 * bool validate_mail(string mail)
	 */
	function validate_mail($mail){
		if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$',$mail)){
			return true;
		}
		$this->debug(1, $mail);
		return false;
	}


	/**
	 * Private
	 * string get_mimetype(string name)
	 */
	function get_mimetype($name){
		$ext_array = explode(".", $name);
		if (($last = count($ext_array) - 1) != 0){
			$ext = $ext_array[$last];
			foreach($this->mime_types as $key => $value){
				if ($ext == $key){
					return $value;
				}
			}
		}
		return "application/octet-stream";
	}


	/**
	 * Private
	 * int open_file(string file)
	 */
	function open_file($file){
		if($fp = @fopen($file, 'r')){
			$content = fread($fp, filesize($file));
			fclose($fp);
			return $content;
		}
		$this->debug(1, $file);
		return false;
   }


	/**
	 * Private
	 * void debug(string msg, [string element])
	 */
	function debug($msg, $element = ""){
		if ($this->msg_error == "yes"){
			echo "<br><b>Error:</b> " . $this->error_msg[$msg] . " $element<br>";
		}
		elseif ($this->msg_error == "halt"){
			die ("<br><b>Error:</b> " . $this->error_msg[$msg] . " $element<br>");
		}
		return false;
	}

}
?>
