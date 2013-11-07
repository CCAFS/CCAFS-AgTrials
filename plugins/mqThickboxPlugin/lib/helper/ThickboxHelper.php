<?php

function thickbox_image($thumbnail = '', $image = '', $link_options = array(), $image_options = array()) {
    _add_resources();
    $link_options = _parse_attributes($link_options);
    $image_options = _parse_attributes($image_options);

    $link_options['class'] = isset($link_options['class']) ? $link_options['class'] : 'thickbox';

    return link_to(image_tag($thumbnail, $image_options), image_path($image, true), $link_options);
}

function thickbox_inline($name = '', $inline_id = '', $options = array(), $thickbox_options = array()) {
    _add_resources();
    $options = _parse_attributes($options);
    $thickbox_options = _parse_attributes($thickbox_options);

    if (array_key_exists('size', $thickbox_options)) {
        list($thickbox_options['width'], $thickbox_options['height']) = explode('x', $thickbox_options['size']);
        unset($thickbox_options['size']);
    }

    $options['class'] = isset($options['class']) ? $options['class'] : 'thickbox';
    $thickbox_options['inlineId'] = $inline_id;

    if (isset($options['query_string'])) {
        $options['query_string'] .= '&' . http_build_query($thickbox_options);
    } else {
        $options['query_string'] = http_build_query($thickbox_options);
    }

    return link_to($name, '#TB_inline', $options);
}

function thickbox_iframe($name = '', $internal_uri = '', $parameter = array(), $options = array(), $thickbox_options = array()) {
    _add_resources();
    $options = _parse_attributes($options);
    $parameter = _parse_attributes($parameter);
    $thickbox_options = _parse_attributes($thickbox_options);


    if (array_key_exists('size', $thickbox_options)) {
        list($thickbox_options['width'], $thickbox_options['height']) = explode('x', $thickbox_options['size']);
        unset($thickbox_options['size']);
    }

    if (!array_key_exists('width', $thickbox_options) && !array_key_exists('height', $thickbox_options)) {
        $thickbox_options['width'] = 750;
        $thickbox_options['height'] = 600;
    }

    $options['class'] = isset($options['class']) ? $options['class'] : 'thickbox';

    if (count($parameter) > 0) {
        $parameter_temp .= http_build_query($parameter);
    }

    $options['query_string'] .= $parameter_temp . '&KeepThis=true&TB_iframe=true' . (!empty($thickbox_options) ? '&' . http_build_query($thickbox_options) : '');

    return link_to($name, $internal_uri, $options);
}

function thickbox_ajax($name = '', $internal_uri = '', $options = array(), $thickbox_options = array()) {
    _add_resources();
    $options = _parse_attributes($options);
    $thickbox_options = _parse_attributes($thickbox_options);

    if (array_key_exists('size', $thickbox_options)) {
        list($thickbox_options['width'], $thickbox_options['height']) = explode('x', $thickbox_options['size']);
        unset($thickbox_options['size']);
    }

    if (!array_key_exists('width', $thickbox_options) && !array_key_exists('height', $thickbox_options)) {
        $thickbox_options['width'] = 600;
        $thickbox_options['height'] = 600;
    }

    $options['class'] = isset($options['class']) ? $options['class'] : 'thickbox';

    if (isset($options['query_string'])) {
        $options['query_string'] .= '&' . http_build_query($thickbox_options);
    } else {
        $options['query_string'] = http_build_query($thickbox_options);
    }

    return link_to($name, $internal_uri, $options);
}

function _add_resources() {
    //use_javascript(sfConfig::get('sf_jquery_web_dir') . '/js/jquery-ui-1.8.7.custom.min');
    use_javascript('/mqThickboxPlugin/js/thickbox');
    use_stylesheet('/mqThickboxPlugin/css/thickbox', 'first');
}