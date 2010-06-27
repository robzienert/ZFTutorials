<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * The first method of handling routes and my personal favorite.
     *
     * Using static routes allows us to add pages right into the router. It
     * results in pleasant-looking URLs and really easy links using the url
     * view helper. On the downside, you have to manage a list of pages
     * somewhere... like here in the bootstrap, in the application.ini.
     */
    protected function _initMvcStaticRoutes()
    {
        $this->bootstrap('frontcontroller');
        $router = $this->getResource('frontcontroller')->getRouter();

        $pages = array(
            'about', 'help', 'terms-of-service',
        );
        foreach ($pages as $page) {
            $router->addRoute($page,
                new Zend_Controller_Router_Route_Static($page, array(
                    'controller' => 'index',
                    'action' => 'page',
                    'slug' => $page,
                )));
        }
    }

    /**
     * The second method, and one I'm not a particular fan of, uses a standard
     * route... but only one of them. There are two obvious advantages to this:
     *
     *  1) You only have one route to mess with.
     *  2) You don't need to manage a list of pages; it all falls to the
     *     IndexController->pageAction() method.
     *
     * Then again, having the slug at root-level is no longer feasible, so you'd
     * have to prepend it with something, like in this example... "page". From
     * experience, if you have a digital strategist on your team, they might
     * throw a fit because they don't get complete control over of the URL.
     */
//    protected function _initMvcStandardRoutes()
//    {
//        $this->bootstrap('frontcontroller');
//        $router = $this->getResource('frontcontroller')->getRouter();
//
//        $router->addRoute('page',
//            new Zend_Controller_Router_Route('page/:slug', array(
//                'controller' => 'index',
//                'action' => 'page',
//            )));
//    }

}

