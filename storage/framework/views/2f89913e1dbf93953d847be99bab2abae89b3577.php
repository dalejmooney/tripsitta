<!-- large_2_column -->
<?php
    $title = $block->input('title');
    if(!empty($block->input('title_font_colour'))){
        $title = '<span style="color: '.$block->input('title_font_colour').'">'.$block->input('title').'</span>';
    }

    $selected_url = $block->browserIds('page_url');
    $page = \App\Models\Page::find($selected_url)->first();
    $page_slug = ($page && $page->getActiveSlug()) ? $page->getActiveSlug()->slug : '';

    $line_color = '';
    if(!empty($block->input('title_line_colour')))
    {
        $line_color = 'style="border-left-color:'.$block->input('title_line_colour').'"';
    }

    $button_class = 'is-secondary has-text-white';
    if(!empty($block->input('button_style')))
    {
        if($block->input('button_style') == 'primary') $button_class = 'is-primary';
        elseif($block->input('button_style') == 'secondary') $button_class = 'is-secondary has-text-white';
        elseif($block->input('button_style') == 'dark') $button_class = 'is-dark';
        elseif($block->input('button_style') == 'primary_outlined') $button_class = 'is-primary is-outlined';
        elseif($block->input('button_style') == 'secondary_outlined') $button_class = 'is-secondary is-outlined';
        elseif($block->input('button_style') == 'dark_outlined') $button_class = 'is-dark is-outlined';
    }
?>
<div class="container">
    <div class="columns tripsitta-large2column <?php if($block->input('column_setup') == 1): ?> reverse-row-order <?php endif; ?>">
        <div class="column is-6">
            <?php if(!empty($block->input('title_font_size'))): ?>
                <?php
                    $size = $block->input('title_font_size');
                    $size_tablet = $size + 2;
                    if($size_tablet >= 6) $size_tablet = 6;

                    $size_mobile = $size + 3;
                    if($size_mobile >= 6) $size_mobile = 6;
                ?>
                <p class="title is-size-<?php echo e($size_mobile); ?> is-size-<?php echo e($size_tablet); ?>-tablet is-size-<?php echo e($size); ?>-desktop" <?php echo $line_color; ?>><?php echo $title; ?></p>
            <?php else: ?>
                <p class="title is-size-4 is-size-3-tablet is-size-1-desktop"><?php echo $title; ?></p>
            <?php endif; ?>
            <div class="content">
                <?php echo $block->input('content'); ?>

            </div>
            <p><a href="<?php echo e($page_slug); ?>" class="button <?php echo e($button_class); ?> is-tripsitta"><?php echo e($block->input('button_text')); ?></a></p>
        </div>
        <div class="column is-6">
            <figure class="image">
                <img src="<?php echo e($block->image('cover')); ?>" alt=""/>
            </figure>
        </div>
    </div>
</div>
<?php /**PATH /var/www/resources/views/layouts/blocks/large_2_column.blade.php ENDPATH**/ ?>