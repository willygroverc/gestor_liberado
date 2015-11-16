<?php

// PHP Report Maker 1.0 - website configuration
// Database connection

define("HOST", "localhost", TRUE);
define("PORT", 3306, TRUE);
define("USER", "root", TRUE);
define("PASS", "", TRUE);
define("DB", "ordenes_de_trabajo_mutual", TRUE);

// Database configuration
define("EW_DBMSNAME", "MySQL", TRUE);
define("EW_DB_START_QUOTE", "`", TRUE);
define("EW_DB_END_QUOTE", "`", TRUE);
define("EW_USE_MYSQLI", FALSE, TRUE);

// Date format
define("DEFAULT_DATE_FORMAT", "yyyy/mm/dd", TRUE);
define("EW_DATE_SEPARATOR", "/", TRUE);
define("DEFAULT_CURRENCY_SYMBOL", "$", TRUE);
define("DEFAULT_MON_DECIMAL_POINT", ".", TRUE);
define("DEFAULT_MON_THOUSANDS_SEP", ",", TRUE);
define("DEFAULT_POSITIVE_SIGN", "", TRUE);
define("DEFAULT_NEGATIVE_SIGN", "-", TRUE);
define("DEFAULT_FRAC_DIGITS", 2, TRUE);
define("DEFAULT_P_CS_PRECEDES", TRUE, TRUE);
define("DEFAULT_P_SEP_BY_SPACE", FALSE, TRUE);
define("DEFAULT_N_CS_PRECEDES", TRUE, TRUE);
define("DEFAULT_N_SEP_BY_SPACE", FALSE, TRUE);
define("DEFAULT_P_SIGN_POSN", 3, TRUE);
define("DEFAULT_N_SIGN_POSN", 3, TRUE);

// Filter label
define("EW_NULL_LABEL", "(Null)", TRUE);
define("EW_EMPTY_LABEL", "(Empty)", TRUE);

// Project config
define("EW_PROJECT_NAME", "reportestibk12", TRUE); // Project Name
define("EW_PROJECT_VAR", "reportestibk12", TRUE); // Project Var

// Session names
define("EW_SESSION_STATUS", EW_PROJECT_VAR . "_status", TRUE); // Login Status
define("EW_SESSION_USERNAME", EW_SESSION_STATUS . "_UserName", TRUE); // User Name
define("EW_SESSION_USERID", EW_SESSION_STATUS . "_UserID", TRUE); // User ID
define("EW_SESSION_USERLEVEL", EW_SESSION_STATUS . "_UserLevel", TRUE); // User Level
define("EW_SESSION_PARENT_USERID", EW_SESSION_STATUS . "_ParentUserID", TRUE); // Parent User ID
define("EW_SESSION_SYSTEM_ADMIN", EW_PROJECT_VAR . "_SysAdmin", TRUE); // System Admin
define("EW_SESSION_MESSAGE", EW_PROJECT_VAR . "_Message", TRUE); // System Message

// Hard-coded admin
define("EW_ADMIN_USERNAME", "", TRUE);
define("EW_ADMIN_PASSWORD", "", TRUE);

// User admin
define("EW_USERNAME_FIELD", "", TRUE);
define("EW_PASSWORD_FIELD", "", TRUE);
define("EW_USERID_FIELD", "", TRUE);
define("EW_PARENT_USERID_FIELD", "", TRUE);
define("EW_USERLEVEL_ARRAY_FIELD", "", TRUE);
define("EW_LOGIN_SELECT_SQL", "", TRUE);

// Cookie names
define("EW_COOKIE_AUTOLOGIN", EW_PROJECT_VAR . "_autologin", TRUE); // Auto Login
define("EW_COOKIE_USERNAME", EW_PROJECT_VAR . "_username", TRUE); // Auto Login User Name
define("EW_COOKIE_PASSWORD", EW_PROJECT_VAR . "_password", TRUE);; // Auto Login Password

// Random key for encryption
define("EW_RANDOM_KEY", "_44i&T1cPY1VW_9S", TRUE);

// Chart data encoding
// Note: If you use non English languages, you need to set the encoding for
// charting. Make sure your encoding is supported by your PHP and either
// iconv functions or multibyte string functions are enabled. See PHP manual
// for details
// eg. define("EW_ENCODING", "ISO-8859-1", true);

define("EW_ENCODING", "ISO-8859-1", TRUE); // enter your encoding here
?>
