<?php
//use DB;
//use Storage;


function dde($arr){
	echo "<pre>"; print_r($arr);die;
}

function random_text($length_of_string = 8) {
    $chr = 'GHIJKLA123MNOSTUVW0XYZPQR456789BCDEF'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $length_of_string; $i++) { 
        $index = rand(0, strlen($chr) - 1); 
        $randomString .= $chr[$index]; 
    }   
    return $randomString; 
}

function random_number($length_of_string = 8) {
    $chr = '1234506789'; 
    $randomString = ''; 
    for ($i = 0; $i < $length_of_string; $i++) { 
        $index = rand(0, strlen($chr) - 1); 
        $randomString .= $chr[$index]; 
    }   
    return '9'.$randomString; 
}

function qry($str){
	$data = DB::select($str);
	return $data;
}

function insert_data($tbl,$data){
	DB::table($tbl)->insert($data);
}

function insert_data_id($tbl,$data){
	$id = DB::table($tbl)->insertGetId($data);
	return $id;
}

function update_data($tbl,$data,$con){
	$affected_id = DB::table($tbl)->where($con)->update($data);
	return $affected_id;
}


function UploadImage($file, $dir,$filename_prefix='') {
    $percent = 0.6;
    $fileName = $filename_prefix.uniqid().time() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('storage'. '/'. $dir), $fileName);
    $urlFile = public_path('/storage') . '/' . $dir . '/' . $fileName;

    $filesize = filesize($urlFile)/1024;

    if($filesize>512 && (in_array(strtolower($file->getClientOriginalExtension()), Config::get('constants.image_extension')))){
        list($width, $height) = getimagesize($urlFile);
        $newwidth = $width * $percent;
        $newheight = $height * $percent;
        $imgThumb = Image::make($urlFile)->resize($newwidth, $newheight, function ($constraint) {
            $constraint->aspectRatio();
        });
        $imgThumb->save($urlFile);
    }
    return $fileName;
}


function DeleteFile($filename, $dir) {
    $existImage = public_path('storage/'.$dir.'/'.$filename);
        if (File::exists($existImage)) {
            File::delete($existImage);
        }
    return 1;
}


function sendMail($html, $useremail, $username, $subject, $data =[]){
    return 1;
    
    Mail::send('client.mail.msg', $data, function ($message) use ($useremail,$username,$subject) {
            $message->from('xyz@gmail.com', 'Bigdaddy')
                ->to($useremail, $username)
                ->subject($subject);
    });
    return 1;
}

function constants($key=''){
    if(trim($key=='')){
        return 0;
    }
    else
    {
        return Config::get('constants.'.$key);
    }
}

function sendPath(){
    return asset('storage').'/';
}

function valid_mobile($mobile='') {
    $mobileregex = "/^[6-9][0-9]{9}$/";  
    if(strlen($mobile)==10 && preg_match($mobileregex, $mobile) === 1)
    {
        return true;
    }
    return false;
}

function valid_id($id='') {
    if(is_numeric($id) && $id>0)
    {
        return true;
    }
    return false;
}


function valid_password($password='') {
    if(strlen(trim($password))>=6 && strlen(trim($password))<25)
    {
        return true;
    }
    return false;
}

function valid_email($email='') {
    if($email!='' && filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
    return false;
}

function createOTP($number=6) {
    return 1111;
    return mt_rand(str_repeat(1,$number),str_repeat(9,$number));
}


function sendMsg($text='', $mobile=''){
    return true;
}


function getIPAddress() {  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  

function get_file_extension($file_name) {
    return substr(strrchr($file_name,'.'),1);
}












