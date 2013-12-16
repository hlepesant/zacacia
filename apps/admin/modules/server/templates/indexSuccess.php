<?php slot(
    'title',
    __("Platform".":".$platform->getCn()."&rarr;"."Servers")
);
?>

<div class="row">
    <div class="col-md-10">
<?php echo button_to('New', '@server_new?platform='.$platform->getCn(), array('class' => 'btn btn-primary')) ?> &nbsp;
    </div>
    <div class="col-md-2">
<?php echo button_to('Back', '@platforms', array('class' => 'btn btn-info')) ?>
    </div>
</div>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th class="col-sm-1"><?php echo __('Status') ?></th>
            <th class="col-sm-2"><?php echo __('Name') ?></th>
            <th class="col-xs-1"><?php echo __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>

<?php
$id = 0;
foreach ($servers as $server) {
    include_partial('item', array('platform' => $platform, 'server' => $server, 'id' => $id));
    $id++;
}
?>
    </tbody>
</table>
<!-- end #collection -->

<?php echo javascript_tag("
/* var new_url = '".url_for('@server_new?platform='.$platform->getCn())."'; */
var logout_url = '".url_for('security/logout')."';

var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';
") ?>
