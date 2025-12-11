<?php

namespace app\Controller;

use app\Service\Components;
use app\View\ApiView;
use app\View\View;

class Controller
{
    
    private $view;
    private $components;

    public function __construct() {
        $this->view = new View;
        $this->components = new Components;
    }

    protected function set_static_dir_view(string $dir)
    {
       if(!$dir) return;

       $this->view = new View($dir);
    }
    
    protected function html_render()
    {
        return $this->view;
    }

    protected function components(String $file, Array $vars = [])
    {   

        return $this->components
        ->load($file)
        ->set($vars)
        ->render();
    }

    protected function navegation_elements(Array $paths)
    {   

        $nav = '';

        foreach ($paths as $key => $value) {
            
            $nav .= $this->components('View/Components/sub.php',[
                'title' => $key,
                'href' => "/$key",
                'class' => 'sub-menu',
                'location' => empty($value) ? '-location' : '',
                'submenu' => (function () use ($value) {
                    $sub = '';
                    foreach ($value as $k => $val) 
                    {
                        $sub .= $this->components('View/Components/li.php', $val);
                    }

                    return $sub;
                })()
            ]);
        }

        return $nav;
    }

    #=============
    #
    #

    protected function apiView(Int $status, Array $data)
    {
        $print = new ApiView;
        $print->setStatus($status)
        ->setData($data)
        ->send();

    }
}