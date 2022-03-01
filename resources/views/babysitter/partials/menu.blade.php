<aside class="menu">
    <ul class="menu-list">
        <p class="menu-label">
            Dashboard
        </p>
        <li>@include('babysitter.partials.menu-item', ['route' => 'babysitter.overview', 'label' => 'Overview'])</li>
        @if($user->babysitter->published == 1)
            <li>@include('babysitter.partials.menu-item', ['route' => 'babysitter.bookings', 'label' => 'Bookings'])</li>
            <li>@include('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile-availability', 'label' => 'Booking availability'])</li>
        @endif

        @if($user->babysitter->published == 1 || ($user->babysitter->reg_form_submitted == 0 && $user->babysitter->published == 0))
        <p class="menu-label">
            My profile
        </p>
        @endif
        <li>
            <ul>
                @if($user->babysitter->published == 1 || ($user->babysitter->reg_form_submitted == 0 && $user->babysitter->published == 0))
                    <li>@include('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile', 'label' => 'General info', 'form_filled' => (bool) $user->babysitter->reg_step_1_completed])</li>
                    <li>@include('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile-addresses', 'label' => 'Contact & addresses', 'form_filled' => (bool) $user->babysitter->reg_step_2_completed])</li>
                    <li>@include('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile-about-me', 'label' => 'Reasons for joining & About me', 'form_filled' => (bool) $user->babysitter->reg_step_3_completed])</li>
                    <li>@include('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile-experience', 'label' => 'Experience & Qualifications', 'form_filled' => (bool) $user->babysitter->reg_step_4_completed])</li>
                @endif
                @if($user->babysitter->reg_form_submitted == 0)
                    <li>@include('babysitter.partials.menu-item', ['route' => 'babysitter.my-profile-submit-application', 'label' => 'Book an interview & submit application', 'form_filled' => (bool) $user->babysitter->reg_form_submitted])</li>
                @endif
            </ul>
        </li>

        @if($user->babysitter->published == 1)
            <p class="menu-label">
                Payments
            </p>
            <li>@include('babysitter.partials.menu-item', ['route' => 'babysitter.invoices', 'label' => 'Invoices'])</li>
            <li>@include('babysitter.partials.menu-item', ['route' => 'babysitter.transactions', 'label' => 'Payouts'])</li>
            <li>@include('babysitter.partials.menu-item', ['route' => 'babysitter.bank_details', 'label' => 'Payment settings'])</li>
        @endif

    </ul>
</aside>
