<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Sistem Gudang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: #2a2d35;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* Animated Particles Background */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(0, 245, 255, 0.6);
            border-radius: 50%;
            animation: float-particle 15s infinite;
            box-shadow: 0 0 10px rgba(0, 245, 255, 0.8);
        }

        @keyframes float-particle {
            0% {
                transform: translateY(100vh) translateX(0) scale(0);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) translateX(100px) scale(1);
                opacity: 0;
            }
        }

        .particle:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            left: 20%;
            animation-delay: 2s;
            background: rgba(255, 0, 110, 0.6);
            box-shadow: 0 0 10px rgba(255, 0, 110, 0.8);
        }

        .particle:nth-child(3) {
            left: 30%;
            animation-delay: 4s;
        }

        .particle:nth-child(4) {
            left: 40%;
            animation-delay: 6s;
            background: rgba(255, 0, 110, 0.6);
            box-shadow: 0 0 10px rgba(255, 0, 110, 0.8);
        }

        .particle:nth-child(5) {
            left: 50%;
            animation-delay: 8s;
        }

        .particle:nth-child(6) {
            left: 60%;
            animation-delay: 10s;
            background: rgba(255, 0, 110, 0.6);
            box-shadow: 0 0 10px rgba(255, 0, 110, 0.8);
        }

        .particle:nth-child(7) {
            left: 70%;
            animation-delay: 12s;
        }

        .particle:nth-child(8) {
            left: 80%;
            animation-delay: 14s;
            background: rgba(255, 0, 110, 0.6);
            box-shadow: 0 0 10px rgba(255, 0, 110, 0.8);
        }

        .particle:nth-child(9) {
            left: 90%;
            animation-delay: 1s;
        }

        .particle:nth-child(10) {
            left: 15%;
            animation-delay: 3s;
            background: rgba(255, 0, 110, 0.6);
            box-shadow: 0 0 10px rgba(255, 0, 110, 0.8);
        }

        /* Glitch Transition Effect */
        .glitch-transition {
            position: fixed;
            inset: 0;
            background: #000;
            z-index: 999999;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            opacity: 0;
            pointer-events: none;
        }

        .glitch-transition.active {
            opacity: 1;
            pointer-events: all;
            animation: glitchIn 1s ease-in-out forwards;
        }

        .glitch-layer {
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(0deg, #ff006e 0%, #00f5ff 5%, #000 10%);
            opacity: 0.05;
            mix-blend-mode: screen;
            animation: glitchShift 0.3s infinite;
        }

        .glitch-layer:nth-child(2) {
            background: linear-gradient(90deg, #ff006e 0%, transparent 100%);
            opacity: 0.2;
            animation-delay: 0.1s;
        }

        .glitch-layer:nth-child(3) {
            background: linear-gradient(270deg, #00f5ff 0%, transparent 100%);
            opacity: 0.2;
            animation-delay: 0.2s;
        }

        .glitch-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 48px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 5px;
            text-shadow: 2px 2px #ff006e, -2px -2px #00f5ff;
            animation: glitchText 0.3s infinite;
        }

        @keyframes glitchShift {
            0% {
                transform: translate(0, 0);
            }

            20% {
                transform: translate(-3px, 2px);
            }

            40% {
                transform: translate(3px, -2px);
            }

            60% {
                transform: translate(-2px, -3px);
            }

            80% {
                transform: translate(2px, 3px);
            }

            100% {
                transform: translate(0, 0);
            }
        }

        @keyframes glitchText {
            0% {
                text-shadow: 2px 2px #ff006e, -2px -2px #00f5ff;
            }

            50% {
                text-shadow: -2px -2px #ff006e, 2px 2px #00f5ff;
            }

            100% {
                text-shadow: 2px 2px #ff006e, -2px -2px #00f5ff;
            }
        }

        @keyframes glitchIn {
            0% {
                opacity: 0;
                transform: scale(1.2);
            }

            30% {
                opacity: 1;
                transform: scale(1);
            }

            100% {
                opacity: 0;
                transform: scale(1);
            }
        }

        /* Alert Styles */
        .alert {
            position: fixed;
            top: 30px;
            right: 30px;
            padding: 18px 25px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            z-index: 9999;
            animation: slideIn 0.4s ease-out;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            max-width: 400px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert i {
            font-size: 20px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-error {
            background: linear-gradient(145deg, #ff006e, #d10056);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .alert-success {
            background: linear-gradient(145deg, #00f5ff, #00d4e6);
            color: #1a1d25;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .login-container {
            position: relative;
            width: 320px;
            height: 140px;
            transition: all 0.7s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            cursor: pointer;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .login-card {
            position: relative;
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, #3a3d48, #2f323a);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05);
            transition: all 0.7s cubic-bezier(0.68, -0.55, 0.265, 1.55), transform 0.1s ease-out;
            overflow: hidden;
            transform-style: preserve-3d;
        }

        .neon-wrapper {
            position: absolute;
            inset: -2px;
            border-radius: 22px;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
            padding: 20px;
        }

        .neon-wrapper::before {
            content: '';
            position: absolute;
            width: 400%;
            height: 400%;
            background: conic-gradient(from 0deg at 50% 50%,
                    transparent 0deg, #ff006e 10deg, #ff006e 25deg, transparent 35deg,
                    transparent 90deg, #00f5ff 100deg, #00f5ff 115deg, transparent 125deg,
                    transparent 180deg, #00f5ff 190deg, #00f5ff 205deg, transparent 215deg,
                    transparent 270deg, #ff006e 280deg, #ff006e 295deg, transparent 305deg,
                    transparent 360deg);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: rotate-border 8s linear infinite;
            filter: drop-shadow(0 0 15px rgba(255, 0, 110, 0.8)) drop-shadow(0 0 15px rgba(0, 245, 255, 0.8));
        }

        .neon-wrapper::after {
            content: '';
            position: absolute;
            inset: 5.5px;
            background: linear-gradient(145deg, #3a3d48, #2f323a);
            border-radius: 20px;
            z-index: 1;
        }

        @keyframes rotate-border {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .inner-card {
            width: 100%;
            height: 100%;
            background: #3a3d48;
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.5);
            transition: all 0.5s ease;
            position: relative;
            z-index: 1;
        }

        .login-container.open .inner-card,
        .login-container:focus-within .inner-card {
            opacity: 0;
            visibility: hidden;
        }

        .login-title {
            color: #fff;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 8px;
            text-transform: uppercase;
            transition: all 0.5s ease;
            position: relative;
            display: flex;
            align-items: center;
            gap: 15px;
            text-shadow:
                0 0 10px #00f5ff, 0 0 20px #00f5ff, 0 0 30px #00f5ff, 0 0 40px #00f5ff,
                0 0 70px #00f5ff, 0 0 80px #00f5ff, 0 0 100px #00f5ff,
                1px 1px 0 #0aa, 2px 2px 0 #0aa, 3px 3px 0 #088,
                4px 4px 0 #066, 5px 5px 0 #044, 6px 6px 0 #022,
                7px 7px 5px rgba(0, 0, 0, 0.8);
            animation: neonPulse 2s ease-in-out infinite alternate;
        }

        @keyframes neonPulse {
            from {
                text-shadow:
                    0 0 10px #00f5ff, 0 0 20px #00f5ff, 0 0 30px #00f5ff, 0 0 40px #00f5ff,
                    0 0 70px #00f5ff, 0 0 80px #00f5ff, 0 0 100px #00f5ff,
                    1px 1px 0 #0aa, 2px 2px 0 #0aa, 3px 3px 0 #088,
                    4px 4px 0 #066, 5px 5px 0 #044, 6px 6px 0 #022,
                    7px 7px 5px rgba(0, 0, 0, 0.8);
            }

            to {
                text-shadow:
                    0 0 5px #ff006e, 0 0 10px #ff006e, 0 0 15px #ff006e, 0 0 20px #ff006e,
                    0 0 35px #ff006e, 0 0 40px #ff006e, 0 0 50px #ff006e,
                    1px 1px 0 #a00, 2px 2px 0 #a00, 3px 3px 0 #800,
                    4px 4px 0 #600, 5px 5px 0 #400, 6px 6px 0 #200,
                    7px 7px 5px rgba(0, 0, 0, 0.8);
            }
        }

        .login-title i {
            font-size: 32px;
            color: rgba(255, 255, 255, 0.9);
            filter: drop-shadow(0 0 5px rgba(0, 245, 255, 0.3));
        }

        .click-hint {
            position: absolute;
            top: 5px;
            left: 26%;
            transform: translateX(-50%);
            color: #00f5ff;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            opacity: 0.9;
            padding: 8px 16px;
            border-radius: 999px;
            white-space: nowrap;
            animation: pulse-hint 2s ease-in-out infinite;
            z-index: 3;
        }

        .login-container.open .click-hint,
        .login-container:focus-within .click-hint {
            opacity: 0;
            visibility: hidden;
            transform: translate(-50%, -8px);
        }

        @keyframes pulse-hint {

            0%,
            100% {
                opacity: 0.5;
                transform: scale(1);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }
        }

        .login-form {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease, visibility 0.5s ease;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: absolute;
            z-index: 2;
        }

        .login-container.open .login-title,
        .login-container:focus-within .login-title {
            opacity: 0;
            visibility: hidden;
        }

        .form-title {
            color: #fff;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 8px;
            text-transform: uppercase;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-shadow:
                0 0 10px #00f5ff, 0 0 20px #00f5ff, 0 0 30px #00f5ff,
                1px 1px 0 #0aa, 2px 2px 0 #0aa, 3px 3px 0 #088,
                4px 4px 0 #066, 5px 5px 5px rgba(0, 0, 0, 0.8);
            animation: titleFloat 3s ease-in-out infinite;
        }

        @keyframes titleFloat {

            0%,
            100% {
                transform: translateY(0px);
                text-shadow:
                    0 0 10px #00f5ff, 0 0 20px #00f5ff, 0 0 30px #00f5ff,
                    1px 1px 0 #0aa, 2px 2px 0 #0aa, 3px 3px 0 #088,
                    4px 4px 0 #066, 5px 5px 5px rgba(0, 0, 0, 0.8);
            }

            50% {
                transform: translateY(-5px);
                text-shadow:
                    0 0 15px #00f5ff, 0 0 25px #00f5ff, 0 0 35px #00f5ff,
                    1px 1px 0 #0aa, 2px 2px 0 #0aa, 3px 3px 0 #088,
                    4px 4px 0 #066, 5px 5px 0 #044, 6px 6px 0 #022,
                    7px 10px 10px rgba(0, 0, 0, 0.9);
            }
        }

        .form-title i {
            font-size: 30px;
            color: #00f5ff;
            text-shadow: 0 0 10px #00f5ff, 0 0 20px #00f5ff, 0 0 30px #00f5ff;
        }

        .form-container {
            background: linear-gradient(145deg, #3a3d48, #2f323a);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5), inset 0 2px 5px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 18px;
            width: 360px;
        }

        .login-container.open,
        .login-container:focus-within {
            width: 420px;
            height: 500px;
        }

        .login-container.open .login-card,
        .login-container:focus-within .login-card {
            border-radius: 25px;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.1) 50%, rgba(255, 255, 255, 0) 100%);
            transform: translateX(-100%);
            transition: transform 0.6s;
            pointer-events: none;
            z-index: 10;
        }

        .login-container.open .login-card::before,
        .login-container:focus-within .login-card::before {
            transform: translateX(100%);
        }

        .login-container.open .neon-wrapper,
        .login-container:focus-within .neon-wrapper {
            border-radius: 27px;
        }

        .login-container.open .neon-wrapper::after,
        .login-container:focus-within .neon-wrapper::after {
            border-radius: 25px;
        }

        .login-container.open .neon-wrapper::before,
        .login-container:focus-within .neon-wrapper::before {
            filter: drop-shadow(0 0 25px rgba(255, 0, 110, 1)) drop-shadow(0 0 25px rgba(0, 245, 255, 1));
        }

        .login-container.open .login-form,
        .login-container:focus-within .login-form {
            opacity: 1;
            visibility: visible;
            transition-delay: 0.4s;
        }

        .form-group {
            width: 100%;
            margin-top: 0;
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b6e7a;
            font-size: 16px;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .toggle-password {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b6e7a;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #00f5ff;
            text-shadow: 0 0 10px rgba(0, 245, 255, 0.6);
            transform: translateY(-50%) scale(1.1);
        }

        .form-input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            background: #2f323a;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 50px;
            color: #e3e8f4;
            font-size: 14px;
            font-family: "Poppins", sans-serif;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.4);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.45);
            font-weight: 500;
        }

        .form-input:focus {
            border-color: rgba(0, 245, 255, 0.6);
            background: #373d48;
            box-shadow: inset 0 1px 4px rgba(255, 255, 255, 0.04), 0 0 14px rgba(0, 245, 255, 0.4), 0 0 28px rgba(0, 245, 255, 0.2);
        }

        .form-input:focus+.input-icon,
        .form-input:focus~.toggle-password {
            color: #00f5ff;
            text-shadow: 0 0 12px rgba(0, 245, 255, 0.9);
        }

        .signin-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #00f5ff 0%, #00d4e6 100%);
            border: none;
            border-radius: 50px;
            color: #1a1d25;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
            box-shadow: 0 8px 25px rgba(0, 245, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .signin-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .signin-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .signin-btn span,
        .signin-btn i {
            position: relative;
            z-index: 1;
        }

        .signin-btn i {
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .signin-btn:hover i {
            transform: translateX(5px);
        }

        .signin-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(0, 245, 255, 0.6);
            background: #00d4e6;
        }

        .signin-btn:active {
            transform: translateY(0);
        }

        .system-info {
            margin-top: 8px;
            color: #7a7d88;
            font-size: 12px;
            text-align: center;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .system-info i {
            font-size: 14px;
            color: #00f5ff;
        }

        .signin-btn.loading {
            pointer-events: none;
            background: #6b6e7a;
        }

        .signin-btn.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            z-index: 2;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .signin-btn.loading span,
        .signin-btn.loading i {
            opacity: 0;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .login-container.shake {
            animation: shake 0.5s;
        }

        /* Success Popup */
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
        }

        .success-popup.show {
            opacity: 1;
            visibility: visible;
        }

        .success-popup-content {
            background: linear-gradient(145deg, #3a3d48, #2f323a);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(0, 245, 255, 0.2);
            animation: popupSlide 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes popupSlide {
            0% {
                opacity: 0;
                transform: scale(0.5) translateY(30px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
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

        @media (max-width: 480px) {
            .login-container {
                width: 280px;
            }

            .login-container.open,
            .login-container:focus-within {
                width: 340px;
                height: 480px;
            }

            .form-container {
                width: 320px;
                padding: 30px 25px;
            }

            .alert {
                top: 20px;
                right: 20px;
                left: 20px;
                max-width: none;
            }

            .glitch-text {
                font-size: 32px;
            }
        }
    </style>
</head>

<body>

    <!-- Animated Particles Background -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Glitch Transition -->
    <div class="glitch-transition" id="glitchTransition">
        <div class="glitch-layer"></div>
        <div class="glitch-layer"></div>
        <div class="glitch-layer"></div>
        <div class="glitch-text">LOADING</div>
    </div>

    @if (session('error'))
    <div class="alert alert-error" id="alert">
        <i class="fas fa-exclamation-triangle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-error" id="alert">
        <i class="fas fa-exclamation-triangle"></i>
        <span>{{ $errors->first() }}</span>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success" id="alert">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="login-container" tabindex="0">
        <div class="login-card">
            <div class="neon-wrapper"></div>
            <div class="inner-card">
                <h1 class="login-title">
                    <i class="fas fa-warehouse"></i>
                    LOGIN
                </h1>
            </div>
            <div class="click-hint">↓ CLICK TO LOGIN ↓</div>
            <form class="login-form" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-container">
                    <h1 class="form-title">
                        <i class="fas fa-shield-halved"></i>
                        LOGIN
                    </h1>
                    <div class="form-group">
                        <input type="email" name="email" class="form-input" placeholder="Email"
                            required autocomplete="username" value="{{ old('email') }}" />
                        <i class="input-icon fas fa-envelope"></i>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="passwordInput" class="form-input"
                            placeholder="Password" required autocomplete="current-password" />
                        <i class="input-icon fas fa-lock"></i>
                        <i class="toggle-password fas fa-eye" onclick="togglePassword()"></i>
                    </div>
                    <button type="submit" class="signin-btn" id="submitBtn">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        <span>Sign in</span>
                    </button>
                    <div class="system-info">
                        <i class="fas fa-database"></i>
                        Sistem Manajemen Gudang
                    </div>
                    <div style="text-align: center; margin-top: 15px; color: #7a7d88; font-size: 13px;">
                        Belum punya akun? <span style="color: #00f5ff; font-weight: 600;">Hubungi administrator</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // 3D Tilt Effect on Mouse Move
        const loginContainer = document.querySelector('.login-container');
        const loginCard = document.querySelector('.login-card');

        loginContainer.addEventListener('mousemove', function(e) {
            const rect = loginContainer.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;

            loginCard.style.transform = `
                perspective(1000px)
                rotateX(${rotateX}deg)
                rotateY(${rotateY}deg)
                scale3d(1.02, 1.02, 1.02)
            `;

            const shadowX = (centerX - x) / 5;
            const shadowY = (y - centerY) / 5;
            loginCard.style.boxShadow = `
                ${shadowX}px ${shadowY}px 40px rgba(0, 245, 255, 0.3),
                ${-shadowX}px ${-shadowY}px 40px rgba(255, 0, 110, 0.3),
                0 20px 60px rgba(0, 0, 0, 0.6)
            `;
        });

        loginContainer.addEventListener('mouseleave', function() {
            loginCard.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
            loginCard.style.boxShadow = '0 20px 60px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.05)';
        });

        loginContainer.addEventListener('click', function() {
            this.classList.toggle('open');
        });

        loginContainer.addEventListener('focusin', function() {
            this.classList.add('open');
        });

        // Tutup form saat tekan ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                loginContainer.classList.remove('open');
            }
        });

        // Tutup form saat klik di luar card
        document.addEventListener('click', function(e) {
            if (!loginContainer.contains(e.target) && loginContainer.classList.contains('open')) {
                loginContainer.classList.remove('open');
            }
        });

        // Toggle Show/Hide Password
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const toggleIcon = document.querySelector('.toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Glitch Transition Function
        function glitchTransition(url) {
            const glitch = document.getElementById('glitchTransition');
            glitch.classList.add('active');
            setTimeout(() => {
                window.location.href = url;
            }, 1000);
        }

        // Register Link with Glitch Effect
        const registerLink = document.getElementById('registerLink');
        if (registerLink) {
            registerLink.addEventListener('click', function(e) {
                e.preventDefault();
                glitchTransition(this.getAttribute('href'));
            });
        }

        // Loading Animation on Submit
        document.querySelector('.login-form').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
        });

        // Input Focus Glow Effect
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Auto hide alert after 5 seconds
        const alert = document.getElementById('alert');
        if (alert) {
            setTimeout(() => {
                alert.style.animation = 'slideIn 0.4s ease-out reverse';
                setTimeout(() => {
                    alert.remove();
                }, 400);
            }, 5000);
        }

        // Fade out glitch transition on page load
        window.addEventListener('load', () => {
            const glitch = document.getElementById('glitchTransition');
            glitch.style.transition = 'opacity 0.6s ease-out';
            glitch.style.opacity = '0';
        });
    </script>
</body>

</html>