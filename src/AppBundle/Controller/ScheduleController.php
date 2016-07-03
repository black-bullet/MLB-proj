<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ScheduleParseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Schedule Controller
 *
 * @author Yevgeniy Zholkevskiy <zhenya.zholkevskiy@gmail.com>
 */
class ScheduleController extends Controller
{
    /**
     * Parse schedule MLB
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @Route("/schedule/parse", name="schedule_parse")
     */
    public function parseAction(Request $request)
    {
        $formCreate = $this->createForm(ScheduleParseType::class);

        $formCreate->handleRequest($request);
        if ($formCreate->isValid()) {
            $this->get('app.parse_service')->parseSchedule();
        }

        return $this->render('AppBundle:schedule:parse.html.twig', [
            'form_create' => $formCreate->createView(),
        ]);
    }

    /**
     * Get schedule MLB in JSON-format from DB
     *
     * @param Request $request Request
     *
     * @return Response
     *
     * @Route("/schedule/json", name="get_schedule_json")
     */
    public function getJSONAction(Request $request)
    {
        $em = $this->getDoctrine()->getRepository('AppBundle:Schedule');

        $pagination = $request->query->all();
        if (array_key_exists('limit', $pagination) && array_key_exists('offset', $pagination)) {
            $schedules = $em->findScheduleWithPagination($pagination['limit'], $pagination['offset']);
        } else {
            $schedules = $em->findScheduleWithPagination(10, 0);
        }

        return new JsonResponse([
            'schedules' => $schedules,
        ]);
    }

    /**
     * Get schedules
     *
     * @return Response
     *
     * @Route("/schedule", name="get_schedule")
     */
    public function getAction(Request $request)
    {
        $response  = $this->getJSONAction($request)->getContent();
        $schedules = $this->get('serializer')->decode($response, 'json');

        return $this->render('AppBundle:schedule:index.html.twig', [
            'schedules' => $schedules['schedules'],
        ]);
    }
}
