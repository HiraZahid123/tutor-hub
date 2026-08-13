@extends('layouts.dashboard')

@section('title', 'Secure Checkout - TutorHub')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Secure Checkout</h1>
        <p class="text-slate-500 font-medium italic">Settle your session payment using one of our verified Pakistani payment methods.</p>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl text-rose-700 text-sm font-semibold flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-rose-500"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Session Info & Instructions (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Session Summary Card -->
            <div class="bg-slate-900 p-8 rounded-[2rem] text-white shadow-xl shadow-slate-950/5 relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-6 border-b border-white/10 pb-3">Session Summary</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-xs font-bold text-slate-400">Tutor</span>
                            <span class="text-sm font-black text-white">{{ $booking->tutor->name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-xs font-bold text-slate-400">Date</span>
                            <span class="text-sm font-black text-white">{{ $booking->start_time->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-xs font-bold text-slate-400">Time</span>
                            <span class="text-sm font-black text-white">{{ $booking->start_time->format('h:i A') }} - {{ $booking->end_time->format('h:i A') }}</span>
                        </div>
                        @if($booking->is_trial)
                            <div class="flex justify-between items-center py-2">
                                <span class="text-xs font-bold text-slate-400">Type</span>
                                <span class="text-xs font-bold text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full uppercase tracking-wider">Free Trial</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center pt-6 border-t border-white/10">
                            <span class="text-base font-black text-white">Total Fee</span>
                            <span class="text-xl font-black text-blue-400">{{ $booking->display_currency }} {{ number_format($booking->price_at_booking, 2) }}</span>
                        </div>
                    </div>
                </div>
                <!-- Background decoration -->
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
            </div>

            <!-- Support / Instruction Alert -->
            <div class="bg-blue-50 border border-blue-100 p-6 rounded-3xl space-y-4">
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle text-xs"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-blue-900 uppercase tracking-widest mb-1">First Preference</h4>
                        <p class="text-[11px] font-bold text-blue-700 leading-relaxed">If multiple payment options are available, we kindly request that you select <strong>Bank Alfalah</strong> as your first preference.</p>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-blue-200/50">
                    <p class="text-[10px] font-black text-blue-900 uppercase tracking-widest mb-2">Need Support?</p>
                    <div class="space-y-2">
                        <a href="https://wa.me/message/DZR6LZI6TTYSM1" target="_blank" class="flex items-center gap-2 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                            <i class="fab fa-whatsapp text-sm"></i> WhatsApp Support: +92 3414133395
                        </a>
                        <a href="mailto:admin.tutorhub@gmail.com" class="flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-700 transition-colors">
                            <i class="fas fa-envelope text-sm"></i> admin.tutorhub@gmail.com
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Interactive Tabs & Upload (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">
            <!-- Payment Method Tabs -->
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Choose Payment Method</h3>
                
                <div class="grid grid-cols-3 gap-3">
                    <button type="button" id="tab-bank" onclick="selectMethod('Bank Alfalah')" class="payment-tab py-4 px-2 rounded-2xl border-2 transition-all flex flex-col items-center gap-2 border-blue-600 bg-blue-50/50 text-blue-600">
                        <i class="fas fa-university text-lg"></i>
                        <span class="text-[10px] font-black uppercase tracking-wider text-center">Bank Transfer</span>
                    </button>
                    
                    <button type="button" id="tab-easypaisa" onclick="selectMethod('EasyPaisa')" class="payment-tab py-4 px-2 rounded-2xl border-2 transition-all flex flex-col items-center gap-2 border-slate-100 hover:border-slate-200 text-slate-600">
                        <i class="fas fa-mobile-alt text-lg"></i>
                        <span class="text-[10px] font-black uppercase tracking-wider text-center">EasyPaisa</span>
                    </button>
                    
                    <button type="button" id="tab-jazzcash" onclick="selectMethod('JazzCash')" class="payment-tab py-4 px-2 rounded-2xl border-2 transition-all flex flex-col items-center gap-2 border-slate-100 hover:border-slate-200 text-slate-600">
                        <i class="fas fa-wallet text-lg"></i>
                        <span class="text-[10px] font-black uppercase tracking-wider text-center">JazzCash</span>
                    </button>
                </div>
            </div>

            <!-- Interactive Payment Details -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                
                <!-- Bank Alfalah Details -->
                <div id="details-bank" class="payment-details-panel space-y-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-500/10 px-2 py-0.5 rounded">First Preference</span>
                            <h4 class="text-lg font-black text-slate-900 mt-2">Bank Alfalah Limited</h4>
                        </div>
                        <img src="{{ asset('images/payments/bank_alfalah_qr.png') }}" class="hidden" alt="Bank Alfalah QR Code">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 block">Account Title</span>
                                <span class="text-sm font-bold text-slate-800">HAFIZ AFTAB ALAM</span>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 block">Account Number</span>
                                <span class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                    55725000663088
                                    <button type="button" onclick="copyText('55725000663088', this)" class="text-xs text-blue-600 hover:text-blue-700"><i class="far fa-copy"></i></button>
                                </span>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 block">IBAN</span>
                                <span class="text-xs font-bold text-slate-800 flex items-center gap-2">
                                    PK13ALFH5572005000663088
                                    <button type="button" onclick="copyText('PK13ALFH5572005000663088', this)" class="text-xs text-blue-600 hover:text-blue-700"><i class="far fa-copy"></i></button>
                                </span>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 block">Swift Code</span>
                                <span class="text-sm font-bold text-slate-800">ALFHPKKAXXX</span>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 block">Branch & Code</span>
                                <span class="text-xs font-bold text-slate-800">COLLEGE RD. TOWNSHIP, LAHORE IBG (5572)</span>
                            </div>
                        </div>

                        <!-- Bank QR Code Display -->
                        <div class="flex flex-col items-center justify-center border-l border-slate-100 pl-6">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Scan to Pay</p>
                            <img src="{{ asset('images/payments/bank_alfalah_qr.png') }}" class="w-48 h-auto rounded-2xl border border-slate-100 shadow-sm" alt="Bank Alfalah QR Code">
                        </div>
                    </div>
                </div>

                <!-- EasyPaisa Details -->
                <div id="details-easypaisa" class="payment-details-panel space-y-6 hidden">
                    <h4 class="text-lg font-black text-slate-900">EasyPaisa Account</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 block">Account Title</span>
                                <span class="text-sm font-bold text-slate-800">Hafiz Aftab Alam</span>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 block">Mobile Number</span>
                                <span class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                    03414133395
                                    <button type="button" onclick="copyText('03414133395', this)" class="text-xs text-blue-600 hover:text-blue-700"><i class="far fa-copy"></i></button>
                                </span>
                            </div>
                        </div>

                        <!-- EasyPaisa QR Code Display -->
                        <div class="flex flex-col items-center justify-center border-l border-slate-100 pl-6">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Scan to Pay</p>
                            <img src="{{ asset('images/payments/easypaisa_qr.png') }}" class="w-48 h-auto rounded-2xl border border-slate-100 shadow-sm" alt="EasyPaisa QR Code">
                        </div>
                    </div>
                </div>

                <!-- JazzCash Details -->
                <div id="details-jazzcash" class="payment-details-panel space-y-6 hidden">
                    <h4 class="text-lg font-black text-slate-900">JazzCash Account</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 block">Account Title</span>
                                <span class="text-sm font-bold text-slate-800">Hafiz Aftab Alam</span>
                            </div>
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-wider text-slate-400 block">Mobile Number</span>
                                <span class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                    03414133395
                                    <button type="button" onclick="copyText('03414133395', this)" class="text-xs text-blue-600 hover:text-blue-700"><i class="far fa-copy"></i></button>
                                </span>
                            </div>
                        </div>

                        <!-- JazzCash QR Code -->
                        <div class="flex flex-col items-center justify-center border-l border-slate-100 pl-6 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <img src="{{ asset('images/jazzcash.jpeg') }}" alt="JazzCash QR Code - Hafiz Aftab Alam 3395" class="w-48 h-auto rounded-2xl shadow-md border border-slate-100">
                                <p class="text-[9px] font-black uppercase tracking-wider text-slate-500">Scan to Pay via JazzCash</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Receipt & Transaction Submission Form -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                <h3 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400 mb-6">Submit Payment Proof</h3>
                
                <form action="{{ route('payment.submit', $booking->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Selected Method Hidden Input -->
                    <input type="hidden" name="payment_method" id="input-payment-method" value="Bank Alfalah">

                    <div class="space-y-4">
                        <div>
                            <label for="transaction_id" class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-2 block">Transaction ID / Reference Number <span class="text-rose-500">*</span></label>
                            <input type="text" name="transaction_id" id="transaction_id" placeholder="Enter Transaction Reference (TID)" required class="w-full px-4 py-3.5 bg-slate-55/50 border border-slate-200 rounded-xl font-bold text-slate-800 text-sm focus:outline-none focus:border-blue-500 transition-colors">
                            @error('transaction_id')
                                <p class="text-xs font-semibold text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-wider text-slate-500 mb-2 block">Upload Receipt Image (Optional)</label>
                            
                            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:border-blue-500 transition-colors relative cursor-pointer group" id="upload-zone">
                                <input type="file" name="receipt" id="receipt" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                                <div class="text-slate-400 group-hover:text-blue-600 transition-colors">
                                    <i class="fas fa-cloud-upload-alt text-2xl mb-2"></i>
                                    <p class="text-xs font-black uppercase tracking-wider" id="upload-filename">Drag & Drop or Click to Upload</p>
                                    <p class="text-[9px] text-slate-400 mt-1">Accepts PNG, JPG, JPEG, WEBP (Max 5MB)</p>
                                </div>
                            </div>
                            @error('receipt')
                                <p class="text-xs font-semibold text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4.5 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black uppercase tracking-widest transition-all transform hover:scale-[1.01] shadow-lg shadow-blue-600/10 flex items-center justify-center gap-2">
                        <i class="fas fa-check-circle"></i> Submit Payment for Verification
                    </button>
                </form>
            </div>
            
            <div class="text-center">
                <a href="{{ route('student.dashboard') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-900 transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i> Cancel and Return to Dashboard
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    // Copy button helper function
    function copyText(text, btnElement) {
        navigator.clipboard.writeText(text).then(() => {
            const icon = btnElement.querySelector('i');
            icon.className = 'fas fa-check text-emerald-500';
            setTimeout(() => {
                icon.className = 'far fa-copy';
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }

    // Toggle Payment Method Panel
    function selectMethod(method) {
        // Set hidden input value
        document.getElementById('input-payment-method').value = method;

        // Reset all tabs style
        document.querySelectorAll('.payment-tab').forEach(tab => {
            tab.className = 'payment-tab py-4 px-2 rounded-2xl border-2 transition-all flex flex-col items-center gap-2 border-slate-100 hover:border-slate-200 text-slate-600';
        });

        // Hide all details panels
        document.querySelectorAll('.payment-details-panel').forEach(panel => {
            panel.classList.add('hidden');
        });

        // Highlight selected tab & show active panel
        if (method === 'Bank Alfalah') {
            document.getElementById('tab-bank').className = 'payment-tab py-4 px-2 rounded-2xl border-2 transition-all flex flex-col items-center gap-2 border-blue-600 bg-blue-50/50 text-blue-600';
            document.getElementById('details-bank').classList.remove('hidden');
        } else if (method === 'EasyPaisa') {
            document.getElementById('tab-easypaisa').className = 'payment-tab py-4 px-2 rounded-2xl border-2 transition-all flex flex-col items-center gap-2 border-blue-600 bg-blue-50/50 text-blue-600';
            document.getElementById('details-easypaisa').classList.remove('hidden');
        } else if (method === 'JazzCash') {
            document.getElementById('tab-jazzcash').className = 'payment-tab py-4 px-2 rounded-2xl border-2 transition-all flex flex-col items-center gap-2 border-blue-600 bg-blue-50/50 text-blue-600';
            document.getElementById('details-jazzcash').classList.remove('hidden');
        }
    }

    // Update filename placeholder when a file is selected
    const receiptInput = document.getElementById('receipt');
    if (receiptInput) {
        receiptInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Drag & Drop or Click to Upload';
            document.getElementById('upload-filename').textContent = fileName;
        });
    }
</script>
@endsection
