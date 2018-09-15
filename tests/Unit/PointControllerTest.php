<?php

namespace Tests\Unit;

use App\Category;
use App\Point;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class PointControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    public function testIndex(): void
    {
        factory(Category::class, 1)->create()->each(
            function (Category $category) {
                factory(Point::class, 2)->create(
                    [
                        'category_id' => $category->id,
                    ]
                );
            }
        );

        $response = $this->json('GET', route('points.index'));

        $response
            ->assertOk()
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'created_at',
                        'updated_at',
                        'longitude',
                        'latitude',
                    ],
                ]
            );
    }

    public function testCreate(): void
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();

        $data = [
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'category_id' => $category->id,
        ];
        $response = $this->json('POST', route('points.store'), $data);

        $response
            ->assertOk()
            ->assertJsonStructure(['id']);
    }

    /**
     * @throws \Exception
     */
    public function testCreateValidation(): void
    {
        $response = $this->json('POST', route('points.store'), []);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(
                [
                    'errors' => [
                        'longitude',
                        'latitude',
                        'category_id',
                    ],
                ]
            );

        $response = $this->json(
            'POST',
            route('points.store'),
            [
                'longitude' => $this->faker->longitude,
                'latitude' => $this->faker->latitude,
                'category_id' => \random_int(100, 200),
            ]
        );

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(
                [
                    'errors' => [
                        'category_id',
                    ],
                ]
            );

        $response = $this->json(
            'POST',
            route('points.store'),
            [
                'longitude' => -200,
                'latitude' => -100,
                'category_id' => \random_int(100, 200),
            ]
        );

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(
                [
                    'errors' => [
                        'category_id',
                        'longitude',
                        'latitude',
                    ],
                ]
            );

        $response = $this->json(
            'POST',
            route('points.store'),
            [
                'longitude' => 200,
                'latitude' => 100,
                'category_id' => \random_int(100, 200),
            ]
        );

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(
                [
                    'errors' => [
                        'category_id',
                        'longitude',
                        'latitude',
                    ],
                ]
            );
    }
}
