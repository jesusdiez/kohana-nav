# Nav #

Navigation menu simple helper for Kohana3 PHP framework

## Data "types" ##

Navitem, a link formatted as array

    $navitem = array(
        'title' => 'Item1',
        'href'  => 'http://domain.es',
        'target'=> '_blank'
    );

Navdata, an array of navitems

    $navdata = array(
        array(
            'title'=>'Item1'
            'href'=>'http://google.es'
        ),
        array(
            'title'=>'Item2'
        )
    );

## Usage ##
    
### Creates a breadcrumb ###

    $nav = Nav::instance();
    $nav->add_navitem(
        array(
            'title'  => $group->name,
            'href'   => URL::site($group->link)
            'target' => '_blank'
        ) );
    $nav->add_navitem(
        array( 
            'title'  => $subgroup->name,
            'href'   => URL::site($subgroup->link)
        ) )
    $nav->add( $product->name, URL::site($product->link) )
    $nav->add( $subproduct->name );
    $html = $nav->render();

### Creates a breadcrumb using chainable methods, from a view ###

    <html><body>
    <?php echo Nav::instance()->add('Home','/')->add('News','/news')->add('New'); ?>
    </body></html>

The `render()` method is automagically called using `__toString()`
The resultant code is:

    <html><body>
    <ul id="nav">
    <li><a href="/">Home</a></li>
    <li><a href="/news">News</a></li>
    <li>New</li>
    </ul>
    </body></html>

You can easily stylize it using CSS.

## How do I use it? ##

I added a `private $nav;` atribute to the `Controller_Template`, from wich my controllers extend. 
I also initialized `$nav` on the constructor, with an initial value.

    $this->nav = Nav::instance()->add('Home', URL::site());
    
Later, on whathever action method of any app controller, I add specific navigation info.

    $this->template->nav->add( $promo->name,    $promo->link )
                        ->add( $cat->name,      $cat->link )
                        ->add( $product->name );

And finally, the data has to be rendered somewhere. I added it to my template

    <html>
    <body>
        <div id="header"><?php echo $nav->render(); ?></div>
    </body>
    </html>


## Other Info ##

**Version** 0.6 - 2011/02/06
**License** (http://creativecommons.org/licenses/by-sa/3.0/ "CC BY-SA 3.0")
**Author** Jesús Díez
* web (http://jesusdiez.com "Jesus Díez") 
* email (mailto:jesus@jesusdiez.com "jesus@jesusdiez.com")
* twitter (http://twitter.com/jesusdiezc "@jesusdiezc") 