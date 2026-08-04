{{-- Login Success Popup --}}
<div id="loginSuccessPopup" class="success-popup">
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

<style>
    .success-popup {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(8px);
        z-index: 99999;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease, visibility 0.4s ease;
        pointer-events: none;
    }

    .success-popup.show {
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: all;
    }

    .success-popup-content {
        background: linear-gradient(145deg, #1e2235, #252a3d);
        border-radius: 28px;
        padding: 50px 60px;
        text-align: center;
        box-shadow:
            0 30px 80px rgba(0, 0, 0, 0.8),
            0 0 35px rgba(0, 245, 255, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.05);
        border: 1.5px solid rgba(0, 245, 255, 0.25);
        width: 380px;
        position: relative;
        overflow: hidden;
        animation: popupEntrance 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    .success-popup-content::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(from 0deg, transparent 0deg, rgba(0, 245, 255, 0.04) 60deg, transparent 120deg);
        animation: rotateBg 8s linear infinite;
    }

    @keyframes rotateBg {
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes popupEntrance {
        0% {
            opacity: 0;
            transform: scale(0.5) translateY(40px);
        }

        60% {
            transform: scale(1.05) translateY(-5px);
        }

        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* SweetAlert2 Success Icon Animation - Vibrant Green Checkmark */
    .swal2-icon.swal2-success {
        border-color: #22c55e;
        color: #22c55e;
        width: 80px;
        height: 80px;
        border: 4px solid rgba(34, 197, 94, 0.25);
        border-radius: 50%;
        font-family: inherit;
        margin: 0 auto 24px;
        padding: 0;
        position: relative;
        box-sizing: content-box;
        cursor: default;
        user-select: none;
    }

    .swal2-icon.swal2-success .swal2-success-ring {
        position: absolute;
        top: -4px;
        left: -4px;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 4px solid rgba(34, 197, 94, 0.4);
        box-sizing: content-box;
        z-index: 2;
        box-shadow: 0 0 15px rgba(34, 197, 94, 0.4);
    }

    .swal2-icon.swal2-success [class^='swal2-success-line'] {
        display: block;
        position: absolute;
        z-index: 2;
        height: 5px;
        background-color: #22c55e;
        border-radius: 2px;
        box-shadow: 0 0 14px rgba(34, 197, 94, 0.9);
    }

    .swal2-icon.swal2-success .swal2-success-line-tip {
        top: 46px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
        animation: swal2-animate-success-line-tip 0.45s;
    }

    .swal2-icon.swal2-success .swal2-success-line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
        animation: swal2-animate-success-line-long 0.45s;
    }

    @keyframes swal2-animate-success-line-tip {
        0% {
            top: 19px;
            left: 1px;
            width: 0;
        }
        54% {
            top: 19px;
            left: 1px;
            width: 0;
        }
        70% {
            top: 37px;
            left: -8px;
            width: 50px;
        }
        84% {
            top: 48px;
            left: 21px;
            width: 17px;
        }
        100% {
            top: 46px;
            left: 14px;
            width: 25px;
        }
    }

    @keyframes swal2-animate-success-line-long {
        0% {
            top: 54px;
            right: 46px;
            width: 0;
        }
        65% {
            top: 54px;
            right: 46px;
            width: 0;
        }
        84% {
            top: 35px;
            right: 0;
            width: 55px;
        }
        100% {
            top: 38px;
            right: 8px;
            width: 47px;
        }
    }

    /* Pulse rings */
    .pulse-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        border: 2px solid rgba(34, 197, 94, 0.4);
        animation: pulseRing 1.5s ease-out infinite;
    }

    .pulse-ring-1 {
        width: 130px;
        height: 130px;
        animation-delay: 0.5s;
    }

    .pulse-ring-2 {
        width: 130px;
        height: 130px;
        animation-delay: 0.8s;
    }

    .pulse-ring-3 {
        width: 130px;
        height: 130px;
        animation-delay: 1.1s;
    }

    @keyframes pulseRing {
        0% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.6;
        }

        100% {
            transform: translate(-50%, -50%) scale(1.8);
            opacity: 0;
        }
    }

    /* Teks - Green Vibrant Theme */
    .success-title {
        font-size: 24px;
        font-weight: 800;
        color: #22c55e;
        letter-spacing: 2px;
        text-transform: uppercase;
        text-shadow: 0 0 20px rgba(34, 197, 94, 0.6), 0 0 40px rgba(34, 197, 94, 0.3);
        margin-bottom: 8px;
        animation: fadeSlideUp 0.3s ease 0.2s both;
    }

    .success-greeting {
        color: #94a3b8;
        font-size: 15px;
        margin-bottom: 6px;
        animation: fadeSlideUp 0.3s ease 0.3s both;
    }

    .success-name {
        color: #e2e8f0;
        font-weight: 700;
    }

    .success-role {
        color: #22c55e;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 1px;
        margin-bottom: 24px;
        animation: fadeSlideUp 0.3s ease 0.35s both;
    }

    /* Progress bar - Green Vibrant Gradient */
    .success-progress-bar {
        width: 100%;
        height: 3px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 99px;
        overflow: hidden;
        margin-bottom: 8px;
        animation: fadeSlideUp 0.3s ease 0.4s both;
    }

    .success-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #22c55e, #10b981);
        border-radius: 99px;
        width: 0%;
        animation: fillProgress 1.2s cubic-bezier(0.4, 0, 0.2, 1) 0.4s forwards;
        box-shadow: 0 0 12px rgba(34, 197, 94, 0.8);
    }

    @keyframes fillProgress {
        to {
            width: 100%;
        }
    }

    .success-progress-text {
        color: rgba(148, 163, 184, 0.6);
        font-size: 11px;
        letter-spacing: 1px;
        animation: fadeSlideUp 0.3s ease 0.45s both;
    }

    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popup = document.getElementById('loginSuccessPopup');
        if (!popup) return;

        const justLoggedIn = @json(session()-> has('login_success'));

        if (justLoggedIn) {
            // Pause semua animasi dashboard + sidebar
            document.querySelectorAll('.animate-card, .animate-sidebar').forEach(el => {
                el.style.animationPlayState = 'paused';
                el.style.opacity = '0';
            });

            setTimeout(() => {
                popup.classList.add('show');

                // Setelah popup selesai, resume semua animasi
                setTimeout(() => {
                    popup.style.transition = 'opacity 0.4s ease, visibility 0.4s ease';
                    popup.classList.remove('show');

                    setTimeout(() => {
                        document.querySelectorAll('.animate-card, .animate-sidebar').forEach(el => {
                            el.style.opacity = '';
                            el.style.animationPlayState = 'running';
                        });
                        sessionStorage.setItem('app_navigated', 'true');
                    }, 400);
                }, 1700);
            }, 150);
        }
    });
</script>