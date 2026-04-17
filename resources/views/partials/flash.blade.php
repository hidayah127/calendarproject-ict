@if(session('success') || session('error') || session('warning') || session('info'))
<div id="flashContainer" style="
    position: fixed;
    top: 80px;
    right: 24px;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    gap: 10px;
    min-width: 320px;
    max-width: 400px;
">

    @if(session('success'))
    <div class="flash-toast flash-success">
        <div class="flash-icon"><i class="fa fa-circle-check"></i></div>
        <div class="flash-body">
            <div class="flash-title">Success</div>
            <div class="flash-msg">{{ session('success') }}</div>
        </div>
        <button class="flash-close" onclick="closeToast(this)"><i class="fa fa-xmark"></i></button>
        <div class="flash-progress flash-progress-success"></div>
    </div>
    @endif

    @if(session('error'))
    <div class="flash-toast flash-error">
        <div class="flash-icon"><i class="fa fa-circle-xmark"></i></div>
        <div class="flash-body">
            <div class="flash-title">Error</div>
            <div class="flash-msg">{{ session('error') }}</div>
        </div>
        <button class="flash-close" onclick="closeToast(this)"><i class="fa fa-xmark"></i></button>
        <div class="flash-progress flash-progress-error"></div>
    </div>
    @endif

    @if(session('warning'))
    <div class="flash-toast flash-warning">
        <div class="flash-icon"><i class="fa fa-triangle-exclamation"></i></div>
        <div class="flash-body">
            <div class="flash-title">Warning</div>
            <div class="flash-msg">{{ session('warning') }}</div>
        </div>
        <button class="flash-close" onclick="closeToast(this)"><i class="fa fa-xmark"></i></button>
        <div class="flash-progress flash-progress-warning"></div>
    </div>
    @endif

    @if(session('info'))
    <div class="flash-toast flash-info">
        <div class="flash-icon"><i class="fa fa-circle-info"></i></div>
        <div class="flash-body">
            <div class="flash-title">Info</div>
            <div class="flash-msg">{{ session('info') }}</div>
        </div>
        <button class="flash-close" onclick="closeToast(this)"><i class="fa fa-xmark"></i></button>
        <div class="flash-progress flash-progress-info"></div>
    </div>
    @endif

</div>
@endif