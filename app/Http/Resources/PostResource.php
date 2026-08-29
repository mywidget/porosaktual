<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'featured_image' => $this->featured_image,
            'featured_image_url' => $this->featured_image_url,
            'author' => [
                'name' => $this->whenLoaded('author', fn () => $this->author->name),
                'avatar' => $this->whenLoaded('author', fn () => $this->author->avatar),
                'slug' => $this->whenLoaded('author', fn () => $this->author->slug),
            ],
            'category' => [
                'name' => $this->whenLoaded('category', fn () => $this->category->name),
                'slug' => $this->whenLoaded('category', fn () => $this->category->slug),
            ],
            'tags' => $this->whenLoaded('tags', fn () => $this->tags->map(fn ($tag) => [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
            ])),
            'published_at' => $this->published_at?->toISOString(),
            'views_count' => $this->views_count,
            'reading_time' => $this->reading_time,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'url' => route('post.show', $this->slug),
        ];
    }
}
