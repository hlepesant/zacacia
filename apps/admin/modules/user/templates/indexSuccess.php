<div id="collection-header">
    <div id="collection-header" class="section">
        <?php echo __('Users') ;?>
    </div>
    <div id="collection-header" class="navigation">
      <?php echo link_to_function(image_tag('icons/arrow_up.png'), "$('company_back').submit()") ?> 
      <?php echo link_to_function(image_tag('icons/user_add.png'), "$('user_new').submit()") ?> 
    </div>
</div>

<div id="collection">
    <div id="title">
        <div id="title" class="description"><?php echo __("Name") ?></div>
        <div id="title" class="navigation"><?php echo __("Action") ?></div>
    </div>

<?php
$id = 0;
foreach ($users as $u):
    include_partial('user', array('u' => $u, 'id' => $id, 'f' => $forms[$u->getDn()]));
    $id++;
endforeach;
?>
</div>

<form action="<?php echo url_for('user/new') ?>" method="POST" id="user_new" class="invisible">
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
