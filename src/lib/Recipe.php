<?php

namespace Application\Lib\Recipe;

class Recipe {
    public int $rec_id;
    public string $rec_title;
    public string $rec_image;
    public string $rec_summary;
    public string $rec_creation_date;
    public string $rec_modification_date;
    public string $use_nickname;
    public array $tags;
}