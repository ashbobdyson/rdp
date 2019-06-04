<div class="gallery-wrap">
    <div class="text">
        <h1>{{ get_the_title() }}</h1>
        <h2>Work</h2>
        <p>{{ get_field('description') }}</p>
        <a href="/portfolio" class="back">@include('icons.tail-left') Back</a>
    </div>
    <div class="images">
        <?php foreach (get_field('gallery') as $image) : ?>
            <div class="gallery-image-wrapper" data-lightbox="{!! wp_get_attachment_image_src($image['image']['id'], 'full')[0] !!}">
                <div class="lightbox-btn">@include('icons.zoom-e')</div>
                <div class="fb-btn"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= get_permalink() ?>">@include('icons.logo-fb-simple')</a></div>
                <div class="twitter-btn"><a target="_blank" href="https://twitter.com/home?status=<?= get_permalink() ?>">@include('icons.logo-twitter')</a></div>
                <?php if($image['linked_product']) : ?>
                    <a href="<?= get_the_permalink($image['linked_product']) ?>" class="no-barba buy-btn">@include('icons.bag-20')</a>
                <?php endif; ?>
                <img <?= create_srcset($image['image']['id']) ?>/>
            </div>
        <?php endforeach; ?>
    </div>
</div>