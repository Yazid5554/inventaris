@extends('layouts.app')

@section('title', 'Pemindai Cerdas')

@section('content')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<style>
    #reader {
        border: none !important;
        border-radius: 1.5rem !important;
        overflow: hidden !important;
        background: transparent !important;
    }
    #reader video {
        width: 100% !important;
        height: 100% !important;
        min-height: 440px !important;
        max-height: 600px !important;
        object-fit: cover !important;
        border-radius: 1.5rem !important;
    }
    #reader__scan_region {
        background: transparent !important;
    }
    #reader__dashboard {
        display: none !important;
    }

    /* Hide Html5Qrcode default duplicate border & shaded overlay */
    #reader__scan_region > div,
    #reader__scan_region div[style*="border"] {
        border: none !important;
        box-shadow: none !important;
    }
    #reader__scan_region img,
    #reader__scan_region canvas,
    #qr-shaded-region {
        display: none !important;
        border: none !important;
    }

    /* Scanner Laser Beam Animation */
    @keyframes scanBeam {
        0% { top: 10%; opacity: 0.7; }
        50% { top: 85%; opacity: 1; }
        100% { top: 10%; opacity: 0.7; }
    }
    .scan-laser-line {
        animation: scanBeam 2.3s ease-in-out infinite;
    }
</style>

<div class="max-w-2xl mx-auto w-full pb-10">

    {{-- Main Scanner Container Card (Dark Theme) --}}
    <div class="relative bg-gradient-to-b from-[#1a2f6e] via-[#0f172a] to-[#0b132b] rounded-3xl overflow-hidden shadow-2xl border border-blue-900/40 animate-card min-h-[500px] sm:min-h-[580px] flex flex-col justify-between" style="animation-delay: 0ms;">

        {{-- Top Floating Overlay Bar --}}
        <div class="absolute top-0 inset-x-0 z-30 p-4 sm:p-5 flex items-center justify-between bg-gradient-to-b from-black/80 via-black/40 to-transparent">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="p-2 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-md transition border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-white tracking-wide drop-shadow">Pemindai Cerdas</h1>
                </div>
            </div>

            <div class="flex items-center gap-2">
                {{-- Small Upload Image Icon Button --}}
                <label for="qr-input-file" class="cursor-pointer p-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-md transition border border-white/10" title="Upload Foto QR dari Galeri">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </label>
                <input type="file" id="qr-input-file" accept="image/*" class="hidden" onchange="scanImageFile(this)">

                {{-- Flip Camera Button --}}
                <button onclick="toggleCameraFacing()" class="p-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white backdrop-blur-md transition border border-white/10" title="Ganti Kamera">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                </button>
            </div>
        </div>

        {{-- Camera Video Background Container --}}
        <div class="relative flex-1 w-full h-full min-h-[440px] sm:min-h-[520px] flex items-center justify-center">
            
            {{-- Html5Qrcode video element --}}
            <div id="reader" class="w-full h-full"></div>

            {{-- Center Viewfinder Frame Overlay --}}
            <div id="scanner-frame-overlay" class="absolute inset-0 pointer-events-none flex flex-col items-center justify-center z-20 p-6">
                
                {{-- Frame Box with Corner Brackets --}}
                <div class="relative w-64 h-64 sm:w-72 sm:h-72 flex items-center justify-center">
                    
                    {{-- Top-Left Bracket --}}
                    <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-white rounded-tl-xl shadow-sm"></div>
                    
                    {{-- Top-Right Bracket --}}
                    <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-white rounded-tr-xl shadow-sm"></div>
                    
                    {{-- Bottom-Left Bracket --}}
                    <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-white rounded-bl-xl shadow-sm"></div>
                    
                    {{-- Bottom-Right Bracket --}}
                    <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-white rounded-br-xl shadow-sm"></div>

                    {{-- Center Pulsing Dot --}}
                    <div class="w-2.5 h-2.5 bg-white rounded-full animate-ping shadow-[0_0_12px_#ffffff]"></div>
                    <div class="w-2.5 h-2.5 bg-white rounded-full absolute shadow-md"></div>

                    {{-- Laser Beam Line --}}
                    <div id="scan-laser-bar" class="absolute inset-x-3 h-0.5 bg-gradient-to-r from-transparent via-emerald-400 to-transparent scan-laser-line shadow-[0_0_15px_#10b981]"></div>
                </div>

                {{-- Subtitle Text Below Frame --}}
                <p class="text-white/90 text-xs sm:text-sm font-medium mt-6 text-center max-w-xs drop-shadow-md tracking-wide">
                    Sejajarkan kode QR dengan bingkai untuk memindai
                </p>
            </div>

            {{-- Status Notification Toast (On Detection) --}}
            <div id="status-toast" class="absolute top-20 inset-x-6 z-40 hidden">
                <div id="status-success" class="hidden bg-emerald-500/95 backdrop-blur-md text-white rounded-2xl p-3.5 text-xs font-bold text-center shadow-lg border border-emerald-400/50 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>QR Code Terdeteksi! Mengalihkan...</span>
                </div>
                <div id="status-error" class="hidden bg-red-500/95 backdrop-blur-md text-white rounded-2xl p-3.5 text-xs font-bold text-center shadow-lg border border-red-400/50 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>QR Code tidak valid atau dari luar sistem.</span>
                </div>
            </div>

            {{-- Scanner Placeholder / Permission Prompt Overlay --}}
            <div id="scanner-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-30 bg-[#0f172a]/95 backdrop-blur-md transition-all duration-300">
                <div id="placeholder-icon" class="w-16 h-16 bg-amber-500/20 text-amber-400 rounded-2xl flex items-center justify-center mx-auto mb-3 border border-amber-400/30">
                    <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                </div>
                <h3 id="placeholder-title" class="text-white font-extrabold text-base">Aktifkan Kamera Pemindai</h3>
                <div id="placeholder-msg" class="text-gray-300 text-xs mt-2 max-w-sm leading-relaxed px-2">
                    Klik tombol di bawah ini untuk mengizinkan browser mengakses kamera Anda.
                </div>
                <button id="btn-request-cam" onclick="requestCameraAccess()" class="mt-5 bg-gradient-to-r from-blue-600 to-[#2548cc] hover:from-blue-500 hover:to-blue-700 text-white px-7 py-3 rounded-full text-xs font-extrabold shadow-xl hover:scale-105 active:scale-95 transition-all flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                    <span>Izinkan & Buka Kamera</span>
                </button>
            </div>

        </div>

        {{-- Bottom Active Indicator Overlay --}}
        <div class="relative z-30 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 pb-5 flex items-center justify-center">
            <div id="cam-status-pill" class="flex items-center gap-2 text-emerald-400 font-bold text-xs sm:text-sm bg-black/40 px-4 py-1.5 rounded-full backdrop-blur-md border border-emerald-500/30">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_#10b981]"></span>
                <span id="cam-status-text">Siap Memindai</span>
            </div>
        </div>

    </div>

    {{-- Compact Manual Search Input --}}
    <div class="mt-4 bg-white rounded-2xl border border-gray-100 shadow-sm p-3.5 animate-card" style="animation-delay: 100ms;">
        <form action="{{ route('barang.index') }}" method="GET" class="flex items-center gap-2">
            <div class="flex-1 relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <input type="text" name="search" placeholder="Atau ketik kode barang / no inventaris..." required class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-9 pr-3 py-2 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/30 focus:border-[#2548cc] transition">
            </div>
            <button type="submit" class="bg-[#2548cc] text-white px-4 py-2 rounded-xl text-xs sm:text-sm font-bold shadow-sm hover:bg-blue-800 transition flex-shrink-0">
                Cari
            </button>
        </form>
    </div>

</div>

<script>
    let html5QrCode = null;
    let currentFacingMode = "environment";
    let isCameraActive = false;
    const baseUrl = "{{ url('/') }}";

    // Auto attempt on page load
    document.addEventListener('DOMContentLoaded', () => {
        if (navigator.permissions && navigator.permissions.query) {
            navigator.permissions.query({ name: 'camera' }).then(permissionStatus => {
                if (permissionStatus.state === 'granted') {
                    requestCameraAccess();
                } else {
                    showPromptOverlay();
                }
            }).catch(() => {
                requestCameraAccess();
            });
        } else {
            requestCameraAccess();
        }
    });

    function showPromptOverlay() {
        const placeholder = document.getElementById('scanner-placeholder');
        if (placeholder) {
            placeholder.classList.remove('hidden');
            document.getElementById('placeholder-title').textContent = 'Aktifkan Kamera Pemindai';
            document.getElementById('placeholder-msg').textContent = 'Klik tombol di bawah untuk mengizinkan browser mengakses kamera Anda.';
        }
    }

    function requestCameraAccess() {
        if (isCameraActive) return;

        document.getElementById('placeholder-title').textContent = 'Menghubungkan Kamera...';
        document.getElementById('placeholder-msg').textContent = 'Meminta akses video kamera dari perangkat Anda...';

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    stream.getTracks().forEach(track => track.stop());
                    startHtml5QrCodeEngine();
                })
                .catch(err => {
                    console.error("Camera getUserMedia error:", err);
                    showCameraDeniedState(err);
                });
        } else {
            startHtml5QrCodeEngine();
        }
    }

    function startHtml5QrCodeEngine() {
        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("reader");
        }

        const config = {
            fps: 25,
            qrbox: (viewfinderWidth, viewfinderHeight) => {
                const minDim = Math.min(viewfinderWidth, viewfinderHeight);
                return {
                    width: Math.floor(minDim * 0.72),
                    height: Math.floor(minDim * 0.72)
                };
            },
        };

        const onSuccess = (decodedText) => onScanSuccess(decodedText);

        html5QrCode.start({ facingMode: currentFacingMode }, config, onSuccess)
            .then(() => {
                onCameraSuccessfullyStarted();
            })
            .catch(err => {
                console.warn("FacingMode failed, trying camera devices list fallback...", err);

                Html5Qrcode.getCameras().then(devices => {
                    if (devices && devices.length > 0) {
                        const targetCamId = (devices.length > 1 && currentFacingMode === "environment")
                            ? devices[devices.length - 1].id
                            : devices[0].id;

                        html5QrCode.start(targetCamId, config, onSuccess)
                            .then(() => {
                                onCameraSuccessfullyStarted();
                            })
                            .catch(e => {
                                console.warn("Camera ID start failed, trying user camera...", e);
                                html5QrCode.start({ facingMode: "user" }, config, onSuccess)
                                    .then(() => {
                                        onCameraSuccessfullyStarted();
                                    })
                                    .catch(errFinal => showCameraDeniedState(errFinal));
                            });
                    } else {
                        showCameraDeniedState(err);
                    }
                }).catch(e => {
                    showCameraDeniedState(e);
                });
            });
    }

    function onCameraSuccessfullyStarted() {
        isCameraActive = true;
        const placeholder = document.getElementById('scanner-placeholder');
        if (placeholder) placeholder.classList.add('hidden');

        document.getElementById('cam-status-text').textContent = 'Kamera Aktif & Memindai';
    }

    function showCameraDeniedState(err) {
        isCameraActive = false;
        const placeholder = document.getElementById('scanner-placeholder');
        if (placeholder) {
            placeholder.classList.remove('hidden');
            document.getElementById('placeholder-title').textContent = '⚠️ Akses Kamera Diblokir Chrome';
            document.getElementById('placeholder-msg').innerHTML = `
                <div class="bg-amber-500/10 border border-amber-400/30 rounded-xl p-3 text-amber-200 text-left text-xs space-y-1.5 mt-2">
                    <p class="font-bold text-amber-300">Cara Mengaktifkan di Browser Chrome Laptop:</p>
                    <p>1. Lihat di <b>URL Address Bar</b> paling atas kiri (sebelah <code>127.0.0.1:8000</code>).</p>
                    <p>2. Klik <b>Icon Kamera Disilang / Setelan 🚫📷</b>.</p>
                    <p>3. Ubah Kamera dari <b>Block</b> menjadi <b>Allow (Izinkan)</b>.</p>
                    <p>4. Setelah itu tekan <b>F5 (Refresh)</b>.</p>
                </div>
            `;
        }
    }

    function stopScanner() {
        isCameraActive = false;
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                html5QrCode.clear();
                html5QrCode = null;
            }).catch(e => console.log(e));
        }

        showPromptOverlay();
    }

    function toggleCameraFacing() {
        currentFacingMode = currentFacingMode === "environment" ? "user" : "environment";
        if (isCameraActive) {
            stopScanner();
            setTimeout(() => {
                requestCameraAccess();
            }, 300);
        } else {
            requestCameraAccess();
        }
    }

    function scanImageFile(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        
        const html5QrCodeFile = new Html5Qrcode("reader");
        html5QrCodeFile.scanFile(file, true)
            .then(decodedText => {
                onScanSuccess(decodedText);
            })
            .catch(err => {
                console.error("Gagal memindai foto QR:", err);
                const toast = document.getElementById('status-toast');
                if (toast) {
                    toast.classList.remove('hidden');
                    document.getElementById('status-error').classList.remove('hidden');
                    setTimeout(() => toast.classList.add('hidden'), 3000);
                }
            });
    }

    function onScanSuccess(decodedText) {
        stopScanner();
        const toast = document.getElementById('status-toast');
        toast.classList.remove('hidden');

        if (decodedText.startsWith(baseUrl + '/barang/') || decodedText.includes('/barang/')) {
            document.getElementById('status-success').classList.remove('hidden');
            setTimeout(() => {
                window.location.href = decodedText;
            }, 700);
        } else {
            document.getElementById('status-error').classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
                requestCameraAccess();
            }, 3000);
        }
    }
</script>
@endsection