
<?php slot(
    'title',
    __("Platforms")
);
?>

<?php echo button_to('New', '@platform_new', array('class' => 'ym-button z-button-new')) ?>

<table class="table table-striped">
<thead>
<tr>
<th class="col-sm-1"><?php echo __('Status') ?></th>
<th class="col-sm-4"><?php echo __('Name') ?></th>
<th class="col-sm-1"><?php echo __('Company'); ?></th>
<th class="col-sm-1"><?php echo __('Server'); ?></th>
<th class="col-sm-4"><?php echo __('Actions'); ?></th>
</tr>
</thead>
<tbody>
<?php
$id = 0;
foreach ($platforms as $platform) {
    include_partial('item', array('platform' => $platform, 'id' => $id));
    $id++;
}
?>
</tbody>
</table>
<!-- end #collection -->

<?php echo javascript_tag("
var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';
var _js_msg_disable = '".__("Disable the platform")."';
var _js_msg_enable = '".__("Enable the platform")."';
var _js_msg_delete = '".__("Delete the platform")."';
") ?>

