<?php

declare(strict_types=1);

final class Post
{
    public function __construct(
        private readonly int $id,
        private readonly int $authorId,
        private readonly string $authorName,
        private string $title,
        private string $text,
        private readonly string $time,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function update(string $title, string $text): self
    {
        $this->title = $title;
        $this->text = $text;

        return $this;
    }
}
