<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Form\AddEditEventFormType;
use AppBundle\Form\CommentType;
use DateTimeZone;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Intl;


class EventController extends Controller
{

    protected function getErrorMessages(\Symfony\Component\Form\Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }



    public function listAction(Request $request)
    {

        $srcTz = new DateTimeZone("Europe/Bucharest");
        $timeObj = new \DateTime($request->get("start"), $srcTz);
        $startTimestamp  = $timeObj->getTimestamp();

        $timeObj = new \DateTime($request->get("end"), $srcTz);
        $endTimestamp  = $timeObj->getTimestamp();
        $events  = $this->get("app_bundle.event_service")->getEventsThatStartBetween($startTimestamp, $endTimestamp);

        $processedEventArray = array();
        foreach($events as $event){
           ;

            $processedEventArray[] = array(
                "title" => $event->getName(),
                "description" => $event->getDescription(),
                "start" =>  $timeObj->setTimestamp($event->getStartTime())->format('Y-m-d\Th:i:s'),
                "end" =>  $timeObj->setTimestamp($event->getEndTime())->format('Y-m-d\Th:i:s'),
                );
        }


//        $serializer = $this->get('serializer');

        $response = new Response(json_encode($processedEventArray)

       );
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }


    /**
     * @ParamConverter("event", class="AppBundle:Event")
     */
    public function removeAction($event)
    {
        $this->get("app_bundle.event_service")->remove($event);
    }



    public function addAction(Request $request)
    {
        $errors = array();
        $form = $this->createForm(new AddEditEventFormType());
        $form->submit($request);
        if ($form->isValid()) {
            $data = $form->getData();

            $srcTz = new DateTimeZone("Europe/Bucharest");
            $timeObj = new \DateTime($data['startDate']." ".$data['startTime'], $srcTz);
            $data['startTime']  = $timeObj->getTimestamp();

            $timeObj = new \DateTime($data['endDate']." ".$data['endTime'], $srcTz);
            $data['endTime']  = $timeObj->getTimestamp();
            $event = $this->get("app_bundle.event_service")->addEvent($data);
        } else {
            $errors = $this->getErrorMessages($form);
        }
        $serializer = $this->get('serializer');

        $response = new Response(json_encode(array(
            'success' => (count($errors) == 0),
            'errors' => $errors,
            'event' => $serializer->serialize($event, 'json')

        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @ParamConverter("event", class="AppBundle:Event")
     */
    public function editAction($event, Request $request)
    {

        $errors = array();
        $form = $this->createForm(new AddEditEventFormType());
        $form->submit($request);
        if ($form->isValid()) {
            $data = $form->getData();


           $event =  $this->get("app_bundle.event_service")->editEvent($event, $data);
        } else {
            $errors = $this->getErrorMessages($form);
        }
        $serializer = $this->get('serializer');

        $response = new Response(json_encode(array(
            'success' => (count($errors) == 0),
            'errors' => $errors,
            'event' => $serializer->serialize($event, 'json')

        )));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }
}
