<!-- featured-elements -->
<?php
    $selected_items_ids = $block->browserIds('babysitter');
    $featured_babysitters = \App\Models\Babysitter::find($selected_items_ids);


    $selected_url = $block->browserIds('pages');
    $page = \App\Models\Page::find($selected_url)->first();
    $page_slug = ($page && $page->getActiveSlug()) ? $page->getActiveSlug()->slug : '';
?>

<div class="tripsitta-featured-elements">
    <div class="container">
        <p class="subtitle is-tripsitta is-7"><?php echo e($block->input('small_title')); ?></p>
        <p class="title is-4-mobile is-2-tablet" style="padding-top:15px"><?php echo e($block->input('title')); ?></p>

        <div class="columns is-mobile is-multiline is-centered">
            <?php $__currentLoopData = $featured_babysitters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $babysitter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="column is-8-mobile is-3-tablet">
                    <figure class="image is-2by3">
                        <div class="image-overlay-right">
                            <span class="icon is-large">
                                <i class="flag-icon flag-icon-squared is-country flag-icon-<?php echo e(strtolower($babysitter->mainAddress->country)); ?>"></i>
                            </span>
                            <span><?php echo e($babysitter->user->name); ?></span>
                        </div>
                        <?php if(count($babysitter->images('profile_image')) > 0): ?>
                            <a href="<?php echo e(route('babysitter-profile-show', [$babysitter->user->slug])); ?>">
                                <img
                                    class="has-rounded-border"
                                    src="<?php echo e(\A17\Twill\Services\MediaLibrary\ImageService::getUrlWithCrop(
                                        $babysitter->imageObject('profile_image')->uuid,
                                        [],
                                        ['fit' => 'crop-50-50', 'w' => 300, 'h' => 470]
                                    )); ?>"
                                    alt="Tripsitta babysitter - <?php echo e($babysitter->user->name); ?>"
                                />
                            </a>
                        <?php endif; ?>
                    </figure>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <p class="tfe_button" style="margin-top:20px;"><a href="<?php echo e($page_slug); ?>" class="button is-primary is-tripsitta"><?php echo e($block->input('button_text')); ?></a></p>
    </div>
</div>
<?php /**PATH /var/www/resources/views/layouts/blocks/featured_elements.blade.php ENDPATH**/ ?>