<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wisdmlabs.com
 * @since      1.0.0
 *
 * @package    Gradeandtypefilter
 * @subpackage Gradeandtypefilter/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Gradeandtypefilter
 * @subpackage Gradeandtypefilter/public
 * @author     Sumeet Dubey <sumeet.dubey@wisdmlabs.com>
 */
class Gradeandtypefilter_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode('gradecategory_filter_courses', array($this, 'grade_type_filter_shortcode'));
		add_filter('learndash_ld_course_list_query_args', array($this, 'modify_course_list_query_args'), 10, 2);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gradeandtypefilter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gradeandtypefilter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/gradeandtypefilter-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gradeandtypefilter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gradeandtypefilter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/gradeandtypefilter-public.js', array('jquery'), $this->version, false);
	}
	public function grade_type_filter_shortcode($atts)
	{
		ob_start();

		$gradecategories = get_terms(array(
			'taxonomy' => 'grade',
			'hide_empty' => true,
		));

		$types = get_terms(array(
			'taxonomy' => 'type',
			'hide_empty' => true,
		));


		echo '<div class="parent">';
		$gradecategorydropdown = '<div id="ld_gradecategorydropdown" class="child">';
		$gradecategorydropdown .= '<form method="get">
            <label for="ld_gradecategorydropdown_select">Grades</label>
            <select id="ld_gradecategorydropdown_select" name="gradecat" onchange="this.form.submit()">
                <option value="">Select Grade</option>';

		foreach ($gradecategories as $grade) {
			$selected = (isset($_GET['gradecat']) && $_GET['gradecat'] == $grade->term_id) ? 'selected' : '';
			$gradecategorydropdown .= '<option value="' . $grade->term_id . '" ' . $selected . '>' . $grade->name . '</option>';
		}
		$gradecategorydropdown .= '</select><input type="submit" style="display:none"></div>';

		$typedropdown = '<div id="ld_typedropdown" class="child">';
		$typedropdown .= '
            <label for="ld_typedropdown_select">Types</label>
            <select id="ld_typedropdown_select" name="typecat" onchange="this.form.submit()">
                <option value="">Select Type</option>';

		foreach ($types as $type) {
			$selected = (isset($_GET['typecat']) && $_GET['typecat'] == $type->term_id) ? 'selected' : '';
			$typedropdown .= '<option value="' . $type->term_id . '" ' . $selected . '>' . $type->name . '</option>';
		}

		$typedropdown .= '</select><input type="submit" style="display:none"></form></div>';

		echo apply_filters('ld_gradecategorydropdown', $gradecategorydropdown, $atts);
		echo apply_filters('ld_typedropdown', $typedropdown, $atts);
		echo '</div>';
		wp_reset_postdata();

		return ob_get_clean();
	}


	public function modify_course_list_query_args($filter, $atts)
	{

		$tax_query = array();

		if (isset($_GET['gradecat']) && !empty($_GET['gradecat'])) {
			$tax_query[] = array(
				'taxonomy' => 'grade',
				'field'    => 'term_id',
				'terms'    => intval($_GET['gradecat']),
			);
		}

		if (isset($_GET['typecat']) && !empty($_GET['typecat'])) {
			$tax_query[] = array(
				'taxonomy' => 'type',
				'field'    => 'term_id',
				'terms'    => intval($_GET['typecat']),
			);
		}


		if (count($tax_query) > 1) {
			$tax_query['relation'] = 'AND';
		}

		if (!empty($tax_query)) {
			$filter['tax_query'] = $tax_query;
		}

		return $filter;
	}
}
