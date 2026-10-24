{{-- Login Success Popup --}}
<div id="loginSuccessPopup" class="success-popup" data-login-success="{{ session()->has('login_success') ? 'true' : 'false' }}">
    <div class="success-popup-content">

        {{-- Animasi SweetAlert2 Checkmark --}}
        <div class="swal2-icon swal2-success swal2-icon-show" style="display: flex;">
            <div class="swal2-success-circular-line-left"></div>
            <span class="swal2-success-line-tip"></span>
            <span class="swal2-success-line-long"></span>
            <div class="swal2-success-ring"></div>
            <div class="swal2-success-fix"></div>
            <div class="swal2-success-circular-line-right"></div>
        </div>

        {{-- Teks --}}
        <div class="success-title">LOGIN BERHASIL!</div>
        <div class="success-greeting">Selamat datang, <span class="success-name">{{ auth()->user()->name ?? '' }}</span></div>
        <div class="success-role">{{ auth()->user()->role === 'super_admin' ? '⚡ Super Admin' : '👤 Admin' }}</div>

        {{-- Progress bar --}}
        <div class="success-progress-bar">
            <div class="success-progress-fill"></div>
        </div>
        <div class="success-progress-text">Mengalihkan ke dashboard...</div>

    </div>
</div>