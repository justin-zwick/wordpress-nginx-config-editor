<?php
namespace O10n;

/**
 * Nginx Config Editor Admin View Controller
 *
 * @package    optimization
 * @subpackage optimization/controllers/admin
 * @author     Optimization.Team <info@optimization.team>
 */
if (!defined('ABSPATH')) {
    exit;
}

class AdminViewNginx extends AdminViewBase
{
    protected static $view_key = 'nginx'; // reference key for view
    protected $module_key = 'nginx';

    // default tab view
    private $default_tab_view = 'intro';

    private $nginx_config_location;

    /**
     * Load controller
     *
     * @param  Core       $Core   Core controller instance.
     * @param  false      $module Module parameter not used for core view controllers
     * @return Controller Controller instance.
     */
    public static function &load(Core $Core)
    {
        // instantiate controller
        return parent::construct($Core, array(
            'json',
            'file',
            'options',
            'AdminClient',
            'AdminScreen'
        ));
    }
    
    /**
     * Setup controller
     */
    protected function setup()
    {
        // WPO plugin
        if (defined('O10N_WPO_VERSION')) {
            $this->default_tab_view = 'optimization';
        }
        // set view etc
        parent::setup();
    }

    /**
     * Setup view
     */
    public function setup_view()
    {
        // process form submissions
        add_action('o10n_save_settings_verify_input', array( $this, 'verify_input' ), 10, 1);

        // enqueue scripts
        add_action('admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), $this->first_priority);

        // add screen options
        $this->AdminScreen->load_screen('editor');

        $this->nginx_config_location = get_option('o10n_nginx_config_location');
        if (!$this->nginx_config_location) {
            $this->nginx_config_location = trailingslashit(ABSPATH) . 'nginx.conf';
        }
    }

    /**
     * Return help tab data
     */
    final public function help_tab()
    {
        $data = array(
            'name' => __('Nginx config Editor', 'o10n'),
            'github' => 'https://github.com/o10n-x/wordpress-nginx-config-editor',
            'wordpress' => 'https://wordpress.org/support/plugin/nginx-config-editor',
            'docs' => 'https://github.com/o10n-x/wordpress-nginx-config-editor/tree/master/docs'
        );

        return $data;
    }

    /**
     * Enqueue scripts and styles
     */
    final public function enqueue_scripts()
    {
        // skip if user is not logged in
        if (!is_admin() || !is_user_logged_in()) {
            return;
        }

        // set module path
        $this->AdminClient->set_config('module_url', $this->module->dir_url());

        $this->AdminClient->preload_CodeMirror('nginx');

        // scripts
        wp_enqueue_script('o10n_view_nginx', $this->module->dir_url() . 'admin/js/view-nginx.js', array( 'jquery', 'o10n_cp' ), $this->module->version());
    }


    /**
     * Return view template
     */
    public function template($view_key = false)
    {
        // template view key
        $view_key = false;

        $tab = (isset($_REQUEST['tab'])) ? trim($_REQUEST['tab']) : $this->default_tab_view;
        switch ($tab) {
            case "intro":
            case "editor":
                $view_key = 'nginx-' . $tab;
            break;
            default:
                throw new Exception('Invalid view ' . esc_html($view_key), 'core');
            break;
        }

        return parent::template($view_key);
    }
    
    /**
     * Verify settings input
     *
     * @param  object   Form input controller object
     */
    final public function verify_input($forminput)
    {
        // Nginx config editor

        $tab = (isset($_REQUEST['tab'])) ? trim($_REQUEST['tab']) : 'o10n';

        switch ($tab) {
            case "editor":

                // location
                $nginx_config_location = $forminput->get('nginx.location');
                if ($nginx_config_location === '') {
                    $nginx_config_location = trailingslashit(ABSPATH) . 'Nginx config';
                }

                // location changed
                if ($nginx_config_location !== $this->nginx_config_location) {
                    update_option('o10n_nginx_config_location', $nginx_config_location, false);
                } else {

                    // nginx text
                    $nginx_content = $forminput->get('nginx.content');

                    if (!is_writable($this->nginx_config_location)) {
                        $forminput->error('', __('<code>'.esc_html($this->file->safe_path($this->nginx_config_location)).'</code> is not writable.', 'o10n'));
                    } else {
                        try {
                            // write gzip file
                            $this->file->put_contents($this->nginx_config_location, $nginx_content);
                        } catch (\Exception $err) {
                            $forminput->error('', 'Failed to store Nginx config file ' . esc_html($this->file->safe_path($this->nginx_config_location)) . ' <pre>'.$err->getMessage().'</pre>', 'nginx');
                        }
                    }
                }

            break;
        }
    }

    /**
     * Get Nginx config content
     */
    final public function get_nginx_config()
    {
        if (!file_exists($this->nginx_config_location)) {
            return '';
        } else {
            return file_get_contents($this->nginx_config_location);
        }
    }

    /**
     * Get Nginx config location
     */
    final public function get_nginx_config_location()
    {
        return $this->nginx_config_location;
    }
}
