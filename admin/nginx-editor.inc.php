<?php
namespace O10n;

/**
 * Nginx config editor admin template
 *
 * @package    optimization
 * @subpackage optimization/admin
 * @author     Optimization.Team <info@optimization.team>
 */
if (!defined('ABSPATH') || !defined('O10N_ADMIN')) {
    exit;
}

// print form header
$this->form_start(__('Nginx Config Editor', 'o10n'), 'nginx');

$nginx_config = $view->get_nginx_config();
$nginx_config_location = $view->get_nginx_config_location();

?>

<table class="form-table">
    <tr valign="top">
        <td colspan="2">
        <textarea class="json-array-lines" id="nginx_config_editor" name="o10n[nginx.content]"><?php print esc_html($nginx_config); ?></textarea>
        </td>
    </tr>

    <tr valign="top">
        <th scope="row">File Location</th>
        <td>
            <input type="text" style="width:100%;" name="o10n[nginx.location]" value="<?php print esc_attr($nginx_config_location); ?>" placeholder="<?php print trailingslashit(ABSPATH) . 'nginx.conf'; ?>" />
            <p class="description">Optionally enter an alternative Nginx config file location. The default is <code><?php print trailingslashit(ABSPATH) . 'nginx.conf'; ?></code>.</p>
            <p class="info_white"><strong>Note:</strong> If you change the file location, the Nginx config text will not be saved.</p>
        </td>
    </tr>
    </table>
<hr />
<?php
    submit_button(__('Save'), 'primary large', 'is_submit', false);

// print form header
$this->form_end();
