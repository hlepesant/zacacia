<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title" id="back-link">
    <?php echo __('Platform') ;?> : <?php echo $platform->getCn() ?> &rarr;
    <?php echo __('Company') ;?> : <?php echo $company->getCn() ?> &rarr;
    <?php echo __("Users") ?>
    </div>
    <div class="ym-g30 ym-gr">
        <form action="<?php echo url_for('user/new') ?>" method="POST" id="user_new">
        <?php echo $new->renderHiddenFields(); ?>
        <input type="submit" value="<?php echo __("New") ?>" class="ym-button z-button-new" />
        </form>
    </div>
</div>

<?php
$id = 0;
foreach ($users as $user) {
    include_partial('item', array('user' => $user, 'id' => $id, 'form' => $forms[$user->getDn()]));
    $id++;
}
?>
<!-- end #collection -->

<?php echo javascript_tag("
var new_url = '".url_for('@user_new')."';

var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';

var _js_msg_disable = '".__("Disable the user")."';
var _js_msg_enable = '".__("Enable the user")."';
var _js_msg_delete = '".__("Delete the user")."';
") ?>

<form action="<?php echo url_for('@companies') ?>" method="POST" id="back_form" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>
