<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $platform->getCn() ?></u>&nbsp;&rarr;
            <u><?php echo $company->getCn() ?></u>&nbsp;&rarr;
            <?php echo __('Users') ;?>
        </div>
        <!-- end #navigation_header._title -->
        <div class="_link">
            <?php echo image_tag('famfam/back.png', array('title' => __('Back'), 'id' => 'goback')) ?>
<?php
if ( 1 ) { # $company->getZacaciaMultiTenant() ) {
    echo image_tag('famfam/add.png', array('title' => __('New'), 'id' => 'gotonew'));
} else {
    echo image_tag('add_bw.png', array('title' => __('User Licence reached'), 'id' => 'not_allowed'));
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
foreach ($users as $u):
    include_partial('user', array('u' => $u, 'id' => $id, 'f' => $forms[$u->getDn()]));
    $id++;
endforeach;
?>
    </div>
    <!-- end #collection_enumerate -->

</div>
<!-- end #collection -->

<form action="<?php echo url_for('user/new') ?>" method="POST" id="user_new" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<form action="<?php echo url_for('@company') ?>" method="POST" id="company_back" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var _js_msg_01 = \"".__("Disable the user")."\";
var _js_msg_02 = \"".__("Enable the user")."\";
var _js_msg_03 = \"".__("Delete the user")."\";
var _js_module = \"".$this->getModuleName()."\";
var _js_url = '".url_for(false)."';
") ?>
