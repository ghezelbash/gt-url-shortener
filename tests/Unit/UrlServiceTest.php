<?php

namespace Tests\Unit;

use App\Models\Url;
use App\Models\User;
use App\Services\UrlService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Tests\TestCase;

class UrlServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UrlService $urlService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->urlService = new UrlService(new Url());
    }

    public function testGetByShortenedUrl()
    {
        $fakeUser = User::factory()->create();
        $url = Url::factory()->create(['shortened_url' => 'abcdef', 'user_id' => $fakeUser->id]);

        $foundUrl = $this->urlService->getByShortenedUrl('abcdef');

        $this->assertInstanceOf(Url::class, $foundUrl);
        $this->assertEquals($url->id, $foundUrl->id);
    }

    public function testGetByUuid()
    {
        $fakeUser = User::factory()->create();
        $url = Url::factory()->create(['uuid' => (string) Str::uuid(), 'user_id' => $fakeUser->id]);

        $foundUrl = $this->urlService->getByUuid($url->uuid, 1);

        $this->assertInstanceOf(Url::class, $foundUrl);
        $this->assertEquals($url->id, $foundUrl->id);
    }

    public function testGetAllByUser()
    {
        $fakeUser = User::factory()->create();
        Url::factory()->count(3)->create(['user_id' => $fakeUser->id]);

        $urls = $this->urlService->getAllByUser($fakeUser->id);

        $this->assertInstanceOf(Collection::class, $urls);
        $this->assertCount(3, $urls);
    }

    public function testStore()
    {
        $data = ['original_url' => 'https://example.com'];
        $fakeUser = User::factory()->create();

        $url = $this->urlService->store($data, $fakeUser->id);

        $this->assertInstanceOf(Url::class, $url);
        $this->assertEquals($data['original_url'], $url->original_url);
        $this->assertEquals($fakeUser->id, $url->user_id);
    }

    public function testStoreInvalidUrl()
    {
        $this->expectException(InvalidArgumentException::class);

        $data = ['original_url' => 'invalid-url'];
        $fakeUser = User::factory()->create();

        $this->urlService->store($data, $fakeUser->id);
    }

    public function testUpdate()
    {

        $fakeUser = User::factory()->create();
        $url = Url::factory()->create(['uuid' => (string) Str::uuid(), 'user_id' => $fakeUser->id]);

        $data = ['original_url' => 'https://new-example.com'];

        $updatedUrl = $this->urlService->update($data, $url->uuid, 1);

        $this->assertInstanceOf(Url::class, $updatedUrl);
        $this->assertEquals($data['original_url'], $updatedUrl->original_url);
    }

    public function testUpdateInvalidUrl()
    {
        $this->expectException(InvalidArgumentException::class);

        $fakeUser = User::factory()->create();
        $url = Url::factory()->create(['uuid' => (string) Str::uuid(), 'user_id' => $fakeUser->id]);

        $data = ['original_url' => 'invalid-url'];

        $this->urlService->update($data, $url->uuid, 1);
    }

    public function testDelete()
    {
        $fakeUser = User::factory()->create();
        $url = Url::factory()->create(['uuid' => (string) Str::uuid(), 'user_id' => $fakeUser->id]);

        $this->urlService->delete($url->uuid, $fakeUser->id);

        $this->assertDatabaseMissing('urls', ['id' => $url->id]);
    }
}
