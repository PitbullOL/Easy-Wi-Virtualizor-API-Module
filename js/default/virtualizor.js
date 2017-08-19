var Ajax_Virtualizor = function () {

    var handleAjaxRequest = function(data,code,callback) {
        $.ajax({
            url: "userpanel.php?w=virt&ajax=1",
            data: data,
            dataType: "json",
            cache: false,
            timeout: 10000
        }).done(function (data) {
           //console.info("Get Data: "+data);
            var tmpFunc = new Function("data",code);
            tmpFunc(data);
            if(callback !== null) {
                callback();
            }
        }).fail(function () {
           
        });
    };
    
    var handleUpdateALL = function () {
        handleAjaxRequest({status: 'all'},
        "$.each(data, function( sid, info ) { "+
        "$('#bandwidth_limit_'+sid).empty().html(info.bandwidth.limit_gb);"+
        "$('#bandwidth_percent_'+sid).empty().html(info.bandwidth.percent);"+
        "$('#bandwidth_percent_2_'+sid).width(info.bandwidth.percent+\"%\");"+
        "$('#bandwidth_percent_free_'+sid).empty().html(info.bandwidth.percent_free);"+

        "$('#icon_'+sid).removeAttr('class').attr('class', info.style.icon );"+
        "$('#'+sid).removeAttr('class').attr('class', info.style.class );"+
        "$('#'+sid).css({ 'background-color': info.style.css });"+
        
        "$('#disk_limit_'+sid).empty().html(info.disk.disk.limit_gb);"+
        "$('#disk_percent_'+sid).empty().html(info.disk.disk.percent);"+
        "$('#disk_percent_2_'+sid).width(info.disk.disk.percent+\"%\");"+
        "$('#disk_percent_free_'+sid).empty().html(info.disk.disk.percent_free);"+
        
        "$('#ram_limit_'+sid).empty().html(info.ram.limit);"+
        "$('#ram_percent_'+sid).empty().html(info.ram.percent);"+
        "$('#ram_percent_2_'+sid).width(info.ram.percent+\"%\");"+
        "$('#ram_percent_free_'+sid).empty().html(info.ram.percent_free);"+
        
        "$('#cpu_cpumanu_'+sid).empty().html(info.cpu.limit);"+
        "$('#cpu_percent_'+sid).empty().html(info.cpu.percent);"+
        "$('#cpu_percent_2_'+sid).width(info.cpu.percent+\"%\");"+
        "$('#cpu_percent_free_'+sid).empty().html(info.cpu.percent_free);"+
        " });",
        null);
    };

    return {
        init: function () {
            setInterval(function(){ 
                handleUpdateALL();
            }, 10000);
        }
    };
}();
