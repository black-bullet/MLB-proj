<?php

namespace AppBundle\Service;

use AppBundle\Entity\Schedule;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;

/**
 * Schedule Parse Service
 *
 * @author Yevgeniy Zholkevskiy <zhenya.zholkevskiy@gmail.com>
 */
class ScheduleParseService
{
    /** @var EntityManager $manager Entity manager */
    private $manager;

    /** @var Client $client Client */
    private $client;

    /** @var string $scheduleURL Schedule URL */
    private $scheduleURL = 'https://api.fantasydata.net/mlb/v2/json/Games/2016';

    /** @var string $scheduleSecret Schedule secret */
    private $scheduleSecret;

    /**
     * Constructor
     *
     * @param string $scheduleSecret Schedule secret
     */
    public function __construct(EntityManager $manager, $scheduleSecret)
    {
        $this->client         = new Client();
        $this->manager        = $manager;
        $this->scheduleSecret = $scheduleSecret;
    }

    /**
     * Parse schedule MLB
     */
    public function parseSchedule()
    {
        $response = $this->client->get($this->scheduleURL, [
            'headers' => [
                'Ocp-Apim-Subscription-Key' => $this->scheduleSecret,
            ],
        ]);

        $schedules = json_decode((string) $response->getBody()->getContents(), true);
        foreach ($schedules as $schedule) {
            $scheduleEntity = (new Schedule())
                ->setHomeTeam($schedule['HomeTeam'])
                ->setAwayTeam($schedule['AwayTeam'])
                ->setStadiumID($schedule['StadiumID'])
                ->setDate(new \DateTime($schedule['DateTime']));

            if (null != $scheduleEntity && null != $scheduleEntity->getStadiumID()) {
                $this->manager->persist($scheduleEntity);
            }
        }

        $this->manager->flush();
    }
}
