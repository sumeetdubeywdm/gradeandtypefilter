<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wisdmlabs.com
 * @since             1.0.0
 * @package           Gradeandtypefilter
 *
 * @wordpress-plugin
 * Plugin Name:       Grade and Type filter
 * Plugin URI:        https://wisdmlabs.com
 * Description:       This filter is used to filter the courses by Grade and Types of courses.
 * Version:           1.0.0
 * Author:            Sumeet Dubey
 * Author URI:        https://wisdmlabs.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gradeandtypefilter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('GRADEANDTYPEFILTER_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gradeandtypefilter-activator.php
 */
function activate_gradeandtypefilter()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-gradeandtypefilter-activator.php';
	Gradeandtypefilter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gradeandtypefilter-deactivator.php
 */
function deactivate_gradeandtypefilter()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-gradeandtypefilter-deactivator.php';
	Gradeandtypefilter_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_gradeandtypefilter');
register_deactivation_hook(__FILE__, 'deactivate_gradeandtypefilter');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-gradeandtypefilter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gradeandtypefilter()
{

	$plugin = new Gradeandtypefilter();
	$plugin->run();
}
run_gradeandtypefilter();


require_once(plugin_dir_path(__FILE__) . 'includes/class-gradeandtypefilter-taxonomy.php');
require_once(plugin_dir_path(__FILE__) . 'includes/class-gradeandtypefilter-querymodifier.php');
require_once(plugin_dir_path(__FILE__) . 'includes/class-gradeandtypefilter-shortcode.php');

class GradeandTypeFilter_Plugin
{
	private $taxonomy_var;
	private $query_modifier_var;
	private $shortcode_var;

	public function __construct()
	{
		$this->taxonomy_var = new GradeAndTypeFilter_Taxonomy();
		$this->query_modifier_var = new GradeAndTypeFilter_QueryModifier();
		$this->shortcode_var = new GradeAndTypeFilter_Shortcode();

		add_action('init', array($this->taxonomy_var, 'register_taxonomies'));
		add_filter('learndash_ld_course_list_query_args', array($this->query_modifier_var, 'modify_course_list_query_args'), 10, 2);
		add_shortcode('gradecategory_filter_courses', array($this->shortcode_var, 'grade_type_filter_shortcode'));
	}
}

new GradeandTypeFilter_Plugin();
