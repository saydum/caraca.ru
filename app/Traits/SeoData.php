<?php

namespace App\Traits;

trait SeoData
{
    public function setSeoMetaData(array $data): void
    {
        if (seo()->meta()->title() == null) {
            seo()->meta()->title();
            seo()->meta()->description();
            seo()->meta()->keywords();
            seo()->meta()->text();
        }

        seo()->title($data['title'], true);
        seo()->description($data['description'], true);
        seo()->keywords($data['keywords'], true);
        seo()->text($data['text'], true);
    }
}
