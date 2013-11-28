<form class="form-signin" method="POST">
    <h2 class="form-signin-heading">Login</h2>
    <?php echo $form->renderHiddenFields() ?>
    <?php echo $form->render() ?>
    <button class="btn btn-large btn-primary" type="submit">Sign in</button>
</form>
