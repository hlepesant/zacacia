<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $platform->getCn() ?></u>&nbsp;&rarr;
            <?php echo __('Servers') ;?>
        </div>
        <!-- end #navigation_header._title -->
        <div class="_link">
            <?php echo image_tag('famfam/back.png', array('title' => __('Back'), 'id' => 'goback')) ?>
<?php
if ( $platform->getMiniMultiServer() || ( count($servers) <= 1 ) ) {
    echo image_tag('famfam/add.png', array('title' => __('New'), 'id' => 'gotonew'));
} else {
    echo image_tag('add_bw.png', array('title' => __('Single Server Platform'), 'id' => 'not_allowed'));
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
foreach ($domains as $d) {
    include_partial('domain', array('d' => $d, 'id' => $id, 'f' => $forms[$d->getDn()]));
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

<form action="<?php echo url_for('@platform') ?>" method="POST" id="platform_back" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var _js_msg_01 = '".__("Disable the host")."';
var _js_msg_02 = '".__("Enable the host")."';
var _js_msg_03 = '".__("Delete the host")."';
var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';
") ?>
</div>

<?php echo $new->renderHiddenFields() ?>
</form>

<form action="<?php echo url_for('company/index') ?>" method="POST" id="company_back" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<?php if ($sf_user->hasFlash('ldap_error')): ?>
<?php echo javascript_tag("
alert('". $sf_user->getFlash('ldap_error') ."');
") ?>
<?php endif; ?>

<?php echo javascript_tag("
function jumpTo(id, name, destination) 
{
    var f = document.getElementById(sprintf('navigation_form_%03d', id));
    var m = '".$this->getModuleName()."';
    
    if ( typeof(destination) == 'undefined' )
    {
        var a = document.getElementById(sprintf('destination_%03d', id));
        var d = a.options[a.selectedIndex].value;
        var t = a.options[a.selectedIndex].text;
    }
    else
    {
        var d = destination;
        var t = destination;
    }

    switch ( d )
    {
        case 'none':
            return false;
        break;
        
        case 'edit':
        break;
        
        case 'status':
            if ( ! confirm( t+' ".__("the server")." \"'+name+'\" ?'))
            {
                return false;
            }
        break;
        
        case 'delete':
            if ( ! confirm( t+' ".__("the server")." \"'+name+'\" ?'))
            {
              a.selectedIndex = 0;
              return false;
            }
        break;
    }

    f.action = sprintf('".url_for(false)."%s/%s/', m, d);

    f.submit();
    return true;
}
") ?>
