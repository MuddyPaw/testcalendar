<?php

namespace AppBundle\Service;

use AppBundle\Entity\Event;

use Symfony\Component\DependencyInjection\ContainerInterface;

class EventService extends AbstractService
{

    /**
     * @var RepositoryManager $persistenceManager
     */
    private $eventManager;
    protected $container;

    /**
     * @param RepositoryManager $repositoryManager
     */
    public function __construct($em, ContainerInterface $container)
    {

        parent::__construct($em->getRepository(Event::ENTITY_PATH));


        $this->entityPath = Event::ENTITY_PATH;
        $this->eventManager =  $this->repositoryManager;
        $this->container = $container;
    }

    public function editEvent(Event $event, $data)
    {

        if (array_key_exists('title', $data)) {
            $event->setName($data['title']);

        }
        if (array_key_exists('description', $data)) {
            $event->setDescription($data['description']);
        }
        $event->setStartTime($data['startTime']);
        $event->setEndTime($data['endTime']);
        $event->setType($data['type']);
        $this->eventManager->save($event);
        return $event;
    }

    public function addEvent($data){
        $event  = new Event($data);
        $this->eventManager->save($event);
        return $event;

    }


}