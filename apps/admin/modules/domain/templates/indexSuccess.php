<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $platform->getCn() ?></u>&nbsp;&rarr;
            <u><?php echo $company->getCn() ?></u>&nbsp;&rarr;
            <?php echo __('Domains') ;?>
        </div>
        <!-- end #navigation_header._title -->
        <div class="_link">
            <?php echo image_tag('famfam/back.png', array('title' => __('Back'), 'id' => 'goback')) ?>
            <?php echo image_tag('famfam/add.png', array('title' => __('New'), 'id' => 'gotonew')); ?>
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
foreach ($domains as $d) {
    include_partial('item', array('d' => $d, 'id' => $id, 'f' => $forms[$d->getDn()]));
    $id++;
}
?>
    </div>
    <!-- end #collection_enumerate -->

</div>
<!-- end #collection -->

<form action="<?php echo url_for('domain/new') ?>" method="POST" id="domain_new" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<form action="<?php echo url_for('@company') ?>" method="POST" id="company_back" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var _js_msg_01 = \"".__("Disable the domain")."\";
var _js_msg_02 = \"".__("Enable the domain")."\";
var _js_msg_03 = \"".__("Delete the domain")."\";
var _js_module = \"".$this->getModuleName()."\";
var _js_url = '".url_for(false)."';
") ?>
