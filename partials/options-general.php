<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
<form name="lh_css_lazy_load-backend_form" method="post" action="">
<?php wp_nonce_field( $this->namespace."-nonce", $this->namespace."-nonce", false ); ?>
<table class="form-table">
<tr valign="top">
<th scope="row">
<label for="<?php echo $this->namespace; ?>-css_handles"><?php  _e("CSS handles:", $this->namespace );  ?></label></th>
<td><input id="<?php echo $this->namespace; ?>-css_handles" name="<?php echo $this->namespace; ?>-css_handles" type="text" value="<?php echo implode(",", $this->options[$this->namespace.'-css_handles']); ?>" /> - <?php  _e("use a comma to seperate multiple css handles", $this->namespace );  ?>
</tr>
</table>
<?php submit_button( 'Save Changes' ); ?>
</form>