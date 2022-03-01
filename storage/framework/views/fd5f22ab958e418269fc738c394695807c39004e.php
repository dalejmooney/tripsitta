<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('meta_title',  config('app.name', 'Laravel')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_desc'); ?>">

    <!-- Scripts -->
    <script src="<?php echo e(mix('js/app.js')); ?>"></script>
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js"></script>
    <?php echo $__env->yieldContent('scripts', ''); ?>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">


    <!-- Styles -->
    <link href="<?php echo e(mix('css/app.css')); ?>" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="hero is-fullheight">
            <nav id="navbar-primary-wrapper" class="navbar" role="navigation" aria-label="main navigation">
                <div class="navbar-brand">
                    <a class="navbar-item" href="<?php echo e(route('home')); ?>">
                        <img src="<?php echo e(route('home')); ?>/images/tripsitta-logo-2x.png" srcset="<?php echo e(route('home')); ?>/images/tripsitta-logo.png, <?php echo e(route('home')); ?>/images/tripsitta-logo-2x.png 2x" alt="Tripsitta logo"/>
                    </a>

                    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>

                <div id="navbar-primary" class="navbar-menu">
                    <div class="navbar-end">
                        <a href="/" class="navbar-item is-hidden-tablet">
                            Home
                        </a>
                        <?php $__currentLoopData = $primary_navigation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('home')); ?>/<?php echo e($link['slug']); ?>" class="navbar-item">
                                <?php echo e($link['title']); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="navbar-item has-dropdown is-mega">
                            <div class="navbar-link">
                                Explore
                            </div>
                            <div class="navbar-dropdown">
                                <div class="navbar-dropdown-content">
                                    <p class="title is-4">Information & Guidelines</p>
                                    <div class="columns">
                                        <div class="column is-one-fifth">
                                            <p class="subtitle is-6">Booking process</p>
                                            <ul>
                                                <?php $__currentLoopData = $mega_menu->where('bucket', 'ex_1'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><a href="<?php echo e(route('home')); ?>/<?php echo e($link['slug']); ?>"><?php echo e($link['title']); ?></a></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                        <div class="column is-one-fifth">
                                            <p class="subtitle is-6">Guidelines</p>
                                            <ul>
                                                <?php $__currentLoopData = $mega_menu->where('bucket', 'ex_2'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><a href="<?php echo e(route('home')); ?>/<?php echo e($link['slug']); ?>"><?php echo e($link['title']); ?></a></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                        <div class="column is-one-fifth">
                                            <p class="subtitle is-6">About Us</p>
                                            <ul>
                                                <?php $__currentLoopData = $mega_menu->where('bucket', 'ex_3'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><a href="<?php echo e(route('home')); ?>/<?php echo e($link['slug']); ?>"><?php echo e($link['title']); ?></a></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                        <div class="column is-two-fifths">
                                            <p class="subtitle is-6">Latest from our blog</p>
                                            <?php if($recent_post): ?>
                                                <div class="blog_latest_wrapper">
                                                    <p class="is-size-6"><a href="<?php echo e(route('blog')); ?>/<?php echo e($recent_post->slug); ?>"><?php echo e($recent_post->title); ?></a></p>
                                                    <div class="content has-text-grey">
                                                        <?php echo $recent_post->description; ?>

                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(auth()->guard()->guest()): ?>
                            <div class="navbar-item navbar-mobile-inline">
                                <a id="register-button" href="<?php echo e(route('register-specific', 'babysitter')); ?>" class="button is-dark">
                                    Become a Tripsitta nanny
                                </a>
                            </div>
                            <div class="navbar-item navbar-mobile-inline">
                                <a id="signin-button" href="<?php echo e(route('login')); ?>" class="button is-light">
                                    Sign in
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="navbar-item has-dropdown">
                                <a href="" class="navbar-link">
                                    Logged in as <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                                </a>

                                <div class="navbar-dropdown is-right">
                                    <?php if(Auth::user()->role === 'babysitter'): ?>
                                        <a href="<?php echo e(route('babysitter.overview')); ?>" class="navbar-item">
                                            My profile
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('parent.overview')); ?>" class="navbar-item">
                                            My profile
                                        </a>
                                    <?php endif; ?>
                                    <a class="navbar-item has-text-danger" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Log out
                                    </a>
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                    <hr class="navbar-divider">
                                    <?php if(Auth::user()->role === 'babysitter'): ?>
                                        <a class="navbar-item" href="<?php echo e(route('babysitter.admin-chat')); ?>">
                                            Contact Tripsitta
                                        </a>
                                    <?php else: ?>
                                        <a class="navbar-item" href="<?php echo e(route('parent.admin-chat')); ?>">
                                            Contact Tripsitta
                                        </a
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <footer>
            <div class="container">
                <div class="columns is-mobile is-multiline">
                    <div class="column is-2 is-hidden-mobile">
                        <figure class="image is-128x128">
                            <img src="<?php echo e(route('home')); ?>/images/tripsitta-logo-large.png" alt="tripsitta logo"/>
                        </figure>
                    </div>
                    <div class="column is-6-mobile is-2-tablet">
                        <p class="subtitle is-tripsitta is-size-7">Tripsitta</p>
                        <ul>
                            <li><a href="/" class="navbar-item">Home</a></li>
                            <?php $__currentLoopData = $primary_navigation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e($link['slug']); ?>" class="navbar-item">
                                    <?php echo e($link['title']); ?>

                                </a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="/contact-us" class="navbar-item">Contact us</a></li>
                        </ul>
                    </div>
                    <div class="column is-6-mobile is-2-tablet">
                        <p class="subtitle is-tripsitta is-size-7">Booking process</p>
                        <ul>
                            <?php $__currentLoopData = $mega_menu->where('bucket', 'ex_1'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e($link['slug']); ?>"><?php echo e($link['title']); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="column is-6-mobile is-2-tablet">
                        <p class="subtitle is-tripsitta is-size-7">Guidelines</p>
                        <ul>
                            <?php $__currentLoopData = $mega_menu->where('bucket', 'ex_2'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e($link['slug']); ?>"><?php echo e($link['title']); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="column is-6-mobile is-2-tablet">
                        <p class="subtitle is-tripsitta is-size-7">About Us</p>
                        <ul>
                            <?php $__currentLoopData = $mega_menu->where('bucket', 'ex_3'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e($link['slug']); ?>"><?php echo e($link['title']); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="column is-6-mobile is-2-tablet">
                        <p class="subtitle is-tripsitta is-size-7">Social</p>
                        <ul>
                            <li><a href=""><span class="icon"><i class="fab fa-facebook"></i></span>  Facebook</a></li>
                            <li><a href=""><span class="icon"><i class="fab fa-twitter"></i></span>  Twitter</a></li>
                            <li><a href=""><span class="icon"><i class="fab fa-pinterest"></i></span>  Pinterest</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <p id="copyright" class="has-text-right is-size-7 has-text-grey">2020 © Copyright Tripsitta</p>
    </div>
</body>
</html>
<?php /**PATH /var/www/resources/views/layouts/app_full_hero.blade.php ENDPATH**/ ?>