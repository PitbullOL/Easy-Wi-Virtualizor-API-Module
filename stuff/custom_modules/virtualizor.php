<?php

if ((!isset($user_id) or $main != 1)) {
    header('Location: userpanel.php');
    die;
}

include_once(EASYWIDIR . '/stuff/custom_modules/api/module_functions.php');
include_once(EASYWIDIR . '/stuff/custom_modules/api/config.php');
include_once(EASYWIDIR . '/stuff/custom_modules/api/virtualizor_api.php');
$sprache = getlanguagefile('vm', $user_language, $reseller_id);

if(array_key_exists('ajax', $ui_array['get'])) {
    $v = new Virtualizor_Enduser_API($host_ip, $key, $key_pass);
    
    switch($ui_array['get']['status']) {
        case 'all':
            $servers = array();
            foreach($v->listvs() as $sid => $data){
                $monitor = $v->monitor($sid);
                
                if($data['status']) { 
                        $status_style = 'rgba(0, 150, 136, 0.09)';
                        $status_class = 'panel box box-success';
                        $status_icon = 'info-box-icon bg-green';
                } else {
                        $status_style = 'rgba(255, 138, 0, 0.09)';
                        $status_class = 'panel box box-danger';
                        $status_icon = 'info-box-icon bg-red';
                }
                
                $servers[$sid]['style'] = array('css' => $status_style, 
                    'class' => $status_class, 
                    'icon' => $status_icon);
                
                $servers[$sid]['ram'] = $monitor['ram'];
                $servers[$sid]['disk'] = $monitor['disk'];
                $servers[$sid]['bandwidth'] = $v->bandwidth($sid);
                $servers[$sid]['cpu'] = $monitor['cpu']['cpu'];
            }
            exit(json_encode($servers));
        break;
        case 'server':
            if(isset($ui_array['get']['sid']) && !empty($ui_array['get']['sid'])) {
                if(!empty($host_ip) && !empty($key) && !empty($key_pass) ) {
                    $v = new Virtualizor_Enduser_API($host_ip, $key, $key_pass);
                    $data = $v->listvs();
                    if(array_key_exists($ui_array['get']['sid'], $data)) {
                        exit(json_encode(array('sid' => $ui_array['get']['sid'], 
                            'status' => intval($data[intval($ui_array['get']['sid'])]['status']))));
                    }
                }
            }
            
            exit(json_encode(array('sid' => $ui_array['get']['sid'], 'status' => '0')));
            break;
    }
}

if(!empty($host_ip) && !empty($key) && !empty($key_pass) ) {
    $v = new Virtualizor_Enduser_API($host_ip, $key, $key_pass); $msg = "";
    $sprache = getlanguagefile('vm', $user_language, $reseller_id);
    switch ((isset($ui_array['post']['option']) ? strtolower($ui_array['post']['option']) : '')) {
        case 'start_stop':
        switch (isset($ui_array['post']['action']) ? strtolower($ui_array['post']['action']) : ''){
        case 'start':
            if(!$v->status(intval($ui_array['get']['sid']))) {
                if($v->start(intval($ui_array['get']['sid']))) {
                    $msg .= msg_info_box($sprache->sstart);
                } else {
                    $msg .= msg_info_box($sprache->fail,"alert-danger");
                }
            } else {
                $msg .= msg_info_box($sprache->srunning,"alert-warning");
            }
        break;
        case 'stop':
            $msg_hide = "";
            if($v->status(intval($ui_array['get']['sid']))) {
                if($v->stop(intval($ui_array['get']['sid']))) {
                        $msg .= msg_info_box($sprache->sstop);
                } else {
                        $msg .= msg_info_box($sprache->fail,"alert-danger");
                }
            } else {
                    $msg .= msg_info_box($sprache->soff,"alert-warning");
            }
        break;
        case 'restart':
            $msg_hide = "";
            if($v->stop(intval($ui_array['get']['sid']))) {
                if($v->restart(intval($ui_array['get']['sid']))) {
                        $msg .= msg_info_box($sprache->restart);
                } else {
                        $msg .= msg_info_box($sprache->fail,"alert-danger");
                }
            } else {
                    $msg .= msg_info_box($sprache->srunning,"alert-warning");
            }
        break;
        case 'poweroff':
            $msg_hide = "";
            if($v->status(intval($ui_array['get']['sid']))) {
                if($v->poweroff(intval($ui_array['get']['sid']))) {
                        $msg .= msg_info_box($sprache->sshutdown);
                } else {
                        $msg .= msg_info_box($sprache->fail,"alert-danger");
                }
            } else {
                    $msg .= msg_info_box($sprache->soff,"alert-warning");
            }
        break;
    }
        break;
        case 'root_password':
            $msg_hide = ""; $root_passwd = false;
            if(empty($ui_array['post']['changepassword'])) {
                $root_passwd = random_password(15);
            }
            $v->changepassword(intval($ui_array['get']['sid']),
                    (!empty($ui_array['post']['changepassword']) ? $ui_array['post']['changepassword'] : $root_passwd));
            $msg .= msg_info_box($sprache->changepw);
            if($root_passwd) {
                $msg .= msg_info_box($sprache->nopw,"alert-info");
                $msg .= msg_info_box($sprache->pwgen .$root_passwd,"alert-warning");
            } else {
                $msg .= msg_info_box($sprache->pw .$ui_array['post']['changepassword'],"alert-info");
            }  
        break;
        case 'new_hostname':
            $msg_hide = "";
            if(!empty($ui_array['post']['hostname'])) {
                if($v->hostname(intval($ui_array['get']['sid']), ($ui_array['post']['hostname']))) {
                    $msg .= msg_info_box($sprache->changehn);
                    $msg .= msg_info_box($sprache->hnl .$ui_array['post']['hostname'],"alert-info");
                } else {
                    $msg .= msg_info_box($sprache->hnf ,"alert-warning");
                }
            } else {
                    $msg .= msg_info_box($sprache->changehnf ,"alert-warning");
            }
        break;
        case 'install_server':
            $msg_hide = ""; $root_passwd = false;
            if(empty($ui_array['post']['server_passwd'])) {
                $root_passwd = random_password(15);
            }

            $os_id = intval($ui_array['post']['server_os']);
            $os_list = $v->ostemplate(intval($ui_array['get']['sid']),$os_id,
                    (!empty($ui_array['post']['server_passwd']) ? $ui_array['post']['server_passwd'] : $root_passwd));
            ($os_list);
            $msg .= msg_info_box($sprache->changedi);

            if($root_passwd) {
                $msg .= msg_info_box($sprache->nopw ,"alert-info");
                $msg .= msg_info_box($sprache->pwgen .$root_passwd,"alert-warning");
            } else {
                $msg .= msg_info_box($sprache->pw .$ui_array['post']['server_passwd'] ,"alert-info");
            } 
        break;
        case 'vnc_pass':
            $msg_hide = ""; $root_passwd = false;
            if(empty($ui_array['post']['vncpass'])) {
                $root_passwd = random_password(15, false);
            }
            $v->vncpass(intval($ui_array['get']['sid']),
                    (!empty($ui_array['post']['vncpass']) ? $ui_array['post']['vncpass'] :$root_passwd));
            $msg .= msg_info_box($sprache->changepwvnc);
            if($root_passwd) {
                $msg .= msg_info_box($sprache->nopwvnc,"alert-info");
                $msg .= msg_info_box($sprache->pwgenvnc .$root_passwd,"alert-warning");
            } else {
                $msg .= msg_info_box($sprache->pwvnc .$ui_array['post']['vncpass'],"alert-info");
            }  
        break;
        case 'rescueenable':
            $msg_hide = ""; $root_passwd = false;
            if(empty($ui_array['post']['pass'])) {
                $root_passwd = random_password(15);
            }
            $v->rescue(intval($ui_array['get']['sid']),
                    (!empty($ui_array['post']['pass']) ? $ui_array['post']['pass'] :$root_passwd));
            $msg .= msg_info_box($sprache->changepwres);
            if($root_passwd) {
                $msg .= msg_info_box($sprache->nopwres,"alert-info");
                $msg .= msg_info_box($sprache->pwgenres .$root_passwd,"alert-warning");
            } else {
                $msg .= msg_info_box($sprache->pwres .$ui_array['post']['pass'],"alert-info");
            }
        break;
        case 'disablerescue':
            $msg_hide = "";
            if($v->disable_rescue(intval($ui_array['get']['sid']))) {
                $msg .= msg_info_box($sprache->rescuedis);
                } else {
                $msg .= msg_info_box($sprache->fail,"alert-danger");
            }
        break;
    }

    $option = ''; $run = false; $servers = '';
    foreach($v->listvs() as $sid => $data){
        foreach($data as $key => $wert){
            $ips = "-"; $hostname = "-";
            switch ($key) {
                case 'ips':
                    if(count($wert) >= 1) {
                        $ips = '';
                        foreach ($wert as $null => $ip) {
                            $ips .= $ip.' | ';
                        }

                        $ips = substr($ips, 0, -3);
                    }
                break;
                }
            }

        $os_list = $v->ostemplate($sid); $option_os ='';
        foreach($os_list as $os_name => $data_os) {
            foreach($data_os as $os_id => $os_infos) {
                $option_os .= '<option value="'.$os_id.'">'.$os_infos['name'].'</option>';
            }
        }
        
        $vnc = $v->vnc($sid);
        $rescue = $v->rescue($sid);
        $bandwidth = $v->bandwidth($sid);
        $monitor = $v->monitor($sid);
        $ram = $monitor['ram'];
        $disk = $monitor['disk'];
        $cpu = $monitor['cpu']['cpu'];
        
        if($data['rescue']){
            $hiddenresoff = '';
            $hiddenreson = 'position: absolute; top: -9999px; left: -9999px;';
        } else {
            $hiddenreson = '';
            $hiddenresoff = 'position: absolute; top: -9999px; left: -9999px;';
        }
        
        if(is_array($vnc)) { 
            $hidden = '';
        } else {
            $hidden = 'position: absolute; top: -9999px; left: -9999px;';
        }
        
        if($data['status']) { 
            $status_style = 'background-color: rgba(0, 150, 136, 0.09);';
            $status_class = 'panel box box-success';
            $status_icon = 'info-box-icon bg-green';
	} else {
            $status_style = 'background-color: rgba(255, 138, 0, 0.09);';
            $status_class = 'panel box box-danger';
            $status_icon = 'info-box-icon bg-red';
	}

        $servers .= show_template('virtualizor_servers.tpl',array(
            'server_ip' => $ips,
            'server_host' => $data['hostname'],
            'server_os' => $data['os_name'],
            'server_os_pic' => $data['distro'],
            'server_os' => $data['os_name'],
            'svst' => $data['status'],
            'server_os_options' => $option_os, 
            'status_style' => $status_style,
            'status_class' => $status_class,
            'status_icon' => $status_icon,
            'status_ser' => $status_ser,
            'hidden' => $hidden,
            'hiddenresoff' => $hiddenresoff,
            'hiddenreson' => $hiddenreson,
            'cpupercent_free' => $cpu['percent_free'],
            'cpupercent' => $cpu['percent'],
            'cpumanu' => $monitor['manu'],
            'cpulimit' => $cpu['limit'],
            'rampercent_free' => $ram['percent_free'],
            'rampercent' => $ram['percent'],
            'ramlimit' => $ram['limit'],
            'disklimit' => $disk['disk']['limit_gb'],
            'diskpercent' => $disk['disk']['percent'],
            'diskpercent_free' => $disk['disk']['percent_free'],
            'bandwidthlimit' => $bandwidth['limit_gb'],
            'bandwidthpercent' => $bandwidth['percent'],
            'bandwidthpercent_free' => $bandwidth['percent_free'],
            'vncip' => $vnc['ip'],
            'vncport' => $vnc['port'],
            'vncpw' => $vnc['password'],
            'serverfunc' => $sprache->serverfunc,
            'nerp' => $sprache->newrp,
            'setrp' => $sprache->setrp,
            'newhn' => $sprache->newhn,
            'sethn' => $sprache->sethn,
            'serverre' => $sprache->serverre,
            'chodi' => $sprache->chodi,
            'setrpdi' => $sprache->setrpdi,
            'rp' => $sprache->rp,
            'startbt' => $sprache->startbt,
            'stopbt' => $sprache->stopbt,
            'restartbt' => $sprache->restartbt,
            'shutdownbt' => $sprache->shutdownbt,
            'changebt' => $sprache->changebt,
            'installbt' => $sprache->installbt,
            'cpu' => $sprache->cpu,
            'ram' => $sprache->ram,
            'disk' => $sprache->disk,
            'bw' => $sprache->bw,
            'ac' => $sprache->ac,
            'free' => $sprache->free,
            'vnc' => $sprache->vnc,
            'vncp' => $sprache->vncp,
            'setvnc' => $sprache->setvnc,
            'vncips' => $sprache->vncips,
            'vncpos' => $sprache->vncpos,
            'vncpws' => $sprache->vncpws,
            'rescuefu' => $sprache->rescuefu,
            'rescueset' => $sprache->rescueset,
            'rescuepw' => $sprache->rescuepw,
            'hn' => $sprache->hn,
            'ip' => $sprache->ip,
            'os' => $sprache->os,
            'sid' => $sid));
    }
    
    $template_file = '/default/user/virtualizor_body.tpl';
    } else {
    if(!empty($host_ip) && !empty($key) && !empty($key_pass) ) {
        //
    }
 
    $template_file = '/default/user/userpanel_404.tpl';
}