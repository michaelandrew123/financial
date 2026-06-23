<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Create Saving') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Add more savings") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')
        
    </form>
</section>
