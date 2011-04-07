<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $p->getCn() ?></u>&nbsp;&rarr;
            <?php echo __('Servers') ;?>
        </div>
        <!-- end #navigation_header._title -->
        <div class="_link">
            <?php echo image_tag('famfam/back.png', array('title' => 'Back', 'id' => 'goback')) ?>
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
foreach ($servers as $s):
    include_partial('item', array('s' => $s, 'id' => $id, 'f' => $forms[$s->getDn()]));
    $id++;
endforeach;
?>
    </div>
    <!-- end #collection_enumerate -->

</div>
<!-- end #collection -->

<form action="<?php echo url_for('server/new') ?>" method="POST" id="server_new" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<form action="<?php echo url_for('@platform') ?>" method="POST" id="platform_back" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<?php if ($sf_user->hasFlash('ldap_error')): ?>
<?php echo javascript_tag("
alert('". $sf_user->getFlash('ldap_error') ."');
") ?>
<?php endif; ?>

<?php echo javascript_tag("
function jumpTo(id, name, target, message)
{
    var f = \"f = $(sprintf('#navigation_form_%03d', id))\";
    eval(f);
    var m = '".$this->getModuleName()."';
    var d = target;

    switch ( target )
    {
        case 'edit':
        break;

        case 'status':
            if ( ! confirm( message + ' ".__("the server")." \"' + name + '\" ?')) {
                return false;
            }
        break;

        case 'delete':
            if ( ! confirm( message +' ".__("the server")." \"' + name + '\" ?')) {
              return false;
            }
        break;

        default:
            return false;
        break;
    }

    f.attr('action', sprintf('".url_for(false)."%s/%s/', m, d));

    f.submit();
    return true;
}
") ?>
