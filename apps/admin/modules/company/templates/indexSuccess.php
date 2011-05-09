<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $platform->getCn() ?></u>&nbsp;&rarr;
            <?php echo __('Companies') ;?>
        </div>
        <!-- end #navigation_header._title -->
        <div class="_link">
            <?php echo image_tag('famfam/back.png', array('title' => __('Back'), 'id' => 'goback')) ?>
<?php
if ( $platform->getMiniMultiTenant() || ( count($companies) == 0 ) ) {
    echo image_tag('famfam/add.png', array('title' => __('New'), 'id' => 'gotonew'));
} else {
    echo image_tag('add_bw.png', array('title' => __('Single Tenant Platform'), 'id' => 'not_allowed'));
} ?>
        </div>
        <!-- end #navigation_header._link -->
    </div>
    <!-- end #navigation_header -->
</div>
<!-- end #navigation -->

<div id="collection">
    <div id="collection_description">
            <div class="_name"><?php echo __("Name") ?></div>
            <div class="_action"><?php echo __("Action") ?></div>
    </div>
    <!-- end #collection_description -->

    <div id="collection_enumerate">
<?php
$id = 0;
foreach ($companies as $c) {
   include_partial('item', array('c' => $c, 'id' => $id, 'f' => $forms[$c->getDn()]));
    $id++;
}
?>
    </div>
    <!-- end #collection_enumerate -->

</div>
<!-- end #collection -->

<form action="<?php echo url_for('company/new') ?>" method="POST" id="company_new" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<form action="<?php echo url_for('@platform') ?>" method="POST" id="platform_back" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var _js_msg_01 = \"".__("Disable the company")."\";
var _js_msg_02 = \"".__("Enable the company")."\";
var _js_msg_03 = \"".__("Delete the company")."\";
var _js_module = \"".$this->getModuleName()."\";
var _js_url = '".url_for(false)."';
") ?>
