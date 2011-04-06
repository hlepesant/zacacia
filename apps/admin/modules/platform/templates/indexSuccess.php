<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <?php echo __('Platforms') ;?>
        </div>
        <!-- end #navigation_header._title -->
        <div class="_link">
            <?php /* echo link_to('[+]', 'platform/new', array('id' => 'gotonew', 'title' => 'New')) */ ?>
            <?php echo image_tag('famfam/add.png', array('title' => 'New', 'id' => 'gotonew')); ?>
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
foreach ($platforms as $p):
    include_partial('item', array('p' => $p, 'id' => $id, 'f' => $forms[$p->getDn()]));
    $id++;
endforeach;
?>
    </div>
    <!-- end #collection_enumerate -->

</div>
<!-- end #collection -->

<form action="<?php echo url_for('platform/new') ?>" method="POST" id="platform_new" class="invisible">
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
            if ( ! confirm( t+' ".__("the platform")." \"'+name+'\" ?'))
            {
                return false;
            }
        break;

        case 'delete':
            if ( ! confirm( t+' ".__("the platform")." \"'+name+'\" ?'))
            {
                a.selectedIndex = 0;
                return false;
            }
        break;

        case 'company':
        case 'server':
        default:
            m = d;
            d = 'index';
        break;
    }

    f.action = sprintf('".url_for(false)."%s/%s/', m, d);

    f.submit();
    return true;
}
") ?>
