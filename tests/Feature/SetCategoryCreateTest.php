<?php

namespace Tests\Feature;

use App\Livewire\SetCategoryCreate;
use App\Models\Category;
use App\Models\SetCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Livewire\Volt\Volt;
use Tests\TestCase;

class SetCategoryCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_set_category()
    {
        $category = Category::factory()->create();

        Volt::test(SetCategoryCreate::class)
            ->set('name', 'Test Set Category')
            ->set('selectedCategories', [$category->id])
            ->call('save');

        $this->assertDatabaseHas('set_categories', [
            'name' => 'Test Set Category',
        ]);
    }

    /** @test */
    public function name_is_required()
    {
        Volt::test(SetCategoryCreate::class)
            ->set('name', '')
            ->call('save')
            ->assertHasErrors(['name' => 'required']);
    }
}
