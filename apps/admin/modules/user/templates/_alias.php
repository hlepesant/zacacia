
<div id="<?php printf("zarafaAliases_%02d", $id) ?>" class="ym-fbox-text">
<?php echo $form['zarafaAliases[]']->renderRow(array('value' => $alias, 'readonly' => 'readonly')) ?>

<?php 

echo link_to_function(
    image_tag('famfam/cross.png'),
    "this.hide('". sprintf("zarafaAliases_%02d", $id) ."')");
?>

</div>
