<link rel="stylesheet" href="{{ asset('css/chatbot.css') }}" nonce="{{ app('csp-nonce') }}">

@persist('chatbot-widget')
    <livewire:publico.chatbot-widget />
@endpersist
