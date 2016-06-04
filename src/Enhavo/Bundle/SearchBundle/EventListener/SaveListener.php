<?php

namespace Enhavo\Bundle\SearchBundle\EventListener;

use Symfony\Component\DependencyInjection\Container;
use Enhavo\Bundle\SearchBundle\Util\SearchUtil;

class SaveListener
{
    protected $container;
    protected $util;

    public function __construct(Container $container, SearchUtil $util)
    {
        $this->container = $container;
        $this->util = $util;
    }

    public function onSave($event)
    {
        //get the current search.yml for the entity
        $resource = $event->getSubject();
        $currentSearchYaml = $this->util->getSearchYaml($resource);

        if($currentSearchYaml != null) {

            //if searchYaml exists try indexing
            $indexEngine = $this->container->get('enhavo_search_index_engine');
            $indexEngine->index($resource);
        }
    }
}