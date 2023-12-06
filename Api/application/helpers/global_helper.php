<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Method: getColumns
 * Params: $table
 * Return: Fields of table
 */
if (!function_exists('getColumns')) {

    function getColumns($table) {
        $result = "";
        $ci = &get_instance();
        $table = $ci->db->dbprefix . $table;
        $sql = "SHOW COLUMNS FROM " . $table;
        $query = $ci->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $result [$row->Field] = "";
            }
        }
        return $result;
    }
}

/**
 * Method: displayDateFormat
 * Params: $date&time
 * Return: date(string)
 */
if (! function_exists ( 'displayDateFormat' )) {
    function displayDateFormat($date = '') {
        if ($date != "") {
            return date ( 'm/d/y', strtotime ( $date ) );
        } else {
            return date ( 'm/d/y' );
        }
    }
}

/**
 * Method: generateMonths
 * Params: 
 * Return: array
 */
if (! function_exists ( 'generateMonths' )) {
    function generateMonths() {
        return $arr = array('1' => 'January', '2' => 'February', '3' => 'March',  '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
    }
}

/**
 * Method: generateCurrnetPlusYears
 * Params: $no_of_years
 * Return: array
 */
if (! function_exists ( 'generateCurrnetPlusYears' )) {
    function generateCurrnetPlusYears($no_of_years) {
        $currentYearIndex = date('Y');
        $currentYearValue = date('Y');

        $arr[$currentYearIndex] = $currentYearValue;
        
        for($i=1; $i<=$no_of_years; $i++){
            $arr[$currentYearIndex++] = $currentYearValue++;
        }
        return $arr;
    }
}

/**
 * Method: displayUpdateDateFormat
 * Params: $date&time
 * Return: date(string)
 */
if (! function_exists ( 'displayUpdateDateFormat' )) {
    function displayUpdateDateFormat($date = '') {
        if ($date != "") {
            return date ( 'M d, Y', strtotime ( $date ) );
        } else {
            return date ( 'M d, Y' );
        }
    }
}




function is_active($table_name, $where, $criteria)
{
    $ci = &get_instance();
    $ci->db->select('status');
    $ci->db->where($where, $criteria);
    $rs = $ci->db->get($table_name);
    if($rs->num_rows() > 0){
        if ($rs->row('status') == 1) {
            return true;
        }
    }
    return false;
}

/**
 * Method: getVal
 * Params: $col, $table, $where, $criteria
 * Return: array
 */

/**
 * Mehtod: init_admin_pagination_history
 * params: $uri, $total_records,$perpage
 * return: pagination configuration
 */
if (!function_exists('init_admin_pagination_history')) {

    function init_admin_pagination_history($uri, $total_records, $perpage,$uriSegment) {
        $ci = & get_instance();
        $config ["base_url"] = base_url() . $uri;

        $prev_link = '&laquo;';
        $next_link = '&raquo;';
        $config ["total_rows"] = $total_records;
        $config ["per_page"] = $perpage;
        $config ['uri_segment'] = $uriSegment;
        $config ['first_link'] = '';
        $config ['last_link'] = '';
        $config ['num_links'] = '5';
        $config ['prev_link'] = $prev_link;
        $config ['next_link'] = $next_link;
        $config ['num_tag_open'] = '<li>';
        $config ['num_tag_close'] = '</li>';
        $config ['cur_tag_open'] = '<li class="active"><a>';
        $config ['cur_tag_close'] = '</a></li>';
        $config ['prev_tag_open'] = '<li>';
        $config ['prev_tag_close'] = '</li>';
        $config ['next_tag_open'] = '<li>';
        $config ['next_tag_close'] = '</li>';
        $config ['page_query_string'] = FALSE;
        $ci->pagination->initialize($config);
        return $config;
    }

}
/**
 * Mehtod: init_admin_pagination
 * params: $uri, $total_records,$perpage
 * return: pagination configuration
 */
if (!function_exists('init_admin_pagination')) {

    function init_admin_pagination($uri, $total_records, $perpage) {
        $ci = & get_instance();
        $config ["base_url"] = base_url() . $uri;

        $prev_link = '&laquo;';
        $next_link = '&raquo;';
        $config ["total_rows"] = $total_records;
        $config ["per_page"] = $perpage;
        $config ['uri_segment'] = '4';
        $config ['first_link'] = '';
        $config ['last_link'] = '';
        $config ['num_links'] = '5';
        $config ['prev_link'] = $prev_link;
        $config ['next_link'] = $next_link;
        $config ['num_tag_open'] = '<li>';
        $config ['num_tag_close'] = '</li>';
        $config ['cur_tag_open'] = '<li class="active"><a>';
        $config ['cur_tag_close'] = '</a></li>';
        $config ['prev_tag_open'] = '<li>';
        $config ['prev_tag_close'] = '</li>';
        $config ['next_tag_open'] = '<li>';
        $config ['next_tag_close'] = '</li>';
        $config ['page_query_string'] = FALSE;
        $ci->pagination->initialize($config);
        return $config;
    }

}


/**
 * Mehtod: init_front_pagination
 * params: $uri, $total_records,$perpage
 * return: pagination configuration
 */
if (! function_exists ( 'init_front_pagination' )) {
    function init_front_pagination($uri, $total_records, $perpage) {
       $ci = & get_instance();
        $config ["base_url"] = base_url() . $uri;

        $prev_link = '&laquo;';
        $next_link = '&raquo;';
        $config ["total_rows"] = $total_records;
        $config ["per_page"] = $perpage;
        $config ['uri_segment'] = '3';
        $config ['first_link'] = '';
        $config ['last_link'] = '';
        $config ['num_links'] = '3';
        $config ['prev_link'] = $prev_link;
        $config ['next_link'] = $next_link;
        $config ['num_tag_open'] = '<li>';
        $config ['num_tag_close'] = '</li>';
        $config ['cur_tag_open'] = '<li class="active"><a>';
        $config ['cur_tag_close'] = '</a></li>';
        $config ['prev_tag_open'] = '<li>';
        $config ['prev_tag_close'] = '</li>';
        $config ['next_tag_open'] = '<li>';
        $config ['next_tag_close'] = '</li>';
        $config ['page_query_string'] = FALSE;
        $ci->pagination->initialize($config);
        return $config;
    }
}

if(!function_exists('getLanguagesArray')){
	function getLanguagesArray(){
	return $language_codes = array(
        'en' => 'English' , 
        'aa' => 'Afar' , 
        'ab' => 'Abkhazian' , 
        'af' => 'Afrikaans' , 
        'am' => 'Amharic' , 
        'ar' => 'Arabic' , 
        'as' => 'Assamese' , 
        'ay' => 'Aymara' , 
        'az' => 'Azerbaijani' , 
        'ba' => 'Bashkir' , 
        'be' => 'Byelorussian' , 
        'bg' => 'Bulgarian' , 
        'bh' => 'Bihari' , 
        'bi' => 'Bislama' , 
        'bn' => 'Bengali/Bangla' , 
        'bo' => 'Tibetan' , 
        'br' => 'Breton' , 
        'ca' => 'Catalan' , 
        'co' => 'Corsican' , 
        'cs' => 'Czech' , 
        'cy' => 'Welsh' , 
        'da' => 'Danish' , 
        'de' => 'German' , 
        'dz' => 'Bhutani' , 
        'el' => 'Greek' , 
        'eo' => 'Esperanto' , 
        'es' => 'Spanish' , 
        'et' => 'Estonian' , 
        'eu' => 'Basque' , 
        'fa' => 'Persian' , 
        'fi' => 'Finnish' , 
        'fj' => 'Fiji' , 
        'fo' => 'Faeroese' , 
        'fr' => 'French' , 
        'fy' => 'Frisian' , 
        'ga' => 'Irish' , 
        'gd' => 'Scots/Gaelic' , 
        'gl' => 'Galician' , 
        'gn' => 'Guarani' , 
        'gu' => 'Gujarati' , 
        'ha' => 'Hausa' , 
        'hi' => 'Hindi' , 
        'hr' => 'Croatian' , 
        'hu' => 'Hungarian' , 
        'hy' => 'Armenian' , 
        'ia' => 'Interlingua' , 
        'ie' => 'Interlingue' , 
        'ik' => 'Inupiak' , 
        'in' => 'Indonesian' , 
        'is' => 'Icelandic' , 
        'it' => 'Italian' , 
        'iw' => 'Hebrew' , 
        'ja' => 'Japanese' , 
        'ji' => 'Yiddish' , 
        'jw' => 'Javanese' , 
        'ka' => 'Georgian' , 
        'kk' => 'Kazakh' , 
        'kl' => 'Greenlandic' , 
        'km' => 'Cambodian' , 
        'kn' => 'Kannada' , 
        'ko' => 'Korean' , 
        'ks' => 'Kashmiri' , 
        'ku' => 'Kurdish' , 
        'ky' => 'Kirghiz' , 
        'la' => 'Latin' , 
        'ln' => 'Lingala' , 
        'lo' => 'Laothian' , 
        'lt' => 'Lithuanian' , 
        'lv' => 'Latvian/Lettish' , 
        'mg' => 'Malagasy' , 
        'mi' => 'Maori' , 
        'mk' => 'Macedonian' , 
        'ml' => 'Malayalam' , 
        'mn' => 'Mongolian' , 
        'mo' => 'Moldavian' , 
        'mr' => 'Marathi' , 
        'ms' => 'Malay' , 
        'mt' => 'Maltese' , 
        'my' => 'Burmese' , 
        'na' => 'Nauru' , 
        'ne' => 'Nepali' , 
        'nl' => 'Dutch' , 
        'no' => 'Norwegian' , 
        'oc' => 'Occitan' , 
        'om' => '(Afan)/Oromoor/Oriya' , 
        'pa' => 'Punjabi' , 
        'pl' => 'Polish' , 
        'ps' => 'Pashto/Pushto' , 
        'pt' => 'Portuguese' , 
        'qu' => 'Quechua' , 
        'rm' => 'Rhaeto-Romance' , 
        'rn' => 'Kirundi' , 
        'ro' => 'Romanian' , 
        'ru' => 'Russian' , 
        'rw' => 'Kinyarwanda' , 
        'sa' => 'Sanskrit' , 
        'sd' => 'Sindhi' , 
        'sg' => 'Sangro' , 
        'sh' => 'Serbo-Croatian' , 
        'si' => 'Singhalese' , 
        'sk' => 'Slovak' , 
        'sl' => 'Slovenian' , 
        'sm' => 'Samoan' , 
        'sn' => 'Shona' , 
        'so' => 'Somali' , 
        'sq' => 'Albanian' , 
        'sr' => 'Serbian' , 
        'ss' => 'Siswati' , 
        'st' => 'Sesotho' , 
        'su' => 'Sundanese' , 
        'sv' => 'Swedish' , 
        'sw' => 'Swahili' , 
        'ta' => 'Tamil' , 
        'te' => 'Tegulu' , 
        'tg' => 'Tajik' , 
        'th' => 'Thai' , 
        'ti' => 'Tigrinya' , 
        'tk' => 'Turkmen' , 
        'tl' => 'Tagalog' , 
        'tn' => 'Setswana' , 
        'to' => 'Tonga' , 
        'tr' => 'Turkish' , 
        'ts' => 'Tsonga' , 
        'tt' => 'Tatar' , 
        'tw' => 'Twi' , 
        'uk' => 'Ukrainian' , 
        'ur' => 'Urdu' , 
        'uz' => 'Uzbek' , 
        'vi' => 'Vietnamese' , 
        'vo' => 'Volapuk' , 
        'wo' => 'Wolof' , 
        'xh' => 'Xhosa' , 
        'yo' => 'Yoruba' , 
        'zh' => 'Chinese' , 
        'zu' => 'Zulu' , 
        );
	}}







if(!function_exists('getBranches')){
function getBranches($term=null){
 $ci = & get_instance ();
    $sql_ = 'EXEC  GetBranchList ';
    $result = $ci->db->query($sql_)->result_array();
	return $result;	
}
}	

if(!function_exists('getCustomers')){
function getCustomers($term=null){
$ci = & get_instance ();
$sql_ = 'EXEC  GetCustomerList ';
$result = $ci->db->query($sql_)->result_array();
array_push($result,['Id' => 0,'CName' => 'Please Select Customer']);
return $result;	
}
}	

if(!function_exists('getUsers')){
function getUsers($term){
$ci = & get_instance ();
$sql_ = 'EXEC  GetUserList ';
$result = $ci->db->query($sql_)->result_array();
return $result;	
}
}	

if(!function_exists('getProducts')){
function getProducts($term){
$ci = & get_instance();
$sql_ = "EXEC  GetProductList @str='".$term."'";
$result = $ci->db->query($sql_)->result_array();
return $result;	
}
}	


if(!function_exists('getProductGroup')){
function getProductGroup($term=null){
$ci = & get_instance ();
$sql_ = 'EXEC  GetProductGroupList  ';
$result = $ci->db->query($sql_)->result_array();
return $result;	
}
}	
