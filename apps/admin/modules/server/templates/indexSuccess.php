<div id="collection-header">
    <div id="collection-header" class="section">
        <?php echo __('Servers') ;?>
    </div>
    <div id="collection-header" class="navigation">
      <?php echo link_to_function(image_tag('icons/arrow_up.png'), "document.getElementById('platform_back').submit()") ?> 
      <?php echo link_to_function(image_tag('icons/server_add.png'), "document.getElementById('server_new').submit()") ?> 
    </div>
</div>

<div id="collection">
    <div id="title">
        <div id="title" class="description"><?php echo __("Name") ?></div>
        <div id="title" class="navigation"><?php echo __("Action") ?></div>
    </div>

<?php
$id = 0;
foreach ($servers as $s):
    include_partial('server', array('s' => $s, 'id' => $id, 'f' => $forms[$s->getDn()]));
    $id++;
endforeach;
?>
</div>

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
