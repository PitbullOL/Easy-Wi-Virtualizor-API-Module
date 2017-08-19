<?php

$ui_array = json_decode(json_encode($ui),true);

function get_api_db($userid,$key) {
    global $sql;
    if(!$key) { return null; }
    $query = $sql->prepare("SELECT `customID`,`var` FROM `custom_columns` WHERE `itemID` = ?;");
    $query->execute(array(intval($userid))); $get = array();
    if(!$query->rowCount()) { return null; }
    
    while($rows = $query->fetch(PDO::FETCH_ASSOC)) {
            $get[$rows['customID']] = utf8_decode($rows['var']);
    } unset($rows,$query);

    if($key >= 1) {
            return $get[intval($key)];
    }

    if($key >= 0) {
            echo "Modul nicht verfügbar!";
    }

    return $get;
}

function show_template($tplfile,array $pholder = array()) {
    if(file_exists(EASYWIDIR . '/template/default/user/'.$tplfile)) {
        $source = file_get_contents(EASYWIDIR . '/template/default/user/'.$tplfile);
    } else {
        $source = $tplfile;
    }
    
    foreach ($pholder as $key => $value) {
        $source = str_ireplace('{'.$key.'}', $value, $source);
    }
    
    return $source;
}

function random_password($passwordLength=8, $specialcars=true) {
    $passwordComponents = array("ABCDEFGHIJKLMNOPQRSTUVWXYZ" , "abcdefghijklmnopqrstuvwxyz" , "0123456789" , "#$@!");
    $componentsCount = count($passwordComponents);
    if(!$specialcars && $componentsCount == 4) {
        unset($passwordComponents[3]);
        $componentsCount = count($passwordComponents);
    }

    shuffle($passwordComponents); $password = '';
    for ($pos = 0; $pos < $passwordLength; $pos++) {
        $componentIndex = ($pos % $componentsCount);
        $componentLength = strlen($passwordComponents[$componentIndex]);
        $random = rand(0, $componentLength-1);
        $password .= $passwordComponents[$componentIndex]{ $random };
    }

    return $password;
}

function msg_info_box($msg='',$class='alert-success',$msg_hide=false) {
    return show_template('virtualizor_msg.tpl',
            array('msg_hide' => $msg_hide ? ' hide' : '',
                'class' => $class,
                'msg' => $msg));
}