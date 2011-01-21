<?php use_helper('Javascript') ?>

<div id="form-header">
    <div id="form-header" class="section">
        <?php echo __('New Server') ;?>
    </div>
</div>

<div id="form-inner">

<form action="<?php echo url_for('server/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="form-error">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

    <div id="form-line">
        <div id="form-line" class="item"><?php echo $form['cn']->renderLabel() ?></div>
        <div id="form-line" class="field"><?php echo $form['cn']->render() ?></div>
        <div id="form-line" class="check">
            <div id="checkName"></div>
        </div>
    </div>
    
    <div id="form-line">
        <div id="form-line" class="item"><?php echo $form['ip']->renderLabel() ?></div>
        <div id="form-line" class="field"><?php echo $form['ip']->render() ?></div>
        <div id="form-line" class="check">
            <div id="checkIpAddress"></div>
        </div>
    </div>

  <?php echo $form['zarafaHttpPort']->renderRow() ?>
  <?php echo $form['zarafaSslPort']->renderRow() ?>
  <?php echo $form['zarafaContainsPublic']->renderRow() ?>
  <?php echo $form['undeletable']->renderRow() ?>
  <?php echo $form['status']->renderRow() ?>

    <div id="form-submitline">
        <?php echo link_to( "<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form-button\"  />" , "@platform") ?>
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" id="form-submit" />
    </div>

</form>
</div>

<?php echo observe_field('minidata_cn', array(
  'update' => 'checkName',
  'url' => url_for('server/check/'),
  'method' => 'get',
  'with' => "'&name='+getName()",
  'frequency' => '1',
  'script' => 1
))
?>

<?php echo observe_field('minidata_cn', array(
  'update' => 'minidata_ip',
  'url' => url_for('server/resolvehost/'),
  'method' => 'get',
  'with' => "'&name='+getName()",
  'frequency' => '1',
  'script' => 1
))
?>

<?php echo javascript_tag("
function getName()
{
  return document.getElementById('minidata_cn').value;
}
") ?>

<?php echo observe_field('minidata_ip', array(
  'update' => 'checkIpAddress',
  'url' => url_for('server/checkip/'),
  'method' => 'get',
  'with' => "'&ip='+getIpAddress()",
  'frequency' => '1',
  'script' => 1
))
?>

<?php echo javascript_tag("
function getIpAddress()
{
  return document.getElementById('minidata_ip').value;
}
") ?>
