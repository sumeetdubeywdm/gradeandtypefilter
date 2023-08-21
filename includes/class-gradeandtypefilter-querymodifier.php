<?php
class GradeAndTypeFilter_QueryModifier {
    public function modify_course_list_query_args($filter, $atts) {
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
