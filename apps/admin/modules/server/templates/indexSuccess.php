<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title" id="back-link">
        <?php echo __('Platform : '); echo link_to($platform->getCn(), '@platforms'); ?> &rarr;
        <?php echo __("Servers") ?>
    </div>
    <div class="ym-g30 ym-gr">

<?php echo button_to('New', '@server_new?platform='.$platform->getCn(), array('class' => 'ym-button z-button-new')) ?>

<?php /*
        <form action="<?php echo url_for('server/new') ?>" method="POST" id="server_new" class="invisible">
        <?php echo $new->renderHiddenFields(); ?>
        <input type="submit" value="<?php echo __("New") ?>" class="ym-button z-button-new" />
        </form>
        */ ?>
    </div>
</div>

<?php
$id = 0;
foreach ($servers as $server) {
    #include_partial('item', array('s' => $s, 'id' => $id, 'f' => $forms[$s->getDn()]));
    include_partial('item', array('platform' => $platform, 'server' => $server, 'id' => $id));
    $id++;
}
?>
<!-- end #collection -->

<?php echo javascript_tag("
/* var new_url = '".url_for('@server_new?platform='.$platform->getCn())."'; */
var logout_url = '".url_for('security/logout')."';

var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';

var _js_msg_disable = '".__("Disable the server")."';
var _js_msg_enable = '".__("Enable the server")."';
var _js_msg_delete = '".__("Delete the server")."';
") ?>

<?php /*
<form action="<?php echo url_for('@platforms') ?>" method="POST" id="back_form" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>
*/?>
