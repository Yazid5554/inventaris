<style>
    @keyframes slideInLeft {
        0% {
            opacity: 0;
            transform: translateX(-50px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-sidebar {
        animation: slideInLeft 1.2s cubic-bezier(0.16, 1, 0.3, 1) both;
    }

    html.no-boot-animation .animate-card,
    html.no-boot-animation .animate-sidebar {
        animation: none !important;
        opacity: 1 !important;
        transform: none !important;
        animation-delay: 0s !important;
    }

    @keyframes circleGrow {
        0% {
            r: 0;
            opacity: 0;
            filter: drop-shadow(0 0 0 rgba(0, 245, 255, 0));
        }

        50% {
            filter: drop-shadow(0 0 30px rgba(0, 245, 255, 0.8));
        }

        100% {
            r: 35;
            opacity: 1;
            filter: drop-shadow(0 0 20px rgba(0, 245, 255, 0.4));
        }
    }

    @keyframes checkmarkDraw {
        to {
            stroke-dashoffset: 0;
        }
    }

    @keyframes popIn {
        0% {
            opacity: 0;
            transform: scale(0.3) translateY(30px);
        }

        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .animate-pop {
        animation: popIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    /* Login Success Popup */
    .success-popup {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
        z-index: 99999;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        pointer-events: none;
    }

    .success-popup.show {
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: all;
    }

    .success-popup-content {
        background: linear-gradient(145deg, #3a3d48, #2f323a);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05);
        border: 2px solid rgba(0, 245, 255, 0.2);
        animation: popIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .checkmark-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #00f5ff, #00d4e6);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 0 30px rgba(0, 245, 255, 0.5);
        animation: circlePop 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    @keyframes circlePop {
        0% {
            transform: scale(0);
            box-shadow: 0 0 0 rgba(0, 245, 255, 0.5);
        }

        50% {
            transform: scale(1.1);
            box-shadow: 0 0 50px rgba(0, 245, 255, 0.8);
        }

        100% {
            transform: scale(1);
            box-shadow: 0 0 30px rgba(0, 245, 255, 0.5);
        }
    }

    .checkmark {
        width: 40px;
        height: 40px;
        border: 3px solid white;
        border-radius: 50%;
        position: relative;
    }

    .checkmark::after {
        content: '';
        position: absolute;
        width: 8px;
        height: 16px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
        left: 12px;
        top: 5px;
        animation: checkDraw 0.6s ease-in-out 0.3s forwards;
        opacity: 0;
    }

    @keyframes checkDraw {
        to {
            opacity: 1;
        }
    }

    .success-text {
        color: #00f5ff;
        font-size: 24px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        text-shadow: 0 0 10px rgba(0, 245, 255, 0.5);
        margin-bottom: 10px;
    }

    .success-subtext {
        color: #a7c8ff;
        font-size: 14px;
        letter-spacing: 1px;
    }
    
</style>