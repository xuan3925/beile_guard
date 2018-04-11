<div class="jm-post-body jm-post-notitle">
    <div class="jm-post-con jm-post-padding">
        <div class="jm-title">
            守护者勋章
        </div>
        <div class="jm-medals">
            @foreach ($user_achievements as $achievements)
            <div class="jm-medal" data-text="{{ $achievements->intro }}" data-status="{{ $achievements->status }}">
                <img src="{{ resources_domain('images/img_'.$achievements->images_prefix.($achievements->status ? '' : '_gray').'.png') }}" />
            </div>
            @endforeach
        </div>
    </div>
</div>