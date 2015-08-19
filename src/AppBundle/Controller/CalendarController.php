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

use AppBundle\Form\AddEditEventFormType;
use DateInterval;
use DateTimeZone;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Intl;


class CalendarController extends Controller
{
    public function indexAction()
    {

        $selectedTime = "first day of this month";

        $srcTz = new DateTimeZone("Europe/Bucharest");
        $startTimeObj = new \DateTime($selectedTime, $srcTz);
        $endTimeObj = new \DateTime($selectedTime, $srcTz);
        $endTimeObj->add(new DateInterval('P1M'));
        $events = $this->get("app_bundle.event_service")->getEventsThatStartBetween($startTimeObj->getTimestamp(),$endTimeObj->getTimestamp());
        $form = $this->createForm(new AddEditEventFormType());
        return $this->render('AppBundle::index.html.twig',
            array(
                'events' => $events,
                "form" => $form->createView()
            ));
    }
}
