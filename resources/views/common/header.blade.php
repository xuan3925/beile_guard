<header>
    <a href="/" class="jm-header-logo">
        <img src="{{ resources_domain('images/icon_logo.png') }}" />
    </a>
    <div class="jm-header-btns">
        @yield('header')
        <a href="javascript:;" class="jm-btn-music" id="music"></a>
    </div>
    <audio src="{{ resources_domain('medias/guard.mp3') }}" loop/>
</header>