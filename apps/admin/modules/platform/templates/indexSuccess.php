<h3><?php echo __('Platforms') ;?></h3>

<div id="enum" class="table">
  <div id="enum" class="linkto">
  <?php echo link_to_function(image_tag('icons/world_add.png'), "document.getElementById('platform_new').submit()") ?> 
  </div>

  <div id="enum" class="th">
    <div id="enum" class="thtitle"><?php echo __("Name") ?></div>
    <div id="enum" class="thaction"><?php echo __("Action") ?></div>
  </div>
<?php
  $id = 0;
  foreach ($platforms as $p):
    include_partial('platform', array('p' => $p, 'id' => $id, 'f' => $forms[$p->getDn()]));
    $id++;
  endforeach;
?>
</div>

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

  switch ( d ) {
    case 'none':
      return false;
    break;

    case 'edit':
    break;

    case 'status':
      if ( ! confirm( t+' ".__("the platform")." \"'+name+'\" ?')) {
        return false;
      }
    break;

    case 'delete':
      if ( ! confirm( t+' ".__("the platform")." \"'+name+'\" ?')) {
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
