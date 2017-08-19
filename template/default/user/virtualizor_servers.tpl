<div class="col-md-12">
    <div name="server" id="{sid}" class="{status_class}" style="{status_style}">
        <div class="box-header">
            <h3 class="box-title">
                <a data-widget="collapse"></a></h3>
		<div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
                <div class="info-box">
        <!-- Apply any bg-* class to to the icon to color it -->
        <span id="icon_{sid}" class="{status_icon}"><i class="fa fa-server"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">{hn}{server_host}</span>
          <span class="info-box-text">{ip}{server_ip}</span>
          <span class="info-box-text">{os}{server_os}</span>
        </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
        </div>
            <div style="display: block;" class="box-body">
                <div class="form-group">
                            <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="info-box bg-aqua">
                                <span class="info-box-icon"><i class="fa fa-server"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{cpu} <span id="cpu_cpumanu_{sid}">{cpulimit}</span> MHz</span>
                                    <span class="info-box-number"><span id="cpu_percent_{sid}">{cpupercent}</span>% {ac}</span>
                                  <div class="progress">
                                    <div id="cpu_percent_2_{sid}" style="width: {cpupercent}%" class="progress-bar"></div>
                                  </div>
                                    <span class="progress-description"><span id="cpu_percent_free_{sid}">{cpupercent_free}</span>% {free}</span>
                                </div><!-- /.info-box-content -->
                              </div><!-- /.info-box -->
                            </div><!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="info-box bg-aqua">
                                <span class="info-box-icon"><i class="fa fa-server"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{ram} <span id="ram_limit_{sid}"> {ramlimit}</span> MB</span>
                                    <span class="info-box-number"><span id="ram_percent_{sid}">{rampercent}</span>% {ac}</span>
                                  <div class="progress">
                                    <div id="ram_percent_2_{sid}" style="width: {rampercent}%" class="progress-bar"></div>
                                  </div>
                                    <span class="progress-description"><span id="ram_percent_free_{sid}">{rampercent_free}</span>% {free}</span>
                                </div><!-- /.info-box-content -->
                              </div><!-- /.info-box -->
                            </div><!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="info-box bg-aqua">
                                <span class="info-box-icon"><i class="fa fa-server"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{disk} <span id="disk_limit_{sid}"> {disklimit}</span> GB</span>
                                    <span class="info-box-number"><span id="disk_percent_{sid}">{diskpercent}</span>% {ac}</span>
                                  <div class="progress">
                                    <div id="disk_percent_2_{sid}" style="width: {diskpercent}%" class="progress-bar"></div>
                                  </div>
                                    <span class="progress-description"><span id="disk_percent_free_{sid}">{diskpercent_free}</span>% {free}</span>
                                </div><!-- /.info-box-content -->
                              </div><!-- /.info-box -->
                            </div><!-- /.col -->
                            <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="info-box bg-aqua">
                                <span class="info-box-icon"><i class="fa fa-signal"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">{bw} <span id="bandwidth_limit_{sid}"> {bandwidthlimit}</span> GB</span>
                                  <span class="info-box-number"><span id="bandwidth_percent_{sid}">{bandwidthpercent}</span>% {ac}</span>
                                  <div class="progress">
                                    <div id="bandwidth_percent_2_{sid}" style="width: {bandwidthpercent}%" class="progress-bar"></div>
                                  </div>
                                    <span class="progress-description"><span id="bandwidth_percent_free_{sid}">{bandwidthpercent_free}</span>% {free}</span>
                                </div><!-- /.info-box-content -->
                              </div><!-- /.info-box -->
                            </div><!-- /.col -->
                          </div>
                            <div class="box box-solid box-default">
                                <div class="box box-primary">
                                <div class="box-header with-border">
                                <h3 class="box-title">{serverfunc}</h3>
                                </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <form id="test{sid}" name="test{sid}" method="post" action="?w=virt&sid={sid}">
                                            <input type="hidden" name="option" value="start_stop">
                                            <button type="submit" name="action" id="start" value="start" class="btn btn-sm btn-success inline"><i class="icon-white icon-play"></i>{startbt}</button>
                                            <button type="submit" name="action" id="stop" value="stop" class="btn btn-sm btn-danger"><i class="fa fa-power-off"></i> {stopbt}</button>
                                            <button type="submit" name="action" id="restart" value="restart"class="btn btn-sm btn-warning"><i class="fa fa-refresh"></i> {restartbt}</button>
                                            <button type="submit" name="action" id="poweroff" value="poweroff"class="btn btn-sm btn-danger"><i class="fa fa-refresh"></i> {shutdownbt}</button>
                                            <br>
                                            <br>
                                        </form>
                                        <form id="test{sid}" name="test{sid}" method="post" action="?w=virt&sid={sid}">
                                            <input type="hidden" name="option" value="root_password">
                                            {nerp}<br />
                                            <input type="text" placeholder="{setrp}" name="changepassword" id="changepassword" class="form-control" />
                                            <br>
                                            <button name="action" id="changerp" value="changerp" class="btn btn-sm btn-success inline"><i class="fa fa-refresh"></i> {changebt}</button>
                                            <br />
                                        </form>
                                        <form id="test{sid}" name="test{sid}" method="post" action="?w=virt&sid={sid}">
                                            <input type="hidden" name="option" value="new_hostname">
                                            <br>
                                            {newhn}<br>
                                            <input type="text" placeholder="{sethn}" name="hostname" id="hostname" class="form-control" />
                                            <br>
                                            <button type="submit" name="action" id="changehostname" value="changehostname" class="btn btn-sm btn-success inline"><i class="fa fa-refresh"></i> {changebt}</button>
                                        </form>
                                    </div><!-- /.box-body -->
                                </div>
                            </div>
                        <div class="box box-primary">
                            <form id="test{sid}" name="test{sid}" method="post" action="?w=virt&sid={sid}">
                                <input type="hidden" name="option" value="install_server">
                              <div class="box-header with-border">
                                    <h3 class="box-title">{serverre}</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">{chodi}<br>
                                    <select name="server_os" id="server_os" class="form-control">
                                    {server_os_options}
                                    </select>
                                    <br>
                                    {setrpdi}<br>
                                    <input type="text" placeholder="{rp}" name="server_passwd" id="server_passwd" class="form-control" />
                                    <br>
                                    <button type="submit" name="action" id="install" value="Install" class="btn btn-sm btn-success inline">
                                        <i class="fa fa-refresh"></i> {installbt}
                                    </button>
                            </form>
                            </div><!-- /.box-body -->
                </div>
            <div class="box box-primary" style="{hidden}">
                <form id="test{sid}" name="test{sid}" method="post" action="?w=virt&sid={sid}">
                                <input type="hidden" name="option" value="vnc_pass">
                  <div class="box-header with-border">
                                    <h3 class="box-title">{vnc}</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                    {vncips}{vncip}<br>
                                    {vncpos}{vncport}<br>
                                    {vncpws}{vncpw}<br>
                                    <br>
                                    {setvnc}<br>
                                    <input type="text" placeholder="{vncp}" name="vncpass" id="vncpass" class="form-control" />
                                    <br>
                                    <button type="submit" name="action" id="vncpass" value="vncpass" class="btn btn-sm btn-success inline">
                                        <i class="fa fa-refresh"></i> {changebt}
                                    </button>
                        </form>
                            </div><!-- /.box-body -->
                </div>
            <div class="box box-primary" style="{hiddenreson}">
                <form id="test{sid}" name="test{sid}" method="post" action="?w=virt&sid={sid}">
                                <input type="hidden" name="option" value="rescueenable">
                  <div class="box-header with-border">
                                    <h3 class="box-title">{rescuefu}</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                    {rescueset}<br>
                                    <input type="text" placeholder="{rescuepw}" name="pass" id="pass" class="form-control" />
                                    <br>
                                    <button type="submit" name="action" id="vncpass" value="pass" class="btn btn-sm btn-success inline">
                                        <i class="icon-white icon-play"></i> {startbt}
                                    </button>
                        </form>
                            </div><!-- /.box-body -->
                </div>
            <div class="box box-primary" style="{hiddenresoff}">
                <form id="test{sid}" name="test{sid}" method="post" action="?w=virt&sid={sid}">
                                <input type="hidden" name="option" value="disablerescue">
                  <div class="box-header with-border">
                                    <h3 class="box-title">{rescuefu}</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                    <button type="submit" name="action" id="disablerescue" value="disablerescue" class="btn btn-sm btn-danger"><i class="fa fa-power-off"></i> {stopbt}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>