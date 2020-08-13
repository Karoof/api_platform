<?php

namespace App\Tests\Functional;

use App\Entity\WorkoutPlan;
use App\Test\CustomApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class WorkoutPlanResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreateWorkoutPlan()
    {
        $client = self::createClient();

        $client->request('POST', '/api/workout_plans', [
            // not needed because of json key 'headers' => ['Content-Type' => 'application/json'],
            'json' => []
        ]);
        $this->assertResponseStatusCodeSame(401);

        $this->createUserAndlogIn($client, 'karolis@gmail.com', 'foo');

        $client->request('POST', '/api/workout_plans', [
            'json' => []
        ]);
        $this->assertResponseStatusCodeSame(400);
    }

    public function testUpdateWorkoutPlan()
    {
        $client = self::createClient();

        $user1 = $this->createUser('karolis1@gmail.com', 'foo');
        $user2 = $this->createUser('karolis2@gmail.com', 'foo');

        $workoutPlan = new WorkoutPlan();
        $workoutPlan->setTitle('test plan');
        $workoutPlan->setDescription('test description');
        $workoutPlan->setOwner($user1);
        $em = $this->getEntityManager();
        $em->persist($workoutPlan);
        $em->flush();

        $this->logIn($client, 'karolis2@gmail.com', 'foo');
        $client->request('PUT', '/api/workout_plans/' . $workoutPlan->getId(), [
            'json' => [
                'title' => 'updated',
                'owner' => '/api/users/' . $user2->getId()
            ]
        ]);
        $this->assertResponseStatusCodeSame(403);

        $this->logIn($client, 'karolis1@gmail.com', 'foo');
        $client->request('PUT', '/api/workout_plans/' . $workoutPlan->getId(), [
            'json' => [
                'title' => 'updated'
            ]
        ]);
        $this->assertResponseStatusCodeSame(200);
    }
}
