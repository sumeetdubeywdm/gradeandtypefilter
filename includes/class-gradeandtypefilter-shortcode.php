<?php

class GradeAndTypeFilter_Shortcode
{
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

        $gradecategorydropdown .= '</select><input type="submit" style="display:none"></form></div>';

        $typedropdown = '<div id="ld_typedropdown" class="child">';
        $typedropdown .= '<form method="get">
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
}
