<?php
$base_folder_int = '/web/tmp/';
$auth_key = '001000001000';
error_reporting(0);
header('Content-type: text/json; charset=utf-8');
$code = (object)array();
$code->status = null;
$code->mode = null;
$code->ssid = isset($_GET['ssid']) ? $_GET['ssid'] : null;
$where['key'] = isset($_GET['where']) ? $_GET['where'] : null;
$where['value'] = isset($_GET['whval']) ? $_GET['whval'] : null;
$reset['key'] = isset($_GET['reset']) ? $_GET['reset'] : null;
$reset['old'] = isset($_GET['old']) ? $_GET['old'] : null;
$reset['new'] = isset($_GET['new']) ? $_GET['new'] : null;
$code->where = $where;
$code->reset = $reset;
$data = array();
$data['size'] = 0;

if ( !empty($code->ssid) ) {
	if ( empty($code->reset['key']) ) {
		$code->mode = 'view';
		$temp = getSESS($code->ssid);
		if ( !$temp ) {
			goto FINISH;
		}
		array_push($data, $temp);
	}
	else {
		$code->mode = 'reset';
		if ( !isset($_GET['auth']) ) {
			goto FINISH;
		}
		if ($_GET['auth'] != $auth_key ) {
			goto FINISH;
		}
		if ( $code->reset['old'] == null || $code->reset['new'] == null ) {
			goto FINISH;
		}
		$temp = getSESS($code->ssid);
		if ( !$temp ) {
			goto FINISH;
		}
		if ( !isset($temp[$code->reset['key']]) ) {
			goto FINISH;
		}
		/*if ( !is_OK($code->reset['old'], $temp[$code->reset['key']]) ) {
			$code->reset['old'] = null;
			goto FINISH;
		}*/
		resetSESS($code->ssid, $code->reset['key'], $code->reset['old'], $code->reset['new']);
		$temp = getSESS($code->ssid);
		array_push($data, $temp);
	}
}
else {
	if ( !empty($code->where['key']) ) {
		$code->mode = 'search';
		if ( empty($code->where['value']) ) {
			goto FINISH;
		}
		global $base_folder_int;
		if ( is_dir($base_folder_int) ) {
			if ( $dh = opendir($base_folder_int) ) {
				while ( ($file = readdir($dh)) !== false ) {
					if ( strstr($file, 'sess_') != null ) {
						$ssid = explode('_', $file)[1];
						$temp = getSESS($ssid);
						if ( !isset($temp[$code->where['key']]) ) {
							continue;
						}
						if ( in_array($code->where['value'], $temp[$code->where['key']]) ) {
							array_push($data, $temp);
						}
					}
				}
				closedir($dh);
			}
		}
	}
}

function is_OK($word, $arr) {
	foreach ( $arr as $key => $value ) {
		if ( strstr($value, $word) ) {
			return true;
		}
	}
	return false;
}

function resetSESS($ssid, $rekey, $old, $new) {
	global $base_folder_int;
	$filename = $base_folder_int."sess_$ssid";
	$contents = file_get_contents($filename);
	$cut = '';
	$tmp = preg_split('/(?<!^)(?!$)/u', $rekey);
	foreach ( $tmp as $key => $value ) {
		$cut = $cut.'['.$value.']';
	}
	$temp = preg_split('/'.$cut.'/u', $contents);
	$cut = '';
	$tmp = preg_split('/(?<!^)(?!$)/u', $old);
	foreach ( $tmp as $key => $value ) {
		$cut = $cut.'['.$value.']';
	}
	$flag = preg_split('/'.$cut.'/u', $temp[1]);
	$fixed = $temp[0].$rekey.$flag[0].$new.$flag[1];
	for ( $i = 1; $i < count($flag, 0); ++$i ) {
		if ( $i > 1 ) {
			$fixed = $fixed.$old.$flag[$i];
		}
	}
	$refile = fopen($filename, "w");
	fwrite($refile, $fixed);
	fclose($refile);
	$contents = file_get_contents($filename);
	return;
}

function getSESS($ssid) {
	global $base_folder_int;
	$filename = $base_folder_int."sess_$ssid";
	if ( !@fopen($filename, 'r') ) {
		return false;
	}
	$contents = file_get_contents($filename);
	if ( empty($contents) ) {
		return false;
	}
	$contents = preg_split('/[|][a-z][:]/', $contents);
	$res = array();
	$key = $contents[0];
	$value = null;
	for ( $i = 1; $i < count($contents, 0)-1; ++$i ) {
		$tmp = preg_split('/["][;]/', $contents[$i]);
		$value = $tmp[0];
		$res[$key] = $value;
		$key = $tmp[1];
	}
	$res[$key] = $contents[count($contents, 0)-1];
	foreach ( $res as $key => $value ) {
		$val = preg_split('/["][;]/', $value);
		if ( count($val, 0) > 1 ) {
			$value = array();
			for ( $i = 0; $i < count($val, 0); ++$i ) {
				$tmp = preg_split('/[:]["]/', $val[$i]);
				if ( !isset($tmp[1]) ) {
					continue;
				}
				array_push($value, $tmp[1]);
			}
		}
		else {
			$value = array(preg_split('/[0-9][:]["]/', $val[0])[1]);
		}
		$res[$key] = $value;
	}
	$res['update_time'] = date('Y-m-d H:i:s', fileatime($filename));
	$res['session_id'] = $ssid;
	return $res;
}

FINISH:
$data['size'] = count($data, 0)-1;
$code->data = $data;
if ( !isset($data) || !isset($data['size']) || $data['size'] == 0 ) {
	$code->status = 'error';
}
else {
	$code->status = 'success';
}
if ( empty($code->mode) ) {
	$code->mode = 'none';
}
echo 'session('.json_encode($code).');';
exit;
?>
