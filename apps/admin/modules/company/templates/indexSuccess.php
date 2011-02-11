<?php /* use_helper('ModalBox') */ ?>

<div id="collection-header">
    <div id="collection-header" class="section">
        <?php echo __('Companies') ;?>
    </div>
    <div id="collection-header" class="navigation">
      <?php echo link_to_function(image_tag('icons/arrow_up.png'), "document.getElementById('platform_back').submit()") ?> 
      <?php echo link_to_function(image_tag('icons/building_add.png'), "document.getElementById('company_new').submit()") ?> 


<?php /* echo link_to_function('add', m_link_to_element("$('company_new')",
    array(
        'title' => "'Create'",
        'inactiveFade' => false))); */
/*    array('width' => 400, 'height' => 180, 'params' => '*Form.serialize(\'company_new\')*'))); */
/*
<img src="/images/icons/building_add.png" onclick="Modalbox.show('<?php echo url_for('company/new'); ?>', {title: 'Sending status', params: $('company_new').serialize() }); return false;">
*/
/*
echo link_to_function(
    image_tag('icons/building_add.png'),
    "Modalbox.show('".url_for('company/new')."', {title: 'Create company', params: $('company_new').serialize(), width:'700', height:'450' }); return false;"
);
*/
?>

    </div>
</div>

<div id="collection">
    <div id="title">
        <div id="title" class="description"><?php echo __("Name") ?></div>
        <div id="title" class="navigation"><?php echo __("Action") ?></div>
    </div>

<?php
$id = 0;
foreach ($companies as $c):
    include_partial('company', array('c' => $c, 'id' => $id, 'f' => $forms[$c->getDn()]));
    $id++;
endforeach;
?>
</div>

<form action="<?php echo url_for('company/new') ?>" method="POST" id="company_new" class="invisible">
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
