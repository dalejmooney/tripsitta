<!-- contact form -->
@if (session('message'))
    <div class="notification is-success">
        {{ session('message') }}
    </div>
@endif
@if ($errors->any())
    <div class="notification is-danger">
        @foreach ($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
@endif

<div class="tripsitta-contact-form">
    <h2 class="title is-5">{{$block->input('title')}}</h2>

    <form method="post" action="contact-us">
        <div class="field">
            <label class="label">Your name</label>
            <div class="control">
                <input class="input" type="text" name="contact_name"/>
            </div>
        </div>

        <div class="field">
            <label class="label">Your e-mail</label>
            <div class="control">
                <input class="input" type="email" name="contact_email"/>
            </div>
        </div>

        <div class="field">
            <label class="label">Message</label>
            <div class="control">
                <textarea class="textarea" name="contact_message"></textarea>
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                @csrf
                <button class="button is-primary" type="submit" name="contact_submit">Send message</button>
            </div>
        </div>
    </form>
</div>
