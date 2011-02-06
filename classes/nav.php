<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Navigation menu (breadcrumb) simple helper
 *
 * - Data "types" -
 * Navitem, a link formatted as array 
 * navitem = array(
 *  'title' => 'Item1',
 *  'href'  => 'http://domain.es',
 *  'target'=> '_blank'
 * );
 * Navdata, an array of navitems
 * navdata = array(
 *  array(
 *      'title'=>'Item1'
 *      'href'=>'http://google.es'
 *  ),
 *  array(
 *      'title'=>'Item2'
 *  )
 * );
 *
 * - Example -
 * $nav = Nav::instance();
 * $html = $nav->add_navitem(
 *                  array(
 *                      'title'  => $promocion->nombre,
 *                      'href'   => URL::site($promo->link)
 *                      'target' => '_blank'
 *                  )
 *              )
 *              ->add_navitem(
 *                  array( 
 *                      'title'  => $categoria->nombre,
 *                      'href'   => URL::site($cat->link)
 *                  )
 *              )
 *          ->add( $producto->nombre, URL::site($producto->link) )
 *          ->add( $subproducto->nombre )
 *          ->render();
 * 
 * @license http://creativecommons.org/licenses/by-sa/3.0/ CC BY-SA 3.0
 * @author Jesus Díez - jesus@jesusdiez.com
 * @version 0.6 - 2011/02/06
 */
class Nav {

    /**
     * @var Nav Static singleton instance
     */
    protected static $_instance;

    /**
     * Returns the singleton instance
     *     $nav = Nav::instance();
     *
     * @return  Nav singleton instance
     */
    public static function instance( $navData = NULL )
    {
        if (self::$_instance === NULL)
        {
            // Create a new instance
            self::$_instance = new Nav($navData);
        }
        return self::$_instance;
    }
 
    /**
     * @var array of 'navitem', base data used
     */
    private $data = array();

    /**
     * Constructor
     * 
     * @param array $navdata
     */
    public function __construct( $navdata = NULL )
    {
        if (is_array($navdata))
        {
            $this->data = $navdata;
        }
    }

    /**
     * Cleans the current data
     *
     * @return $this
     */
    public function clear()
    {
        $this->data = array();
        
        return $this;
    }

    /**
     * Adds an item to the navigation menu
     *
     * @param string $title     Text
     * @param string $href      Link URI
     * @param string $target    HTML link target (ie: _blank, _top...)
     * @return $this
     */
    public function add( $title, $href = null, $target = null)
    {
        $navitem = array();
        $navitem['title'] = $title;
        if ($href)
        {
            $navitem['href'] = $href;
            if ($target)
            {
                $navitem['target'] = $target;
            }

        }
        $this->add_navitem( $navitem );

        return $this;
    }

    /**
     * Adds an item to the navigation menu, as an 'navitem' array
     *
     * @param array $navitem
     * @return $this
     */
    public function add_navitem( $navitem )
    {
        array_push($this->data, $navitem);
        
        return $this;
    }

    /**
     * Adds a full array of navigation data
     *
     * @param array $navdata
     * @return $this
     */
    public function add_navdata( $navdata )
    {
        foreach($navdata as $navitem){
            array_push($this->data, $navitem);
        }
        
        return $this;
    }

    /**
     * Returns the navigation HTML from the data
     *
     * @param array $navdata
     * @return string  HTML navigation menu
     */
    public function render( $data = NULL )
    {
        $data = $data ? $data : $this->data;
        
        $out = "\n".'<ul id="nav">'."\n";
        if(count($data))
        foreach($data as $navitem)
        {
            $out.= '<li>';
            if (isset($navitem['href'])){
                $out.= '<a href="'.$navitem['href'].'"';
                $out.= isset($navitem['target']) ? ' target="'.$navitem['target'].'"':'';
                $out.= '>'.$navitem['title'].'</a>';
            }else{
                $out.= $navitem['title'];
            }
            $out.= '</li>'."\n";
        }
        $out.= "\n".'</ul>';
        return $out;
    }

    /**
     * 
     * @return string HTML navigation menu 
     */
    public function __toString()
    {
        return $this->render();
    }
}