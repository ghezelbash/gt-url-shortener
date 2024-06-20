<?php

namespace App\Services;

use App\Models\Url;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class UrlService
{
    public function __construct(
        private readonly Url $url
    ){
    }


    /**
     * Get Url by shortened URL
     *
     * @param string $shortenedUrl
     *
     * @return Url
     */
    public function getByShortenedUrl(string $shortenedUrl): Url
    {
        return $this->url->where('shortened_url', $shortenedUrl)->firstOrFail();
    }

    /**
     * Get Url by UUID and UserId
     *
     * @param string $uuid
     * @param int $userId
     * @return Url
     */
    public function getByUuid(string $uuid, int $userId): Url
    {
        try {
            $url = $this->getByUuidAndUserId($uuid, $userId);
        } catch (\Exception $exception) {
            throw new ResourceNotFoundException("URL not found");
        }

        return $url;
    }

    /**
     * Get all Url entities belongs to a user
     *
     * @param int $userId
     *
     * @return Collection|null
     */
    public function getAllByUser(int $userId): ?Collection
    {
        return $this->url->where('user_id', $userId)->get();
    }

    /**
     * Service to validate and store new requested URL
     *
     * @param array $data
     * @param int $userId
     *
     * @return Url
     */
    public function store(array $data, int $userId): Url
    {
        $validator = Validator::make($data, [
            'original_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $url = new $this->url;
        $url->uuid = Str::uuid();
        $url->user_id = $userId;
        $url->original_url = $data['original_url'];
        $url->shortened_url = $this->generateShortenedUrl();
        $url->save();

        return $url->fresh();
    }

    /**
     * Service to update an existing URL
     *
     * @param array $data
     * @param string $uuid
     * @param int $userId
     *
     * @return Url
     */
    public function update(array $data, string $uuid, int $userId): Url
    {
        $validator = Validator::make($data, [
            'original_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        try {
            $url = $this->getByUuidAndUserId($uuid, $userId);
            $url->original_url = $data['original_url'];
            $url->save();
        } catch (\Exception $exception) {
            throw new ResourceNotFoundException("URL not found");
        }

        return $url->fresh();
    }

    /**
     * Service to delete an existing URL
     *
     * @param string $uuid
     * @param int $userId
     *
     * @return void
     */
    public function delete(string $uuid, int $userId): void
    {
        try {
            $url = $this->getByUuidAndUserId($uuid, $userId);
            $url->delete();
        } catch (\Exception $exception) {
            throw new ResourceNotFoundException("URL not found");
        }
    }


    /**
     * Generates random unique shortened url
     *
     * @param int $length
     *
     * @return string
     */
    private function generateShortenedUrl(int $length = 7): string
    {
        while (true){
            $randomString = strtolower(Str::random($length));

            //Check if it already exists or not
            if ($this->url->where('shortened_url', '=', $randomString)->exists() === false){
                return $randomString;
            }
        }
    }

    private function getByUuidAndUserId(string $uuid, int $userId): Url
    {
        return Url::where([['uuid', '=', $uuid], ['user_id', '=', $userId]])->firstOrFail();
    }
}
