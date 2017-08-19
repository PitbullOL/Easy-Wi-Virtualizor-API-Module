<script src="js/default/virtualizor.js" type="text/javascript"></script>
    
<section class="content-header">
    <h1>V-Server</h1>
    <ol class="breadcrumb">
        <li><a href="userpanel.php?w=da"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">V-Server</li>
    </ol>
</section>
<section class="content">
    <?php echo $msg; ?>
    <div class="row">
        <?php echo $servers; ?>
    </div>
</section>
<script type="text/javascript">jQuery(document).ready(function() { Ajax_Virtualizor.init(); });</script>