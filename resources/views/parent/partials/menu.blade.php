<aside class="menu">
    <ul class="menu-list">
        <p class="menu-label">
            Dashboard
        </p>
        <li>@include('parent.partials.menu-item', ['route' => 'parent.overview', 'label' => 'Overview'])</li>
        @if($user->family->published == 1)
            <li>@include('parent.partials.menu-item', ['route' => 'parent.bookings', 'label' => 'Bookings'])</li>
        @endif

        @if($user->family->published == 1 || ($user->family->reg_form_submitted == 0 && $user->family->published == 0))
            <p class="menu-label">
                My profile
            </p>
        @endif
        <li>
            <ul>
                <li>@include('parent.partials.menu-item', ['route' => 'parent.my-profile', 'label' => 'General info', 'form_filled' => (bool) $user->family->reg_step_1_completed])</li>
                <li>@include('parent.partials.menu-item', ['route' => 'parent.my-profile-address', 'label' => 'Home address', 'form_filled' => (bool) $user->family->reg_step_3_completed])</li>
                <li>@include('parent.partials.menu-item', ['route' => 'parent.my-profile-children', 'label' => 'Children details', 'form_filled' => (bool) $user->family->reg_step_2_completed])</li>
                @if($user->family->reg_form_submitted == 0)
                    <li>@include('parent.partials.menu-item', ['route' => 'parent.my-profile-submit-application', 'label' => 'Complete registration', 'form_filled' => (bool) $user->family->reg_form_submitted])</li>
                @endif
            </ul>
        </li>

        @if($user->family->published == 1)
            <p class="menu-label">
                Payments
            </p>
            <li>@include('parent.partials.menu-item', ['route' => 'parent.invoices', 'label' => 'Invoices'])</li>
        @endif
    </ul>
</aside>
