<?php

namespace Tests\Unit;

use App\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    public function testIndex(): void
    {
        factory(Category::class)->create();
        factory(Category::class)->create();

        $response = $this->json('GET', route('categories.index'));

        $response
            ->assertOk()
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'created_at',
                        'updated_at',
                        'name',
                    ],
                ]
            );
    }

    public function testCreate(): void
    {
        $data = [
            'name' => $this->faker->name(),
        ];
        $response = $this->json('POST', route('categories.store'), $data);

        $response
            ->assertOk()
            ->assertJsonStructure(['id']);

        $response = $this->json('POST', route('categories.store'), []);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(
                [
                    'errors' => [
                        'name',
                    ],
                ]
            );
    }

    /**
     * @throws \Exception
     */
    public function testUpdate(): void
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();
        $data = [
            'name' => $this->faker->name(),
        ];

        $response = $this->json('PUT', route('categories.update', $category->id), $data);
        $response
            ->assertOk()
            ->assertJson($data)
            ->assertJsonStructure(
                [
                    'id',
                    'created_at',
                    'updated_at',
                    'name',
                ]
            );

        $response = $this->json('PUT', route('categories.update', $category->id), []);

        $response
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(
                [
                    'errors' => [
                        'name',
                    ],
                ]
            );

        $category->delete();
        $response = $this->json('PUT', route('categories.update', $category->id), $data);
        $response
            ->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
