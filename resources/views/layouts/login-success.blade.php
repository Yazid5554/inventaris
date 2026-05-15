{{-- Login Success Popup --}}
<div id="loginSuccessPopup" class="success-popup">
    <div class="success-popup-content">

        {{-- Animasi Lingkaran + Ceklis SVG --}}
        <div class="success-icon-wrapper">
            <svg class="success-svg" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="circleGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#00f5ff;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#00d4e6;stop-opacity:1" />
                    </linearGradient>
                    <filter id="glow">
                        <feGaussianBlur stdDeviation="3" result="coloredBlur" />
                        <feMerge>
                            <feMergeNode in="coloredBlur" />
                            <feMergeNode in="SourceGraphic" />
                        </feMerge>
                    </filter>
                </defs>

                {{-- Lingkaran luar --}}
                <circle class="circle-outer" cx="60" cy="60" r="54"
                    stroke="url(#circleGrad)" stroke-width="3" fill="none"
                    filter="url(#glow)"
                    stroke-dasharray="339" stroke-dashoffset="339" />

                {{-- Lingkaran dalam --}}
                <circle class="circle-inner" cx="60" cy="60" r="44"
                    stroke="rgba(0,245,255,0.2)" stroke-width="1" fill="rgba(0,245,255,0.05)" />

                {{-- Ceklis --}}
                <polyline class="checkmark-path" points="38,60 52,74 82,44"
                    stroke="url(#circleGrad)" stroke-width="5" fill="none"
                    stroke-linecap="round" stroke-linejoin="round"
                    filter="url(#glow)"
                    stroke-dasharray="60" stroke-dashoffset="60" />
            </svg>

            {{-- Pulse rings --}}
            <div class="pulse-ring pulse-ring-1"></div>
            <div class="pulse-ring pulse-ring-2"></div>
            <div class="pulse-ring pulse-ring-3"></div>
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
            0 0 0 1px rgba(0, 245, 255, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(0, 245, 255, 0.2);
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
        background: conic-gradient(from 0deg, transparent 0deg, rgba(0, 245, 255, 0.03) 60deg, transparent 120deg);
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

    /* Icon wrapper */
    .success-icon-wrapper {
        position: relative;
        width: 130px;
        height: 130px;
        margin: 0 auto 28px;
    }

    .success-svg {
        width: 130px;
        height: 130px;
        position: relative;
        z-index: 2;
    }

    /* Lingkaran animasi */
    .circle-outer {
        animation: drawCircle 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s forwards;
    }

    @keyframes drawCircle {
        to {
            stroke-dashoffset: 0;
        }
    }

    /* Ceklis animasi */
    .checkmark-path {
        animation: drawCheck 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.8s forwards;
    }

    @keyframes drawCheck {
        to {
            stroke-dashoffset: 0;
        }
    }

    /* Pulse rings */
    .pulse-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        border: 2px solid rgba(0, 245, 255, 0.4);
        animation: pulseRing 2s ease-out infinite;
    }

    .pulse-ring-1 {
        width: 130px;
        height: 130px;
        animation-delay: 1s;
    }

    .pulse-ring-2 {
        width: 130px;
        height: 130px;
        animation-delay: 1.4s;
    }

    .pulse-ring-3 {
        width: 130px;
        height: 130px;
        animation-delay: 1.8s;
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

    /* Teks */
    .success-title {
        font-size: 26px;
        font-weight: 800;
        color: #00f5ff;
        letter-spacing: 3px;
        text-transform: uppercase;
        text-shadow: 0 0 20px rgba(0, 245, 255, 0.6), 0 0 40px rgba(0, 245, 255, 0.3);
        margin-bottom: 10px;
        animation: fadeSlideUp 0.5s ease 1.2s both;
    }

    .success-greeting {
        color: #94a3b8;
        font-size: 15px;
        margin-bottom: 6px;
        animation: fadeSlideUp 0.5s ease 1.4s both;
    }

    .success-name {
        color: #e2e8f0;
        font-weight: 700;
    }

    .success-role {
        color: rgba(0, 245, 255, 0.7);
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 1px;
        margin-bottom: 24px;
        animation: fadeSlideUp 0.5s ease 1.5s both;
    }

    /* Progress bar */
    .success-progress-bar {
        width: 100%;
        height: 3px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 99px;
        overflow: hidden;
        margin-bottom: 8px;
        animation: fadeSlideUp 0.5s ease 1.6s both;
    }

    .success-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #00f5ff, #00d4e6);
        border-radius: 99px;
        width: 0%;
        animation: fillProgress 2.2s ease 1.6s forwards;
        box-shadow: 0 0 10px rgba(0, 245, 255, 0.6);
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
        animation: fadeSlideUp 0.5s ease 1.7s both;
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
                    popup.style.transition = 'opacity 0.5s ease, visibility 0.5s ease';
                    popup.classList.remove('show');

                    setTimeout(() => {
                        document.querySelectorAll('.animate-card, .animate-sidebar').forEach(el => {
                            el.style.opacity = '';
                            el.style.animationPlayState = 'running';
                        });
                    }, 500);
                }, 3500);
            }, 300);
        }
    });
</script>