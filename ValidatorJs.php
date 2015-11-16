<?php
/*** Revision History
 ** --------------------------------------------
 ** 19-Aug-2002 Added a check to check if the form variable exists
 ** This will ensure that if you give it an invalid form variable name
 ** to check it will not crash the JavaScript. Thanks to Chris Fortune
 ** at cfortune@telus.net for the idea
 **/


/** This class dynamically creates validation javascript
 ** Currently it is only generating limited comparisons.
 ** I did not want to <b>clutter</b> up the code with
 ** unnecessary test cases when I did not use them
 ** within my system
 ** 
 ** The system is fairly easy to understand and fairly
 ** easy to extend. Just the sort of thing that everyone
 ** has been looking for in a validator :-)
 **
 ** @author Brett Dutton - bdutton@radntech.com
 ** @version 1.1 - 19-Aug-2002
 **/ 
 $errorMsgJs=array(
	"compareToday"=>"no puede ser menor a la fecha actual.\\n \\nMensaje generado por GesTor F1.",
	"date"=>"debe ser una fecha valida y menor al ano 2030.\\n \\nMensaje generado por GesTor F1.",
	"empty"=>"no puede ser vacio.\\n \\nMensaje generado por GesTor F1.",
	"expresion"=>"debe ser una expresion valida y no puede ser vacio.\\n \\nMensaje generado por GesTor F1.",
	"alpha"=>"debe ser un caracter alfabetico.\\n \\nMensaje generado por GesTor F1.",
	"compareDates"=>"las fechas son incoherentes. \\nPor ejemplo: fecha de inicio debe ser menor o igual a la fecha de conclusion.\\n \\nMensaje generado por GesTor F1.",
	"compareDates2"=>"las fechas son incoherentes. \\nPor ejemplo: Fecha de Ejecucion debe ser menor o igual a la Fecha de Registro.\\n \\nMensaje generado por GesTor F1.",
	"number"=>"debe ser un valor numerico.\\n \\nMensaje generado por GesTor F1.",
	"length"=>"debe ser menor a 500 caracteres.\\n \\nMensaje generado por GesTor F1.",
	"time"=>"debe ser una hora valida.\\nPor ejemplo: hora (00-23); minutos (01-59).\\n \\nMensaje generado por GesTor F1."
 );
class Validator {
    
    /** Name of the form in this document
     ** @type String 
     ** @private 
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    var $formName;
    
    /** An array of all the form variables that will be tested
     ** @see $add
     ** @type array
     ** @private 
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    var $testCases = array ();

    /** List of used functions. This is used so we
     ** do not generate javascript that we don't need
     ** @type array
     ** @private 
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    var $usedFunct = array ();

    /** 
     ** do not generate javascript that we don't need
     ** @type array
     ** @private 
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    var $alertOnMissingFormVar;
	/**
	* nombre de las funciones adicionales para validar. 
	*/
	var $functionName = array();
    /** Constructor
     ** @returns void
     ** @public
     ** @param $f The name of the form that will be validated 
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    function Validator ( $f ) {
        $this->formName = $f;
        $this->alertOnMissingFormVar = FALSE;
    }

    /** Sets the variable alertOnMissingFormVar. This variable controlles
     ** is there is a message displayed if the javascript is given an
     ** invalid form variable name to test
     ** @returns void
     ** @public
     ** @param $state The state of this variable
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    function setMissingAlert ( $state ) { $this->alertOnMissingFormVar = $state; }
    
    /** Add a test for this form variable. Tests for Existance
     ** @returns void
     ** @public
     ** @param $fv Form Variable name
     ** @param $desc A message if the test fails
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    function addExists ( $fv, $desc ) { $this->add ( $fv, $desc,  "EXISTS" ); }
	
	function addExiste ( $fv, $desc ) { $this->add ( $fv, $desc,  "EXISTE" ); }
    
    /** Add a test for this form variable. Tests for valid email
     ** Note that empty is valid. That means that you must check for
     ** Existance as well as email.
     ** @returns void
     ** @public
     ** @param $fv The form variable name to test
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    function addEmail  ( $fv ) { $this->add ( $fv, "", "EMAIL"  ); }

    /** Add a test for this form variable. Tests for 2 form variables
     ** are equal. This is partucually useful for passwords
     ** @returns void
     ** @public
     ** @param $fv1 First form variable to check
     ** @param $fv2 Other form variable to test againse
     ** @param $desc Message if the variables are not the same
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    function addEqual  ( $fv1, $fv2, $desc ) { $this->add ( $fv1, $desc, "EQUAL", $fv2 ); }
	function addIsTextNormal  ( $fv1, $desc ) { $this->add ( $fv1, $desc, "ISTEXTNORMAL" ); }
	function addIsAlpha  ( $fv1, $desc ) { $this->add ( $fv1, $desc, "ISALPHA" ); }
	function addIsNumber  ( $fv1, $desc ) { $this->add ( $fv1, $desc, "ISNUMBER" ); }
	function addIsNotEmpty  ( $fv1, $desc ) { $this->add ( $fv1, $desc, "ISNOTEMPTY" ); }
	function addIsDate  ( $fv1, $fv2, $fv3, $desc ) { $this->add ( $fv1, $desc, "ISDATE",  $fv2, $fv3 ); }
	function addCompareDates ( $fv1, $fv2, $fv3, $fv4, $fv5, $fv6, $desc ) { $this->add ( $fv1, $desc, "COMPAREDATES", $fv2, $fv3, $fv4, $fv5, $fv6 ); }
	function addCompareDatesToday  ( $fv1, $fv2, $fv3, $desc ) { $this->add ( $fv1, $desc, "COMPAREDATESTODAY",  $fv2, $fv3 ); }
    function addIsTime  ( $fv1, $fv2, $desc ) { $this->add ( $fv1, $desc, "ISTIME",  $fv2, '', '', '', '' ); }
	function addLength ($fv1, $desc) { $this->add ( $fv1, $desc, "LENGTH" ); }
    /** Add a test for this form variable. Tests if a form variable
     ** is empty. If it is then it copies the value from $fv1 into $fv2
     ** This would be useful for say prefered name
     ** @returns void
     ** @public
     ** @param $fv1 Source Form Variable
     ** @param $fv2 Destination Form Variable
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    function addCopy   ( $fv1, $fv2 ) { $this->add ( $fv1, "", "COPY", $fv2 ); }
    
    /** Generic function for adding tests
     ** @returns void
     ** @private
     ** @param $fv Form Variable
     ** @param $desc Description for this test
     ** @param $t Test type
     ** @param $xtra Extra information
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    function add ( $fv, $desc, $t, $xtra=NULL, $xtra1=NULL, $xtra2=NULL, $xtra3=NULL, $xtra4=NULL ) {
        $this->testCases[] = array ( "NAME" => $fv,
                                     "DESC" => $desc,
                                     "TEST" => $t,
                                     "XTRA" => $xtra,
									 "XTRA1" => $xtra1,
									 "XTRA2" => $xtra2,
									 "XTRA3" => $xtra3,
									 "XTRA4" => $xtra4 );
        $this->usedFunct[$t] = "YES";
    }
	function addFunction ( $name, $desc ){
		$this->functionName[] = array( "NAME" => $name,
										"DESC" => $desc);
	}
    function add000 ( $fv, $desc, $t, $xtra=NULL ) {
        $this->testCases[] = array ( "NAME" => $fv,
                                     "DESC" => $desc,
                                     "TEST" => $t,
                                     "XTRA" => $xtra );
        $this->usedFunct[$t] = "YES";
    }

    /** Generates HTML and Javascript to do the tests on this form
     ** @returns String
     ** @public
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    function toHtml () {
        $msg = "";

        // The first stage is to figure out what is being validated and
        // to only include what you want
        $msg .= ( "function isEmpty(s) { return ((s == null) || (s.length == 0)); }\n" );
        $msg .= ( "var whitespace = \" \\t\\n\\r\";\n" . 
                  "function isWhitespace (s) {\n" .
                  "  var i;\n" .
                  "  if (isEmpty(s)) return true;\n" .
                  "  for (i = 0; i < s.length; i++) {\n" .
                  "    var c = s.charAt(i);\n" .
                  "    if (whitespace.indexOf(c) == -1) return false;\n" .
                  "  }\n" .
                  "  return true;\n" .
                  "}\n" );
        
        foreach ( $this->usedFunct as $key => $val ) {
            switch ( $key ) {
            case "EXISTS":  // Output the javascript functions for Existance
                $msg .= ( "function doesExist (s) { return ( ! isEmpty(s) && ! isWhitespace (s) ); }\n" );
                break;
			case "EXISTE":  // Output the javascript functions for Existance
                $msg .= ( "function doesExist (s) { return ( ! isEmpty(s) && ! isWhitespace (s) ); }\n" );
                break;
			case "ISDATE":
				$msg.="function isDate(s){
					var DateValue = \"\";
					var seperator = \".\";
					var day;
					var month;
					var year;
					var leap = 0;
					var err = 0;
					var i;
					   err = 0;
					   DateValue = s;
					   if ( DateValue.search(new RegExp(\"^[0-9]+$\",\"g\"))<0) {
						err=20;
						}
					   if (DateValue.length == 6) {
					      DateValue = DateValue.substr(0,4) + '20' + DateValue.substr(4,2); }
					   if (DateValue.length != 8) {
					      err = 19;}
					   /* year is wrong if year = 0000 */
					   year = DateValue.substr(4,4);
					   if (year == 0) {
					      err = 20;
					   }
					   if (year > 2030) {
					   		err = 20;
					   }
					   /* Validation of month*/
					   month = DateValue.substr(2,2);
					   if ((month < 1) || (month > 12)) {
					      err = 21;
					   }
					   /* Validation of day*/
					   day = DateValue.substr(0,2);
					   if (day < 1) {
					     err = 22;
					   }
					   /* Validation leap-year / february / day */
					   if ((year % 4 == 0) || (year % 100 == 0) || (year % 400 == 0)) {
					      leap = 1;
					   }
					   if ((month == 2) && (leap == 1) && (day > 29)) {
					      err = 23;
					   }
					   if ((month == 2) && (leap != 1) && (day > 28)) {
					      err = 24;
					   }
					   /* Validation of other months */
					   if ((day > 31) && ((month == \"01\") || (month == \"03\") || (month == \"05\") || (month == \"07\") || (month == \"08\") || (month == \"10\") || (month == \"12\"))) {
					      err = 25;
					   }
					   if ((day > 30) && ((month == \"04\") || (month == \"06\") || (month == \"09\") || (month == \"11\"))) {
					      err = 26;
					   }					
					   /* if 00 ist entered, no error, deleting the entry */
					   if ((day == 0) && (month == 0) && (year == 00)) {
					      err = 0;
					   }
					   /* if no error, write the completed date to Input-Field (e.g. 13.12.2001) */
					   if (err == 0) {
						  return true;
					   }
					   /* Error-message if err != 0 */
					   else {
						  return false;
					   }
					}\n";
				break;
				case "ISTIME":  // Output the javascript functions for Existance
                $msg .= ( "function isTime (h, m) {\n" . 
						  " var time= h + ':' + m + ':00';\n".
                          //"  if (time.search(new RegExp(\"^((([0]?[1-9]|1[0-2])(:|\.)[0-5][0-9]((:|\.)[0-5][0-9])?( )?(AM|am|aM|Am|PM|pm|pM|Pm))|(([0]?[0-9]|1[0-9]|2[0-3])(:|\.)[0-5][0-9]((:|\.)[0-5][0-9])?))$\"))<0) return ( false );\n" .
						  //"  if (time.search(new RegExp(\"^((([0]?[0-9]|1[0-9]|2[0-3])(:|\.)[0-5][0-9]((:|\.)[0-5][0-9])?))$\"))<0) return ( false );\n" .
						  "if (time.search(new RegExp(\"^((([0-1][0-9]|[2][0-3])(:|\.)[0-5][0-9]((:|\.)[0-5][0-9])?))$\"))<0) return ( false );\n" .
                          "  else return ( true );\n" .
                          "}\n" );
                break;
			case "COMPAREDATES":
			case "COMPAREDATESTODAY":
				$msg.=("function compareDates(from, to) {\n".
					"if (Date.parse(from) <= Date.parse(to)) {\n".
					"return true;\n".
					"}\n".
					"else {\n".
					"return false; \n".
					"   }\n".
					"}\n");
				break;
            case "EMAIL": // Output the javascript functions for email
                $msg .= "var iEmail = \"Email, debe ser un correo electronico valido.\";\n";
                $msg .= ( "function isEmail (s) {\n" . 
                          "  if (isEmpty(s)) return ( true );\n" .
                          "  if (isWhitespace(s)) return ( false );\n" .
                          "  var i = 1;\n" .
                          "  var sLength = s.length;\n" .
                          "  while ((i < sLength) && (s.charAt(i) != \"@\")) { i++; }\n" .
                          "  if ((i >= sLength) || (s.charAt(i) != \"@\")) return ( false );\n" .
                          "  else i += 2;\n" .
                          "  while ((i < sLength) && (s.charAt(i) != \".\")) { i++; }\n" .
                          "  if ((i >= sLength - 1) || (s.charAt(i) != \".\")) return ( false );\n" .
                          "  else return ( true );\n" .
                          "}\n" );
                break;
			case "ISTEXTNORMAL":  // Output the javascript functions for Existance
                $msg .= ( "function isTextNormal (s) {\n" . 
                          "  if (s == '' || s.search(new RegExp(\"^([0-9a-zA-Z������������.:,;\\\"'_ /\.-])+$\",\"g\"))<0) return ( false );\n" .
                          "  else return ( true );\n" .
                          "}\n" );
                break;
			case "ISALPHA":  // Output the javascript functions for Existance
                $msg .= ( "function isAlpha (s) {\n" . 
                          "  if (s == '' || s.search(new RegExp(\"^[a-zA-Z������������ ]+$\",\"g\"))<0) return ( false );\n" .
                          "  else return ( true );\n" .
                          "}\n" );
                break;
			case "ISNUMBER":  // Output the javascript functions for Existance
                $msg .= ( "function isNumber (s) {\n" . 
                          "  if (s == '' || s.search(new RegExp(\"^[0-9,.]+$\",\"g\"))<0) return ( false );\n" .
                          "  else return ( true );\n" .
                          "}\n" );
                break;
            }
        }

        // Then create the validation function that will test all the
        // different form variables
        $msg .= "function validateForm() {\n";
		$msg .= "  var form = document.$this->formName;\n";

		foreach ( $this->testCases as $val ) {
            $nam  = $val["NAME"];
            $desc = $val["DESC"];

            // Test is in java and check if the form variable exists
            // Ensures the Javascript does not crash on
            // missing Form Variables
            $msg .= "  if ( form.$nam ) {\n";

            // Output the javascript to do the different checks
            switch ( $val["TEST"] ) {
            case "EXISTS":
                $msg .= "    if ( ! doesExist ( form.$nam.value ) ) {\n";
                $msg .= "      alert ( \"$desc \" );\n";
                $msg .= "      form.$nam.focus();\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";
                break;
			               
            case "EMAIL":
                $msg .= "    if ( ! isEmail ( form.$nam.value ) ) {\n";
                $msg .= "      alert ( iEmail );\n";
                $msg .= "      form.$nam.focus();\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";
                break;
			
			case "ISTEXTNORMAL":
                /*$msg .= "    if ( ! isTextNormal ( form.$nam.value ) ) {\n";
                $msg .= "      alert ( \"$desc\" );\n";
                $msg .= "      form.$nam.focus();\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";*/
				$msg .= "    if ( isEmpty ( form.$nam.value ) ) {\n";
                $msg .= "      alert ( \"$desc\" );\n";
                $msg .= "      form.$nam.focus();\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";
                break;
			case "LENGTH":
				$msg.="if (form.$nam.value.length > 501)\n";
				$msg.="{ alert (\"$desc\");\n";
				$msg.="return false;\n }";
				break;
			case "ISALPHA":
                /*$msg .= "    if ( ! isAlpha ( form.$nam.value ) ) {\n";
                $msg .= "      alert ( \"$desc\" );\n";
                $msg .= "      form.$nam.focus();\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";*/
				$msg .= "    if ( isEmpty ( form.$nam.value ) ) {\n";
                $msg .= "      alert ( \"$desc\" );\n";
                $msg .= "      form.$nam.focus();\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";
                break;
			case "ISNUMBER":
                $msg .= "    if ( ! isNumber ( form.$nam.value ) ) {\n";
                $msg .= "      alert ( \"$desc\" );\n";
                $msg .= "      form.$nam.focus();\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";
                break;
			case "ISDATE":
				$mes = $val["XTRA"];
				$ano = $val["XTRA1"];
				$msg .= "var d=form.$nam.value;\n";
				$msg .= "var m=form.$mes.value;\n";
				$msg .= "if (d.length==1) d='0' + d;\n";
				$msg .= "if (m.length==1) m='0' + m;\n";
				$msg .= "var iDate=d + m + form.$ano.value;\n";				
				$msg .= "    if ( iDate =='' ) { \n";
				$msg .= "		alert ( \"$desc\" );\n";
				$msg .= " 		return false;}\n";
                $msg .= "    if ( ! isDate ( iDate ) ) {\n";
                $msg .= "      alert ( \"$desc\" );\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";
                break;
			case "ISTIME":
				$m = $val["XTRA"];
				$msg .= "	var min=form.$m.value;\n";
                $msg .= "    if ( ! isTime ( form.$nam.value, min ) ) {\n";
                $msg .= "      alert ( \"$desc\" );\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";
                break;
			case "ISNOTEMPTY":
				$msg .= "if ( form.$nam.value == 0 ||  form.$nam.value =='') { \n";
				$msg .= "	alert ( \"$desc\" );\n";
				$msg .= "	return false;}\n";
				//$msg .= "else return true;\n";
				break;
			case "COMPAREDATESTODAY":
				$d = $nam;
				$m = $val["XTRA"];
				$y = $val["XTRA1"];
				$iToday = date("m/d/Y");

				$msg .= "var to=form.$m.value + '/' + form.$d.value + '/' + form.$y.value;\n";
				$msg .= "var from='$iToday';\n";
                $msg .= "    if ( ! compareDates ( from, to ) ) {\n";
                $msg .= "      alert ( \"$desc\" );\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";
                break;
			
			case "COMPAREDATES":
				$d = $nam;
				$m = $val["XTRA"];
				$y = $val["XTRA1"];
				$d1 = $val["XTRA2"];
				$m1 = $val["XTRA3"];
				$y1 = $val["XTRA4"];

				$msg .= "var from=form.$m.value + '/' + form.$d.value + '/' + form.$y.value;\n";
				$msg .= "var to=form.$m1.value+ '/' +  form.$d1.value+ '/' +  form.$y1.value;\n";
                $msg .= "    if ( ! compareDates ( from, to ) ) {\n";
                $msg .= "      alert ( \"$desc\" );\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";
                break;	                
               
            case "EQUAL":
                $nam2 = $val["XTRA"];
                $msg .= "    if ( form.$nam.value != form.$nam2.value ) {\n";
                $msg .= "      alert ( \"$desc\" );\n";
                $msg .= "      form.$nam.focus();\n";
                $msg .= "      return ( false );\n";
                $msg .= "    }\n";
                break;
                
            case "COPY":
                $nam2 = $val["XTRA"];
                $msg .= "    if ( ! doesExist ( form.$nam2.value ) ) {\n";
                $msg .= "      form.$nam2.value = form.$nam.value\n";
                $msg .= "    }\n";
                break;
            }

            // End of the if test that check if the form var exists
            $msg .= "  }\n";
            
            // Check if we are notifying the user on missing form vars
            if ( $this->alertOnMissingFormVar ) {
                $msg .= "  else {\n";
                $msg .= "    alert ( \"Form variable '$nam' does not exist in this form\" );\n";
                $msg .= "    return ( false );\n";
                $msg .= "  }\n";
            }
        }
		
		foreach($this->functionName as $val ){
		    	$name = $val["NAME"];
				$desc = $val["DESC"];
				$msg .= "if (!$name()) {\n";
				//$msg .= "	alert (\"$desc\")\n";
				$msg .= "	return false; }\n";
		    }
        
        $msg .= "  return ( true );\n";
        $msg .= "}\n";
        $msg .= "function validateAndSubmit() {\n";
        $msg .= "  var form = document.$this->formName;\n";
        $msg .= "  var ok = validateForm ();\n";
        $msg .= "  if ( ok ) form.submit ();\n";
        $msg .= "  return ( ok );\n";
        $msg .= "}\n";
        return ( "<script type=\"text/javascript\" language=\"JavaScript\">\n" .
                 $msg .
                 "</script>\n" );
    }

    /** Function to attach some javascript to a Submit button
     ** so that it does the validation. 
     ** @returns String
     ** @public
     ** @param $s Other javascript that is required on this button or link
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    function onSubmit ( $s="" ) {
        return ( "onClick=\"{$s}return validateForm();\"" );
    }

    /** This function would be attached to a button or a link. It 
     ** does the validation first and then does a submit on the form
     ** @returns String
     ** @public
     ** @param $s Other javascript that is required on this button or link
     ** @author Brett Dutton - bdutton@radntech.com
     **/ 
    function doSubmit ( $s="" ) {
        return ( "onClick=\"{$s}return validateAndSubmit();\"" );
    }
}


?>