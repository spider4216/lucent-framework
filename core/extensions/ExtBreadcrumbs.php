<?php

namespace core\extensions;

class ExtBreadcrumbs {

    public static function getAll($controller, $action_name)
    {
        $breadcrumbsArr = $controller->breadcrumbs();

        if ($breadcrumbsArr) {
            $breadcrumbs = [];
            foreach ($breadcrumbsArr as $act_name => $links) {
                if ($act_name == $action_name) {
                    foreach ($links as $title => $link) {
                        $breadcrumbs[] = [
                            'link' => $link,
                            'title' => $title,
                        ];
                    }
                }
            }

            return $breadcrumbs;
        }
        return false;
    }
}