<?php
/**
 * File containing the ezcGraphPaletteEzCustom class
 *
 * @package Graph
 * @version 1.5
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Light Custom color pallet for ezcGraph based on Custom eZ colors
 *
 * @version 1.5
 * @package Graph 
 */
class ezcGraphPaletteEzCustom extends ezcGraphPalette
{
    /**
     * Axiscolor 
     * 
     * @var ezcGraphColor
     */
    protected $axisColor = '#2E3436';

    /**
     * Color of grid lines
     * 
     * @var ezcGraphColor
     */
    protected $majorGridColor = '#D3D7DF';

    /**
     * Array with colors for datasets
     * 
     * @var array
     */
    protected $dataSetColor = array(
        '#FF9797',
        '#FF97E8',
        '#B89AFE',
        '#57BCD9',
        '#6A6AFF',
        '#75B4FF',
        '#75D6FF',
        '#24E0FB',
        '#03F3AB',
        '#9D9D00',
        '#DFE32D',
        '#74BAAC',
        '#C48484',
        '#C98767',
        '#C06A45',
        '#CB876D',
        '#C98A4B',
        '#CEB86C',
        '#D7D78A'
    );

    /**
     * Array with symbols for datasets 
     * 
     * @var array
     */
    protected $dataSetSymbol = array(
        ezcGraph::BULLET,
    );

    /**
     * Name of font to use
     * 
     * @var string
     */
    protected $fontName = 'sans-serif';

    /**
     * Fontcolor 
     * 
     * @var ezcGraphColor
     */
    protected $fontColor = '#2E3436';

    /**
     * Backgroundcolor for chart
     * 
     * @var ezcGraphColor
     */
    protected $chartBackground = '#FFFFFF';

    /**
     * Padding in elements
     * 
     * @var integer
     */
    protected $padding = 1;

    /**
     * Margin of elements
     * 
     * @var integer
     */
    protected $margin = 0;
}

?>
