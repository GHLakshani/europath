<?php

// Ensure the content type is set to application/xml

header('Content-Type: text/xml');



$pages = [

    '/' => "1.00",

    'land' => "0.80",

    'house' => "0.80",

    'about-us' => "0.80",

    'sell-your-land' => "0.80",

    'contact-us' => "0.80",

    'payment-plans' => "0.80",

    'careers' => "0.80",

    'news' => "0.80",

    'branch-network' => "0.80",

    'faq' => "0.80"

];



$dynamic_pages = [

    'houses' => $houses,

    'houses_district' => $houses_district,

    'lands' => $lands,

    'lands_district' => $lands_district,

    'news' => $news,

    'careers' => $careers,

];



?>

<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    @foreach($pages as $path => $priority)

        <url>

            <loc>{{ url($path) }}</loc>

            <lastmod>{{ now()->toAtomString() }}</lastmod>

            <priority>{{ $priority }}</priority>

        </url>

    @endforeach

    

    @foreach($dynamic_pages as $key => $items)

        @foreach($items as $item)

            <?php

            $dynamic_url = ''; // Initialize dynamic URL

            // Add logic for generating dynamic URLs based on $key and $item

            if ($key == 'houses') {

                $title = sanitize_title($item->house_name);

                $dynamic_url = url("house/" . $title .'');

            } elseif ($key == 'lands'){

                $title = sanitize_title($item->land_name);

                $dynamic_url = url("land/" . $title .'');

            } elseif ($key == 'news'){

                $title = sanitize_title($item->title);

                $dynamic_url = url("news/" . $item->id . '/' . $title .'');

            } elseif ($key == 'careers'){

                $title = sanitize_title($item->position_name);

                $dynamic_url = url("careers/" . $item->id . '/' . $title .'');

            } elseif ($key == 'houses_district'){

                $title = sanitize_title($item->name);

                $dynamic_url = url("house/district/" . $title .'');

            } elseif ($key == 'lands_district') {

                $title = sanitize_title($item->name);

                $dynamic_url = url("land/district/" . $title .'');

            }

            ?>

            <url>

                <loc>{{ htmlspecialchars($dynamic_url) }}</loc>

                <lastmod>{{ now()->toAtomString() }}</lastmod>

                <priority>0.64</priority>

            </url>

        @endforeach

    @endforeach

</urlset>

